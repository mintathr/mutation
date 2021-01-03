<?php

namespace App\Http\Controllers;

use App\{Account, Mutation, Bank, User};
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Alert;
use Illuminate\Support\Facades\DB;
#use App\Traits\Side_Accounts;

class MutationController extends Controller
{
    #use Side_Accounts; //ini seperti helpers membuat class sendiri
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $cek_sum_debit = DB::table('mutations as a')
            ->leftJoin('accounts as b', 'a.account_id', '=', 'b.id')
            ->where('a.user_id', '=', Auth::user()->id)
            ->where('b.flag', '=', 'Pribadi')
            ->sum('debit');

        $cek_sum_credit = DB::table('mutations as a')
            ->leftJoin('accounts as b', 'a.account_id', '=', 'b.id')
            ->where('a.user_id', '=', Auth::user()->id)
            ->where('b.flag', '=', 'Pribadi')
            ->sum('credit');

        /* $cek_sum_debit = Mutation::where('user_id', '=', Auth::user()->id)->sum('debit');
        $cek_sum_credit = Mutation::where('user_id', '=', Auth::user()->id)->sum('credit'); */

        $last_mutasi_debit = Mutation::where([
            ['user_id', '=', Auth::user()->id],
            ['debit', '=', 0],
        ])->max('created_at');

        $last_mutasi_credit = Mutation::where([
            ['user_id', '=', Auth::user()->id],
            ['credit', '=', 0],
        ])->max('created_at');

        $cek_sum_debit_month = DB::table('mutations as a')
            ->leftJoin('accounts as b', 'a.account_id', '=', 'b.id')
            ->where('a.user_id', '=', Auth::user()->id)
            ->where('b.flag', '=', 'Pribadi')
            ->whereYear('a.date', Carbon::now()->year)
            ->whereMonth('a.date', Carbon::now()->month)
            ->sum('debit');

        $cek_sum_credit_month = DB::table('mutations as a')
            ->leftJoin('accounts as b', 'a.account_id', '=', 'b.id')
            ->where('a.user_id', '=', Auth::user()->id)
            ->where('b.flag', '=', 'Pribadi')
            ->whereYear('a.date', Carbon::now()->year)
            ->whereMonth('a.date', Carbon::now()->month)
            ->sum('credit');

        /* $cek_sum_debit_month = Mutation::where('user_id', '=', Auth::user()->id)
            ->whereYear('date', Carbon::now()->year)
            ->whereMonth('date', Carbon::now()->month)
            ->sum('debit');

        $cek_sum_credit_month = Mutation::where('user_id', '=', Auth::user()->id)
            ->whereYear('date', Carbon::now()->year)
            ->whereMonth('date', Carbon::now()->month)
            ->sum('credit'); */

        $saldo_bulan_ini = $cek_sum_credit_month - $cek_sum_debit_month;
        $saldo_all = $cek_sum_credit - $cek_sum_debit;

        /* $mutations = Mutation::where('user_id', Auth::user()->id)
            ->orderByRaw('created_at DESC')
            ->get(); */

        $mutations = DB::table('mutations as a')
            ->leftJoin('accounts as b', 'a.account_id', '=', 'b.id')
            ->leftJoin('banks as c', 'b.bank_id', '=', 'c.id')
            ->leftJoin('accounts as d', 'a.account_id_to', '=', 'd.id')
            ->leftJoin('banks as e', 'd.bank_id', '=', 'e.id')
            ->where('a.user_id', '=', Auth::user()->id)
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

        /* $side_banks = DB::table('accounts as a')
            ->leftJoin('banks as b', 'a.bank_id', '=', 'b.id')
            ->select(
                'a.*',
                'b.name'
            )
            ->orderBy('b.name', 'ASC')
            ->get(); */
        #$side_banks = AccountsHelp::getAccount();

        return view('mutation.index', [
            'mutations' => $mutations,
            'cek_sum_debit' => $cek_sum_debit,
            'cek_sum_credit' => $cek_sum_credit,
            'cek_sum_debit_month' => $cek_sum_debit_month,
            'cek_sum_credit_month' => $cek_sum_credit_month,
            'last_mutasi_debit' => $last_mutasi_debit,
            'last_mutasi_credit' => $last_mutasi_credit,
            'saldo_bulan_ini' => $saldo_bulan_ini,
            'saldo_all' => $saldo_all,

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

            'side_banks' => Account::get()
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
        #dd($request);
        $messages = [
            'account_id_to.required'   => 'Rek Tujuan Harus Diisi',
            'description.required'     => 'Deskripsi Harus Diisi',
            'debit.required'           => 'Debit Harus Diisi',
            'date.required'            => 'Tanggal harus diisi',
        ];

        //buat validasi form
        $request->validate([
            'account_id_to'     => 'required',
            'description'       => 'required',
            'debit'             => 'required',
            'date'              => 'required',
        ], $messages);
        $nominal_debit    = str_replace(",", "", $request->debit);
        $nominal_kredit    = $request->nominal_kredit;

        $user_id    = $request->user_id;
        $account_id = $request->account_id;
        $bank_name  = $request->bank_name;
        $slug       = $request->slug;
        $id         = $request->id;
        $desc       = 'Terima dana dari ' . $bank_name;

        $cek_sum_credit = DB::table('mutations as a')
            ->leftJoin('accounts as b', 'a.account_id', '=', 'b.id')
            ->where('a.user_id', '=', Auth::user()->id)
            ->where('b.flag', '=', 'Pribadi')
            ->where('a.account_id', '=', $request->account_id)
            ->sum('credit');

        $cek_rek_others = Account::where('id', '=', $request->account_id_to)
            ->where('flag', '=', 'pribadi')
            ->first();

        if ($nominal_debit < $cek_sum_credit) {
            if ($cek_rek_others === NULL) {
                $data = [
                    [
                        //pendebetan
                        'account_id'    => $request->account_id,
                        'user_id'       => $request->user_id,
                        'description'   => $request->description,
                        'debit'         => $nominal_debit,
                        'credit'        => $nominal_kredit,
                        'account_id_to' => $request->account_id_to,
                        'date'          => $request->date,
                        'created_at' =>  \Carbon\Carbon::now(),
                        'updated_at' => \Carbon\Carbon::now(),
                    ],
                ];
            } else {
                $data = [
                    [
                        //pendebetan
                        'account_id'    => $request->account_id,
                        'user_id'       => $request->user_id,
                        'description'   => $request->description,
                        'debit'         => $nominal_debit,
                        'credit'        => $nominal_kredit,
                        'account_id_to' => $request->account_id_to,
                        'date'          => $request->date,
                        'created_at' =>  \Carbon\Carbon::now(),
                        'updated_at' => \Carbon\Carbon::now(),
                    ],
                    [
                        //penambahan
                        'account_id'    => $request->account_id_to,
                        'user_id'       => $request->user_id,
                        'description'   => $desc,
                        'debit'         => $nominal_kredit,
                        'credit'        => $nominal_debit,
                        'account_id_to' => $request->account_id,
                        'date'          => $request->date,
                        'created_at' =>  \Carbon\Carbon::now(),
                        'updated_at' => \Carbon\Carbon::now(),
                    ],
                ];
            }
            Mutation::insert($data);

            toast('Transfer dari ' . $bank_name . ' Berhasil', 'success', 'top-right');
            return redirect('/mutation/' . $id . '/' . $slug);
        } else {
            toast('Dana Anda Tidak Cukup', 'error');
            return redirect('/mutation/' . $id . '/' . $slug);
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
        $messages = [
            'account_id_to.required'  => 'Sumber Dana Harus Diisi',
            'description.required'    => 'Deskripsi Harus Diisi',
            'credit.required'         => 'Credit Harus Diisi',
            'date.required'           => 'Tanggal harus diisi',
        ];

        $request->validate([
            'account_id_to'  => 'required',
            'description' => 'required',
            'credit'      => 'required',
            'date'        => 'required',
        ], $messages);

        $nominal_credit    = str_replace(",", "", $request->credit);
        $nominal_debit    = $request->nominal_debit;

        $bank_name      = $request->bank_name;
        $slug           = $request->slug;
        $id             = $request->id;

        Mutation::create([
            'account_id'    => $request->account_id, //dibalik karena terima dana dari luar
            'user_id'       => $request->user_id,
            'description'   => $request->description,
            'debit'         => $nominal_debit,
            'credit'        => $nominal_credit,
            'account_id_to' => $request->account_id_to,
            'date'          => $request->date,
        ]);

        toast('Top Up ke ' . $bank_name . ' Berhasil', 'success');
        return redirect('/mutation/' . $id . '/' . $slug);
    }

    public function storeBayarDetail(Request $request)
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

        $slug     =  $request->slug;
        $id             =  $request->id;
        $bank_name      =  $request->bank_name;
        $nominal_credit = $request->nominal_credit;

        $cek_sum_credit = DB::table('mutations as a')
            ->leftJoin('accounts as b', 'a.account_id', '=', 'b.id')
            ->where('a.user_id', '=', Auth::user()->id)
            ->where('b.flag', '=', 'Pribadi')
            ->where('a.account_id', '=', $request->account_id)
            ->sum('credit');

        if ($nominal_debit < $cek_sum_credit) {

            Mutation::create([
                'account_id'    => $request->account_id,
                'user_id'       => $request->user_id,
                'description'   => $request->description,
                'debit'         => $nominal_debit,
                'credit'        => $nominal_credit,
                'account_id_to' => 0,
                'date'          => $request->date,
            ]);

            #Alert::success('Berhasil', 'Data Berhasil di Simpan');
            toast('Pembayaran Dari ' . $bank_name . ' Berhasil', 'success');
            return redirect('/mutation/' . $id . '/' . $slug);
        } else {
            toast('Dana Anda Tidak Cukup', 'error', 'top-right');
            return redirect('/mutation/' . $id . '/' . $slug);
        }
    }

    public function storeTarik(Request $request)
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
        $slug           = $request->slug;
        $bank_name      = $request->bank_name;
        $nominal_kredit = $request->nominal_kredit;
        $id    = $request->id;

        $cek_sum_credit = DB::table('mutations as a')
            ->leftJoin('accounts as b', 'a.account_id', '=', 'b.id')
            ->where('a.user_id', '=', Auth::user()->id)
            ->where('b.flag', '=', 'Pribadi')
            ->where('a.account_id', '=', $request->account_id)
            ->sum('credit');

        if ($nominal_debit < $cek_sum_credit) {
            Mutation::create([
                'account_id'    => $request->account_id,
                'user_id'       => $request->user_id,
                'description'   => $request->description,
                'debit'         => $nominal_debit,
                'credit'        => $nominal_kredit,
                'account_id_to' => 0,
                'date'          => $request->date,
            ]);

            toast('Tarik Tunai ' . $bank_name . ' Berhasil', 'success');
            return redirect('/mutation/' . $id . '/' . $slug);
        } else {
            toast('Dana Anda Tidak Cukup', 'error');
            return redirect('/mutation/' . $id . '/' . $slug);
        }
    }

    public function funds()
    {
        $accounts = Account::where([
            ['user_id', '=', Auth::user()->id],
            ['flag', '=', 'pribadi'],
        ])->get();
        return view('mutation.v_funds', [
            'accounts' => $accounts,

        ]);
    }

    public function fundsedit($id, bank $bank)
    {
        $decrypted = Crypt::decryptString($id);

        $cek_sum_debit = DB::table('mutations as a')
            ->leftJoin('accounts as b', 'a.account_id', '=', 'b.id')
            ->where('a.user_id', '=', Auth::user()->id)
            ->where('b.flag', '=', 'Pribadi')
            ->where('a.account_id', '=', $decrypted)
            ->sum('debit');

        $cek_sum_credit = DB::table('mutations as a')
            ->leftJoin('accounts as b', 'a.account_id', '=', 'b.id')
            ->where('a.user_id', '=', Auth::user()->id)
            ->where('b.flag', '=', 'Pribadi')
            ->where('a.account_id', '=', $decrypted)
            ->sum('credit');

        $cek_sum_debit_month = DB::table('mutations as a')
            ->leftJoin('accounts as b', 'a.account_id', '=', 'b.id')
            ->where('a.user_id', '=', Auth::user()->id)
            ->where('b.flag', '=', 'Pribadi')
            ->where('a.account_id', '=', $decrypted)
            ->whereYear('a.date', Carbon::now()->year)
            ->whereMonth('a.date', Carbon::now()->month)
            ->sum('debit');

        $cek_sum_credit_month = DB::table('mutations as a')
            ->leftJoin('accounts as b', 'a.account_id', '=', 'b.id')
            ->where('a.user_id', '=', Auth::user()->id)
            ->where('b.flag', '=', 'Pribadi')
            ->where('a.account_id', '=', $decrypted)
            ->whereYear('a.date', Carbon::now()->year)
            ->whereMonth('a.date', Carbon::now()->month)
            ->sum('credit');

        $mutations = DB::table('mutations as a')
            ->leftJoin('accounts as b', 'a.account_id', '=', 'b.id')
            ->leftJoin('banks as c', 'b.bank_id', '=', 'c.id')
            ->leftJoin('accounts as d', 'a.account_id_to', '=', 'd.id')
            ->leftJoin('banks as e', 'd.bank_id', '=', 'e.id')
            ->where('a.user_id', '=', Auth::user()->id)
            ->where('a.account_id', '=', $decrypted)
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

        $saldo_all = $cek_sum_credit - $cek_sum_debit;
        #$id_account = Account::find($decrypted);

        return view('mutation.m_banking', [
            'bank' => $bank,
            'cek_sum_debit' => $cek_sum_debit,
            'cek_sum_credit' => $cek_sum_credit,
            'cek_sum_debit_month' => $cek_sum_debit_month,
            'cek_sum_credit_month' => $cek_sum_credit_month,
            'id' => $id,
            'mutations' => $mutations,
            #'id_account' => $id_account,
            'saldo_all' => $saldo_all,
        ]);
    }

    public function debit(bank $bank, $id)
    {
        $decrypted = Crypt::decryptString($id);

        $id_account = DB::table('accounts')
            ->join('banks', 'accounts.bank_id', '=', 'banks.id')
            ->where('accounts.id', '=', $decrypted)
            ->select('accounts.*', 'name', 'slug')
            ->first();

        $accounts = DB::table('accounts')
            ->join('banks', 'accounts.bank_id', '=', 'banks.id')
            ->where('accounts.user_id', '=', Auth::user()->id)
            ->where('accounts.id', '<>', $decrypted)
            ->select('accounts.*', 'name')
            ->orderBy('banks.name', 'asc')
            ->get();
        return view('mutation.debit', [
            'id_account'    => $id_account,
            'accounts'      => $accounts,
            'id'            => $id,
        ]);
    }

    public function credit(bank $bank, $id)
    {
        $decrypted = Crypt::decryptString($id);

        $id_account = DB::table('accounts')
            ->join('banks', 'accounts.bank_id', '=', 'banks.id')
            ->where('accounts.id', '=', $decrypted)
            ->select('accounts.*', 'name', 'slug')
            ->first();

        $accounts = DB::table('accounts')
            ->join('banks', 'accounts.bank_id', '=', 'banks.id')
            ->where('accounts.user_id', '=', Auth::user()->id)
            ->where('flag', '=', 'Others')
            ->select('accounts.*', 'name')
            ->orderBy('banks.name', 'asc')
            ->get();

        return view('mutation.credit', [
            'id_account'    => $id_account,
            'accounts'      => $accounts,
            'id'            => $id,
        ]);
    }

    public function bayarDetail(bank $bank, $id)
    {
        $decrypted = Crypt::decryptString($id);

        $id_account = DB::table('accounts')
            ->join('banks', 'accounts.bank_id', '=', 'banks.id')
            ->where('accounts.id', '=', $decrypted)
            ->where('accounts.flag', '=', 'Pribadi')
            ->select('accounts.*', 'name', 'slug')
            ->first();

        return view('mutation.bayar_detail', [
            'id_account' => $id_account,
            'id' => $id,
        ]);
    }

    public function tarik(bank $bank, $id)
    {
        $decrypted = Crypt::decryptString($id);

        $id_account = DB::table('accounts')
            ->join('banks', 'accounts.bank_id', '=', 'banks.id')
            ->where('accounts.id', '=', $decrypted)
            ->where('accounts.flag', '=', 'Pribadi')
            ->select('accounts.*', 'name', 'slug')
            ->first();

        $accounts = DB::table('accounts')
            ->join('banks', 'accounts.bank_id', '=', 'banks.id')
            ->where('accounts.user_id', '=', Auth::user()->id)
            ->where('accounts.flag', '=', 'Pribadi')
            ->select('accounts.*', 'name')
            ->orderBy('banks.name', 'asc')
            ->get();

        return view('mutation.tarik', [
            'id_account' => $id_account,
            'accounts' => $accounts,
            'id' => $id,
        ]);
    }

    public function transfer()
    {
        $pribadis = DB::table('accounts')
            ->join('banks', 'accounts.bank_id', '=', 'banks.id')
            ->where('accounts.user_id', '=', Auth::user()->id)
            ->where('accounts.flag', '=', 'Pribadi')
            ->select('accounts.*', 'name')
            ->orderBy('banks.name', 'asc')
            ->get();

        $accounts = DB::table('accounts')
            ->join('banks', 'accounts.bank_id', '=', 'banks.id')
            ->where('accounts.user_id', '=', Auth::user()->id)
            ->select('accounts.*', 'name')
            ->orderBy('banks.name', 'asc')
            ->get();

        return view('mutation.transfer', [
            'accounts' => $accounts,
            'pribadis' => $pribadis,


        ]);
    }

    public function transferStore(Request $request)
    {
        $messages = [
            'account_id.required'      => 'Sumber Dana Harus Diisi',
            'account_id_to.required'   => 'Rekening Tujuan Harus Diisi',
            'debit.required'           => 'Debit Harus Diisi',
            'description.required'     => 'Deskripsi Harus Diisi',
            'date.required'            => 'Tanggal harus diisi',
        ];

        //buat validasi form
        $request->validate([
            'account_id'        => 'required',
            'account_id_to'     => 'required',
            'debit'             => 'required',
            'description'       => 'required',
            'date'              => 'required',
        ], $messages);
        $nominal_debit    = str_replace(",", "", $request->debit);
        $nominal_kredit    = $request->nominal_kredit;

        $cek_sum_credit = DB::table('mutations as a')
            ->leftJoin('accounts as b', 'a.account_id', '=', 'b.id')
            ->where('a.user_id', '=', Auth::user()->id)
            ->where('b.flag', '=', 'Pribadi')
            ->where('a.account_id', '=', $request->account_id)
            ->sum('credit');

        $nama_bank = Bank::find($request->account_id_to);
        $bank_from = Bank::find($request->account_id);
        $desc = 'Terima dana dari ' . $nama_bank->name;

        $cek_rek_others = Account::where('id', '=', $request->account_id_to)
            ->where('flag', '=', 'pribadi')
            ->first();

        if ($nominal_debit < $cek_sum_credit) {
            if ($cek_rek_others === NULL) {
                $data = [
                    [
                        //pendebetan
                        'account_id'    => $request->account_id,
                        'user_id'       => $request->user_id,
                        'description'   => $request->description,
                        'debit'         => $nominal_debit,
                        'credit'        => $nominal_kredit,
                        'account_id_to' => $request->account_id_to,
                        'date'          => $request->date,
                        'created_at' =>  \Carbon\Carbon::now(),
                        'updated_at' => \Carbon\Carbon::now(),
                    ],
                ];
            } else {
                $data = [
                    [
                        //pendebetan
                        'account_id'    => $request->account_id,
                        'user_id'       => $request->user_id,
                        'description'   => $request->description,
                        'debit'         => $nominal_debit,
                        'credit'        => $nominal_kredit,
                        'account_id_to' => $request->account_id_to,
                        'date'          => $request->date,
                        'created_at' =>  \Carbon\Carbon::now(),
                        'updated_at' => \Carbon\Carbon::now(),
                    ],
                    [
                        //penambahan
                        'account_id'    => $request->account_id_to,
                        'user_id'       => $request->user_id,
                        'description'   => $desc,
                        'debit'         => $nominal_kredit,
                        'credit'        => $nominal_debit,
                        'account_id_to' => $request->account_id,
                        'date'          => $request->date,
                        'created_at' =>  \Carbon\Carbon::now(),
                        'updated_at' => \Carbon\Carbon::now(),
                    ],
                ];
            }
            Mutation::insert($data);

            toast('Transfer Dari ' . $bank_from->name . ' Berhasil', 'success');
            return redirect('/mutation');
        } else {
            toast('Dana Anda Tidak Cukup', 'error');
            return redirect('/mutation');
        }
    }

    public function bayar()
    {
        $pribadis = DB::table('accounts')
            ->join('banks', 'accounts.bank_id', '=', 'banks.id')
            ->where('accounts.flag', '=', 'Pribadi')
            ->select('accounts.*', 'name')
            ->orderBy('banks.name', 'asc')
            ->get();

        return view('mutation.bayar', [
            'pribadis' => $pribadis,
        ]);
    }

    public function bayarStore(Request $request)
    {
        $messages = [
            'account_id.required'      => 'Sumber Dana Harus Diisi',
            'debit.required'           => 'Nominal Harus Diisi',
            'description.required'     => 'Deskripsi Harus Diisi',
            'date.required'            => 'Tanggal harus diisi',
        ];

        //buat validasi form
        $request->validate([
            'account_id'        => 'required',
            'debit'            => 'required',
            'description'       => 'required',
            'date'              => 'required',
        ], $messages);
        $nominal_debit    = str_replace(",", "", $request->debit);
        $nominal_credit    = $request->nominal_credit;

        $nama_bank = Bank::find($request->account_id);

        $cek_sum_credit = DB::table('mutations as a')
            ->leftJoin('accounts as b', 'a.account_id', '=', 'b.id')
            ->where('a.user_id', '=', Auth::user()->id)
            ->where('b.flag', '=', 'Pribadi')
            ->where('a.account_id', '=', $request->account_id)
            ->sum('credit');

        if ($nominal_debit < $cek_sum_credit) {

            Mutation::create([
                'account_id'    => $request->account_id,
                'user_id'       => $request->user_id,
                'description'   => $request->description,
                'debit'         => $nominal_debit,
                'credit'        => $nominal_credit,
                'account_id_to' => 0,
                'date'          => $request->date,
            ]);

            toast('Bayar Dari ' . $nama_bank->name . ' Berhasil', 'success');
            return redirect('/mutation');
        } else {
            toast('Dana Anda Tidak Cukup', 'error');
            return redirect('/mutation');
        }
    }

    public function penerimaan()
    {
        $accounts = DB::table('accounts')
            ->join('banks', 'accounts.bank_id', '=', 'banks.id')
            ->where('accounts.flag', '=', 'Pribadi')
            ->select('accounts.*', 'name')
            ->orderBy('banks.name', 'asc')
            ->get();

        $others = DB::table('accounts')
            ->join('banks', 'accounts.bank_id', '=', 'banks.id')
            ->where('accounts.flag', '=', 'Others')
            ->select('accounts.*', 'name')
            ->orderBy('banks.name', 'asc')
            ->get();

        return view('mutation.penerimaan', [
            'accounts' => $accounts,
            'others' => $others,
        ]);
    }

    public function penerimaanStore(Request $request)
    {
        $messages = [
            'account_id.required'      => 'Sumber Dana Harus Diisi',
            'account_id_to.required'   => 'Rekening Tujuan Harus Diisi',
            'credit.required'          => 'Kredit Harus Diisi',
            'description.required'     => 'Deskripsi Harus Diisi',
            'date.required'            => 'Tanggal harus diisi',
        ];

        //buat validasi form
        $request->validate([
            'account_id'        => 'required',
            'account_id_to'     => 'required',
            'credit'            => 'required',
            'description'       => 'required',
            'date'              => 'required',
        ], $messages);
        $nominal_credit    = str_replace(",", "", $request->credit);
        $nominal_debit    = $request->nominal_debit;

        $nama_bank = Bank::find($request->account_id_to);

        Mutation::create([
            'account_id'    => $request->account_id_to, //dibalik karena terima dana dari luar
            'user_id'       => $request->user_id,
            'description'   => $request->description,
            'debit'         => $nominal_debit,
            'credit'        => $nominal_credit,
            'account_id_to' => $request->account_id,
            'date'          => $request->date,
        ]);

        toast('Saldo ' . $nama_bank->name . ' Berhasil Ditambah', 'success');
        return redirect('/mutation');
    }

    public function tarikTunai()
    {
        $accounts = DB::table('accounts')
            ->join('banks', 'accounts.bank_id', '=', 'banks.id')
            ->where('accounts.user_id', '=', Auth::user()->id)
            ->where('accounts.flag', '=', 'Pribadi')
            ->select('accounts.*', 'name')
            ->orderBy('banks.name', 'asc')
            ->get();

        return view('mutation.tarik-tunai', [
            'accounts' => $accounts,
        ]);
    }

    public function tarikTunaiStore(Request $request)
    {
        $messages = [
            'account_id.required'      => 'Sumber Dana Harus Diisi',
            'debit.required'           => 'Nominal Harus Diisi',
            'description.required'     => 'Deskripsi Harus Diisi',
            'date.required'            => 'Tanggal harus diisi',
        ];

        //buat validasi form
        $request->validate([
            'account_id'        => 'required',
            'debit'            => 'required',
            'description'       => 'required',
            'date'              => 'required',
        ], $messages);
        $nominal_debit    = str_replace(",", "", $request->debit);
        $nominal_credit    = $request->nominal_credit;

        $nama_bank = Bank::find($request->account_id);

        $cek_sum_credit = DB::table('mutations as a')
            ->leftJoin('accounts as b', 'a.account_id', '=', 'b.id')
            ->where('a.user_id', '=', Auth::user()->id)
            ->where('b.flag', '=', 'Pribadi')
            ->where('a.account_id', '=', $request->account_id)
            ->sum('credit');

        if ($nominal_debit < $cek_sum_credit) {

            Mutation::create([
                'account_id'    => $request->account_id,
                'user_id'       => $request->user_id,
                'description'   => $request->description,
                'debit'         => $nominal_debit,
                'credit'        => $nominal_credit,
                'account_id_to' => 0,
                'date'          => $request->date,
            ]);

            toast('Tarik Tunai Dari ' . $nama_bank->name . ' Berhasil', 'success');
            return redirect('/mutation');
        } else {
            toast('Dana Anda Tidak Cukup', 'error');
            return redirect('/mutation');
        }
    }

    /* public function mutasiBank()
    {
        #$accounts = Account::all();

        return view('desk-layout.sidebar', [
            'accounts' => Account::get(),
        ]);
    } */
    /*     public function showbank($id)
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
    } */
}
