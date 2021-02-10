<?php

namespace Database\Seeders;

use App\Models\AmbookAttribute;
use Illuminate\Database\Seeder;

class AmbookAttributesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $modelpraRecords = [
            [
                'id' => 1,
                'ambook_id' => 4,
                'ambook_name' => 'เนื้อทองคำ',
                'ambook_create' => 199,
                'ambook_stock' => 199,
                'ambook_price' => 55000,
            ],
            [
                'id' => 2,
                'ambook_id' => 4,
                'ambook_name' => 'เนื้อเงินหน้ากากทองคำ',
                'ambook_create' => 1999,
                'ambook_stock' => 1999,
                'ambook_price' => 11999,
            ],
            [
                'id' => 3,
                'ambook_id' => 4,
                'ambook_name' => 'เนื้อเงิน',
                'ambook_create' => 2999,
                'ambook_stock' => 2999,
                'ambook_price' => 1999,
            ],
        ];

        AmbookAttribute::insert($modelpraRecords);
    }
}
