<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Account extends Model
{
    protected $fillable = [
        'bank_id',
        'user_id',
        'no_rekening',
        'name_account',
        'flag',
        'keterangan',
    ];


    public function Bank()
    {
        return $this->belongsTo(Bank::class);
    }

    public function User()
    {
        return $this->belongsTo(User::class);
    }
}
