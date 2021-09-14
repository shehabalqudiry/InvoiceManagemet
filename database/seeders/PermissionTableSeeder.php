<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Permission;

class PermissionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('permissions')->delete();

        $permissions = [
            // Roles
            'role-list'             => 'الادوار',
            'role-create'           => 'إضافة دور',
            'role-edit'             => 'تعديل دور',
            'role-delete'           => 'حذف دور',
            // Users
            'user-list'             => 'المستخدمين',
            'user-create'           => 'إضافة مستخدم',
            'user-edit'             => 'تعديل مستخدم',
            'user-delete'           => 'حذف مستخدم',
            // Sections
            'section-list'          => 'الاقسام',
            'section-create'        => 'إضافة قسم',
            'section-edit'          => 'تعديل قسم',
            'section-delete'        => 'حذف قسم',
            // Products
            'product-list'          => 'المنتجات',
            'product-create'        => 'إضافة منتج',
            'product-edit'          => 'تعديل منتج',
            'product-delete'        => 'حذف منتج',
            // Invoices
            'invoice-list'          => 'الفواتير',
            'invoice-create'        => 'إضافة فاتورة',
            'invoice-edit'          => 'تعديل فاتورة',
            'invoice-delete'        => 'حذف فاتورة',
            'invoice-print'         => 'طباعة فاتورة',
            'invoice-export'        => 'تصدير الفواتير الي ملف Excel',
            'invoice-paid'          => 'الفواتير المدفوعة',
            'invoice-part_paid'     => 'الفواتير المدفوهة جزئيا',
            'invoice-unpaid'        => 'الفواتير الغير مدفوعة',
            'invoice-archive'       => 'الفواتير المؤرشفة',
            // Reports
            'report-list'           => 'التقارير',
            'report-create'         => 'إضافة تقرير',
            'report-edit'           => 'تعديل تقرير',
            'report-delete'         => 'حذف تقرير',
            // Settings
            'notifications'         => 'الاشعارات',
            // Settings
            'setting-list'          => 'الاعدادات',
            'setting-edit'          => 'تعديل الاعددات',
        ];

        foreach ($permissions as $key => $permission) {
            Permission::create([
                'name' => $key,
                'display_name' => $permission,
            ]);
        }
    }
}
