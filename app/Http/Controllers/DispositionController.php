<?php

namespace App\Http\Controllers;

use App\Models\Disposisi;
use App\Models\SuratMasuk;
use App\Models\Kopstuk;
use App\Models\User;
use App\Models\DisposisiList;
use Illuminate\Http\Request;
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
        // return view('dispositions.print_v2', [
        //     'disposisi' => $disposisi,
        //     'kopstuk' => $kopstuk,
        //     'pejabat' => $pejabat,
        //     'disposisi_list' => $disposisi_list
        // ]);
        
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
}
