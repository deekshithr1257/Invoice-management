<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UpdateOriginalAmountInInvoicesSeeder extends Seeder
{
    public function run()
    {
        DB::table('invoices')->update([
            'original_amount' => DB::raw('amount')
        ]);
    }
}
