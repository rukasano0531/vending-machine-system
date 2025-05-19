<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Company;

class CompanySeeder extends Seeder
{
    public function run(): void
    {
        Company::create(['name' => 'Coca-Cola']);
        Company::create(['name' => 'サントリー']);
        Company::create(['name' => 'キリン']);
    }
}