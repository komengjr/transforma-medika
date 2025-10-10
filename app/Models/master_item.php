<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class master_item extends Model
{
    protected $table = 'master_item';
    protected $fillable = [
        'id_master_item',
        'master_item_code',
        'master_item_name',
        'master_item_type',
        'master_item_class',
        'master_item_opt',
        'master_item_pic',
        'master_item_barcode',
        'master_item_status',
        'created_at',
    ];
}
