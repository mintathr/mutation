<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Mutation extends Model
{
    protected $fillable = [
        'bank_id',
        'user_id',
        'description',
        'debit',
        'credit',
        'date',
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
