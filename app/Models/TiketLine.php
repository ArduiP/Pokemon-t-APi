<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
class TiketLine extends Model
{
    use HasFactory;
    protected static function booted()
    {
        static::addGlobalScope('notDeleted', function (Builder $builder) {
            $builder->where('deleted', 0);
        });
    }
    protected $table = 'tiket_lines';
    public $timestamps = false;
}
