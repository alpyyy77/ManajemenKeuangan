<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OpenApi\Annotations as OA;

/**
 * @OA\Schema(
 *     schema="Piutang",
 *     type="object",
 *     title="Piutang",
 *     required={"tanggal", "jumlah", "debitur", "user_id"},
 *     @OA\Property(property="id_piutang", type="integer", example=1),
 *     @OA\Property(property="tanggal", type="string", format="date", example="2025-05-01"),
 *     @OA\Property(property="catatan", type="string", example="Catatan piutang"),
 *     @OA\Property(property="jumlah", type="number", example=150000),
 *     @OA\Property(property="debitur", type="string", example="Nama debitur"),
 *     @OA\Property(property="user_id", type="integer", example=1)
 * )
 */
class Piutang extends Model
{
    use HasFactory;

    protected $table = 'piutang';
    protected $primaryKey = 'id_piutang';

    protected $fillable = [
        'tanggal',
        'catatan',
        'jumlah',
        'debitur',
        'user_id'
    ];

    // Relasi ke user
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
