<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        // Create admin user
        User::create([
            'name' => 'Admin User',
            'email' => 'admin@healthhub.com',
            'password' => Hash::make('password'),
            'date_of_birth' => '1990-01-01',
            'gender' => 'Male',
            'address' => '123 Admin Street',
            'city' => 'Admin City',
            'contact_no' => '1234567890',
            'role' => 'admin',
        ]);

        // Create categories
        $categories = [
            ['name' => 'Diagnostic Equipment', 'slug' => 'diagnostic-equipment'],
            ['name' => 'Surgical Instruments', 'slug' => 'surgical-instruments'],
            ['name' => 'Patient Monitoring', 'slug' => 'patient-monitoring'],
            ['name' => 'Medical Furniture', 'slug' => 'medical-furniture'],
            ['name' => 'Therapeutic Equipment', 'slug' => 'therapeutic-equipment'],
        ];

        foreach ($categories as $category) {
            Category::create($category);
        }

        // Create products
        $products = [
            [
                'name' => 'Digital Blood Pressure Monitor',
                'description' => 'Automatic digital blood pressure monitor with large LCD display and memory function.',
                'price' => 49.99,
                'category_id' => 1,
                'image_url' => 'https://via.placeholder.com/300x200?text=Blood+Pressure+Monitor',
                'stock' => 50,
            ],
            [
                'name' => 'Stethoscope Professional',
                'description' => 'Dual-head stethoscope for medical professionals with high acoustic sensitivity.',
                'price' => 29.99,
                'category_id' => 1,
                'image_url' => 'https://via.placeholder.com/300x200?text=Stethoscope',
                'stock' => 100,
            ],
            [
                'name' => 'Surgical Scissors Set',
                'description' => 'Premium stainless steel surgical scissors set for precise cutting.',
                'price' => 39.99,
                'category_id' => 2,
                'image_url' => 'https://via.placeholder.com/300x200?text=Surgical+Scissors',
                'stock' => 75,
            ],
            [
                'name' => 'Patient Monitor',
                'description' => 'Advanced patient monitor with ECG, SpO2, NIBP, and temperature monitoring.',
                'price' => 1299.99,
                'category_id' => 3,
                'image_url' => 'https://via.placeholder.com/300x200?text=Patient+Monitor',
                'stock' => 10,
            ],
            [
                'name' => 'Adjustable Hospital Bed',
                'description' => 'Electric adjustable hospital bed with remote control and safety rails.',
                'price' => 1999.99,
                'category_id' => 4,
                'image_url' => 'https://via.placeholder.com/300x200?text=Hospital+Bed',
                'stock' => 5,
            ],
            [
                'name' => 'Portable Oxygen Concentrator',
                'description' => 'Lightweight portable oxygen concentrator for patients on the go.',
                'price' => 899.99,
                'category_id' => 5,
                'image_url' => 'https://via.placeholder.com/300x200?text=Oxygen+Concentrator',
                'stock' => 15,
            ],
        ];

        foreach ($products as $product) {
            Product::create($product);
        }
    }
}