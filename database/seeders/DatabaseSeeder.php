<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Company;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // テスト用ユーザーを重複チェックつきで作成
        if (!User::where('email', 'test@example.com')->exists()) {
            User::create([
                'name' => 'Test User',
                'email' => 'test@example.com',
                'password' => bcrypt('password'),
            ]);
        }

        // メーカー情報を重複チェックつきで追加
        $companies = ['Coca-Cola', 'サントリー', 'キリン'];

        foreach ($companies as $companyName) {
            Company::firstOrCreate(['name' => $companyName]);
        }
    }
}