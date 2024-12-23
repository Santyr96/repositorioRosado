<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Hairdresser extends Model
{
    use HasFactory;

    protected $table = 'hairdressers';

    public function clients(){

    	return $this->belongsToMany(User::class, 'signups', 'hairdresser_id', 'client_id')
        ->where('role','cliente');
    }

    public function owner(){
    	return $this->belongsTo(User::class, 'owner_id');
    }
}
