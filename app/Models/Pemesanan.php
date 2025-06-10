<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pemesanan extends Model
{
    use HasFactory;

    protected $fillable = [
        'kode_booking', 'kamar_id', 'user_id', 'nomor_kamar','nama_pemesan', 'tanggal_lahir', 'jenis_kelamin',
        'tanggal_checkin', 'tanggal_checkout', 'jumlah_tamu', 'nomor_hp',
        'email', 'sumber', 'status', 'total_harga','metode_pembayaran', 
    ];

    public function kamar()
    {
        return $this->belongsTo(Kamar::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function pembayaran()
    {
        return $this->hasOne(Pembayaran::class);
    }

    public function checkin()
    {
        return $this->hasOne(Checkin::class);
    }

    protected static function booted()
{
    static::creating(function ($pemesanan) {
        // 🔢 Generate kode_booking terstruktur
        if (empty($pemesanan->kode_booking)) {
            $pemesanan->kode_booking = self::generateKodeBooking($pemesanan->sumber ?? 'walkin');
        }

        // ❗ Cek stok kamar
        if ($pemesanan->kamar && $pemesanan->kamar->stok <= 0) {
            throw new \Exception("Stok kamar habis.");
        }
    });

    static::created(function ($pemesanan) {
        // 🔻 Kurangi stok kamar setelah booking
        if ($pemesanan->kamar) {
            $pemesanan->kamar->decrement('stok');
        }
    });

    static::deleted(function ($pemesanan) {
        // 🔼 Kembalikan stok kamar jika pemesanan dihapus
        if ($pemesanan->kamar) {
            $pemesanan->kamar->increment('stok');
        }
    });
}

// 🔧 Fungsi pembantu untuk membuat kode booking terstruktur
protected static function generateKodeBooking(string $sumber): string
{
    $prefix = $sumber === 'online' ? 'WB' : 'WK';
    $tanggal = now()->format('Ymd');

    $count = self::whereDate('created_at', today())
        ->where('sumber', $sumber)
        ->count() + 1;

    $urutan = str_pad($count, 3, '0', STR_PAD_LEFT);

    return "{$prefix}-{$tanggal}-{$urutan}";
}


}
