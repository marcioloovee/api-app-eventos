<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Foto extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'fotos';
    protected $primaryKey = 'foto_id';

    protected $appends = [
        'curtido',
    ];

    protected function getCurtidoAttribute()
    {
        $like = FotoLike::where('foto_id', '=', $this->foto_id)
            ->where('usuario_id', '=', auth()->id())
            ->first();

        return (!is_null($like));
    }
}
