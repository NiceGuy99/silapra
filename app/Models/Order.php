<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'nomor_rm',
        'nama_pasien',
        'asal_ruangan_mutasi',
        'tujuan_ruangan_mutasi',
        'user_request',
        'asal_ruangan_user_request',
        'tanggal_permintaan',
        'tanggal_diterima',
        'tanggal_selesai',
        'status',
        'officer_id'
    ];

    protected $casts = [
        'tanggal_permintaan' => 'datetime',
        'tanggal_diterima' => 'datetime',
        'tanggal_selesai' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime'
    ];

    // Relationship dengan officer
    public function officer()
    {
        return $this->belongsTo(Officer::class);
    }
}