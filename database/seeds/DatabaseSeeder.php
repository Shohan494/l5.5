<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

use App\User;
use App\Catagory;
use App\Product;
use App\Transaction;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // $this->call(UsersTableSeeder::class);
        
        DB::statement('SET FOREIGN_KEY_CHECKS = 0');
        User::truncate();
        Product::truncate();
        Catagory::truncate();
        Transaction::truncate();
        DB::table('catagory_product')->truncate();

        $usersQuantity = 200;
        $catagoriesQuantity = 30;
        $productsQuantity = 1000;
        $transactionsQuantity = 1000;

        factory(User::class, $usersQuantity)->create();
        factory(Catagory::class, $catagoriesQuantity)->create();
        factory(Product::class, $productsQuantity)->create()->each(
        	function($product){
        		$catagories = Catagory::all()->random(mt_rand(1,5))->pluck('id');
        		$product->catagories()->attach($catagories);
        	});
        factory(Transaction::class, $transactionsQuantity)->create();

    }
}
