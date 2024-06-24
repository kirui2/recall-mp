<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Signature; 

class MP extends Model
{
    use HasFactory;
	
	protected $table = 'mps'; // Specify your actual table name here


    protected $fillable = ['name', 'role', 'county_id', 'constituency_id', 'voted_yes', 'recall_count'];
	
	public function signatures()
    {
        return $this->hasMany(Signature::class, 'mp_id'); // Specify the foreign key column if needed
    }
	
	public function county()
    {
        return $this->belongsTo(County::class);
    }

    public function constituency()
    {
        return $this->belongsTo(Constituency::class);
    }
}
