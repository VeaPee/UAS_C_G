<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class TransaksiTicket extends Model
{
    use HasFactory;

    protected $fillable = [
        'hargaTicket',
        'tempatDuduk',
        'jenisTicket'
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
