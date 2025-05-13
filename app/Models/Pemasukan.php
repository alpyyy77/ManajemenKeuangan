<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pemasukan extends Model
{
    use HasFactory;

    protected $table = 'pemasukan';
    protected $primaryKey = 'id_pemasukan';

    protected $fillable = [
        'tanggal',
        'catatan',
        'jumlah',
        'status',
        'user_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
