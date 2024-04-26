<?php

namespace Database\Seeders;

use App\Models\User;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        DB::table('roles')->insert([
            'nama' => 'Customer',
            'gaji_harian' => 0,
        ]);
        DB::table('roles')->insert([
            'nama' => 'Staf',
            'gaji_harian' => 100000,
        ]);
        DB::table('roles')->insert([
            'nama' => 'Admin',
            'gaji_harian' => 200000,
        ]);
        DB::table('roles')->insert([
            'nama' => 'Manager Operasional',
            'gaji_harian' => 250000,
        ]);
        DB::table('roles')->insert([
            'nama' => 'Owner',
            'gaji_harian' => 350000,
        ]);

        ///bahan baku
        DB::table('bahan_bakus')->insert([
            'nama' => 'Butter',
            'stok' => 10000,
            'harga' => 120,
            'satuan' => 'gr',
        ]);
        DB::table('bahan_bakus')->insert([
            'nama' => 'Creamer',
            'stok' => 30000,
            'harga' => 70,
            'satuan' => 'gr',
        ]);
        DB::table('bahan_bakus')->insert([
            'nama' => 'Telur',
            'stok' => 60000,
            'harga' => 33,
            'satuan' => 'buah',
        ]);
        DB::table('bahan_bakus')->insert([
            'nama' => 'Gula Pasir',
            'stok' => 80000,
            'harga' => 27,
            'satuan' => 'gr',
        ]);
        DB::table('bahan_bakus')->insert([
            'nama' => 'Susu Bubuk',
            'stok' => 5000,
            'harga' => 120,
            'satuan' => 'gr',
        ]);
        DB::table('bahan_bakus')->insert([
            'nama' => 'Tepung Terigu',
            'stok' => 36000,
            'harga' => 15,
            'satuan' => 'gr',
        ]);
        DB::table('bahan_bakus')->insert([
            'nama' => 'Garam',
            'stok' => 2000,
            'harga' => 16,
            'satuan' => 'gr',
        ]);
        DB::table('bahan_bakus')->insert([
            'nama' => 'Coklat Bubuk',
            'stok' => 10000,
            'harga' => 150,
            'satuan' => 'gr',
        ]);
        DB::table('bahan_bakus')->insert([
            'nama' => 'Selai Strawberry',
            'stok' => 5000,
            'harga' => 100,
            'satuan' => 'gr',
        ]);
        DB::table('bahan_bakus')->insert([
            'nama' => 'Coklat Batang',
            'stok' => 50000,
            'harga' => 80,
            'satuan' => 'gr',
        ]);
        DB::table('bahan_bakus')->insert([
            'nama' => 'Minyak Goreng',
            'stok' => 5000,
            'harga' => 16,
            'satuan' => 'gr',
        ]);
        DB::table('bahan_bakus')->insert([
            'nama' => 'Tepung Maizena',
            'stok' => 30000,
            'harga' => 21,
            'satuan' => 'gr',
        ]);
        DB::table('bahan_bakus')->insert([
            'nama' => 'Baking Powder',
            'stok' => 100,
            'harga' => 300,
            'satuan' => 'gr',
        ]);
        DB::table('bahan_bakus')->insert([
            'nama' => 'Kacang Kenari',
            'stok' => 4000,
            'harga' => 400,
            'satuan' => 'gr',
        ]);
        DB::table('bahan_bakus')->insert([
            'nama' => 'Ragi',
            'stok' => 2000,
            'harga' => 230,
            'satuan' => 'gr',
        ]);
        DB::table('bahan_bakus')->insert([
            'nama' => 'Susu Cair',
            'stok' => 15000,
            'harga' => 20,
            'satuan' => 'ml',
        ]);
        DB::table('bahan_bakus')->insert([
            'nama' => 'Sosis Blackpaper',
            'stok' => 1000,
            'harga' => 3000,
            'satuan' => 'buah',
        ]);
        DB::table('bahan_bakus')->insert([
            'nama' => 'Whipped Cream',
            'stok' => 10000,
            'harga' => 250,
            'satuan' => 'ml',
        ]);
        DB::table('bahan_bakus')->insert([
            'nama' => 'Susu Full Cream',
            'stok' => 3000,
            'harga' => 20,
            'satuan' => 'ml',
        ]);
        DB::table('bahan_bakus')->insert([
            'nama' => 'Keju Mozarella',
            'stok' => 20000,
            'harga' => 240,
            'satuan' => 'gr',
        ]);
        DB::table('bahan_bakus')->insert([
            'nama' => 'Matcha Bubuk',
            'stok' => 4000,
            'harga' => 250,
            'satuan' => 'gr',
        ]);
        ///Penitip
        DB::table('penitips')->insert([
            'nama' => 'Kripick Co.',
            'no_telp' => '08111701791',
        ]);
        DB::table('penitips')->insert([
            'nama' => 'Milky Yoghurty',
            'no_telp' => '08218899910',
        ]);
        ///User
        DB::table('users')->insert([
            'nama' => 'Test User',
            'password' => bcrypt('test'),
            'email' => 'test@test.com',
            'id_role' => 1,
        ]);
        DB::table('customers')->insert([
            'id_user' => 1,
            'tanggal_lahir' => '2023-01-01',
            'promo_poin' => 0,
            'saldo' => 0,
        ]);
        ///Karyawan
        DB::table('users')->insert([
            'nama' => 'Admin',
            'password' => bcrypt('admin'),
            'email' => 'admin@admin.com',
            'id_role' => 3,
        ]);
    }
}
