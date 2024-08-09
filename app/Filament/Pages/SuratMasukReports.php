<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;
use Filament\Forms;
use Filament\Tables;
use Filament\Actions\Action;
use Illuminate\Database\Eloquent\Builder;
use App\Models\SuratMasuk;
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
class SuratMasukReports extends Page implements HasTable,HasForms
{
    use InteractsWithTable;
    use InteractsWithForms;

    #[Url]
    public ?array $tableFilters = null;
    protected static ?string $navigationIcon = 'heroicon-o-document-text';
    protected static string $view = 'filament.pages.surat-masuk-reports';
    protected static ?string $model = SuratMasuk::class;

    protected function getHeaderActions(): array
    {
        return [
            Action::make('cetak')
                ->label(__('print'))
                ->color('info')
                ->icon('heroicon-o-printer')  
                ->url(route('surat-masuk-reports.cetak', ['filters' => $this->tableFilters])) // Pass filters if necessary
                ->openUrlInNewTab(), 
        ];
    }
    public function cetak()
    {
        // Ambil data sesuai dengan filter yang diterapkan
        $suratMasuk = $this->getFilteredTableQuery()->get();
    
        // Kirim data ke view untuk dicetak
        return response()->streamDownload(function () use ($suratMasuk) {
            $pdf = PDF::loadView('filament.pages.surat-masuk-reports-cetak', compact('suratMasuk'));
            echo $pdf->output();
        }, 'laporan_surat_masuk_' . Carbon::now()->format('d_m_Y_His') . '.pdf');
    }
    
    public function table(Table $table): Table
    {
        return $table
            ->query(SuratMasuk::query()->where('kd_ktm', auth()->user()->kd_ktm)
            ->where('kd_smk', auth()->user()->kd_smk))
            ->columns([
                TextColumn::make('nomor_agenda')
                ->label(__('form.no_agenda')),
                TextColumn::make('nomor_surat')
                ->label(__('form.letter_number')),

                TextColumn::make('tanggal_surat')
                ->label(__('form.letter_date')),

                Tables\Columns\TextColumn::make('terima_dari')
                    ->label(__('form.received_from')),

                TextColumn::make('perihal')
                    ->label('Perihal'),
            ])
            ->filters([
                DateRangeFilter::make('tanggal_agenda')->label(__('form.agenda_date')),
                DateRangeFilter::make('tanggal_surat')->label(__('form.letter_date')),
                
            ], layout: FiltersLayout::AboveContent)->filtersFormColumns(2)
            ->filtersFormSchema(fn (array $filters): array => [
                Section::make(__('global.label_incoming_letter'))
                    // ->description('These filters affect the visibility of the records in the table.')
                    ->schema([
                        $filters['tanggal_agenda'],
                        $filters['tanggal_surat'],
                    ])
                        ->columns(2)
                    ->columnSpanFull(),
            ]);
    }
}
