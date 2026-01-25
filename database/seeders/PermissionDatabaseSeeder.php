<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PermissionDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        Model::unguard();

        $permissions = [
            // --- Admins ----
            [
                'id' => 1,
                'name' => 'Admins',
                'slug' => 'admins',
                'parent_id' => null
            ],
            [
                'id' => 2,
                'name' => 'Show',
                'slug' => 'list-admin',
                'parent_id' => 1
            ],
            [
                'id' => 3,
                'name' => 'Create',
                'slug' => 'create-admin',
                'parent_id' => 1
            ],
            [
                'id' => 4,
                'name' => 'Update',
                'slug' => 'edit-admin',
                'parent_id' => 1
            ],
            [
                'id' => 5,
                'name' => 'Delete',
                'slug' => 'delete-admin',
                'parent_id' => 1
            ],
            [
                'id' => 6,
                'name' => 'Restore',
                'slug' => 'restore-admin',
                'parent_id' => 1
            ],
            [
                'id' => 7,
                'name' => 'Force Delete',
                'slug' => 'force-delete-admin',
                'parent_id' => 1
            ],

            // --- Roles
            [
                'id' => 8,
                'name' => 'Roles',
                'slug' => 'roles',
                'parent_id' => null
            ],
            [
                'id' => 9,
                'name' => 'Show',
                'slug' => 'list-role',
                'parent_id' => 8
            ],
            [
                'id' => 10,
                'name' => 'Create',
                'slug' => 'create-role',
                'parent_id' => 8
            ],
            [
                'id' => 11,
                'name' => 'Update',
                'slug' => 'edit-role',
                'parent_id' => 8
            ],
            [
                'id' => 12,
                'name' => 'Delete',
                'slug' => 'delete-role',
                'parent_id' => 8
            ],

            // --- Countries
            [
                'id' => 13,
                'name' => 'Countries',
                'slug' => 'countries',
                'parent_id' => null
            ],
            [
                'id' => 14,
                'name' => 'Show',
                'slug' => 'list-country',
                'parent_id' => 13
            ],
            [
                'id' => 15,
                'name' => 'Create',
                'slug' => 'create-country',
                'parent_id' => 13
            ],
            [
                'id' => 16,
                'name' => 'Update',
                'slug' => 'edit-country',
                'parent_id' => 13
            ],
            [
                'id' => 17,
                'name' => 'Delete',
                'slug' => 'delete-country',
                'parent_id' => 13
            ],
            [
                'id' => 18,
                'name' => 'Restore',
                'slug' => 'restore-country',
                'parent_id' => 13
            ],
            [
                'id' => 19,
                'name' => 'Force Delete',
                'slug' => 'force-delete-country',
                'parent_id' => 13
            ],

            // --- FAQs ----
            [
                'id' => 20,
                'name' => 'FAQs',
                'slug' => 'faqs',
                'parent_id' => null
            ],
            [
                'id' => 21,
                'name' => 'Show',
                'slug' => 'list-faq',
                'parent_id' => 20
            ],
            [
                'id' => 22,
                'name' => 'Create',
                'slug' => 'create-faq',
                'parent_id' => 20
            ],
            [
                'id' => 23,
                'name' => 'Update',
                'slug' => 'edit-faq',
                'parent_id' => 20
            ],
            [
                'id' => 24,
                'name' => 'Delete',
                'slug' => 'delete-faq',
                'parent_id' => 20
            ],
            [
                'id' => 25,
                'name' => 'Restore',
                'slug' => 'restore-faq',
                'parent_id' => 20
            ],
            [
                'id' => 26,
                'name' => 'Force Delete',
                'slug' => 'force-delete-faq',
                'parent_id' => 20
            ],

            // --- Messages - Contact Us
            [
                'id' => 27,
                'name' => 'Messages - Contact Us',
                'slug' => 'messages',
                'parent_id' => null
            ],
            [
                'id' => 28,
                'name' => 'Show',
                'slug' => 'list-message',
                'parent_id' => 27
            ],
            [
                'id' => 29,
                'name' => 'Create',
                'slug' => 'create-message',
                'parent_id' => 27
            ],
            [
                'id' => 30,
                'name' => 'Update',
                'slug' => 'edit-message',
                'parent_id' => 27
            ],
            [
                'id' => 31,
                'name' => 'Delete',
                'slug' => 'delete-message',
                'parent_id' => 27
            ],
            [
                'id' => 32,
                'name' => 'Restore',
                'slug' => 'restore-message',
                'parent_id' => 27
            ],
            [
                'id' => 33,
                'name' => 'Force Delete',
                'slug' => 'force-delete-message',
                'parent_id' => 27
            ],

            // --- Menus
            [
                'id' => 34,
                'name' => 'Menus',
                'slug' => 'navs',
                'parent_id' => null
            ],
            [
                'id' => 35,
                'name' => 'Show',
                'slug' => 'list-nav',
                'parent_id' => 34
            ],
            [
                'id' => 36,
                'name' => 'Create',
                'slug' => 'create-nav',
                'parent_id' => 34
            ],
            [
                'id' => 37,
                'name' => 'Update',
                'slug' => 'edit-nav',
                'parent_id' => 34
            ],
            [
                'id' => 38,
                'name' => 'Delete',
                'slug' => 'delete-nav',
                'parent_id' => 34
            ],
            [
                'id' => 39,
                'name' => 'Restore',
                'slug' => 'restore-nav',
                'parent_id' => 34
            ],
            [
                'id' => 40,
                'name' => 'Force Delete',
                'slug' => 'force-delete-nav',
                'parent_id' => 34
            ],

            // --- Menu Items
            [
                'id' => 41,
                'name' => 'Menu Items',
                'slug' => 'subnavs',
                'parent_id' => null
            ],
            [
                'id' => 42,
                'name' => 'Show',
                'slug' => 'list-subnav',
                'parent_id' => 41
            ],
            [
                'id' => 43,
                'name' => 'Create',
                'slug' => 'create-subnav',
                'parent_id' => 41
            ],
            [
                'id' => 44,
                'name' => 'Update',
                'slug' => 'edit-subnav',
                'parent_id' => 41
            ],
            [
                'id' => 45,
                'name' => 'Delete',
                'slug' => 'delete-subnav',
                'parent_id' => 41
            ],

            // --- Pages
            [
                'id' => 46,
                'name' => 'Pages',
                'slug' => 'pages',
                'parent_id' => null
            ],
            [
                'id' => 47,
                'name' => 'Show',
                'slug' => 'list-page',
                'parent_id' => 46
            ],
            [
                'id' => 48,
                'name' => 'Create',
                'slug' => 'create-page',
                'parent_id' => 46
            ],
            [
                'id' => 49,
                'name' => 'Update',
                'slug' => 'edit-page',
                'parent_id' => 46
            ],
            [
                'id' => 50,
                'name' => 'Delete',
                'slug' => 'delete-page',
                'parent_id' => 46
            ],
            [
                'id' => 51,
                'name' => 'Restore',
                'slug' => 'restore-page',
                'parent_id' => 46
            ],
            [
                'id' => 52,
                'name' => 'Force Delete',
                'slug' => 'force-delete-page',
                'parent_id' => 46
            ],

            // --- Page Sections
            [
                'id' => 53,
                'name' => 'Sections',
                'slug' => 'page-sections',
                'parent_id' => null
            ],
            [
                'id' => 54,
                'name' => 'Show',
                'slug' => 'list-section',
                'parent_id' => 53
            ],
            [
                'id' => 55,
                'name' => 'Create',
                'slug' => 'create-section',
                'parent_id' => 53
            ],
            [
                'id' => 56,
                'name' => 'Update',
                'slug' => 'edit-section',
                'parent_id' => 53
            ],
            [
                'id' => 57,
                'name' => 'Delete',
                'slug' => 'delete-section',
                'parent_id' => 53
            ],
            [
                'id' => 58,
                'name' => 'Restore',
                'slug' => 'restore-section',
                'parent_id' => 53
            ],
            [
                'id' => 59,
                'name' => 'Force Delete',
                'slug' => 'force-delete-section',
                'parent_id' => 53
            ],

            // --- Settings
            [
                'id' => 60,
                'name' => 'Settings',
                'slug' => 'settings',
                'parent_id' => null
            ],
            [
                'id' => 61,
                'name' => 'Edit',
                'slug' => 'settings-page',
                'parent_id' => 60
            ],

            // --- Settings Fields
            [
                'id' => 62,
                'name' => 'Settings Fields',
                'slug' => 'settings-fields',
                'parent_id' => null
            ],
            [
                'id' => 63,
                'name' => 'Show',
                'slug' => 'list-setting',
                'parent_id' => 62
            ],
            [
                'id' => 64,
                'name' => 'Create',
                'slug' => 'create-setting',
                'parent_id' => 62
            ],
            [
                'id' => 65,
                'name' => 'Update',
                'slug' => 'edit-setting',
                'parent_id' => 62
            ],
            [
                'id' => 66,
                'name' => 'Delete',
                'slug' => 'delete-setting',
                'parent_id' => 62
            ],
            [
                'id' => 67,
                'name' => 'Restore',
                'slug' => 'restore-setting',
                'parent_id' => 62
            ],
            [
                'id' => 68,
                'name' => 'Force Delete',
                'slug' => 'force-delete-setting',
                'parent_id' => 62
            ],
        ];

        DB::table('permissions')->insert(
            $permissions
        );
    }
}
