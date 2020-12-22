<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Bank;

class BankCreate extends Component
{
    use WithFileUploads;

    public $name;
    public $file_img;

    public function store()
    {
        $messages = [
            'name.required'     => 'Nama Merchant Harus Diisi',
            'name.min'          => 'Min 3 karakter',
            'name.unique'       => 'Merchant Sudah Ada',
            'file_img.required' => 'Image Tidak boleh kosong',
            'file_img.max'      => 'Max 1MB',
        ];
        $this->validate([
            'name'  => 'required|unique:banks|min:3',
            'file_img' => 'required|image|max:1024',
        ], $messages);

        $img_name = $this->file_img->store('photos', 'public');
        $bank = Bank::create([
            'name'      => $this->name,
            'slug'      => \Str::slug($this->name),
            'file_img'  => $img_name,
        ]);

        $this->resetInput();

        //bankStored akan dibuatkan listeningnya didalam class bankindex.php
        $this->emit('bankStored', $bank);
    }

    //menghilangkan inputan field di kolom setelah submit
    private function resetInput()
    {
        $this->name = null;
        $this->file_img = null;
    }

    public function render()
    {
        return view('livewire.bank-create');
    }
}
