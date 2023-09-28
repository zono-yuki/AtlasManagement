<?php

namespace App\Models\Categories;

use Illuminate\Database\Eloquent\Model;

use App\Models\Categories\SubCategory;

class MainCategory extends Model
{
    const UPDATED_AT = null;
    const CREATED_AT = null;
    protected $fillable = [
        'main_category',
        'created_at',
    ];

    public function subCategories(){
        // 1対多の1の方
        return $this->hasMany(SubCategory::class);
    }

}
