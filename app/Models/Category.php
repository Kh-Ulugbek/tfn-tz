<?php

namespace App\Models;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['name', 'parent_id'];

    public static function getCategories(): LengthAwarePaginator
    {
        return self::query()
            ->with('child')
            ->parent()
            ->select('id', 'name', 'parent_id')
            ->paginate();
    }

    public function scopeParent($query)
    {
        return $query->where('parent_id', 0);
    }

    public static function getChildCategories(Category $category): LengthAwarePaginator
    {
        return self::query()
            ->with('child')
            ->where('parent_id', $category->id)
            ->select('id', 'name', 'parent_id')
            ->paginate();
    }

    public static function storeCategory($data): Model|Builder
    {
        return self::query()->create($data);
    }

    public static function updateCategory(Category $category, $data): bool
    {
        return $category->update($data);
    }

    public static function deleteCategory(Category $category): ?bool
    {
        Product::query()->where('category_id', $category->id)->delete();
        Category::query()->where('parent_id', $category->id)->delete();
        return $category->delete();
    }

    public function child(): HasMany
    {
        return $this->hasMany(Category::class, 'parent_id', 'id')
            ->select('id', 'name', 'parent_id');
    }
}
