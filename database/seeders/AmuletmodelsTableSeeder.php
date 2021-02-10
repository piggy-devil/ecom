<?php

namespace Database\Seeders;

use App\Models\Amuletmodel;
use Illuminate\Database\Seeder;

class AmuletmodelsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $modelpraRecords = [
            ['id' => 1, 'user_id' => 1, 'name' => 'รุ่นฉลองอายุ 91 ปี พ.ศ.2563', 'creator' => '', 'purpose' => 'เพื่อหาทุนทรัพย์ในการจัดสร้างรูปเหมือนขนาดเท่าองค์จริง', 'status' => 1],
            ['id' => 2, 'user_id' => 1, 'name' => 'เหรียญรูปเหมือนครึ่งองค์ รุ่น เมตตาธรรม', 'creator' => '', 'purpose' => 'เพื่อบูรณะปฏิสังขรณ์เสนาสนะ', 'status' => 1],
            ['id' => 3, 'user_id' => 1, 'name' => 'พระผงรูปเหมือนหลวงปู่พัฒน์ รุ่นแรก', 'creator' => '', 'purpose' => 'เพื่อสมทบทุนร่วมบูรณปฏิสังขรณ์เสนาสนะวัดห้วยด้วน', 'status' => 1],
        ];

        Amuletmodel::insert($modelpraRecords);
    }
}
