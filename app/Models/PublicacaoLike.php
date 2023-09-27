<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PublicacaoLike extends Model
{
    use HasFactory;

    protected $table = 'publicacoes_likes';
    protected $primaryKey = 'publicacao_like_id';
}
