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
        $components = [
            [
                'name'          => 'IC Mikrokontroler ATmega328',
                'part_number'   => 'IC-001',
                'stock'         => 50,
                'minimum_stock' => 10,
                'unit'          => 'pcs',
            ],
            [
                'name'          => 'Resistor 10K Ohm',
                'part_number'   => 'RS-001',
                'stock'         => 200,
                'minimum_stock' => 50,
                'unit'          => 'pcs',
            ],
            [
                'name'          => 'Kapasitor 100uF',
                'part_number'   => 'CP-001',
                'stock'         => 150,
                'minimum_stock' => 30,
                'unit'          => 'pcs',
            ],
            [
                'name'          => 'PCB 4-Layer Custom Model X-200',
                'part_number'   => 'PCB-X200-4L-REV2',
                'stock'         => 0,
                'minimum_stock' => 100,
                'unit'          => 'pcs',
            ],
        ];

        foreach ($components as $component) {
            Component::updateOrCreate(
                ['part_number' => $component['part_number']],
                $component
            );
        }
    }
}
