<?php

namespace App\Models;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['name', 'category_id'];

    public static function getProducts(): LengthAwarePaginator
    {
        return self::query()
            ->with('category')
            ->select('id', 'name', 'category_id')
            ->paginate();
    }

    public static function getProductsByCategory(Category $category): LengthAwarePaginator
    {
        return self::query()
            ->with('category')
            ->where('category_id', $category->id)
            ->select('id', 'name', 'category_id')
            ->paginate();
    }

    public static function storeProduct($data): Model|Builder
    {
        return self::query()->create($data);
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class, 'category_id', 'id')
            ->select('id', 'name', 'parent_id');
    }

    public static function updateProduct(Product $product, $data): bool
    {
        return $product->update($data);
    }

    public static function deleteProduct(Product $product): ?bool
    {
        return $product->delete();
    }
}
