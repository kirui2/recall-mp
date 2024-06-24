<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ward extends Model
{
    use HasFactory;

    protected $table = 'wards'; // Assuming 'wards' is the name of your table

    // Define relationships if any
    public function constituency()
    {
        return $this->belongsTo(Constituency::class);
    }
}