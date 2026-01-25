<?php

namespace Database\Seeders;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class EmailTemplateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        Model::unguard();

        DB::table('email_templates')->insert(
            [
                [
                    'name' => 'Contact Us Email Template',
                    'subject' => 'LNF - Contact Us',
                    'body' => '<h2 style="text-align:center;"><span style="color:hsl(240,67%,46%);"><strong>Thank you for contacting LNF...</strong></span></h2><p><i><strong>You are very important to us, We will contact you very soon! For urgent inquiries please contact us directly at </strong></i></p>', // password
                    'bcc' => 'fred@wsa-network.com,ahmedasassd24@gmail.com',
                    'slug' => 'contact_us_email_template',
                    'source' => NULL,
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'name' => 'New Application Confirmation Email Template',
                    'subject' => '**We received your LNF Membership Application**',
                    'body' => '<h2 style="text-align:center;"><span style="color:hsl(240,67%,46%);"><strong>Welcome IN LNF...</strong></span></h2><p><i><strong>You are very important to us, Thank you for applying to join the LNF </strong></i></p>', // password
                    'bcc' => 'fred@wsa-network.com,ahmedasassd24@gmail.com',
                    'slug' => 'new_application_confirmation_email_template',
                    'source' => NULL,
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
            ]
        );
    }
}
