<?php

namespace App\Traits;

use Illuminate\Support\Facades\DB;

trait Side_Accounts
{
    public function SideAccounts()
    {
        $side_banks = DB::table('accounts as a')
            ->leftJoin('banks as b', 'a.bank_id', '=', 'b.id')
            ->select(
                'a.*',
                'b.name'
            )
            ->orderBy('b.name', 'ASC')
            ->get();

        return ($side_banks);
    }
}
