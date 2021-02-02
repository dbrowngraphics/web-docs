<?php

namespace Dashboard;

use DB;

use Illuminate\Support\Facades\Input;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class Category extends Model
{
    protected $table = 'CW.V3T_ARTICLE_CATEGORY';


    public static function findCategoryValue($categoryTitle)
    {
        $categories = Category::all();
        // dd($categories);

        // $value = $categories->search(function ($item, $key){
        //     return $item == 'Additional Benefits' ? $key : null;
        // });

        // $value = $categories->toJson;

        foreach ($categories as $category) {
            if ($category->category == $categoryTitle) {
                return $category->id;
            }
        }

        return null;
    }
}