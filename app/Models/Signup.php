<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Signup extends Model
{
    use HasFactory;

    // Nombre de la tabla asociada
    protected $table = 'signups';

    // Columnas que se pueden asignar masivamente
    protected $fillable = [
        'client_id',
        'hairdresser_id',
    ];

    // Relación con el modelo Cliente (User)
    public function client()
    {
        return $this->belongsTo(User::class, 'client_id');
    }

    // Relación con el modelo Hairbooker
    public function hairbooker()
    {
        return $this->belongsTo(Hairdresser::class, 'hairdresser_id');
    }
}
