<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class TeamMember extends Model
{
    use HasFactory;

    protected $fillable = [
        'member_name',
        'id_game',
        'id_team',
        ]; 
    
    public function team()
    {
        return $this->belongsTo(Team::class, 'id_team');
    }

    public function getCreatedAttribute(){
            if(!is_null($this->attributes['created_at'])){
                return Carbon::parse($this->attributes['created_at'])->format('Y-m-d H:i:s');
            }
        }
    
    public function getUpdateAttribute(){
            if(!is_null($this->attributes['update_at'])){
                return Carbon::parse($this->attributes['update_at'])->format('Y-m-d H:i:s');
            }
        }
}

