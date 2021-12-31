<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class InsertController extends Controller
{
    public function index() {
        return view('insert');
    }
    
    public function upload(Request $request) {
        DB::table('restaurant')->insert([
            'r_name' => $request->input('name'), 
            'r_menu' => $request->input('menu'),
            'r_category' => $request->input('category'),
            'r_tag' => $request->name('tag-list'),
            'r_location' => $request->input('location')
        ]);

        return redirect() -> route('dashboard');
    }
}
