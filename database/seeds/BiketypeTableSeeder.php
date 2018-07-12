<?php

use Illuminate\Database\Seeder;
use App\Biketype;

class BiketypeTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $ab=new Biketype();
        $ab->name='adult bikes';
        $ab->info='adult bikes';
        $ab->price_h=12;
        $ab->price_d=22;
        $ab->insurance=2;
        $ab->save();
        $kb=new Biketype();
        $kb->name='kid bikes';
        $kb->info='kid bikes';
        $kb->price_h=10;
        $kb->price_d=20;
        $kb->insurance=2;
        $kb->save();
        $tb=new Biketype();
        $tb->name='tandem bikes';
        $tb->info='tandem bikes';
        $tb->price_h=15;
        $tb->price_d=28;
        $tb->insurance=2;
        $tb->save();
        //
    }
}
