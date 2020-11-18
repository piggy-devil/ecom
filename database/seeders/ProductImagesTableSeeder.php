<?php

namespace Database\Seeders;

use App\Models\ProductImage;
use Illuminate\Database\Seeder;

class ProductImagesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $productImageRecords = [
            ['id' => 1, 'product_id' => 1, 'image' => 'DSC_1776.jpg-74242.jpg', 'status' => 1]
        ];
        ProductImage::insert($productImageRecords);
    }
}
