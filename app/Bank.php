<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Bank extends Model
{
    protected $fillable = [
        'user_id',
        'no_rekening',
        'name',
        'slug',
        'file_img',
    ];

    public function Mutations()
    {
        return $this->hasMany(Mutation::class);
    }

    public function User()
    {
        return $this->belongsTo(User::class);
    }
}
