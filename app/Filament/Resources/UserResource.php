<?php

namespace App\Filament\Resources;

use Filament\Forms;
use App\Models\User;
use Filament\Tables;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Illuminate\Support\Facades\Hash;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Actions\ViewAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Actions\ActionGroup;
use Filament\Tables\Actions\DeleteAction;
use Illuminate\Database\Eloquent\Builder;
use TomatoPHP\FilamentUsers\Facades\FilamentUser;
use TomatoPHP\FilamentUsers\Resources\UserResource\Pages;
use App\Models\Kotama;
use App\Models\Satminkal;
class UserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?int $navigationSort = 9;

    protected static ?string $navigationIcon = 'heroicon-o-lock-closed';

    public static function getNavigationLabel(): string
    {
        return trans('filament-users::user.resource.label');
    }

    public static function getPluralLabel(): string
    {
        return trans('filament-users::user.resource.label');
    }

    public static function getLabel(): string
    {
        return trans('filament-users::user.resource.single');
    }

    public static function getNavigationGroup(): ?string
    {
        return trans('global.settings');
    }

    public function getTitle(): string
    {
        return trans('filament-users::user.resource.title.resource');
    }

      public static function getNavigationBadge(): ?string
    {
        /** @var class-string<Model> $modelClass */
        $modelClass = static::$model;

        return (string) $modelClass::count();
    }
    public static function form(Form $form): Form
    {
        $rows = [
            TextInput::make('name')
                ->required()
                ->label(trans('filament-users::user.resource.name')),
            TextInput::make('email')
                ->email()
                ->required()
                ->label(trans('filament-users::user.resource.email')),
            Forms\Components\Select::make('kd_ktm')
                ->label('Kotama')
                ->options(Kotama::all()->pluck('ur_ktm', 'kd_ktm'))
                ->required()->searchable()              
                ->reactive()  
                ->afterStateUpdated(fn(callable $set)=>$set('kd_smk',null)) ,
            Forms\Components\Select::make('kd_smk')
                ->label('Satminkal')
                ->options(function (callable $get){
                    if($get('kd_ktm')){
                        return Satminkal::where('kd_ktm',$get('kd_ktm'))->pluck('ur_smk', 'kd_smk');
                    }else{
                        return Satminkal::all()->pluck('ur_smk', 'kd_smk');
                    }   
                })
                ->required()->searchable(),
                
            TextInput::make('jabatan')
            ->required()
            ->label(trans('filament-users::user.resource.jabatan')),
            TextInput::make('password')
                ->label(trans('filament-users::user.resource.password'))
                ->password()
                ->maxLength(255)
                ->dehydrateStateUsing(static function ($state, $record) use ($form) {
                    return !empty($state)
                        ? Hash::make($state)
                        : $record->password;
                }),
        ];

        if (config('filament-users.shield') && class_exists(\BezhanSalleh\FilamentShield\FilamentShield::class)) {
            $rows[] = Forms\Components\Select::make('roles')
                // ->multiple()
                ->preload()
                ->relationship('roles', 'name')
                ->label(trans('filament-users::user.resource.roles'));
        }



        $form->schema(array_merge($rows, FilamentUser::getFormInputs()));

        return $form;
    }


    public static function table(Table $table): Table
    {
        $actions = [
            
            // Tables\Actions\ActionGroup::make([    
                ViewAction::make()->iconButton()->tooltip(trans('filament-users::user.resource.title.show')),
                EditAction::make()->iconButton()->tooltip(trans('filament-users::user.resource.title.edit')),
                DeleteAction::make()->iconButton()->tooltip(trans('filament-users::user.resource.title.delete')),
            // ]),
        ];
        if(class_exists( \STS\FilamentImpersonate\Tables\Actions\Impersonate::class) && config('filament-users.impersonate')){
            $actions[] = \STS\FilamentImpersonate\Tables\Actions\Impersonate::make('impersonate')->tooltip(trans('filament-users::user.resource.title.impersonate'));
        }


        $columns = [
            TextColumn::make('id')
                ->sortable()
                ->label(trans('filament-users::user.resource.id')),
            TextColumn::make('name')
                ->sortable()
                ->searchable()
                ->label(trans('filament-users::user.resource.name')),
            TextColumn::make('email')
                ->sortable()
                ->searchable()
                ->label(trans('filament-users::user.resource.email')),
            TextColumn::make('kotama.ur_ktm')
                ->label('Kotama')
                ->toggleable(isToggledHiddenByDefault: true)
                ->searchable(),
            TextColumn::make('satminkal.ur_smk')
                ->label('Satminkal')
                ->searchable()                
                ->toggleable(isToggledHiddenByDefault: true)
                ->default(function ($record) { 
                    $row=Satminkal::where('kd_ktm',$record->kd_ktm)->where('kd_smk',$record->kd_smk)->first();
                    return $row->ur_smk;
                }),                
            TextColumn::make('jabatan')
                ->label(trans('filament-users::user.resource.jabatan'))
                ->searchable(),
            IconColumn::make('email_verified_at')
                ->boolean()
                ->sortable()
                ->searchable()
                ->toggleable(isToggledHiddenByDefault: true)
                ->label(trans('filament-users::user.resource.email_verified_at')),
            TextColumn::make('created_at')
                ->label(trans('filament-users::user.resource.created_at'))
                ->dateTime('M j, Y')
                ->toggleable(isToggledHiddenByDefault: true)
                ->sortable(),
            TextColumn::make('updated_at')
                ->label(trans('filament-users::user.resource.updated_at'))
                ->dateTime('M j, Y')
                ->toggleable(isToggledHiddenByDefault: true)
                ->sortable(),
        ];

        $filters = [
            // Tables\Filters\Filter::make('verified')
            //     ->label(trans('filament-users::user.resource.verified'))
            //     ->query(fn (Builder $query): Builder => $query->whereNotNull('email_verified_at')),
            // Tables\Filters\Filter::make('unverified')
            //     ->label(trans('filament-users::user.resource.unverified'))
            //     ->query(fn (Builder $query): Builder => $query->whereNull('email_verified_at')),
            
            Tables\Filters\SelectFilter::make('kd_ktm')->label('Kotama')
            ->options(fn (): array => Kotama::query()->pluck('ur_ktm', 'kd_ktm')->all())->searchable(),
            // Tables\Filters\SelectFilter::make('kd_smk')->label('Satminkal')
            // ->options(fn (): array => Satminkal::query()->pluck('ur_smk', 'kd_smk')->all())->searchable(),
        ];

        return $table
            ->columns(array_merge($columns, FilamentUser::getTableColumns()))
            ->filters(array_merge($filters, FilamentUser::getTableFilters()))
            ->actions(array_merge($actions, FilamentUser::getTableActions()));
    }

    public static function getRelations(): array
    {
        return FilamentUser::getRelationManagers();
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListUsers::route('/'),
            'create' => Pages\CreateUser::route('/create'),
            'edit' => Pages\EditUser::route('/{record}/edit'),
        ];
    }
}
