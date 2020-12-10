<?php

namespace App\Http\Livewire;

use App\Contact;
use Livewire\Component;

class ContactIndex extends Component
{
    protected $listeners = [
        'contactStored' => 'handleStored'
    ];

    public function render()
    {
        return view('livewire.contact-index', [
            'contacts' => Contact::latest()->get()
        ]);
    }

    public function handleStored($contact)
    {
        //dd($contact);
        session()->flash('sukses', 'Contact ' . $contact['name'] . ' berhasil ditambah!');
    }
}
