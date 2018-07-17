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
        $ab->price_h=15;
        $ab->price_h_2=20;
        $ab->price_h_3=25;
        $ab->price_h_5=30;
        $ab->price_d=40;
        $ab->insurance=2;
        $ab->save();
        $kb=new Biketype();
        $kb->name='kid bikes';
        $kb->info='kid bikes';
        $kb->price_h=15;
        $kb->price_h_2=20;
        $kb->price_h_3=25;
        $kb->price_h_5=30;
        $kb->price_d=40;
        $kb->insurance=2;
        $kb->save();
        $tb=new Biketype();
        $tb->name='tandem bikes';
        $tb->info='tandem bikes';
        $tb->price_h=30;
        $tb->price_h_2=40;
        $tb->price_h_3=50;
        $tb->price_h_5=60;
        $tb->price_d=80 ;
        $tb->insurance=2;
        $tb->save();
        $tb=new Biketype();
        $tb->name='baby seat';
        $tb->info='baby seat';
        $tb->price_h=5;
        $tb->price_h_2=10;
        $tb->price_h_3=15;
        $tb->price_h_5=20;
        $tb->price_d=30 ;
        $tb->insurance=2;
        $tb->save();
        //
    }
}
