<?php

namespace App\Filament\Resources\SuratMasukRelationManagerResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use App\Models\DisposisiList;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Saade\FilamentAutograph\Forms\Components\SignaturePad;
use Filament\Forms\Components\Section;
class DisposisisRelationManager extends RelationManager
{
    protected static string $relationship = 'disposisis';

    protected static ?string $recordTitleAttribute = 'id';

    protected function getUsersByRole()
    {
        $currentUser = Auth::user();
        $currentUserId = $currentUser->id;

        if ($currentUser->hasRole('super_admin')) {
            return User::where('id', '!=', $currentUserId)->pluck('jabatan', 'id');
        }

        $roleHierarchy = [
            'eselon_pimpinan' => ['eselon_pimpinan','eselon_pembantu_pimpinan', 'eselon_pelaksana'],
            'eselon_pembantu_pimpinan' => ['eselon_pembantu_pimpinan','eselon_pelaksana'],
        ];

        $currentUserRole = $currentUser->getRoleNames()->first();
        $higherLevelRoles = $roleHierarchy[$currentUserRole] ?? [];

          if (!empty($higherLevelRoles)) {
              // Fetch users with the higher level roles, excluding the current user
              return User::role($higherLevelRoles)
                  ->where('id', '!=', $currentUserId)
                  ->pluck('jabatan', 'id');
          }
  
          // If no higher level roles are found, return an empty collection
          return collect([]);
    }


    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Tujuan Disposisi')
                    ->schema([
                        Forms\Components\CheckboxList::make('disposisi_kepada')
                            ->label('Disposisi Kepada')
                            ->options($this->getUsersByRole())
                            ->required()
                            ->columns(4),
                        Forms\Components\CheckboxList::make('disposisi_list_id')
                            ->label('Disposisi')
                            ->options(DisposisiList::all()->pluck('ur_disposisi_list', 'id'))
                            ->required()->columns(4),
                            
                    ]), 
// Suggested code may be subject to a license. Learn more: ~LicenseLog:4008917045.
                Section::make('Detail Disposisi')
                    ->schema([
                        Forms\Components\Textarea::make('isi')
                            // ->required()
                            ->label('Uraian Disposisi'),
                        Forms\Components\TextInput::make('user_id')
                            ->default(Auth::user()->id)
                            ->required()
                            ->hidden()
                            ,
                        Forms\Components\DatePicker::make('tanggal_disposisi')
                            ->required()
                            ->label('Tanggal Disposisi')
                            ->default(now()),
                        SignaturePad::make('paraf')
                            ->label(__('Paraf disini'))        
                            ->exportPenColor('#000')                     
                            ->penColor('#000')                  // Pen color on light mode
                            ->penColorOnDark('#fff')            // Pen color on dark mode (defaults to penColor)
                            ->exportPenColor('#00f')  
                            ,
                        Forms\Components\Textarea::make('catatan')
                            ->label('Catatan')
                    ])->columns(2), 
                ])
            ->columns(1);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('nomor_agenda')
            ->columns([
                Tables\Columns\TextColumn::make('penerimaDisposisi')
                    ->label('Penerima Disposisi')
                    ->sortable()->badge(),
                Tables\Columns\TextColumn::make('isi')
                    ->label('Isi Disposisi')
                    ->searchable(),
                Tables\Columns\TextColumn::make('tanggal_disposisi')
                    ->label('Tanggal Disposisi')
                    ->sortable()
                    ->searchable()
                    ->date(),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make(),
            ])
            ->actions([
                Tables\Actions\Action::make('print')
                    ->label('Cetak Disposisi')
                    ->color('warning')
                    ->icon('heroicon-o-printer')
                    ->url(fn ($record) => route('disposisi.print', $record), shouldOpenInNewTab: true)
                    ,
                Tables\Actions\ActionGroup::make([               
                    Tables\Actions\ViewAction::make(),
                    Tables\Actions\EditAction::make(),
                    Tables\Actions\DeleteAction::make(),
                ]),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }
}
