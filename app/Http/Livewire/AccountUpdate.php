<?php

namespace App\Http\Livewire;

use App\{Account, Bank};
use Livewire\Component;

class AccountUpdate extends Component
{
    public $bank_id;
    public $no_rekening;
    public $name_account;
    public $flag;
    public $keterangan;
    public $accountId;

    protected $listeners = [
        'getAccount' => 'showAccount'
    ];

    //berfungsi utk memasukkan data yg didapatkan oleh argumen account yg ada di accountindex (method getcontact)
    public function showAccount($account)
    {
        $this->bank_id = $account['bank_id'];
        $this->no_rekening = $account['no_rekening'];
        $this->name_account = $account['name_account'];
        $this->flag = $account['flag'];
        $this->keterangan = $account['keterangan'];
        $this->accountId = $account['id'];
    }

    public function render()
    {
        return view('livewire.account-update', [
            'banks'     => Bank::all(),
        ]);
    }

    public function update()
    {
        $messages = [
            'bank_id.required'      => 'Nama Account Harus Diisi',
            'no_rekening.required'  => 'No Rekening Harus Diisi',
            'no_rekening.max'       => 'Max 15 Karakter',
            'no_rekening.min'       => 'Min 10 Karakter',
            'name_account.required' => 'Nama Pemilik Rekening Harus Diisi',
            'flag.required'         => 'Kategori Rekening Harus Diisi',
            'keterangan.required'      => 'Keterangan Harus Diisi',
        ];
        $this->validate([
            'bank_id'       => 'required',
            'no_rekening'   => 'required|max:15|min:10',
            'name_account'    => 'required',
            'flag'    => 'required',
            'keterangan'    => 'required',
        ], $messages);

        if ($this->accountId) {
            $account = Account::find($this->accountId);
            $account->update([
                'no_rekening' => $this->no_rekening,
                'name_account' => $this->name_account,
                'flag' => $this->flag,
                'keterangan' => $this->keterangan,
                'bank_id' => $this->bank_id,
            ]);

            $this->resetInput();

            //agar datatable melakukan render ulang dan menampilkan session, dan buatkan listenernya di accounttindex
            $this->emit('accountUpdated', $account);
        }
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
