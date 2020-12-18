<?php

namespace App\Http\Livewire;

use App\Contact;
use Livewire\Component;

class ContactUpdate extends Component
{
    public $name;
    public $phone;
    public $contactId;

    protected $listeners = [
        'getContact' => 'showContact'
    ];

    public function render()
    {
        return view('livewire.contact-update');
    }

    //berfungsi utk memasukkan data yg didapatkan oleh argumen contact yg ada di contactindex (method getcontact)
    public function showContact($contact)
    {
        $this->name = $contact['name'];
        $this->phone = $contact['phone'];
        $this->contactId = $contact['id'];
    }

    public function update()
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

        if ($this->contactId) {
            $contact = Contact::find($this->contactId);
            $contact->update([
                'name' => $this->name,
                'phone' => $this->phone,
            ]);

            $this->resetInput();

            //agar datatable melakukan render ulang dan menampilkan session, dan buatkan listenernya di contactindex
            $this->emit('contactUpdated', $contact);
        }
    }

    private function resetInput()
    {
        $this->name = null;
        $this->phone = null;
    }
}
