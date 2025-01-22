<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Mahasiswa extends Model
{
    use HasFactory;

    public function matakuliahs(): BelongsToMany
    {
        // return $this->belongsToMany('App\Models\Matakuliah');
        return $this->belongsToMany('App\Models\Matakuliah')->withTimestamps();
    }
}
