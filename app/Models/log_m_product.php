<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class log_m_product extends Model
{
    protected $table = 'log_m_product';
    protected $fillable = [
        'id_log_m_product',
        'log_m_product_code',
        'log_m_product_name',
        'log_m_class_code',
        'log_m_type_code',
        'log_m_product_status',
        'log_m_product_qr',
        'log_m_product_file',
        'created_at',
    ];
}
