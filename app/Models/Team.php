<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Team extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama_tim',
        'kota',
        'pelatih',
        'analis',
        ]; 
    
    public function teamMember()
    {
        return $this->belongsTo(TeamMember::class, 'id_team');
    }
}
