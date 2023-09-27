<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Conversa extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'conversas';
    protected $primaryKey = 'conversa_id';

    protected $fillable = [
        'ultima_mensagem_at',
    ];

    protected $appends = [
        'image',
        'username',
        'online',
        'ultima_mensagem',
        'usuario_id',
        'nome',
    ];

    protected function getImageAttribute()
    {
        if ($this->usuario1_id == auth()->id()) {
            return Usuario::find($this->usuario2_id)->foto_perfil_uri;
        }
        return Usuario::find($this->usuario1_id)->foto_perfil_uri;
    }

    protected function getUsernameAttribute()
    {
        if ($this->usuario1_id == auth()->id()) {
            return Usuario::find($this->usuario2_id)->username;
        }
        return Usuario::find($this->usuario1_id)->username;
    }

    protected function getOnlineAttribute()
    {
        return true;
    }

    protected function getUltimaMensagemAttribute()
    {
        return Mensagem::where('conversa_id',$this->conversa_id)
            ->orderBy('mensagem_id', 'DESC')
            ->first()
            ->mensagem ?? '';
    }

    protected function getUsuarioIdAttribute()
    {
        if ($this->usuario1_id == auth()->id()) {
            return Usuario::find($this->usuario2_id)->usuario_id;
        }
        return Usuario::find($this->usuario1_id)->usuario_id;
    }

    protected function getNomeAttribute()
    {
        if ($this->usuario1_id == auth()->id()) {
            return Usuario::find($this->usuario2_id)->nome;
        }
        return Usuario::find($this->usuario1_id)->nome;
    }
}
