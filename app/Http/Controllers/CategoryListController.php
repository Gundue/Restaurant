<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class CategoryListController extends Controller
{
    public function List($category)
    {
        switch($category) {
            case "Chinese":
                $type = "중식";
                break;
            case "Japanese":
                $type = "일식";
                break;
            case "Korean":
                $type = "한식";
                break;
            case "American":
                $type = "양식";
                break;
            case "night":
                $type = "야식";
                break;
            default:
                $type = "전체";
                break;
        }

        if($category == 'All') {
            $list = DB::table('restaurant')->get();  
        } else {
            $list = DB::table('restaurant')->where('r_category', $category)->get();
        }

        return view('list', ['lists' => $list, 'type' => $type]);
    }
}
