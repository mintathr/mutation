<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Account;
use Illuminate\Support\Facades\Auth;
use Livewire\WithPagination;
use RealRashid\SweetAlert\Facades\Alert;

class AccountIndex extends Component
{

    protected $listeners = [
        'accountStored' => 'handleStored',
        'accountCek' => 'handleCek',
    ];

    public function render()
    {
        return view('livewire.account-index', [
            'accounts' => Account::latest()->where('user_id', Auth::user()->id)->get()
        ]);
    }

    public function handleStored($account)
    {
        //dd($account);
        session()->flash('sukses', 'Account Merchant berhasil ditambah!');
        #$this->emit('alert', ['type' => 'success', 'message' => 'Berhasil dul']);
    }

    public function handleCek($testing)
    {
        #$testing;
        #$this->emit('alert', ['type' => 'error', 'message' => 'Berhasil dul']);
        session()->flash('gagal', 'Merchant Sudah Ada!');
    }
}
