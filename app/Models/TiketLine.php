<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TiketLine extends Model
{
    use HasFactory;
    protected $table = 'tickets_lines';
    public $timestamps = false;
}
