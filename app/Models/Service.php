<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Service extends Model
{
    use HasFactory;

    protected $table = 'services';
    
    protected $fillable=[
        'business_id',
        'name',
        'description',
        'price'
    ];

    public function user(){
        return $this->belongsTo(User::class);
    }
}