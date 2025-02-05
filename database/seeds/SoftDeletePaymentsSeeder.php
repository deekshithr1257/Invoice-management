<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SoftDeletePaymentsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Get all soft-deleted invoices
        $softDeletedInvoices = DB::table('invoices')
            ->whereNotNull('deleted_at')
            ->pluck('id'); // Get their IDs

        // Soft delete related payments
        DB::table('payments')
            ->whereIn('invoice_id', $softDeletedInvoices)
            ->update(['deleted_at' => now()]);
    }
}
