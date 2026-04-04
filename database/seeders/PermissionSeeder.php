<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Permission;

class PermissionSeeder extends Seeder
{
    public function run()
    {
        $modules = [
            'service_orders',
            'giftcard_orders',
            'patient',
            'user',
            'employee',
            'category',
            'product',
            'services',
            'giftcard_redeem',
            'service_redeem',
            'terms_and_conditions',
            'gift_card_coupons',
            'email_templates',
            'static_content',
            'sliders',
            'programs',
        ];

        $actions = ['view', 'create', 'edit', 'delete'];

        foreach ($modules as $module) {
            foreach ($actions as $action) {

                Permission::updateOrCreate(
                    [
                        'name' => $action . '_' . $module,
                    ],
                    [
                        'module' => $module,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]
                );

            }
        }
    }
}