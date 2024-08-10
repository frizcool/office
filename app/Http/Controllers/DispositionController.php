<?php

namespace App\Http\Controllers;

use App\Models\Disposisi;
use App\Models\SuratMasuk;
use App\Models\SuratKeluar;
use App\Models\Kopstuk;
use App\Models\User;
use App\Models\DisposisiList;
use Illuminate\Http\Request;
use App\Models\DisposisiSuratKeluar;
use Illuminate\Support\Carbon;
use PDF;

class DispositionController extends Controller
{
    public function print($id)
    {
        $disposisi = Disposisi::with('suratMasuk')->findOrFail($id);
        $disposisi_list = DisposisiList::all();
        $pejabat = User::where('kd_ktm', $disposisi->suratMasuk->kd_ktm)->where('kd_smk', $disposisi->suratMasuk->kd_smk)->whereNot('id',$disposisi->user_id)->whereDoesntHave('roles', function ($query) {
            $query->where('name', 'super_admin');
        })->get();
        $kopstuk = Kopstuk::where('kd_ktm', $disposisi->suratMasuk->kd_ktm)->where('kd_smk', $disposisi->suratMasuk->kd_smk)->first();
        return view('dispositions.print', ['disposisi'=>$disposisi,'kopstuk'=>$kopstuk,'pejabat'=>$pejabat,'disposisi_list'=>$disposisi_list]);
    }

    public function print_v2($id)
    {
        $disposisi = Disposisi::with('suratMasuk')->findOrFail($id);
        $disposisi_list = DisposisiList::all();
        $pejabat = User::where('kd_ktm', $disposisi->suratMasuk->kd_ktm)
            ->where('kd_smk', $disposisi->suratMasuk->kd_smk)
            ->whereNot('id', $disposisi->user_id)
            ->whereHas('roles', function ($query) {
                $query->where('name', 'eselon_pelaksana');
            })->get();
        $kopstuk = Kopstuk::where('kd_ktm', $disposisi->suratMasuk->kd_ktm)
            ->where('kd_smk', $disposisi->suratMasuk->kd_smk)
            ->first();        
        $data = [
            'disposisi' => $disposisi,
            'kopstuk' => $kopstuk,
            'pejabat' => $pejabat,
            'disposisi_list' => $disposisi_list,
        ];
        $pdf = PDF::loadView('dispositions.print_v2', $data);
        return $pdf->stream('disposisi_'.$id.'.pdf');
    }

    public function exportPdf($id)
    {
        $disposisi = Disposisi::with('suratMasuk')->findOrFail($id);
        $disposisi_list = DisposisiList::all();
        $pejabat = User::where('kd_ktm', $disposisi->suratMasuk->kd_ktm)->where('kd_smk', $disposisi->suratMasuk->kd_smk)->whereNot('id', $disposisi->user_id)->whereDoesntHave('roles', function ($query) {
            $query->where('name', 'super_admin');
        })->get();
        $kopstuk = Kopstuk::where('kd_ktm', $disposisi->suratMasuk->kd_ktm)->where('kd_smk', $disposisi->suratMasuk->kd_smk)->first();

        $data = [
            'disposisi' => $disposisi,
            'kopstuk' => $kopstuk,
            'pejabat' => $pejabat,
            'disposisi_list' => $disposisi_list,
        ];

        $pdf = PDF::loadView('dispositions.pdf', $data);
        return $pdf->stream('disposisi_'.$id.'.pdf');
    }
    public function generateDisposisiKeluar($id)
    {
        $disposisi = DisposisiSuratKeluar::findOrFail($id);
        $suratKeluar = $disposisi->suratKeluar;
        
        $kopstuk = Kopstuk::where('kd_ktm', $disposisi->suratKeluar->kd_ktm)
            ->where('kd_smk', $disposisi->suratKeluar->kd_smk)
            ->first();
        $data = [
            'disposisi' => $disposisi,
            'kopstuk' => $kopstuk,
            'suratKeluar' => $suratKeluar,
        ];

        $pdf = Pdf::loadView('dispositions.keluar', $data);
        return $pdf->stream('disposisi_surat_keluar_' . $id . '.pdf');
    }
    public function cetak(Request $request)
    {
        
        $kopstuk = Kopstuk::where('kd_ktm', auth()->user()->kd_ktm)
        ->where('kd_smk', auth()->user()->kd_smk)
            ->first();
        // Ambil data sesuai dengan filter yang diterapkan
        $suratMasuk = SuratMasuk::query();

  // Apply filters from the request if they exist
  if ($request->has('filters')) {
    $filters = $request->input('filters');

    // Access the correct array level and apply the 'tanggal_agenda' filter if present
    if (!empty($filters['tanggal_agenda']['tanggal_agenda'])) {
        $dates = explode(' - ', $filters['tanggal_agenda']['tanggal_agenda']);
        $startDate = Carbon::createFromFormat('d/m/Y', trim($dates[0]))->startOfDay();
        $endDate = Carbon::createFromFormat('d/m/Y', trim($dates[1]))->endOfDay();
        $suratMasuk->whereBetween('tanggal_agenda', [$startDate, $endDate]);
    }

    // Access the correct array level and apply the 'tanggal_surat' filter if present
    if (!empty($filters['tanggal_surat']['tanggal_surat'])) {
        $dates = explode(' - ', $filters['tanggal_surat']['tanggal_surat']);
        $startDate = Carbon::createFromFormat('d/m/Y', trim($dates[0]))->startOfDay();
        $endDate = Carbon::createFromFormat('d/m/Y', trim($dates[1]))->endOfDay();
        $suratMasuk->whereBetween('tanggal_surat', [$startDate, $endDate]);
    }
}



        $suratMasuk = $suratMasuk->get();

        // Kirim data ke view untuk dicetak
        $pdf = PDF::loadView('filament.pages.surat-masuk-reports-cetak', compact('suratMasuk'),[ 'kopstuk' => $kopstuk]);

        return $pdf->stream('laporan_surat_masuk_' . Carbon::now()->format('d_m_Y_His') . '.pdf');
    }
    public function cetak_keluar(Request $request)
    {
        
        $kopstuk = Kopstuk::where('kd_ktm', auth()->user()->kd_ktm)
        ->where('kd_smk', auth()->user()->kd_smk)
            ->first();
            // dd($kopstuk);
        // Ambil data sesuai dengan filter yang diterapkan
        $suratKeluar = SuratKeluar::query();

 // Apply filters from the request if they exist
 if ($request->has('filters')) {
    $filters = $request->input('filters');

    // Access the correct array level and apply the 'tanggal_agenda' filter if present
    if (!empty($filters['tanggal_agenda']['tanggal_agenda'])) {
        $dates = explode(' - ', $filters['tanggal_agenda']['tanggal_agenda']);
        $startDate = Carbon::createFromFormat('d/m/Y', trim($dates[0]))->startOfDay();
        $endDate = Carbon::createFromFormat('d/m/Y', trim($dates[1]))->endOfDay();
        $suratKeluar->whereBetween('tanggal_agenda', [$startDate, $endDate]);
    }

    // Access the correct array level and apply the 'tanggal_surat' filter if present
    if (!empty($filters['tanggal_surat']['tanggal_surat'])) {
        $dates = explode(' - ', $filters['tanggal_surat']['tanggal_surat']);
        $startDate = Carbon::createFromFormat('d/m/Y', trim($dates[0]))->startOfDay();
        $endDate = Carbon::createFromFormat('d/m/Y', trim($dates[1]))->endOfDay();
        $suratKeluar->whereBetween('tanggal_surat', [$startDate, $endDate]);
    }
}

        $suratKeluar = $suratKeluar->get();

        // Kirim data ke view untuk dicetak
        $pdf = PDF::loadView('filament.pages.surat-keluar-reports-cetak', compact('suratKeluar'),[ 'kopstuk' => $kopstuk]);

        return $pdf->stream('laporan_surat_keluar_' . Carbon::now()->format('d_m_Y_His') . '.pdf');
    }
}
