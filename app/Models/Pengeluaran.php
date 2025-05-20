<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OpenApi\Annotations as OA;

/**
 * @OA\Schema(
 *     schema="Pengeluaran",
 *     type="object",
 *     title="Pengeluaran",
 *     required={"tanggal", "jumlah", "user_id"},
 *     @OA\Property(property="id_pengeluaran", type="integer", example=1),
 *     @OA\Property(property="tanggal", type="string", format="date", example="2025-05-01"),
 *     @OA\Property(property="catatan", type="string", example="Belanja bahan"),
 *     @OA\Property(property="jumlah", type="number", example=150000),
 *     @OA\Property(property="user_id", type="integer", example=1)
 * )
 */
class Pengeluaran extends Model
{
    use HasFactory;

    protected $table = 'pengeluaran';
    protected $primaryKey = 'id_pengeluaran';

    protected $fillable = [
        'tanggal',
        'catatan',
        'jumlah',
        'user_id',
    ];

    /**
     * Relasi ke model User
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
