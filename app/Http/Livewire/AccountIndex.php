<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Account;
use Illuminate\Support\Facades\Auth;
use Livewire\WithPagination;

class AccountIndex extends Component
{


    public function render()
    {
        return view('livewire.account-index', [
            'accounts' => Account::where('user_id', Auth::user()->id)->get()
        ]);
    }
}
