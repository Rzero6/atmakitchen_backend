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
            'nama' => 'Owner',
        ]);
        DB::table('roles')->insert([
            'nama' => 'Manager Operasional',
        ]);
        DB::table('roles')->insert([
            'nama' => 'Admin',
        ]);
        DB::table('roles')->insert([
            'nama' => 'Staf',
        ]);
        DB::table('roles')->insert([
            'nama' => 'Customer',
        ]);

        ///bahan baku
        DB::table('bahan_bakus')->insert([
            'nama' => 'Butter',
            'stok' => 10000,
            'satuan' => 'gr',
        ]);
        DB::table('bahan_bakus')->insert([
            'nama' => 'Creamer',
            'stok' => 30000,
            'satuan' => 'gr',
        ]);
        DB::table('bahan_bakus')->insert([
            'nama' => 'Telur',
            'stok' => 60000,
            'satuan' => 'pcs',
        ]);
        DB::table('bahan_bakus')->insert([
            'nama' => 'Gula Pasir',
            'stok' => 80000,
            'satuan' => 'gr',
        ]);
        DB::table('bahan_bakus')->insert([
            'nama' => 'Susu Bubuk',
            'stok' => 5000,
            'satuan' => 'gr',
        ]);
        DB::table('bahan_bakus')->insert([
            'nama' => 'Tepung Terigu',
            'stok' => 36000,
            'satuan' => 'gr',
        ]);
        DB::table('bahan_bakus')->insert([
            'nama' => 'Garam',
            'stok' => 2000,
            'satuan' => 'gr',
        ]);
        DB::table('bahan_bakus')->insert([
            'nama' => 'Coklat Bubuk',
            'stok' => 10000,
            'satuan' => 'gr',
        ]);
        DB::table('bahan_bakus')->insert([
            'nama' => 'Selai Strawberry',
            'stok' => 5000,
            'satuan' => 'gr',
        ]);
        DB::table('bahan_bakus')->insert([
            'nama' => 'Coklat Batang',
            'stok' => 50000,
            'satuan' => 'gr',
        ]);
        DB::table('bahan_bakus')->insert([
            'nama' => 'Minyak Goreng',
            'stok' => 5000,
            'satuan' => 'gr',
        ]);
        DB::table('bahan_bakus')->insert([
            'nama' => 'Tepung Maizena',
            'stok' => 30000,
            'satuan' => 'gr',
        ]);
        DB::table('bahan_bakus')->insert([
            'nama' => 'Baking Powder',
            'stok' => 100,
            'satuan' => 'gr',
        ]);
        DB::table('bahan_bakus')->insert([
            'nama' => 'Kacang Kenari',
            'stok' => 4000,
            'satuan' => 'gr',
        ]);
        DB::table('bahan_bakus')->insert([
            'nama' => 'Ragi',
            'stok' => 2000,
            'satuan' => 'gr',
        ]);
        DB::table('bahan_bakus')->insert([
            'nama' => 'Susu Cair',
            'stok' => 15000,
            'satuan' => 'ml',
        ]);
        DB::table('bahan_bakus')->insert([
            'nama' => 'Sosis Blackpaper',
            'stok' => 1000,
            'satuan' => 'pcs',
        ]);
        DB::table('bahan_bakus')->insert([
            'nama' => 'Whipped Cream',
            'stok' => 10000,
            'satuan' => 'ml',
        ]);
        DB::table('bahan_bakus')->insert([
            'nama' => 'Susu Full Cream',
            'stok' => 3000,
            'satuan' => 'ml',
        ]);
        DB::table('bahan_bakus')->insert([
            'nama' => 'Keju Mozarella',
            'stok' => 20000,
            'satuan' => 'gr',
        ]);
        DB::table('bahan_bakus')->insert([
            'nama' => 'Matcha Bubuk',
            'stok' => 4000,
            'satuan' => 'gr',
        ]);
        DB::table('bahan_bakus')->insert([
            'nama' => 'Box 20x20 cm',
            'stok' => 4000,
            'satuan' => 'pcs',
        ]);
        DB::table('bahan_bakus')->insert([
            'nama' => 'Box 20x10 cm',
            'stok' => 4000,
            'satuan' => 'pcs',
        ]);
        DB::table('bahan_bakus')->insert([
            'nama' => 'Botol 1 liter',
            'stok' => 4000,
            'satuan' => 'pcs',
        ]);
        DB::table('bahan_bakus')->insert([
            'nama' => 'Box Premium',
            'stok' => 4000,
            'satuan' => 'pcs',
        ]);
        DB::table('bahan_bakus')->insert([
            'nama' => 'Kartu Ucapan',
            'stok' => 4000,
            'satuan' => 'pcs',
        ]);
        DB::table('bahan_bakus')->insert([
            'nama' => 'Tas Spunbond',
            'stok' => 4000,
            'satuan' => 'pcs',
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
        ///Karyawan
        DB::table('users')->insert([
            'nama' => 'Greyla',
            'no_telepon' => '0811111111',
            'password' => bcrypt('owner'),
            'email' => 'owner@atmakitchen.com',
            'id_role' => 1,
        ]);
        DB::table('karyawans')->insert([
            'id_user' => 1,
            'gaji_harian' => 350000,
            'bonus' => 250000,
        ]);

        DB::table('users')->insert([
            'nama' => 'Lala',
            'no_telepon' => '082225553400',
            'password' => bcrypt('lala'),
            'email' => 'lala@atmakitchen.com',
            'id_role' => 2,
        ]);
        DB::table('karyawans')->insert([
            'id_user' => 2,
            'gaji_harian' => 250000,
            'bonus' => 175000,
        ]);

        DB::table('users')->insert([
            'nama' => 'Rey',
            'no_telepon' => '085799689430',
            'password' => bcrypt('rey'),
            'email' => 'rey@atmakitchen.com',
            'id_role' => 3,
        ]);
        DB::table('karyawans')->insert([
            'id_user' => 3,
            'gaji_harian' => 200000,
            'bonus' => 150000,
        ]);

        DB::table('users')->insert([
            'nama' => 'Gre',
            'no_telepon' => '081327389023',
            'password' => bcrypt('gre'),
            'email' => 'gre@atmakitchen.com',
            'id_role' => 4,
        ]);
        DB::table('karyawans')->insert([
            'id_user' => 4,
            'gaji_harian' => 100000,
            'bonus' => 100000,
        ]);

        ///User
        DB::table('users')->insert([
            'nama' => 'Test User',
            'no_telepon' => '0812312231',
            'password' => bcrypt('test'),
            'email' => 'test@test.com',
            'id_role' => 5,
        ]);
        DB::table('customers')->insert([
            'id_user' => 5,
            'tanggal_lahir' => '2023-01-01',
            'promo_poin' => 0,
            'saldo' => 0,
            'verify_key' => 'test',
        ]);
        ///alamat
        DB::table('alamats')->insert([
            'id_customer' => 1,
            'nama_penerima' => 'Test Nama Alamat',
            'no_telepon' => '0812312231',
            'kota' => 'Sleman',
            'jalan' => 'Jalan Babarsari 123',
            'rincian' => 'Rumah warna merah',
        ]);
        //Produk
        DB::table('produks')->insert(([
            'nama' => 'Lapis Legit',
            'jenis' => 'Cake',
            'harga' => 850000,
            'stok' => 0,
            'limit_po' => 10,
            'ukuran' => 'Satu Loyang',
        ]));

        DB::table('produks')->insert(([
            'nama' => 'Lapis Legit',
            'jenis' => 'Cake',
            'harga' => 450000,
            'stok' => 0,
            'limit_po' => 10,
            'ukuran' => 'Setengah Loyang',
        ]));

        DB::table('produks')->insert(([
            'nama' => 'Lapis Surabaya',
            'jenis' => 'Cake',
            'harga' => 550000,
            'stok' => 0,
            'limit_po' => 10,
            'ukuran' => 'Satu Loyang',
        ]));

        DB::table('produks')->insert(([
            'nama' => 'Lapis Surabaya',
            'jenis' => 'Cake',
            'harga' => 300000,
            'stok' => 0,
            'limit_po' => 10,
            'ukuran' => 'Setengah Loyang',
        ]));

        DB::table('produks')->insert(([
            'nama' => 'Brownies',
            'jenis' => 'Cake',
            'harga' => 250000,
            'stok' => 0,
            'limit_po' => 10,
            'ukuran' => 'Satu Loyang',
        ]));

        DB::table('produks')->insert(([
            'nama' => 'Brownies',
            'jenis' => 'Cake',
            'harga' => 150000,
            'stok' => 0,
            'limit_po' => 10,
            'ukuran' => 'Setengah Loyang',
        ]));

        DB::table('produks')->insert(([
            'nama' => 'Mandarin',
            'jenis' => 'Cake',
            'harga' => 450000,
            'stok' => 0,
            'limit_po' => 10,
            'ukuran' => 'Satu Loyang',
        ]));

        DB::table('produks')->insert(([
            'nama' => 'Mandarin',
            'jenis' => 'Cake',
            'harga' => 250000,
            'stok' => 0,
            'limit_po' => 10,
            'ukuran' => 'Setengah Loyang',
        ]));

        DB::table('produks')->insert(([
            'nama' => 'Spikoe',
            'jenis' => 'Cake',
            'harga' => 350000,
            'stok' => 0,
            'limit_po' => 10,
            'ukuran' => 'Satu Loyang',
        ]));

        DB::table('produks')->insert(([
            'nama' => 'Spikoe',
            'jenis' => 'Cake',
            'harga' => 200000,
            'stok' => 0,
            'limit_po' => 10,
            'ukuran' => 'Setengah Loyang',
        ]));

        DB::table('produks')->insert(([
            'nama' => 'Roti Sosis',
            'jenis' => 'Roti',
            'harga' => 180000,
            'stok' => 0,
            'limit_po' => 10,
            'ukuran' => 'Per Box (isi 10)',
        ]));

        DB::table('produks')->insert(([
            'nama' => 'Milk Bun',
            'jenis' => 'Roti',
            'harga' => 120000,
            'stok' => 0,
            'limit_po' => 10,
            'ukuran' => 'Per Box (isi 10)',
        ]));

        DB::table('produks')->insert(([
            'nama' => 'Roti Keju',
            'jenis' => 'Roti',
            'harga' => 150000,
            'stok' => 0,
            'limit_po' => 10,
            'ukuran' => 'Per Box (isi 10)',
        ]));

        DB::table('produks')->insert(([
            'nama' => 'Choco Creamy Latte',
            'jenis' => 'Minuman',
            'harga' => 75000,
            'stok' => 0,
            'limit_po' => 10,
            'ukuran' => 'Per Liter',
        ]));

        DB::table('produks')->insert(([
            'nama' => 'Matcha Creamy Latte',
            'jenis' => 'Minuman',
            'harga' => 100000,
            'stok' => 0,
            'limit_po' => 10,
            'ukuran' => 'Per Liter',
        ]));

        DB::table('produks')->insert(([
            'id_penitip' => 1,
            'nama' => 'Keripik Kentang',
            'jenis' => 'Cemilan',
            'harga' => 75000,
            'stok' => 64,
            'ukuran' => 'Per Bungkus 250gr',
        ]));

        DB::table('produks')->insert(([
            'id_penitip' => 1,
            'nama' => 'Kopi Luwak Bubuk',
            'jenis' => 'Minuman',
            'harga' => 250000,
            'stok' => 34,
            'ukuran' => 'Per Bungkus 250gr',
        ]));

        DB::table('produks')->insert(([
            'id_penitip' => 2,
            'nama' => 'Matcha Organik Bubuk',
            'jenis' => 'Minuman',
            'harga' => 300000,
            'stok' => 67,
            'ukuran' => 'Per Bungkus 100gr',
        ]));

        DB::table('produks')->insert(([
            'id_penitip' => 2,
            'nama' => 'Chocolate Bar',
            'jenis' => 'Cemilan',
            'harga' => 120000,
            'stok' => 34,
            'ukuran' => 'Per Bungkus 100gr',
        ]));


        //Produk Hampers
        DB::table('hampers')->insert(([
            'nama' => 'Paket A',
            'id_produk1' => 2,
            'id_produk2' => 6,
            'rincian' => 'Lapis Legit Setengah Loyang + Brownies Setengah Loyang + Exclusice box and card',
            'harga' => 650000,
        ]));

        DB::table('hampers')->insert(([
            'nama' => 'Paket B',
            'id_produk1' => 4,
            'id_produk2' => 11,
            'rincian' => 'Lapis Surabaya Setengah Loyang + Roti Sosis + Exclusice box and card',
            'harga' => 500000,
        ]));

        DB::table('hampers')->insert(([
            'nama' => 'Paket C',
            'id_produk1' => 10,
            'id_produk2' => 15,
            'rincian' => 'Spikoe Setengah Loyang + Matcha Creamy Latte + Exclusice box and card',
            'harga' => 350000,
        ]));

        DB::table('transaksis')->insert(([
            'id_customer' => 1,
            'id_alamat' => 1,
            'tanggal_penerimaan' => '2024-04-24 16:00:00',
            'status' => 'selesai',
            'jarak' => 5,
            'tip' => 50000,
        ]));

        DB::table('detail_transaksis')->insert(([
            'id_transaksi' => 1,
            'id_produk' => 1,
            'id_hampers' => null,
            'jumlah' => 2,
            'subtotal' => 100000,
        ]));
        DB::table('detail_transaksis')->insert(([
            'id_transaksi' => 1,
            'id_produk' => null,
            'id_hampers' => 2,
            'jumlah' => 1,
            'subtotal' => 200000,
        ]));
    }
}
