<?php

namespace App\Http\Controllers;

use App\{Account, Mutation, Bank, User};
use Carbon\Carbon;
use Illuminate\Http\Request;
#use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;
#use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Crypt;
use Alert;

class MutationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $cek_sum_debit = Mutation::where('user_id', '=', Auth::user()->id)->sum('debit');
        $cek_sum_credit = Mutation::where('user_id', '=', Auth::user()->id)->sum('credit');

        $last_mutasi_debit = Mutation::where([
            ['user_id', '=', Auth::user()->id],
            ['debit', '=', 0],
        ])->max('created_at');

        $last_mutasi_credit = Mutation::where([
            ['user_id', '=', Auth::user()->id],
            ['credit', '=', 0],
        ])->max('created_at');

        $cek_sum_debit_month = Mutation::where('user_id', '=', Auth::user()->id)
            ->whereYear('date', Carbon::now()->year)
            ->whereMonth('date', Carbon::now()->month)
            ->sum('debit');

        $cek_sum_credit_month = Mutation::where('user_id', '=', Auth::user()->id)
            ->whereYear('date', Carbon::now()->year)
            ->whereMonth('date', Carbon::now()->month)
            ->sum('credit');


        $mutations = Mutation::where('user_id', Auth::user()->id)
            ->orderByRaw('created_at DESC')
            ->get();

        return view('mutation.index', [
            'mutations' => $mutations,
            'cek_sum_debit' => $cek_sum_debit,
            'cek_sum_credit' => $cek_sum_credit,
            'cek_sum_debit_month' => $cek_sum_debit_month,
            'cek_sum_credit_month' => $cek_sum_credit_month,
            'last_mutasi_debit' => $last_mutasi_debit,
            'last_mutasi_credit' => $last_mutasi_credit
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('mutation.create', [
            'banks' => Bank::get(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $messages = [
            'rek_tujuan.required'         => 'Rek Tujuan Harus Diisi',
            'description.required'     => 'Deskripsi Harus Diisi',
            'debit.required'           => 'Debit Harus Diisi',
            'date.required'            => 'Tanggal harus diisi',
        ];

        //buat validasi form
        $request->validate([
            'rek_tujuan'      => 'required',
            'description'      => 'required',
            'debit'      => 'required',
            'date'        => 'required',
        ], $messages);
        $nominal_debit    = str_replace(",", "", $request->debit);
        #$nominal_kredit    = str_replace(",", "", $request->credit);
        $nominal_kredit    = $request->nominal_kredit;
        #$rek_tujuan    = $request->rek_tujuan;

        $bank_name    =  $request->bank_name;
        $description    =  $request->description;
        $id    =  $request->bank_id;
        $slug  =  $request->slug;
        $desc = $description . ' (Terima Dana dari ' . $bank_name . ')';


        $cek_sum_credit = Mutation::where([
            ['bank_id', '=', $request->bank_id],
            ['user_id', '=', Auth::user()->id],
        ])->sum('credit');

        if ($nominal_debit < $cek_sum_credit) {

            $data = [
                [
                    //pendebetan
                    'bank_id'       => $request->bank_id,
                    'user_id'       => $request->user_id,
                    'description'   => $request->description,
                    'debit'         => $nominal_debit,
                    'credit'        => $nominal_kredit,
                    'date'          => $request->date,
                    'created_at' =>  \Carbon\Carbon::now(),
                    'updated_at' => \Carbon\Carbon::now(),

                ],
                [
                    //penambahan
                    'bank_id'       => $request->rek_tujuan,
                    'user_id'       => $request->user_id,
                    'description'   => $desc,
                    'debit'         => $nominal_kredit,
                    'credit'        => $nominal_debit,
                    'date'          => $request->date,
                    'created_at' =>  \Carbon\Carbon::now(),
                    'updated_at' => \Carbon\Carbon::now(),
                ],
            ];
            Mutation::insert($data);
            return redirect('/mutation/' . $id . '/' . $slug)->with('sukses', 'Data Berhasil DiSimpan.');
        } else {
            #return redirect('/mutation/' . $id . '/' . $slug)->with('gagal', 'Data Gagal DiSimpan.');
            return redirect('/mutation');
        }
        /* atau bisa juga dengan cara eloquent */
        /*Mutation::create([
            'account_id'       => $request->account_id,
            'bank_id'       => $request->bank_id,
            'user_id'       => $request->user_id,
            'description'   => $request->description,
            'debit'         => $nominal_debit,
            'credit'        => $nominal_kredit,
            'date'          => $request->date,
        ]);
        Mutation::create([
            'account_id'       => $request->account_id,
            'bank_id'       => $rek_tujuan,
            'user_id'       => $request->user_id,
            'description'   => $request->description,
            'debit'         => $nominal_kredit,
            'credit'        => $nominal_debit,
            'date'          => $request->date,
        ]);*/
    }

    public function storeCredit(Request $request)
    {
        #dd($request);
        $messages = [
            'description.required'     => 'Deskripsi Harus Diisi',
            'credit.required'           => 'Credit Harus Diisi',
            'date.required'            => 'Tanggal harus diisi',
        ];

        //buat validasi form
        $request->validate([
            'description'      => 'required',
            'credit'      => 'required',
            'date'        => 'required',
        ], $messages);

        $nominal_credit    = str_replace(",", "", $request->credit);
        #$nominal_kredit    = str_replace(",", "", $request->credit);
        $nominal_debit    = $request->nominal_debit;
        #$rek_tujuan    = $request->rek_tujuan;


        $id    =  $request->bank_id;
        $slug  =  $request->slug;

        Mutation::create([
            'bank_id'       => $request->bank_id,
            'user_id'       => $request->user_id,
            'description'   => $request->description,
            'debit'         => $nominal_debit,
            'credit'        => $nominal_credit,
            'date'          => $request->date,
        ]);

        return redirect('/mutation/' . $id . '/' . $slug)->with('sukses', 'Data Berhasil DiSimpan.');
    }

    public function storeBayar(Request $request)
    {
        $messages = [
            'description.required'     => 'Deskripsi Harus Diisi',
            'debit.required'           => 'Debit Harus Diisi',
            'date.required'            => 'Tanggal harus diisi',
        ];

        $request->validate([
            'description'      => 'required',
            'debit'      => 'required',
            'date'        => 'required',
        ], $messages);
        $nominal_debit    = str_replace(",", "", $request->debit);


        $id    =  Crypt::encryptString($request->bank_id);
        $slug  =  $request->slug;
        $bank_name  =  $request->bank_name;
        $nominal_kredit    = $request->nominal_kredit;

        $cek_sum_credit = Mutation::where([
            ['bank_id', '=', $request->bank_id],
            ['user_id', '=', Auth::user()->id],
        ])->sum('credit');

        if ($nominal_debit < $cek_sum_credit) {
            Mutation::create([
                'bank_id'       => $request->bank_id,
                'user_id'       => $request->user_id,
                'description'   => $request->description,
                'debit'         => $nominal_debit,
                'credit'        => $nominal_kredit,
                'date'          => $request->date,
            ]);

            Alert::success('Berhasil', 'Data Berhasil di Simpan');
            return redirect('/mutation/' . $id . '/' . $bank_name);
        } else {
            #return redirect('/mutation/' . $id . '/' . $slug)->with('gagal', 'Data Gagal DiSimpan.');
            return redirect('/mutation');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function showbank($id)
    {
        $cek_sum_debit = Mutation::where([
            ['bank_id', '=', $id],
            ['user_id', '=', Auth::user()->id],
        ])->sum('debit');

        $cek_sum_credit = Mutation::where([
            ['bank_id', '=', $id],
            ['user_id', '=', Auth::user()->id],
        ])->sum('credit');

        $last_mutasi_debit = Mutation::where([
            ['bank_id', '=', $id],
            ['user_id', '=', Auth::user()->id],
            ['debit', '=', 0],
        ])->max('created_at');

        $last_mutasi_credit = Mutation::where([
            ['bank_id', '=', $id],
            ['user_id', '=', Auth::user()->id],
            ['credit', '=', 0],
        ])->max('created_at');

        $cek_sum_debit_month = Mutation::where([
            ['bank_id', '=', $id],
            ['user_id', '=', Auth::user()->id],
        ])
            ->whereYear('date', Carbon::now()->year)
            ->whereMonth('date', Carbon::now()->month)
            ->sum('debit');

        $cek_sum_credit_month = Mutation::where([
            ['bank_id', '=', $id],
            ['user_id', '=', Auth::user()->id],
        ])
            ->whereYear('date', Carbon::now()->year)
            ->whereMonth('date', Carbon::now()->month)
            ->sum('credit');

        $mutations = Mutation::where([
            ['bank_id', '=', $id],
            ['user_id', '=', Auth::user()->id],
        ])
            ->orderByRaw('created_at DESC')
            ->get();

        if ($id == 1) {
            $bank_name = 'BCA';
            return view('mutation.m_bca', [
                'bank_name' => $bank_name,
                'mutations' => $mutations,
                'cek_sum_debit' => $cek_sum_debit,
                'cek_sum_credit' => $cek_sum_credit,
                'cek_sum_debit_month' => $cek_sum_debit_month,
                'cek_sum_credit_month' => $cek_sum_credit_month,
                'last_mutasi_debit' => $last_mutasi_debit,
                'last_mutasi_credit' => $last_mutasi_credit
            ]);
        } elseif ($id == 2) {
            $bank_name = 'BNI';
            return view('mutation.m_bni', [
                'bank_name' => $bank_name,
                'mutations' => $mutations,
                'cek_sum_debit' => $cek_sum_debit,
                'cek_sum_credit' => $cek_sum_credit,
                'cek_sum_debit_month' => $cek_sum_debit_month,
                'cek_sum_credit_month' => $cek_sum_credit_month,
                'last_mutasi_debit' => $last_mutasi_debit,
                'last_mutasi_credit' => $last_mutasi_credit
            ]);
        } elseif ($id == 3) {
            $bank_name = 'CIMB';
            return view('mutation.m_cimb', [
                'bank_name' => $bank_name,
                'mutations' => $mutations,
                'cek_sum_debit' => $cek_sum_debit,
                'cek_sum_credit' => $cek_sum_credit,
                'cek_sum_debit_month' => $cek_sum_debit_month,
                'cek_sum_credit_month' => $cek_sum_credit_month,
                'last_mutasi_debit' => $last_mutasi_debit,
                'last_mutasi_credit' => $last_mutasi_credit
            ]);
        } elseif ($id == 4) {
            $bank_name = 'DBS';
            return view('mutation.m_dbs', [
                'bank_name' => $bank_name,
                'mutations' => $mutations,
                'cek_sum_debit' => $cek_sum_debit,
                'cek_sum_credit' => $cek_sum_credit,
                'cek_sum_debit_month' => $cek_sum_debit_month,
                'cek_sum_credit_month' => $cek_sum_credit_month,
                'last_mutasi_debit' => $last_mutasi_debit,
                'last_mutasi_credit' => $last_mutasi_credit
            ]);
        } elseif ($id == 5) {
            $bank_name = 'Danamon';
            return view('mutation.m_danamon', [
                'bank_name' => $bank_name,
                'mutations' => $mutations,
                'cek_sum_debit' => $cek_sum_debit,
                'cek_sum_credit' => $cek_sum_credit,
                'cek_sum_debit_month' => $cek_sum_debit_month,
                'cek_sum_credit_month' => $cek_sum_credit_month,
                'last_mutasi_debit' => $last_mutasi_debit,
                'last_mutasi_credit' => $last_mutasi_credit
            ]);
        } elseif ($id == 6) {
            $bank_name = 'Panin';
            return view('mutation.m_panin', [
                'bank_name' => $bank_name,
                'mutations' => $mutations,
                'cek_sum_debit' => $cek_sum_debit,
                'cek_sum_credit' => $cek_sum_credit,
                'cek_sum_debit_month' => $cek_sum_debit_month,
                'cek_sum_credit_month' => $cek_sum_credit_month,
                'last_mutasi_debit' => $last_mutasi_debit,
                'last_mutasi_credit' => $last_mutasi_credit
            ]);
        } elseif ($id == 7) {
            $bank_name = 'CC BCA';
            return view('mutation.m_cc_bca', [
                'bank_name' => $bank_name,
                'mutations' => $mutations,
                'cek_sum_debit' => $cek_sum_debit,
                'cek_sum_credit' => $cek_sum_credit,
                'cek_sum_debit_month' => $cek_sum_debit_month,
                'cek_sum_credit_month' => $cek_sum_credit_month,
                'last_mutasi_debit' => $last_mutasi_debit,
                'last_mutasi_credit' => $last_mutasi_credit
            ]);
        } elseif ($id == 8) {
            $bank_name = 'CC Niaga Master';
            return view('mutation.m_cc_niaga_master', [
                'bank_name' => $bank_name,
                'mutations' => $mutations,
                'cek_sum_debit' => $cek_sum_debit,
                'cek_sum_credit' => $cek_sum_credit,
                'cek_sum_debit_month' => $cek_sum_debit_month,
                'cek_sum_credit_month' => $cek_sum_credit_month,
                'last_mutasi_debit' => $last_mutasi_debit,
                'last_mutasi_credit' => $last_mutasi_credit
            ]);
        } elseif ($id == 9) {
            $bank_name = 'CC Niaga Syariah';
            return view('mutation.m_cc_niaga_syariah', [
                'bank_name' => $bank_name,
                'mutations' => $mutations,
                'cek_sum_debit' => $cek_sum_debit,
                'cek_sum_credit' => $cek_sum_credit,
                'cek_sum_debit_month' => $cek_sum_debit_month,
                'cek_sum_credit_month' => $cek_sum_credit_month,
                'last_mutasi_debit' => $last_mutasi_debit,
                'last_mutasi_credit' => $last_mutasi_credit
            ]);
        } elseif ($id == 10) {
            $bank_name = 'CC Panin';
            return view('mutation.m_cc_panin', [
                'bank_name' => $bank_name,
                'mutations' => $mutations,
                'cek_sum_debit' => $cek_sum_debit,
                'cek_sum_credit' => $cek_sum_credit,
                'cek_sum_debit_month' => $cek_sum_debit_month,
                'cek_sum_credit_month' => $cek_sum_credit_month,
                'last_mutasi_debit' => $last_mutasi_debit,
                'last_mutasi_credit' => $last_mutasi_credit
            ]);
        } elseif ($id == 11) {
            $bank_name = 'Cash';
            return view('mutation.m_cash', [
                'bank_name' => $bank_name,
                'mutations' => $mutations,
                'cek_sum_debit' => $cek_sum_debit,
                'cek_sum_credit' => $cek_sum_credit,
                'cek_sum_debit_month' => $cek_sum_debit_month,
                'cek_sum_credit_month' => $cek_sum_credit_month,
                'last_mutasi_debit' => $last_mutasi_debit,
                'last_mutasi_credit' => $last_mutasi_credit
            ]);
        } elseif ($id == 12) {
            $bank_name = 'GoPay';
            return view('mutation.m_gopay', [
                'bank_name' => $bank_name,
                'mutations' => $mutations,
                'cek_sum_debit' => $cek_sum_debit,
                'cek_sum_credit' => $cek_sum_credit,
                'cek_sum_debit_month' => $cek_sum_debit_month,
                'cek_sum_credit_month' => $cek_sum_credit_month,
                'last_mutasi_debit' => $last_mutasi_debit,
                'last_mutasi_credit' => $last_mutasi_credit
            ]);
        } elseif ($id == 13) {
            $bank_name = 'Cash';
            return view('mutation.m_ovo', [
                'bank_name' => $bank_name,
                'mutations' => $mutations,
                'cek_sum_debit' => $cek_sum_debit,
                'cek_sum_credit' => $cek_sum_credit,
                'cek_sum_debit_month' => $cek_sum_debit_month,
                'cek_sum_credit_month' => $cek_sum_credit_month,
                'last_mutasi_debit' => $last_mutasi_debit,
                'last_mutasi_credit' => $last_mutasi_credit
            ]);
        } elseif ($id == 14) {
            $bank_name = 'ShopeePay';
            return view('mutation.m_shopee_pay', [
                'bank_name' => $bank_name,
                'mutations' => $mutations,
                'cek_sum_debit' => $cek_sum_debit,
                'cek_sum_credit' => $cek_sum_credit,
                'cek_sum_debit_month' => $cek_sum_debit_month,
                'cek_sum_credit_month' => $cek_sum_credit_month,
                'last_mutasi_debit' => $last_mutasi_debit,
                'last_mutasi_credit' => $last_mutasi_credit
            ]);
        }
    }

    public function funds()
    {
        #$banks = Bank::whereNotIn('id', [7, 8, 9, 10])->get();
        $accounts = Account::where([
            ['user_id', '=', Auth::user()->id],
        ])->get();
        return view('mutation.v_funds', [
            'accounts' => $accounts
        ]);
    }

    public function fundsedit($id, $slug)
    {

        $decrypted = Crypt::decryptString($id);
        $cek_sum_debit = Mutation::where([
            ['bank_id', '=', $decrypted],
            ['user_id', '=', Auth::user()->id],
        ])->sum('debit');

        $cek_sum_credit = Mutation::where([
            ['bank_id', '=', $decrypted],
            ['user_id', '=', Auth::user()->id],
        ])->sum('credit');

        $last_mutasi_debit = Mutation::where([
            ['bank_id', '=', $decrypted],
            ['user_id', '=', Auth::user()->id],
            ['debit', '=', 0],
        ])->max('created_at');

        $last_mutasi_credit = Mutation::where([
            ['bank_id', '=', $decrypted],
            ['user_id', '=', Auth::user()->id],
            ['credit', '=', 0],
        ])->max('created_at');

        $cek_sum_debit_month = Mutation::where([
            ['bank_id', '=', $decrypted],
            ['user_id', '=', Auth::user()->id],
        ])
            ->whereYear('date', Carbon::now()->year)
            ->whereMonth('date', Carbon::now()->month)
            ->sum('debit');

        $cek_sum_credit_month = Mutation::where([
            ['bank_id', '=', $decrypted],
            ['user_id', '=', Auth::user()->id],
        ])
            ->whereYear('date', Carbon::now()->year)
            ->whereMonth('date', Carbon::now()->month)
            ->sum('credit');

        $mutations = Mutation::where([
            ['bank_id', '=', $decrypted],
            ['user_id', '=', Auth::user()->id],
        ])
            ->orderByRaw('created_at DESC')
            ->get();

        return view('mutation.m_banking', [
            #'account' => $account,
            'banks' => Bank::get(),
            'users' => User::get(),
            'cek_sum_debit' => $cek_sum_debit,
            'cek_sum_credit' => $cek_sum_credit,
            'cek_sum_debit_month' => $cek_sum_debit_month,
            'cek_sum_credit_month' => $cek_sum_credit_month,
            'last_mutasi_debit' => $last_mutasi_debit,
            'last_mutasi_credit' => $last_mutasi_credit,
            'slug' => $slug,
            'id' => $decrypted,
            'mutations' => $mutations,

        ]);
    }

    public function debit(bank $bank)
    {
        return view('mutation.debit', [
            'banks' => Bank::get(),
            'account' => $bank,
        ]);
    }

    public function credit(bank $bank)
    {
        return view('mutation.credit', [
            'banks' => Bank::get(),
            'account' => $bank,
        ]);
    }

    public function bayar(bank $bank)
    {
        return view('mutation.bayar', [
            'banks' => Bank::get(),
            'account' => $bank,
        ]);
    }
}
