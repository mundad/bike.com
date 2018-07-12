<?php

use Illuminate\Database\Seeder;
use App\Agent;

class AgentTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $default=new Agent();
        $default->name='default';
        $default->info='default';
        $default->profit_with_insurance='0';
        $default->profit_without_insurance='0';
        $default->save();
        $default=new Agent();
        $default->name='Agent1';
        $default->info='default';
        $default->profit_with_insurance='10';
        $default->profit_without_insurance='50';
        $default->save();
        //
    }
}
