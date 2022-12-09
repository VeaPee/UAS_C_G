<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;


class Tournament extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama_tournament',
        'tanggal_tournament',
        'prizepool',
        'totalTeam',
        'id_team'
        ]; 

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
