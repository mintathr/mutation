<?php

namespace App\Http\Controllers;

use App\{Mutation, Bank};
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    public function index()
    {
        $cek_sum_debit_today = DB::table('mutations as a')
            ->leftJoin('accounts as b', 'a.account_id_to', '=', 'b.id')
            ->where('a.user_id', '=', Auth::user()->id)
            ->where('b.flag', '=', 'Pribadi')
            ->whereDate('a.date', Carbon::today())
            ->sum('debit');
        $cek_sum_credit_today = DB::table('mutations as a')
            ->leftJoin('accounts as b', 'a.account_id_to', '=', 'b.id')
            ->where('a.user_id', '=', Auth::user()->id)
            ->where('b.flag', '=', 'Pribadi')
            ->whereDate('a.date', Carbon::today())
            ->sum('credit');

        $mutations = DB::table('mutations as a')
            ->leftJoin('accounts as b', 'a.account_id', '=', 'b.id')
            ->leftJoin('banks as c', 'b.bank_id', '=', 'c.id')
            ->leftJoin('accounts as d', 'a.account_id_to', '=', 'd.id')
            ->leftJoin('banks as e', 'd.bank_id', '=', 'e.id')
            ->select(
                'a.*',
                'b.no_rekening',
                'b.bank_id',
                'b.name_account',
                'b.flag',
                'b.keterangan',
                'd.no_rekening as no_rekening_tujuan',
                'd.bank_id as bank_id_tujuan',
                'd.name_account as name_account_tujuan',
                'd.flag as flag_tujuan',
                'd.keterangan as keterangan_tujuan',
                'c.name',
                'e.name as bank_tujuan',
                'd.flag as flag_tujuan'
            )
            ->orderByRaw('created_at DESC')
            ->get();

        return view('home', [
            'mutations' => $mutations,
            'cek_sum_debit_today' => $cek_sum_debit_today,
            'cek_sum_credit_today' => $cek_sum_credit_today,
        ]);
    }
}
