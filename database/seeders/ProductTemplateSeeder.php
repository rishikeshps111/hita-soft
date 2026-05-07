<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class ProductTemplateSeeder extends Seeder
{
    public function run()
    {
        $datePath = date('M-Y');
        $featuredDir = public_path('images/featured_products/' . $datePath);
        $galleryDir = public_path('images/products/' . $datePath);

        File::ensureDirectoryExists($featuredDir);
        File::ensureDirectoryExists($galleryDir);

        $products = [
            [
                'code' => 'hs001',
                'title' => 'Aquamate Automatic Starter',
                'short_description' => 'Compact and efficient starter for small capacity water pumps.',
                'price' => 3360,
                'stock' => 1,
                'capacity' => '0.5 - 1.5 HP',
                'type' => 'DOL Starter',
                'power' => 'Single Phase 230V',
                'size' => 'L 12, B 7.5, H 10 cm',
                'feature' => 'Suitable for basic pump automation with reliable performance',
                'image' => '1.png',
            ],
            [
                'code' => 'hs002',
                'title' => 'Aquamate Automatic Panel',
                'short_description' => 'Reliable automatic panel for open well pump systems.',
                'price' => 3870,
                'stock' => 1,
                'capacity' => '0.5 - 1.5 HP',
                'type' => 'Open Well Pump Panel (Without Cap)',
                'power' => 'Single Phase 230V',
                'size' => 'L 18.5, B 9.5, H 19 cm',
                'feature' => 'Ensures automatic operation with protection features',
                'image' => '2.png',
            ],
            [
                'code' => 'hs003',
                'title' => 'Universal Single Phase Automatic Panel Board',
                'short_description' => 'Smart automation panel designed for borewell pump systems.',
                'price' => 7950,
                'stock' => 1,
                'capacity' => '0.75 - 3 HP',
                'type' => 'Borewell Pump Timer Panel (Without Cap)',
                'power' => 'Single Phase 230V',
                'size' => 'L 24, B 9, H 29 cm',
                'feature' => 'Includes timer-based control and automation',
                'image' => '3.png',
            ],
            [
                'code' => 'hs004',
                'title' => 'Universal 3 Phase DOL Automatic Panel Board',
                'short_description' => 'High-performance panel for industrial-grade 3-phase pumps.',
                'price' => 18550,
                'stock' => 1,
                'capacity' => '5 - 10 HP / 3 Phase 440V',
                'type' => 'DOL Universal',
                'power' => '3 Phase 440V',
                'size' => 'L 35, B 12, H 27 cm',
                'feature' => 'Designed for durability and stable operation',
                'image' => '4.png',
            ],
            [
                'code' => 'hs005',
                'title' => 'Universal 3 Phase DOL 2 Load Interchange Automatic Panel Board',
                'short_description' => 'Dual pump automation panel with interchange functionality.',
                'price' => 27950,
                'stock' => 1,
                'capacity' => '5 - 10 HP (2 Pumps) / 3 Phase 440V',
                'type' => 'DOL Universal',
                'power' => '3 Phase 440V',
                'size' => 'L 45, B 12, H 27 cm',
                'feature' => 'Alternates pump usage to prevent wear and ensure longevity',
                'image' => '5.png',
            ],
            [
                'code' => 'hs006',
                'title' => 'Universal 3 Phase Star-Delta Automatic Panel Board',
                'short_description' => 'Advanced panel for heavy-duty pump operations.',
                'price' => 45800,
                'stock' => 1,
                'capacity' => '10 - 20 HP / 3 Phase 440V',
                'type' => 'Star-Delta (SD) Universal',
                'power' => '3 Phase 440V',
                'size' => 'L 45, B 18, H 37 cm',
                'feature' => 'Suitable for high-load applications with smooth start',
                'image' => '6.png',
            ],
            [
                'code' => 'hs007',
                'title' => 'Universal 3 Phase Star-Delta 2 Load Interchange Automatic Panel Board',
                'short_description' => 'Premium dual-load panel for large-scale automation systems.',
                'price' => 88000,
                'stock' => 1,
                'capacity' => '10 - 25 HP (2 Pumps) / 3 Phase 440V',
                'type' => 'Star-Delta (SD) Universal',
                'power' => '3 Phase 440V',
                'size' => 'L 100, B 22, H 80 cm',
                'feature' => 'Supports interchange operation for heavy-duty usage',
                'image' => '7.png',
            ],
        ];

        foreach ($products as $item) {
            $sourceImage = public_path('assets/img/item/' . $item['image']);
            $featuredName = 'seeded_' . $item['image'];
            $featuredRelativePath = $datePath . '/' . $featuredName;

            if (File::exists($sourceImage)) {
                File::copy($sourceImage, $featuredDir . '/' . $featuredName);
                File::copy($sourceImage, $galleryDir . '/' . $featuredName);
            }

            DB::table('products')->updateOrInsert(
                ['product_code' => $item['code']],
                [
                    'product_code' => $item['code'],
                    'product_title' => $item['title'],
                    'product_desc' => '<p>' . $item['short_description'] . '</p>',
                    'short_description' => $item['short_description'],
                    'original_price' => $item['price'],
                    'discounted_price' => $item['price'],
                    'onhand_qty' => $item['stock'],
                    'features' => $item['feature'],
                    'product_capacity' => $item['capacity'],
                    'product_type' => $item['type'],
                    'product_power' => $item['power'],
                    'product_size' => $item['size'],
                    'product_feature_text' => $item['feature'],
                    'featured_product_img' => $featuredRelativePath,
                    'attributes_flag' => 0,
                    'featuredproduct_flag' => 1,
                    'new_arrival' => 0,
                    'is_block' => 1,
                    'created_user' => 1,
                    'updated_at' => now(),
                    'created_at' => DB::raw('COALESCE(created_at, NOW())'),
                ]
            );

            $product = DB::table('products')->where('product_code', $item['code'])->first();

            if ($product) {
                DB::table('products_images')->where('product_id', $product->id)->delete();
                DB::table('products_images')->insert([
                    'product_id' => $product->id,
                    'image' => $featuredRelativePath,
                    'is_block' => 1,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }
    }
}
