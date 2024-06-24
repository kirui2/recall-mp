<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\MP;

class Signature extends Model
{
    use HasFactory;

    protected $fillable = ['id_card', 'name', 'signature_image', 'mp_id', 'county_id', 'constituency_id', 'ward', 'polling_station', 'polling_center', 'polling_station_number'];

    public function mp()
    {
        return $this->belongsTo(MP::class, 'mp_id'); // Specify the foreign key column if needed
    }
}
