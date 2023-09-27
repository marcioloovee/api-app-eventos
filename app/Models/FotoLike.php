<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FotoLike extends Model
{
    use HasFactory;

    protected $table = 'fotos_likes';
    protected $primaryKey = 'foto_like_id';
}
