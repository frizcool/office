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

class SuratMasukResource extends Resource
{
    protected static ?string $model = SuratMasuk::class;

    protected static ?string $navigationIcon = 'heroicon-o-inbox-arrow-down';
    protected static ?int $navigationSort = 2;
    // protected static ?string $navigationLabel = 'Agenda Surat';
    // protected static ?string $slug = 'agenda-surat';

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()->where('kd_ktm', auth()->user()->kd_ktm)->where('kd_smk', auth()->user()->kd_smk);
    }
    // protected static ?string $recordTitleAttribute = 'nomor_agenda';
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
    // Metode untuk mengonversi angka bulan menjadi angka Romawi
    public static function getRomanMonth($month)
    {
        $romanMonths = [
            1 => 'I', 2 => 'II', 3 => 'III', 4 => 'IV', 5 => 'V', 6 => 'VI',
            7 => 'VII', 8 => 'VIII', 9 => 'IX', 10 => 'X', 11 => 'XI', 12 => 'XII'
        ];
        return $romanMonths[$month];
    }

    // Metode untuk menghasilkan nomor agenda terbaru
    public static function generateNomorAgenda()
    {
        // Dapatkan nomor agenda terakhir
        $lastRecord = SuratMasuk::latest('created_at')->first();
        $currentMonth = Carbon::now()->month;
        $currentYear = Carbon::now()->year;
        $romanMonth = self::getRomanMonth($currentMonth);
        
        if ($lastRecord) {
            // Ambil nomor urut terakhir dan tambahkan 1
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
                Section::make('Informasi Umum')
                    ->schema([
                        Forms\Components\TextInput::make('nomor_agenda')
                            ->required()
                            ->default(
                                function () {
                                    return self::generateNomorAgenda();
                                }
                            ),
                        Forms\Components\DatePicker::make('tanggal_agenda')
                            ->required()
                            ->default(
                                function () {
                                    return Carbon::now();
                                }
                            ),
                        Forms\Components\TimePicker::make('waktu_agenda')
                            ->required()
                            ->default(
                                function () {
                                    return Carbon::now();
                                }
                            ),
                    ])
                    ->columns(3)
                    ->collapsed($isEdit),
    
                Section::make('Detail Surat')
                    ->schema([
                        Forms\Components\Hidden::make('kd_ktm')
                            ->default(auth()->user()->kd_ktm),
                        Forms\Components\Hidden::make('kd_smk')
                            ->default(auth()->user()->kd_smk),
                        Forms\Components\TextInput::make('terima_dari')
                            ->required(),
                        Forms\Components\TextInput::make('nomor_surat')
                            ->required(),
                        Forms\Components\DatePicker::make('tanggal_surat')
                            ->required()
                            ->default(
                                function () {
                                    return Carbon::now();
                                }
                            ),
                        Forms\Components\Select::make('klasifikasi_id')
                            ->label('Klasifikasi Surat')
                            ->options(KlasifikasiSurat::all()->pluck('ur_klasifikasi', 'id'))
                            ->required()
                            ->searchable(),
                        Forms\Components\Select::make('status_id')
                            ->label('Status Surat')
                            ->options(Status::all()->pluck('ur_status', 'id'))
                            ->required()
                            ->searchable(),
                        Forms\Components\Select::make('sifat_id')
                            ->label('Sifat Surat')
                            ->options(Sifat::all()->pluck('ur_sifat', 'id'))
                            ->required()
                            ->searchable(),
                        Forms\Components\Textarea::make('perihal')
                            ->rows(5)
                            ->required(),
                    ])
                    ->columns(3)
                    // ->collapsed($isEdit)
// Suggested code may be subject to a license. Learn more: ~LicenseLog:2391044370.
                    ->collapsible(),
    
                Section::make('Lampiran')
                    ->schema([
                        Forms\Components\FileUpload::make('lampiran_surat_masuk')
                            ->required()
                            ->multiple()
                            ->appendFiles()
                            ->openable()
                            ->uploadingMessage('Uploading attachment...')
                            ->acceptedFileTypes(['application/pdf'])
                            ->directory('Surat_Masuk/' . Carbon::now()->format('Y'))
                            ->label('Lampiran Surat Masuk')
                            ->preserveFilenames(),
                        PdfViewerField::make('lampiran_surat_masuk')
                            ->label('Preview Lampiran')
                            // ->minHeight('40svh')
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
                    ->label('No Agenda')->searchable(),
                
                Tables\Columns\TextColumn::make('status')
                    ->label('Status')
                    ->badge()
                    ->getStateUsing(function (SuratMasuk $record) {
                        $lastDisposisi = $record->disposisis()->latest()->first();
                        return $lastDisposisi && $lastDisposisi->user ? "Sudah di disposisi oleh " . $lastDisposisi->user->jabatan : "Menunggu disposisi";
                    }),
                Tables\Columns\TextColumn::make('tanggal_agenda')
                    ->label('Tgl Agenda')
                    ->date()
                    ->sortable(),
                Tables\Columns\TextColumn::make('terima_dari')
                    ->searchable()->wrap(),
                Tables\Columns\TextColumn::make('perihal')
                    ->searchable()
                    ->limit(50)->wrap(),
                Tables\Columns\TextColumn::make('klasifikasiSurat.ur_klasifikasi')
                    ->label('Klasifikasi Surat')
                    ->searchable()                    
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->sortable(),
                    
                Tables\Columns\TextColumn::make('status.ur_status')
                    ->label('Status Surat')                    
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('sifat.ur_sifat')
                    ->label('Sifat Surat')                    
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->searchable()
                    ->sortable(),
            ])
            ->filters([
                //                
                SelectFilter::make('klasifikasi_id')->label('Klasifikasi')
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
