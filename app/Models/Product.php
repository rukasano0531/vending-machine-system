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

    // 検索ロジックをモデルに移動
    public static function search($keyword, $companyId, $priceMin, $priceMax, $stockMin, $stockMax)
    {
        $query = self::with('company');

        if (!empty($keyword)) {
            $query->where('name', 'like', "%{$keyword}%");
        }

        if (!empty($companyId)) {
            $query->where('company_id', $companyId);
        }

        if (!empty($priceMin)) {
            $query->where('price', '>=', $priceMin);
        }

        if (!empty($priceMax)) {
            $query->where('price', '<=', $priceMax);
        }

        if (!empty($stockMin)) {
            $query->where('stock', '>=', $stockMin);
        }

        if (!empty($stockMax)) {
            $query->where('stock', '<=', $stockMax);
        }

        return $query;
    }
}