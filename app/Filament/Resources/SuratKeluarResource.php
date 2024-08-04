<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SuratKeluarResource\Pages;
use App\Filament\Resources\SuratKeluarResource\RelationManagers;
use App\Models\SuratKeluar;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;
use Filament\Tables\Filters\SelectFilter;
use Filament\Forms\Components\Section;
use Livewire\Features\SupportFileUploads\TemporaryUploadedFile;
use Filament\Forms\Get;
use App\Models\Satminkal;
use App\Models\Status;
use App\Models\Sifat;
use App\Models\KlasifikasiSurat;
use App\Models\Rak;
use App\Models\Lemari;
use App\Models\Loker;
use Illuminate\Support\Str;
use Joaopaulolndev\FilamentPdfViewer\Forms\Components\PdfViewerField;
use App\Models\User;
use Filament\Tables\Enums\FiltersLayout;
use Filament\Tables\Filters\Filter;
use Malzariey\FilamentDaterangepickerFilter\Filters\DateRangeFilter;
use Filament\Tables\Actions\Action;
use Joaopaulolndev\FilamentPdfViewer\Infolists\Components\PdfViewerEntry;
use Filament\Support\Enums\MaxWidth;
use Filament\Pages\SubNavigationPosition;
use Filament\Infolists\Infolist;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Components\Group;
use Filament\Infolists\Components\ViewEntry;
use Filament\Infolists\Components\TextareaEntry;
use Filament\Infolists\Components\FileEntry;
use Filament\Resources\Pages\Page;
use Filament\Infolists\Components;
use Hugomyb\FilamentMediaAction\MediaAction;
use Hugomyb\FilamentMediaAction\MediaColumn;
class SuratKeluarResource extends Resource
{
    protected static ?string $model = SuratKeluar::class;
    protected static ?string $navigationIcon = 'heroicon-o-arrow-up-tray';
    protected static ?int $navigationSort = 3;


    protected static SubNavigationPosition $subNavigationPosition = SubNavigationPosition::Top;
    public static function getNavigationLabel(): string
    {
        return trans('global.label_outgoing_letter');
    }

    public static function getPluralLabel(): string
    {
        return trans('global.label_outgoing_letter');
    }

    public static function getLabel(): string
    {
        return trans('global.label_outgoing_letter');
    }

    public function getTitle(): string
    {
        return trans('global.label_outgoing_letter_management');
    }

    public static function getEloquentQuery(): Builder
    {
        // return parent::getEloquentQuery()
        //     ->where('created_by', auth()->id());

        return parent::getEloquentQuery()
            ->where('kd_ktm', auth()->user()->kd_ktm)
            ->where('kd_smk', auth()->user()->kd_smk);
    }

    public static function getGloballySearchableAttributes(): array
    {
        return ['nomor_agenda', 'nomor_surat', 'perihal', 'kepada'];
    }

    public static function getGlobalSearchResultDetails(Model $record): array
    {
        return [
            'nomor_agenda' => $record->nomor_agenda,
            'nomor_surat' => $record->nomor_surat,
            'perihal' => $record->perihal,
            'kepada' => $record->kepada,
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
        $lastRecord = SuratKeluar::latest('created_at')->first();
        $currentMonth = Carbon::now()->month;
        $currentYear = Carbon::now()->year;
        $romanMonth = self::getRomanMonth($currentMonth);
        if ($lastRecord) {
            $lastRecordYear = Carbon::parse($lastRecord->created_at)->year;
            $lastNumber = ($lastRecordYear === $currentYear) ? intval(explode('/', $lastRecord->nomor_agenda)[1]) + 1 : 1;
        } else {
            $lastNumber = 1;
        }
        return 'AGDK/' . $lastNumber . '/' . $romanMonth . '/' . $currentYear;
    }

    public static function form(Form $form): Form
    {
        $isEdit = request()->routeIs('filament.admin.resources.surat-keluars.edit');
        $isTU = auth()->user()->hasRole('TU');

        return $form
            ->schema([
                Section::make(__('form.general_information'))
                    ->schema([
                        Forms\Components\TextInput::make('nomor_agenda')
                            ->label(__('form.no_agenda'))
                            ->required()
                            ->helperText(__('form.generate_automatic'))
                            ->default(fn() => self::generateNomorAgenda())
                            ->prefixIcon('heroicon-m-inbox-stack')
                            ->prefixIconColor('success'),
                        Forms\Components\DatePicker::make('tanggal_agenda')
                            ->label(__('form.agenda_date'))
                            ->helperText(__('form.generate_automatic'))
                            ->required()
                            ->default(fn() => Carbon::now())
                            ->prefixIcon('heroicon-o-calendar')
                            ->prefixIconColor('primary'),
                    ])
                    ->columns(2)
                    ->collapsed($isEdit),

                Section::make(__('form.detail_surat'))
                    ->schema([
                        Forms\Components\Hidden::make('created_by')->default(auth()->id()),
                        Forms\Components\TextInput::make('kepada')
                            ->label(__('form.to'))
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
                            ->default(fn() => Carbon::now())
                            ->prefixIcon('heroicon-o-calendar')
                            ->prefixIconColor('primary'),
                        Forms\Components\Select::make('klasifikasi_id')
                            ->label(__('form.classification'))
                            ->options(KlasifikasiSurat::all()->pluck('ur_klasifikasi', 'id'))
                            ->required()
                            ->searchable()
                            ->prefixIcon('heroicon-o-tag')
                            ->prefixIconColor('success'),
                        Forms\Components\Hidden::make('kd_ktm')->default(auth()->user()->kd_ktm),
                        Forms\Components\Hidden::make('kd_smk')->default(auth()->user()->kd_smk),
                        Forms\Components\Textarea::make('perihal')
                            ->label(__('form.subject'))
                            ->rows(5)
                            ->required(),        
                    ])
                    ->columns(2)
                    ->collapsible(),
                Section::make(__('form.attachments'))
                    ->schema([
                        Forms\Components\FileUpload::make('lampiran_surat_keluar')
                            ->label(__('form.outgoing_attachments'))
                            ->required()
                            ->multiple()
                            ->appendFiles()
                            ->openable()
                            ->uploadingMessage('Uploading attachment...')
                            ->acceptedFileTypes(['application/pdf'])
                            ->directory('Surat_Keluar/' . Carbon::now()->format('Y'))
                            ->getUploadedFileNameForStorageUsing(function (Get $get, TemporaryUploadedFile $file) {
                                $uniqueId = str_pad(random_int(1000, 99999), 5, '0', STR_PAD_LEFT); // Generate a unique 4 or 5 digit ID
                                $nomorAgenda = str_replace([' ', '/'], '_', $get('nomor_agenda'));
                                return Carbon::now()->format('d_m_Y').'_'.$uniqueId.'_'.$nomorAgenda . '.' . $file->getClientOriginalExtension();
                            }),                            
                        PdfViewerField::make('lampiran_surat_keluar')
                            ->label(__('form.preview_attachments')),
                    ])
                    ->columns(2)
                    ->collapsible(),
                Section::make(__('form.additional_information'))
                    ->schema([
                        Forms\Components\Select::make('rak_id')
                            ->label(__('form.rack'))
                            ->options(Rak::all()->pluck('nama_rak', 'id'))
                            // ->required()
                            ->searchable()
                            ->prefixIcon('heroicon-o-archive-box')
                            ->prefixIconColor('success'),
                        Forms\Components\Select::make('lemari_id')
                            ->label(__('form.cabinet'))
                            ->options(Lemari::all()->pluck('nama_lemari', 'id'))
                            // ->required()
                            ->searchable()
                            ->prefixIcon('heroicon-o-briefcase')
                            ->prefixIconColor('success'),
                            Forms\Components\Select::make('loker_id')
                            ->label(__('form.locker'))
                            ->options(Loker::all()->pluck('nama_loker', 'id'))
                            // ->required()
                            ->searchable()
                            ->prefixIcon('heroicon-o-lock-closed')
                            ->prefixIconColor('success'),
                    ])
                    ->columns(3)
                    ->collapsed($isEdit)
                    ->hidden(fn() => !auth()->user()->hasRole('TU')),
            ])
            ->columns(2);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('nomor_agenda')
                    ->label(__('form.no_agenda'))
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),

            // MediaColumn::make('lampiran_surat_keluar')  // Add this line to include the media column
            // ->label('Media Files'),
                Tables\Columns\TextColumn::make('nomor_surat')
                    ->label(__('form.letter_number'))
                    ->searchable(),
                // Menampilkan status dari disposisi terakhir
                Tables\Columns\TextColumn::make('status')
                    ->label(__('form.status'))
                    ->badge()
                    ->icon(function (string $state): ?string {
                        return match ($state) {
                            'Konsep' => 'heroicon-o-pencil-square',    // Pencil icon for 'Konsep'
                            'Tinjau Kembali' => 'heroicon-o-arrow-path', // Refresh icon for 'Tinjau Kembali'
                            'Perbaikan' => 'heroicon-m-arrows-up-down',  // Adjustments icon for 'Perbaikan'
                            'Disetujui' => 'heroicon-o-check-circle', // Check circle icon for 'Disetujui'
                            default => 'heroicon-o-question-mark-circle',  // No icon for other statuses
                        };
                    })
                    ->color(function (string $state): string {
                        return match ($state) {
                            'Konsep' => 'primary',
                            'Tinjau Kembali' => 'danger',
                            'Perbaikan' => 'info',
                            'Disetujui' => 'success',
                            default => 'danger',
                        };
                    }),
                // Menampilkan nama pengesah dari disposisi terakhir
                Tables\Columns\TextColumn::make('latestDisposisiApproverName')
                    ->label(__('form.approver'))
                    ->searchable()
                    ->wrap(),
                Tables\Columns\TextColumn::make('tanggal_agenda')
                    ->label(__('form.agenda_date'))
                    ->date()
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->sortable(),
                Tables\Columns\TextColumn::make('tanggal_surat')
                    ->label(__('form.letter_date'))
                    ->date()
                    ->sortable(),
                Tables\Columns\TextColumn::make('kepada')
                    ->label(__('form.to'))
                    ->searchable()
                    ->wrap(),
                Tables\Columns\TextColumn::make('perihal')
                    ->label(__('form.subject'))
                    ->searchable()
                    ->limit(50)
                    ->wrap(),
                Tables\Columns\TextColumn::make('klasifikasiSurat.ur_klasifikasi')
                    ->label(__('form.classification'))
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->sortable(),
            ])
            ->filters([
                SelectFilter::make('klasifikasi_id')
                    ->label(__('form.classification'))
                    ->options(fn (): array => KlasifikasiSurat::query()->pluck('ur_klasifikasi', 'id')->all()),
                SelectFilter::make('status')
                    ->multiple()
                    ->options([
                        'Konsep' => 'Konsep',
                        'Tinjau Kembali' => 'Tinjau Kembali',
                        'Perbaikan' => 'Perbaikan',
                        'Disetujui' => 'Disetujui',
                    ]),
                DateRangeFilter::make('tanggal_surat')
                    ->label(__('form.letter_date'))
                    ->disableRanges(),
            ], layout: FiltersLayout::AboveContentCollapsible)
            ->actions([  
                Action::make('lampiran_surat_keluar')
                    ->icon('heroicon-o-paper-clip')
                    ->color('warning')
                    ->label('')
                        ->form(function ($record) {
                            $files = $record->lampiran_surat_keluar ?? [];                    

                            $fileUrl = !empty($files) ? \Storage::url(end($files)) : null;
                            
                            return [
                                PdfViewerField::make('lampiran_surat_keluar')
                                ->label(__('form.outgoing_attachments'))
                                    ->fileUrl($fileUrl),
                            ];
                        })                    
                        ->modalSubmitAction(false)
                        ->modalWidth(MaxWidth::FiveExtraLarge)                   
                        ->stickyModalHeader(),
            // ViewAction::make()
            //     ->label('View')
            //     ->modalHeading('Media Files')
            //     ->form([
            //         MediaAction::make('media')
            //             ->label('View Media')
            //             ->multiple()
            //             ->disabled(), // Disable if you want only to view the media
            //     ]),
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
            ])
            ->groups([
                Tables\Grouping\Group::make('tanggal_agenda')
                    ->label(__('form.agenda_date'))
                    ->date()
                    ->collapsible(),
            ]);
    }

    
    public static function infolist(Infolist $infolist): Infolist
    {
        
        $files = $record->lampiran_surat_keluar ?? [];                    

        $fileUrl = !empty($files) ? \Storage::url(end($files)) : null;
        return $infolist
            ->schema([
                Components\Section::make(__('form.general_information'))
                    ->schema([
                        Components\Split::make([
                            Components\Grid::make(2)
                                ->schema([
                                    Components\Group::make([
                                        Components\TextEntry::make('nomor_agenda')
                                            ->label(__('form.no_agenda')),
                                        Components\TextEntry::make('nomor_surat')
                                            ->label(__('form.letter_number')),
                                        Components\TextEntry::make('tanggal_agenda')
                                            ->label(__('form.agenda_date'))
                                            ->badge()
                                            ->date()
                                            ->color('primary'),
                                        Components\TextEntry::make('perihal')
                                            ->label(__('form.subject'))
                                            ->prose()
                                            ->markdown(),
                                    ]),
                                    Components\Group::make([
                                        Components\TextEntry::make('kepada')
                                            ->label(__('form.to')),
                                        Components\TextEntry::make('klasifikasiSurat.ur_klasifikasi')
                                            ->label(__('form.classification')),
                                        Components\TextEntry::make('status')
                                            ->label(__('form.status'))
                                            ->badge()
                                            ->color('success')   ,
                                    ]),
                                ]),
                                PdfViewerEntry::make('lampiran_surat_keluar')
                                ->hiddenLabel()
                                ->grow(false)
                                ->fileUrl('https://9002-idx-office-1720079367933.cluster-7ubberrabzh4qqy2g4z7wgxuw2.cloudworkstations.dev/storage/Surat_Keluar/2024/01_08_2024_88117_AGDK_5_VIII_2024.pdf'),
                        ])->from('lg'),
                    ]),
                Components\Section::make(__('form.additional_information'))
                    ->schema([
                        Components\TextEntry::make('rak.nama_rak')
                            ->label(__('form.rack')),
                        Components\TextEntry::make('lemari.nama_lemari')
                            ->label(__('form.cabinet')),
                        Components\TextEntry::make('loker.nama_loker')
                            ->label(__('form.locker')),
                    ])
                    ->columns(3)
                    ->hidden(fn() => !auth()->user()->hasRole('TU')),
            ]);
    }
    
    
 
    public static function getRelations(): array
    {
        return [            
            SuratKeluarRelationManagerResource\RelationManagers\DisposisiSuratKeluarsRelationManager::class,
        ];
    }
    public static function getNavigationBadge(): ?string
    {
        /** @var class-string<Model> $modelClass */
        $modelClass = static::$model;

        return (string) $modelClass::where('status', 'Draft')->count();
    }
    public static function getRecordSubNavigation(Page $page): array
    {
        return $page->generateNavigationItems([
            Pages\ViewSuratKeluar::class,
            Pages\EditSuratKeluar::class,
            // Pages\ManagePostComments::class,
        ]);
    }
    public static function getPages(): array
    {
        return [
            'index' => Pages\ListSuratKeluars::route('/'),
            'create' => Pages\CreateSuratKeluar::route('/create'),
            'edit' => Pages\EditSuratKeluar::route('/{record}/edit'),
            'view' => Pages\ViewSuratKeluar::route('/{record}'),
        ];
    }
}
