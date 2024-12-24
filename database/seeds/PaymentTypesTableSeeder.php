<?php

use App\PaymentType;
use App\User;
use Illuminate\Database\Seeder;

class PaymentTypesTableSeeder extends Seeder
{
    public function run()
    {
        $paymentTypes = [
            [
                'id'             => 1,
                'name'           => 'Cash',
                'created_by'     => 1,
                'created_at'     => '2024-12-24 19:21:30',
                'updated_at'     => '2024-12-24 19:21:30',
            ],
            [
                'id'             => 2,
                'name'           => 'UPI',
                'created_by'     => 1,
                'created_at'     => '2024-12-24 19:21:30',
                'updated_at'     => '2024-12-24 19:21:30',
            ],
            [
                'id'             => 3,
                'name'           => 'Cheque',
                'created_by'     => 1,
                'created_at'     => '2024-12-24 19:21:30',
                'updated_at'     => '2024-12-24 19:21:30',
            ],
        ];

        PaymentType::insert($paymentTypes);
    }
}
