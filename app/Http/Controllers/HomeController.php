<?php

namespace App\Http\Controllers;

use App\{Mutation, Bank};
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function index()
    {
        //$posts = Post::whereDate('created_at', Carbon::today())->get();
        #return view('home');
        $cek_sum_debit_today = Mutation::where('user_id', '=', Auth::user()->id)
            ->whereDate('date', Carbon::today())
            ->sum('debit');
        $cek_sum_credit_today = Mutation::where('user_id', '=', Auth::user()->id)
            ->whereDate('date', Carbon::today())
            ->sum('credit');

        $mutations = Mutation::where('user_id', Auth::user()->id)
            ->whereDate('date', Carbon::today())
            ->orderByRaw('created_at DESC')
            ->get();

        return view('home', [
            'mutations' => $mutations,
            'cek_sum_debit_today' => $cek_sum_debit_today,
            'cek_sum_credit_today' => $cek_sum_credit_today,
        ]);
    }
}
