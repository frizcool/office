<?php
namespace App\Filament\Resources;

use App\Filament\Resources\SuratMasukResource\Pages;
use App\Filament\Resources\SuratMasukResource\RelationManagers;
use App\Models\SuratMasuk;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Models\Satminkal;
use App\Models\Status;
use App\Models\Sifat;
use App\Models\KlasifikasiSurat;
use Illuminate\Support\Carbon;
use Filament\Tables\Filters\SelectFilter;
use Illuminate\Contracts\Support\Htmlable;
use Filament\Notifications\Notification;
use Illuminate\Database\Eloquent\Model;
use Joaopaulolndev\FilamentPdfViewer\Forms\Components\PdfViewerField;
use Filament\Forms\Components\Section;
use Livewire\Features\SupportFileUploads\TemporaryUploadedFile;
use Filament\Forms\Get;
class SuratMasukResource extends Resource
{
    protected static ?string $model = SuratMasuk::class;

    protected static ?string $navigationIcon = 'heroicon-o-inbox-arrow-down';
    protected static ?int $navigationSort = 2;

    public static function getNavigationLabel(): string
    {
        return trans('global.label_incoming_letter');
    }

    public static function getPluralLabel(): string
    {
        return trans('global.label_incoming_letter');
    }

    public static function getLabel(): string
    {
        return trans('global.label_incoming_letter');
    }

    public function getTitle(): string
    {
        return trans('global.label_incoming_letter_management');
    }



    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()->where('kd_ktm', auth()->user()->kd_ktm)->where('kd_smk', auth()->user()->kd_smk);
    }

    public static function getGloballySearchableAttributes(): array
    {
        return ['nomor_agenda', 'nomor_surat', 'perihal','terima_dari'];
    }

    public static function getGlobalSearchResultDetails(Model $record): array
    {
        return [
            'nomor_agenda' => $record->nomor_agenda,
            'nomor_surat' => $record->nomor_surat,
            'perihal' => $record->perihal,
            'terima_dari' => $record->terima_dari,
        ];
    }

    public static function getRomanMonth($month)
    {
        $romanMonths = [
            1 => 'I', 2 => 'II', 3 => 'III', 4 => 'IV', 5 => 'V', 6 => 'VI',
            7 => 'VII', 8 => 'VIII', 9 => 'IX', 10 => 'X', 11 => 'XI', 12 => 'XII'
        ];
        return $romanMonths[$month];
    }

    public static function generateNomorAgenda()
    {
        $lastRecord = SuratMasuk::latest('created_at')->first();
        $currentMonth = Carbon::now()->month;
        $currentYear = Carbon::now()->year;
        $romanMonth = self::getRomanMonth($currentMonth);
        
        if ($lastRecord) {
            $lastNumber = intval(explode('/', $lastRecord->nomor_agenda)[1]) + 1;
        } else {
            $lastNumber = 1;
        }

        return 'AGD/' . $lastNumber . '/' . $romanMonth . '/' . $currentYear;
    }

    public static function form(Form $form): Form
    {
        $isEdit = request()->routeIs('filament.admin.resources.surat-masuks.edit');
        return $form
            ->schema([
                Section::make(__('form.general_information'))
                    ->schema([
                        Forms\Components\TextInput::make('nomor_agenda')
                            ->label(__('form.no_agenda'))
                            ->required()
                            ->default(
                                function () {
                                    return self::generateNomorAgenda();
                                }
                            )
                            ->prefixIcon('heroicon-m-inbox-stack')
                            ->prefixIconColor('success'),
                        Forms\Components\DatePicker::make('tanggal_agenda')
                            ->label(__('form.agenda_date'))
                            ->required()
                            ->default(
                                function () {
                                    return Carbon::now();
                                }
                            )
                            ->prefixIcon('heroicon-o-calendar')
                            ->prefixIconColor('primary'),
                        Forms\Components\TimePicker::make('waktu_agenda')
                            ->label(__('form.agenda_time'))
                            ->required()
                            ->default(
                                function () {
                                    return Carbon::now();
                                }
                            )
                            ->prefixIcon('heroicon-o-clock')
                            ->prefixIconColor('warning'),
                    ])
                    ->columns(3)
                    ->collapsed($isEdit),
    
                Section::make(__('form.detail_surat'))
                    ->schema([
                        Forms\Components\Hidden::make('kd_ktm')
                            ->default(auth()->user()->kd_ktm),
                        Forms\Components\Hidden::make('kd_smk')
                            ->default(auth()->user()->kd_smk),
                        Forms\Components\TextInput::make('terima_dari')
                            ->label(__('form.received_from'))
                            ->required()
                            ->prefixIcon('heroicon-o-user')
                            ->prefixIconColor('info'),
                        Forms\Components\TextInput::make('nomor_surat')
                            ->label(__('form.letter_number'))
                            ->required()
                            ->prefixIcon('heroicon-o-document-text')
                            ->prefixIconColor('secondary'),
                        Forms\Components\DatePicker::make('tanggal_surat')
                            ->label(__('form.letter_date'))
                            ->required()
                            ->default(
                                function () {
                                    return Carbon::now();
                                }
                            )
                            ->prefixIcon('heroicon-o-calendar')
                            ->prefixIconColor('primary'),
                        Forms\Components\Select::make('klasifikasi_id')
                            ->label(__('form.classification'))
                            ->options(KlasifikasiSurat::all()->pluck('ur_klasifikasi', 'id'))
                            ->required()
                            ->searchable()
                            ->prefixIcon('heroicon-o-tag')
                            ->prefixIconColor('success'),
                        Forms\Components\Select::make('status_id')
                            ->label(__('form.status'))
                            ->options(Status::all()->pluck('ur_status', 'id'))
                            ->required()
                            ->searchable()
                            ->prefixIcon('heroicon-o-arrows-right-left')
                            ->prefixIconColor('success'),
                        Forms\Components\Select::make('sifat_id')
                            ->label(__('form.nature'))
                            ->options(Sifat::all()->pluck('ur_sifat', 'id'))
                            ->required()
                            ->searchable()
                            ->prefixIcon('heroicon-o-bookmark')
                            ->prefixIconColor('warning'),
                        Forms\Components\Textarea::make('perihal')
                            ->label(__('form.subject'))
                            ->rows(5)
                            ->required(),
                    ])
                    ->columns(3)
                    ->collapsible(),
    
                Section::make(__('form.attachments'))
                ->schema([
                    Forms\Components\FileUpload::make('lampiran_surat_masuk')
                        ->label(__('form.incoming_attachments'))
                        ->required()
                        ->multiple()
                        ->appendFiles()
                        ->openable()
                        ->uploadingMessage('Uploading attachment...')
                        ->acceptedFileTypes(['application/pdf'])
                        ->directory('Surat_Masuk/' . Carbon::now()->format('Y'))
                        ->getUploadedFileNameForStorageUsing(function (Get $get,TemporaryUploadedFile $file) {
                            $nomorAgenda = str_replace([' ', '/'], '_', $get('nomor_agenda'));
                            return Carbon::now()->format('d_m_Y').'_'.$nomorAgenda . '.' . $file->getClientOriginalExtension();
                        }),
                    PdfViewerField::make('lampiran_surat_masuk')
                        ->label(__('form.preview_attachments')),
                ])
                
                    ->columns(2)
                    ->collapsible(),
            ])
            ->columns(3);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('nomor_agenda')
                    ->label(__('form.no_agenda'))->searchable(),
                Tables\Columns\TextColumn::make('status')
                    ->label(__('form.status'))
                    ->badge()
                    ->getStateUsing(function (SuratMasuk $record) {
                        $lastDisposisi = $record->disposisis()->latest()->first();
                        return $lastDisposisi && $lastDisposisi->user ? "Disposisi oleh " . $lastDisposisi->user->jabatan : "Menunggu disposisi";
                    }),
                Tables\Columns\TextColumn::make('tanggal_agenda')
                    ->label(__('form.agenda_date'))
                    ->date()
                    ->sortable(),
                Tables\Columns\TextColumn::make('terima_dari')
                    ->label(__('form.received_from'))
                    ->searchable()->wrap(),
                Tables\Columns\TextColumn::make('perihal')
                    ->label(__('form.subject'))
                    ->searchable()
                    ->limit(50)->wrap(),
                Tables\Columns\TextColumn::make('klasifikasiSurat.ur_klasifikasi')
                    ->label(__('form.classification'))
                    ->searchable()                    
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->sortable(),
                Tables\Columns\TextColumn::make('status.ur_status')
                    ->label(__('form.status'))                    
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('sifat.ur_sifat')
                    ->label(__('form.nature'))                    
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->searchable()
                    ->sortable(),
            ])
            ->filters([
                SelectFilter::make('klasifikasi_id')->label(__('form.classification'))
                    ->options(fn (): array => KlasifikasiSurat::query()->pluck('ur_klasifikasi', 'id')->all())
            ])
            ->actions([ 
                Tables\Actions\ViewAction::make(),
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

    public static function getRelations(): array
    {
        return [            
            SuratMasukRelationManagerResource\RelationManagers\DisposisisRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListSuratMasuks::route('/'),
            'create' => Pages\CreateSuratMasuk::route('/create'),
            'edit' => Pages\EditSuratMasuk::route('/{record}/edit'),
        ];
    }
}
