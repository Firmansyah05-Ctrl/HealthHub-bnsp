<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Product;
use App\Models\Category;

class UpdateProductsSeeder extends Seeder
{
    public function run()
    {
        // Data produk medis baru yang realistis
        $medicalProducts = [
            // Furnitur Medis
            [
                'category_slug' => 'furnitur-medis',
                'products' => [
                    [
                        'name' => 'Kursi Roda Standar Aluminium',
                        'description' => 'Kursi roda ringan dengan rangka aluminium, dilengkapi rem tangan dan bantalan empuk. Cocok untuk mobilitas pasien jangka panjang.',
                        'price' => 2500000,
                        'image_filename' => 'kursi-roda-aluminium.jpg'
                    ],
                    [
                        'name' => 'Tempat Tidur Pasien 2 Engkol',
                        'description' => 'Ranjang pasien dengan 2 engkol manual untuk mengatur posisi kepala dan kaki. Rangka besi kuat dengan roda dan rem.',
                        'price' => 4500000,
                        'image_filename' => 'tempat-tidur-2-engkol.jpg'
                    ],
                    [
                        'name' => 'Lemari Obat Stainless Steel',
                        'description' => 'Lemari penyimpanan obat-obatan dengan material stainless steel, dilengkapi kunci ganda untuk keamanan maksimal.',
                        'price' => 3200000,
                        'image_filename' => 'lemari-obat-stainless.jpg'
                    ]
                ]
            ],
            // Instrumen Bedah
            [
                'category_slug' => 'instrumen-bedah',
                'products' => [
                    [
                        'name' => 'Set Pisau Bedah Disposable',
                        'description' => 'Set lengkap pisau bedah sekali pakai dengan berbagai ukuran mata pisau. Steril dan siap pakai untuk prosedur medis.',
                        'price' => 150000,
                        'image_filename' => 'set-pisau-bedah.jpg'
                    ],
                    [
                        'name' => 'Gunting Bedah Stainless Steel',
                        'description' => 'Gunting bedah presisi tinggi dari stainless steel berkualitas medis. Tajam dan tahan karat untuk berbagai prosedur.',
                        'price' => 350000,
                        'image_filename' => 'gunting-bedah-stainless.jpg'
                    ],
                    [
                        'name' => 'Forceps Anatomis Set',
                        'description' => 'Set forceps anatomis berbagai ukuran untuk manipulasi jaringan halus. Material berkualitas tinggi dan ergonomis.',
                        'price' => 450000,
                        'image_filename' => 'forceps-anatomis-set.jpg'
                    ]
                ]
            ],
            // Pemantauan Pasien
            [
                'category_slug' => 'pemantauan-pasien',
                'products' => [
                    [
                        'name' => 'Monitor Vital Sign 5 Parameter',
                        'description' => 'Monitor pasien dengan 5 parameter vital: ECG, NIBP, SpO2, Temp, dan Resp. Layar LCD 12 inci dengan alarm.',
                        'price' => 25000000,
                        'image_filename' => 'monitor-vital-sign.jpg'
                    ],
                    [
                        'name' => 'Pulse Oximeter Fingertip',
                        'description' => 'Pulse oximeter portable untuk mengukur saturasi oksigen dan denyut nadi. Akurat dan mudah digunakan.',
                        'price' => 750000,
                        'image_filename' => 'pulse-oximeter.jpg'
                    ]
                ]
            ],
            // Peralatan Diagnostik
            [
                'category_slug' => 'peralatan-diagnostik',
                'products' => [
                    [
                        'name' => 'Glucometer Digital Akurat',
                        'description' => 'Alat tes gula darah digital dengan akurasi tinggi. Hasil cepat dalam 5 detik, memory 500 hasil tes.',
                        'price' => 500000,
                        'image_filename' => 'glucometer-digital.jpg'
                    ],
                    [
                        'name' => 'Tensimeter Digital Otomatis',
                        'description' => 'Tensimeter digital otomatis dengan manset dewasa. Akurasi tinggi dengan deteksi aritmia dan memori 2x99.',
                        'price' => 850000,
                        'image_filename' => 'tensimeter-digital.jpg'
                    ],
                    [
                        'name' => 'Stetoskop Dual Head Professional',
                        'description' => 'Stetoskop profesional dengan dual head untuk auskultasi jantung dan paru. Akustik superior dan ergonomis.',
                        'price' => 1200000,
                        'image_filename' => 'stetoskop-dual-head.jpg'
                    ]
                ]
            ],
            // Peralatan Terapi
            [
                'category_slug' => 'peralatan-terapi',
                'products' => [
                    [
                        'name' => 'Lampu Infrared Terapi TDP',
                        'description' => 'Lampu terapi infrared dengan teknologi TDP untuk terapi nyeri otot dan persendian. Timer otomatis dan adjustable.',
                        'price' => 1500000,
                        'image_filename' => 'lampu-infrared-tdp.jpg'
                    ],
                    [
                        'name' => 'Nebulizer Compressor Portabel',
                        'description' => 'Nebulizer kompresor portable untuk terapi pernafasan. Compact design dengan daya hisap optimal.',
                        'price' => 950000,
                        'image_filename' => 'nebulizer-portable.jpg'
                    ],
                    [
                        'name' => 'TENS Unit Elektroterapi',
                        'description' => 'Unit TENS (Transcutaneous Electrical Nerve Stimulation) untuk terapi nyeri non-invasif dengan berbagai program.',
                        'price' => 2200000,
                        'image_filename' => 'tens-unit.jpg'
                    ]
                ]
            ]
        ];

        // Hapus semua produk lama dengan aman
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        Product::truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        // Insert produk baru
        foreach ($medicalProducts as $categoryData) {
            $category = Category::where('slug', $categoryData['category_slug'])->first();
            
            if ($category) {
                foreach ($categoryData['products'] as $productData) {
                    Product::create([
                        'name' => $productData['name'],
                        'description' => $productData['description'],
                        'price' => $productData['price'],
                        'category_id' => $category->id,
                        'image_url' => 'products/' . $productData['image_filename'],
                        'stock' => rand(10, 100),
                    ]);
                }
            }
        }

        $this->command->info('Products updated successfully!');
    }
}