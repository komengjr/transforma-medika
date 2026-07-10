<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KopArisanGroup extends Model
{
    protected $table = 'kop_arisan_group';
    protected $primaryKey = 'id_kop_arisan_group';
    protected $fillable = ['kop_arisan_group_status'];
}
