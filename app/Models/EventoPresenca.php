<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EventoPresenca extends Model
{
    use HasFactory;

    protected $table = 'eventos_presencas';
    protected $primaryKey = 'evento_presenca_id';
}
