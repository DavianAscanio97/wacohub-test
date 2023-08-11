<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Favorites extends Model
{
    use HasFactory;

    protected $fillable = ['id_user', 'ref_api'];

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user');
    }
}
