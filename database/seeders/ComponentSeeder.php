<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Component;

class ComponentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Component::insert([
            [
                'name'          => 'IC Mikrokontroler ATmega328',
                'part_number'   => 'IC-001',
                'stock'         => 50,
                'minimum_stock' => 10,
                'unit'          => 'pcs',
                'created_at'    => now(),
                'updated_at'    => now(),
            ],
            [
                'name'          => 'Resistor 10K Ohm',
                'part_number'   => 'RS-001',
                'stock'         => 200,
                'minimum_stock' => 50,
                'unit'          => 'pcs',
                'created_at'    => now(),
                'updated_at'    => now(),
            ],
            [
                'name'          => 'Kapasitor 100uF',
                'part_number'   => 'CP-001',
                'stock'         => 150,
                'minimum_stock' => 30,
                'unit'          => 'pcs',
                'created_at'    => now(),
                'updated_at'    => now(),
            ],
        ]);
    }
}
