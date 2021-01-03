<?php

namespace App\Http\Livewire;

use App\{Account, Bank};
use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class AccountCreate extends Component
{
    public $bank_id;
    public $no_rekening;
    public $name_account;
    public $flag;
    public $keterangan;

    public function store()
    {
        $messages = [
            'bank_id.required'      => 'Nama Account Harus Diisi',
            'no_rekening.required'  => 'No Rekening Harus Diisi',
            'no_rekening.unique'  => 'No Rekening Sudah Ada',
            'no_rekening.max'       => 'Max 15 Karakter',
            'no_rekening.min'       => 'Min 10 Karakter',
            'name_account.required' => 'Nama Pemilik Rekening Harus Diisi',
            'flag.required'         => 'Kategori Rekening Harus Diisi',
            'keterangan.required'   => 'Keterangan Harus Diisi',
        ];
        $this->validate([
            'bank_id'       => 'required',
            'no_rekening'   => 'required|unique:accounts|max:15|min:10',
            'name_account'  => 'required',
            'flag'          => 'required',
            'keterangan'    => 'required',
        ], $messages);

        //kondisi bila data ada (like: mysqlnumrows)
        /* $this->account = Account::where('user_id', '=', Auth::user()->id)
            ->where('bank_id', '=', $this->bank_id)
            ->get();
        if ($this->account->isEmpty()) { */
        $account = Account::create([
            'bank_id'      => $this->bank_id,
            'user_id'      => Auth::user()->id,
            'no_rekening'  => $this->no_rekening,
            'name_account' => $this->name_account,
            'flag'         => $this->flag,
            'keterangan'   => $this->keterangan,
        ]);

        $this->resetInput();

        $this->emit('accountStored', $account);
        //accountStored akan dibuatkan listeningnya didalam class accountindex.php
        /* } else {
            $testing = 'testing';
            #$testing = $this->emit('alert', ['type' => 'error', 'message' => 'Berhasil dul']);
            $this->emit('accountCek', $testing);
        } */
    }

    public function render()
    {
        return view('livewire.account-create', [
            'banks'     => Bank::all(),
            'accounts' => Account::where('user_id', Auth::user()->id)->get(),
        ]);
    }

    private function resetInput()
    {
        $this->bank_id = null;
        $this->no_rekening = null;
        $this->name_account = null;
        $this->flag = null;
        $this->keterangan = null;
    }
}
