<?php

use App\Permission;
use Illuminate\Database\Seeder;

class PermissionsTableSeeder extends Seeder
{
    public function run()
    {
        $permissions = [
            [
                'id'         => '1',
                'title'      => 'user_management_access',
                'created_at' => '2024-12-24 19:21:30',
                'updated_at' => '2024-12-24 19:21:30',
            ],
            [
                'id'         => '2',
                'title'      => 'permission_create',
                'created_at' => '2024-12-24 19:21:30',
                'updated_at' => '2024-12-24 19:21:30',
            ],
            [
                'id'         => '3',
                'title'      => 'permission_edit',
                'created_at' => '2024-12-24 19:21:30',
                'updated_at' => '2024-12-24 19:21:30',
            ],
            [
                'id'         => '4',
                'title'      => 'permission_show',
                'created_at' => '2024-12-24 19:21:30',
                'updated_at' => '2024-12-24 19:21:30',
            ],
            [
                'id'         => '5',
                'title'      => 'permission_delete',
                'created_at' => '2024-12-24 19:21:30',
                'updated_at' => '2024-12-24 19:21:30',
            ],
            [
                'id'         => '6',
                'title'      => 'permission_access',
                'created_at' => '2024-12-24 19:21:30',
                'updated_at' => '2024-12-24 19:21:30',
            ],
            [
                'id'         => '7',
                'title'      => 'role_create',
                'created_at' => '2024-12-24 19:21:30',
                'updated_at' => '2024-12-24 19:21:30',
            ],
            [
                'id'         => '8',
                'title'      => 'role_edit',
                'created_at' => '2024-12-24 19:21:30',
                'updated_at' => '2024-12-24 19:21:30',
            ],
            [
                'id'         => '9',
                'title'      => 'role_show',
                'created_at' => '2024-12-24 19:21:30',
                'updated_at' => '2024-12-24 19:21:30',
            ],
            [
                'id'         => '10',
                'title'      => 'role_delete',
                'created_at' => '2024-12-24 19:21:30',
                'updated_at' => '2024-12-24 19:21:30',
            ],
            [
                'id'         => '11',
                'title'      => 'role_access',
                'created_at' => '2024-12-24 19:21:30',
                'updated_at' => '2024-12-24 19:21:30',
            ],
            [
                'id'         => '12',
                'title'      => 'user_create',
                'created_at' => '2024-12-24 19:21:30',
                'updated_at' => '2024-12-24 19:21:30',
            ],
            [
                'id'         => '13',
                'title'      => 'user_edit',
                'created_at' => '2024-12-24 19:21:30',
                'updated_at' => '2024-12-24 19:21:30',
            ],
            [
                'id'         => '14',
                'title'      => 'user_show',
                'created_at' => '2024-12-24 19:21:30',
                'updated_at' => '2024-12-24 19:21:30',
            ],
            [
                'id'         => '15',
                'title'      => 'user_delete',
                'created_at' => '2024-12-24 19:21:30',
                'updated_at' => '2024-12-24 19:21:30',
            ],
            [
                'id'         => '16',
                'title'      => 'user_access',
                'created_at' => '2024-12-24 19:21:30',
                'updated_at' => '2024-12-24 19:21:30',
            ],
            [
                'id'         => '17',
                'title'      => 'invoice_management_access',
                'created_at' => '2024-12-24 19:21:30',
                'updated_at' => '2024-12-24 19:21:30',
            ],
            [
                'id'         => '23',
                'title'      => 'payment_type_create',
                'created_at' => '2024-12-24 19:21:30',
                'updated_at' => '2024-12-24 19:21:30',
            ],
            [
                'id'         => '24',
                'title'      => 'payment_type_edit',
                'created_at' => '2024-12-24 19:21:30',
                'updated_at' => '2024-12-24 19:21:30',
            ],
            [
                'id'         => '25',
                'title'      => 'payment_type_show',
                'created_at' => '2024-12-24 19:21:30',
                'updated_at' => '2024-12-24 19:21:30',
            ],
            [
                'id'         => '26',
                'title'      => 'payment_type_delete',
                'created_at' => '2024-12-24 19:21:30',
                'updated_at' => '2024-12-24 19:21:30',
            ],
            [
                'id'         => '27',
                'title'      => 'payment_type_access',
                'created_at' => '2024-12-24 19:21:30',
                'updated_at' => '2024-12-24 19:21:30',
            ],
            [
                'id'         => '28',
                'title'      => 'invoice_create',
                'created_at' => '2024-12-24 19:21:30',
                'updated_at' => '2024-12-24 19:21:30',
            ],
            [
                'id'         => '29',
                'title'      => 'invoice_edit',
                'created_at' => '2024-12-24 19:21:30',
                'updated_at' => '2024-12-24 19:21:30',
            ],
            [
                'id'         => '30',
                'title'      => 'invoice_show',
                'created_at' => '2024-12-24 19:21:30',
                'updated_at' => '2024-12-24 19:21:30',
            ],
            [
                'id'         => '31',
                'title'      => 'invoice_delete',
                'created_at' => '2024-12-24 19:21:30',
                'updated_at' => '2024-12-24 19:21:30',
            ],
            [
                'id'         => '32',
                'title'      => 'invoice_access',
                'created_at' => '2024-12-24 19:21:30',
                'updated_at' => '2024-12-24 19:21:30',
            ],
            [
                'id'         => '33',
                'title'      => 'payment_create',
                'created_at' => '2024-12-24 19:21:30',
                'updated_at' => '2024-12-24 19:21:30',
            ],
            [
                'id'         => '34',
                'title'      => 'payment_edit',
                'created_at' => '2024-12-24 19:21:30',
                'updated_at' => '2024-12-24 19:21:30',
            ],
            [
                'id'         => '35',
                'title'      => 'payment_show',
                'created_at' => '2024-12-24 19:21:30',
                'updated_at' => '2024-12-24 19:21:30',
            ],
            [
                'id'         => '36',
                'title'      => 'payment_delete',
                'created_at' => '2024-12-24 19:21:30',
                'updated_at' => '2024-12-24 19:21:30',
            ],
            [
                'id'         => '37',
                'title'      => 'payment_access',
                'created_at' => '2024-12-24 19:21:30',
                'updated_at' => '2024-12-24 19:21:30',
            ],
            [
                'id'         => '38',
                'title'      => 'invoice_report_create',
                'created_at' => '2024-12-24 19:21:30',
                'updated_at' => '2024-12-24 19:21:30',
            ],
            [
                'id'         => '39',
                'title'      => 'invoice_report_edit',
                'created_at' => '2024-12-24 19:21:30',
                'updated_at' => '2024-12-24 19:21:30',
            ],
            [
                'id'         => '40',
                'title'      => 'invoice_report_show',
                'created_at' => '2024-12-24 19:21:30',
                'updated_at' => '2024-12-24 19:21:30',
            ],
            [
                'id'         => '41',
                'title'      => 'invoice_report_delete',
                'created_at' => '2024-12-24 19:21:30',
                'updated_at' => '2024-12-24 19:21:30',
            ],
            [
                'id'         => '42',
                'title'      => 'invoice_report_access',
                'created_at' => '2024-12-24 19:21:30',
                'updated_at' => '2024-12-24 19:21:30',
            ],
            [
                'id'         => '43',
                'title'      => 'supplier_create',
                'created_at' => '2024-12-24 19:21:30',
                'updated_at' => '2024-12-24 19:21:30',
            ],
            [
                'id'         => '44',
                'title'      => 'supplier_edit',
                'created_at' => '2024-12-24 19:21:30',
                'updated_at' => '2024-12-24 19:21:30',
            ],
            [
                'id'         => '45',
                'title'      => 'supplier_show',
                'created_at' => '2024-12-24 19:21:30',
                'updated_at' => '2024-12-24 19:21:30',
            ],
            [
                'id'         => '46',
                'title'      => 'supplier_delete',
                'created_at' => '2024-12-24 19:21:30',
                'updated_at' => '2024-12-24 19:21:30',
            ],
            [
                'id'         => '47',
                'title'      => 'supplier_access',
                'created_at' => '2024-12-24 19:21:30',
                'updated_at' => '2024-12-24 19:21:30',
            ],
            [
                'id'         => '48',
                'title'      => 'dashboard_access',
                'created_at' => '2024-12-24 19:21:30',
                'updated_at' => '2024-12-24 19:21:30',
            ],
        ];

        Permission::insert($permissions);
    }
}
