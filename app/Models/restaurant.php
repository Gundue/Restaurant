<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class restaurant extends Model
{
    protected $table = 'restaurant';
    protected $primaryKey = 'r_idx';

    protected $fillable = ['r_name', 'r_menu', 'r_category'];
}
