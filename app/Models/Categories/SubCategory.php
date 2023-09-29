<?php

namespace App\Models\Categories;

use Illuminate\Database\Eloquent\Model;
use App\Models\Categories\MainCategory;
use App\Models\Posts\Post;

class SubCategory extends Model
{
    const UPDATED_AT = null;
    const CREATED_AT = null;
    protected $fillable = [
        'main_category_id',
        'sub_category',
        'created_at',
    ];
    public function mainCategory(){
     // リレーション 1対多の多
        return $this->belongsTo(MainCategory::class);

    }

    public function posts(){
        // リレーション 多対多 結合テーブルsub_category_id ,post_id
        return $this->belongsToMany(Post::class,'post_sub_categories','sub_category_id','post_id');
    }
}
