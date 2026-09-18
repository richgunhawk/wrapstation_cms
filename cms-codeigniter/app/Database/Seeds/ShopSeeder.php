<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class ShopSeeder extends Seeder
{
    public function run()
    {
        $this->db->table('users')->insertBatch([
            ['name' => 'Richardus Sugeng Raharjo'],
            ['name' => 'Demo Customer'],
        ]);
        $this->db->table('products')->insertBatch([
            ['product_name' => 'Apple Fuji', 'qty_in_stock' => 25, 'price' => 18000],
            ['product_name' => 'Orange Valencia', 'qty_in_stock' => 18, 'price' => 15000],
            ['product_name' => 'Pineapple Gold', 'qty_in_stock' => 12, 'price' => 28000],
        ]);
    }
}
