<?php

namespace App\Http\Livewire;

use App\Contact;
use Livewire\Component;

class ContactCreate extends Component
{
    public $name;
    public $phone;


    public function render()
    {
        return view('livewire.contact-create');
    }

    public function store()
    {
        $messages = [
            'name.required'         => 'Nama Harus Diisi',
            'name.min'         => 'Min 3 karakter',
            'phone.required'         => 'Phone Harus Diisi',
            'phone.max'     => 'Max 15 karakter',
        ];
        $this->validate([
            'name' => 'required|min:3',
            'phone' => 'required|max:15',
        ], $messages);

        $contact = Contact::create([
            'name' => $this->name,
            'phone' => $this->phone
        ]);

        $this->resetInput();

        //contactStored akan dibuatkan listeningnya didalam class contactindex.php
        $this->emit('contactStored', $contact);
    }

    //menghilangkan inputan field di kolom setelah submit
    private function resetInput()
    {
        $this->name = null;
        $this->phone = null;
    }
}
