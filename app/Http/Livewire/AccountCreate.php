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
        #$tes = $this->bank_id;
        #dd($tes);
        /* $data = [
            ['user_id' => Auth::user()->id],
            ['bank_id' => $this->bank_id],
        ]; */

        #Account::insert($data);
        /* $user_id = Auth::user()->id;
        foreach ($this->bank_id as $key => $value) {
            $input['bank_id'] = $this->bank_id[$key];
            # $input['user_id'] = $user_id[$key];

            Account::create($input);
        } */
        #if ($this->bank_id == ) {

        $account = Account::create([
            'bank_id'      => $this->bank_id,
            'user_id'      => Auth::user()->id,
        ]);

        $this->resetInput();

        //accountStored akan dibuatkan listeningnya didalam class accountindex.php
        $this->emit('accountStored', $account);
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
