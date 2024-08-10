<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;
use Filament\Forms;
use Filament\Tables;
use Filament\Actions\Action;
use Illuminate\Database\Eloquent\Builder;
use App\Models\SuratKeluar;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Support\Carbon;
use Filament\Tables\Filters\SelectFilter;
use App\Models\KlasifikasiSurat;
use App\Models\Sifat;
use App\Models\Status;
use Filament\Tables\Enums\FiltersLayout;
use Filament\Tables\Filters\Filter;
use Malzariey\FilamentDaterangepickerFilter\Fields\DateRangePicker;
use Filament\Forms\Components\Fieldset;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Table;
use Illuminate\Contracts\View\View;
use Livewire\Component; 
use Filament\Forms\Components\Split;
use Filament\Forms\Components\Section;
use Livewire\Attributes\Url;
use Malzariey\FilamentDaterangepickerFilter\Filters\DateRangeFilter;
use PDF;
class SuratKeluarReports extends Page implements HasTable,HasForms
{
    use InteractsWithTable;
    use InteractsWithForms;

    protected static ?int $navigationSort = -1;
    #[Url]
    public ?array $tableFilters = null;
    protected static ?string $navigationIcon = 'heroicon-o-document-arrow-up';
    protected static string $view = 'filament.pages.surat-keluar-reports';
    protected static ?string $model = SuratKeluar::class;
    public static function getNavigationGroup(): ?string
    {
        return __('global.report');
    }
    public static function getNavigationLabel(): string
    {
        return trans('global.label_outgoing_letter_report');
    }

    public static function getPluralLabel(): string
    {
        return trans('global.label_outgoing_letter_report');
    }

    public static function getLabel(): string
    {
        return trans('global.label_outgoing_letter_report');
    }
    public function getTitle(): string
    {
        return trans('global.label_outgoing_letter_report');
    }
    public function table(Table $table): Table
    {
        return $table
            ->query(SuratKeluar::query()->where('kd_ktm', auth()->user()->kd_ktm)
            ->where('kd_smk', auth()->user()->kd_smk))
            ->columns([
                TextColumn::make('nomor_agenda')
                ->label(__('form.no_agenda')),
                TextColumn::make('nomor_surat')
                ->label(__('form.letter_number')),

                TextColumn::make('tanggal_surat')
                ->date()
                ->label(__('form.letter_date')),

                Tables\Columns\TextColumn::make('kepada')
                    ->label(__('form.to')),

                TextColumn::make('perihal')                    
                    ->label(__('form.subject')),
            ])
            ->filters([
                DateRangeFilter::make('tanggal_agenda')->label(__('form.agenda_date')),
                DateRangeFilter::make('tanggal_surat')->label(__('form.letter_date')),
                
            ], layout: FiltersLayout::AboveContent)->filtersFormColumns(2)
            ->filtersFormSchema(fn (array $filters): array => [
                Section::make(__('global.label_outgoing_letter'))
                    // ->description('These filters affect the visibility of the records in the table.')
                    ->schema([
                        $filters['tanggal_agenda'],
                        $filters['tanggal_surat'],
                    ])
                        ->columns(2)
                    ->columnSpanFull(),
            ]);
    }
    protected function getHeaderActions(): array
    {
        return [
            Action::make('cetak')
                ->label(__('form.print'))
                ->color('info')
                ->icon('heroicon-o-printer')
                ->url(function () {
                    // Ensure filters are passed correctly
                    $filters = $this->tableFilters ?? [];
                    
                    // Generate the route URL with filters
                    $url = route('surat-keluar-reports.cetak_keluar', ['filters' => $filters]);
                    
                    // Log or debug to check the URL
                    // dd($url);
                    return $url;
                })
                ->openUrlInNewTab(),
        ];
    }
}
