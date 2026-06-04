<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\Menber;

class DefUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        Menber::create([
            "Name" => "admin",
            "Password" => "admin",
            "Permission" => 1,
            "Status" => 1,
            "LearnTime" => 0,
        ]);
    }
}
