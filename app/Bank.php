<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Bank extends Model
{
    public function Mutations()
    {
        return $this->hasMany(Mutation::class);
    }
}
