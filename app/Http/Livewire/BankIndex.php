<?php

namespace App\Http\Livewire;

use App\Bank;
use Livewire\Component;
use Livewire\WithPagination;

class BankIndex extends Component
{
    use WithPagination;

    #public $banks;
    public $paginate = 5;
    public $search;

    protected $listeners = [
        'bankStored' => 'handleStored',
        #'bankUpdated' => 'handleUpdated',
    ];

    protected $updatesQueryString = ['search'];

    public function mount()
    {
        $this->search = request()->query('search', $this->search);
    }

    public function render()
    {
        return view('livewire.bank-index', [
            'banks' => $this->search === null ? Bank::latest()->paginate($this->paginate) :
                Bank::latest()->where('name', 'like', '%' . $this->search . '%')->paginate($this->paginate)
        ]);
    }

    public function handleStored($bank)
    {
        //dd($bank);
        session()->flash('sukses', 'Merchant ' . $bank['name'] . ' berhasil ditambah!');
    }
}
