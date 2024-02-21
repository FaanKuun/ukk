<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Foto extends Model
{
    use HasFactory;

    protected $table = 'foto';

    protected $fillable = [
        'judul',
        'deskripsi',
        'foto',
        'user_id'
    ];

    public function user(){
        return $this->belongsTo(User::class,'user_id');
    }
}
