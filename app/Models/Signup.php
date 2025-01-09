<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Signup extends Model
{
    use HasFactory;

    
    protected $table = 'signups';


    protected $fillable = [
        'client_id',
        'hairdresser_id',
    ];

    
    public function client()
    {
        return $this->belongsTo(User::class, 'client_id');
    }

    public function hairbooker()
    {
        return $this->belongsTo(Hairdresser::class, 'hairdresser_id');
    }
}
