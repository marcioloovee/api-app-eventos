<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Tymon\JWTAuth\Contracts\JWTSubject;

class Usuario extends Authenticatable implements JWTSubject
{
    use HasApiTokens, HasFactory, Notifiable, SoftDeletes;

    protected $table = 'usuarios';
    protected $primaryKey = 'usuario_id';

    protected $hidden = [
        'password',
        'deleted_at',
    ];

    protected $fillable = [
        'foto_perfil_uri'
    ];

    protected $appends = [
        'idade',
        'seguido',
        'fotos',
        'online'
    ];

    protected function getIdadeAttribute()
    {
        $dataNascimento = Carbon::parse($this->data_nascimento);
        return $dataNascimento->age;
    }

    protected function getSeguidoAttribute()
    {
        return Seguidor::where('usuario1_id', auth()->id())
            ->where('usuario2_id', $this->usuario_id)
            ->exists();
    }

    protected function getFotosAttribute()
    {
        return Foto::where('usuario_id', $this->usuario_id)
            ->count();
    }

    protected function getOnlineAttribute()
    {
        $offlineThreshold = now()->subMinutes(10);
        return ($this->ultima_atividade_at > $offlineThreshold);
    }

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims()
    {
        return [];
    }
}
