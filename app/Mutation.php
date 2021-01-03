<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Mutation extends Model
{

    protected $fillable = [
        'account_id',
        'user_id',
        'description',
        'debit',
        'credit',
        'account_id_to',
        'date',
    ];

    public function Bank()
    {
        return $this->belongsTo(Bank::class);
    }

    public function account()
    {
        return $this->belongsTo(Account::class);
    }

    public function User()
    {
        return $this->belongsTo(User::class);
    }

    /* public function Bank()
    {
        #return $this->belongsToMany('App\Role', 'role_user', 'user_id', 'role_id');
        return $this->belongsToMany(Bank::class, 'account_id_to', 'id');
    } */
}
