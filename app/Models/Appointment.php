<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{
    use HasFactory;
    
    protected $table = 'appointments';
    protected $fillable = [
        'start',     
        'end',       
        'status',    
        'service_id', 
        'client_id', 
        'hairdresser_id', 
        'unregistered_client',
    ];
    protected $casts = [
        'start' => 'datetime', 
        'end' => 'datetime',
    ];


    
    public function service()
    {
        return $this->belongsTo(Service::class);
    }

    public function client(){
        return $this->belongsTo(User::class);
    }

    public function hairdresser()
    {
        return $this->belongsTo(Hairdresser::class);
    }
}
