<?php

namespace App\Http\Livewire;

use App\Account;
use Livewire\Component;
use App\Bank;
use Illuminate\Support\Facades\Auth;

class AccountCreate extends Component
{
    public $bank_id;

    public function store()
    {
        $messages = [
            'bank_id.required'     => 'Nama Merchant Harus Diisi',
        ];
        $this->validate([
            'bank_id'  => 'required',
        ], $messages);

        $this->account = Account::where('user_id', '=', Auth::user()->id)
            ->where('bank_id', '=', $this->bank_id)
            ->get();
        if ($this->account->isEmpty()) {
            $account = Account::create([
                'bank_id'      => $this->bank_id,
                'user_id'      => Auth::user()->id,
            ]);

            $this->resetInput();

            $this->emit('accountStored', $account);
            //accountStored akan dibuatkan listeningnya didalam class accountindex.php
        } else {
            $testing = 'testing';
            #$testing = $this->emit('alert', ['type' => 'error', 'message' => 'Berhasil dul']);
            $this->emit('accountCek', $testing);
        }
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
    }
}
