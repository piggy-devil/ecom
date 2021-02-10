<?php

namespace Database\Seeders;

use App\Models\Ambook;
use Illuminate\Database\Seeder;

class AmbookTableSeeder extends Seeder
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
                'ammodel_id' => 1,
                'ambook_name' => 'เนื้อทองคำ',
                'ambook_create' => 199,
                'ambook_stock' => 199,
                'ambook_price' => 55000,
                'is_list' => 'No',
                'is_topic' => 'No'
            ],
            [
                'id' => 2,
                'ammodel_id' => 1,
                'ambook_name' => 'เนื้อเงินหน้ากากทองคำ',
                'ambook_create' => 1999,
                'ambook_stock' => 1999,
                'ambook_price' => 11999,
                'is_list' => 'No',
                'is_topic' => 'No'
            ],
            [
                'id' => 3,
                'ammodel_id' => 1,
                'ambook_name' => 'เนื้อเงิน',
                'ambook_create' => 2999,
                'ambook_stock' => 2999,
                'ambook_price' => 1999,
                'is_list' => 'No',
                'is_topic' => 'No'
            ],
            [
                'id' => 4,
                'ammodel_id' => 1,
                'ambook_name' => 'ชุดพิเศษ ยกลังเนื้อนวะ',
                'ambook_create' => 100,
                'ambook_stock' => 100,
                'ambook_price' => 20000,
                'is_list' => 'Yes',
                'is_topic' => 'No'
            ],
            [
                'id' => 5,
                'ammodel_id' => 1,
                'ambook_name' => 'ชุดกรรมการ',
                'ambook_create' => 100,
                'ambook_stock' => 100,
                'ambook_price' => 20000,
                'is_list' => 'Yes',
                'is_topic' => 'Yes'
            ],
        ];

        Ambook::insert($modelpraRecords);
    }
}
