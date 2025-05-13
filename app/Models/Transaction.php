<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    // Nama tabel jika tidak mengikuti konvensi Laravel (opsional, karena default-nya sudah 'transactions')
    // protected $table = 'transactions';

    // Field yang dapat diisi secara mass-assignment
    protected $fillable = [
        'user_id',
        'category_id',
        'amount',
        'type',
        'description',
        'transaction_date',
    ];

    /**
     * Relasi: Transaction dimiliki oleh User
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Relasi: Transaction dimiliki oleh Category
     */
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * Scope untuk filter transaksi berdasarkan tipe
     * Contoh penggunaan: Transaction::type('income')->get();
     */
    public function scopeType($query, $type)
    {
        return $query->where('type', $type);
    }

    /**
     * Accessor: Format jumlah dengan pemisah ribuan (optional)
     */
    public function getFormattedAmountAttribute()
    {
        return number_format($this->amount, 2, ',', '.');
    }
}
