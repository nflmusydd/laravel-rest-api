<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;


class Business extends Model
{
    use HasFactory;

    protected $table = 'business';
    
    protected $fillable=[
        'user_id',
        'name',
        'opening_hours',
        'status'
    ];

    public function user(){
        return $this->belongsTo(User::class);
    }

}
