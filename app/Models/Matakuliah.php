<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Matakuliah extends Model
{
    use HasFactory;

    public function mahasiswas(): BelongsToMany
    {
        return $this->belongsToMany('App\Models\Mahasiswa')->withTimestamps();
    }
}
