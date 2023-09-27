<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Mensagem extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'mensagens';
    protected $primaryKey = 'mensagem_id';

    protected $appends = [
        'username',
        'userSend'
    ];

    protected function getUsernameAttribute()
    {
        return Usuario::find($this->usuario_id)->username;
    }

    protected function getUserSendAttribute()
    {
        return ($this->usuario_id === auth()->id());
    }
}
