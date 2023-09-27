<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Publicacao extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'publicacoes';
    protected $primaryKey = 'publicacao_id';

    protected $appends = [
        'username',
        'username_image',
        'data',
        'curtido',
    ];

    protected function getUsernameAttribute()
    {
        return Usuario::find($this->usuario_id)->username;
    }

    protected function getUsernameImageAttribute()
    {
        return Usuario::find($this->usuario_id)->foto_perfil_uri;
    }

    protected function getDataAttribute()
    {
        return Carbon::parse($this->created_at)->format('Y-m-d H:i:s');
    }

    protected function getCurtidoAttribute()
    {
        $like = PublicacaoLike::where('publicacao_id', '=', $this->publicacao_id)
            ->where('usuario_id', '=', auth()->id())
            ->first();

        return (!is_null($like));
    }

}
