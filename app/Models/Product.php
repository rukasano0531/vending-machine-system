<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Company;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'company_id',
        'price',
        'stock',
        'comment',
        'image',
    ];

    // Company（メーカー）とのリレーション
    public function company()
    {
        return $this->belongsTo(Company::class);
    }
}