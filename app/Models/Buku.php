<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;

class Buku extends Model
{
    use HasFactory;

    protected $table = 'bukus';

    protected $fillable = [
        'kode_buku',
        'judul_buku',
        'pengarang',
        'penerbit',
        'stok'  // Ini adalah TOTAL STOK (tetap)
    ];

    protected $casts = [
        'stok' => 'integer',
    ];

    // === RELATIONSHIPS ===
    public function peminjaman()
    {
        return $this->hasMany(Loan::class, 'buku', 'judul_buku');
    }

    // === STOK METHODS ===
    public function getStokTersedia()
    {
        $dipinjam = Loan::where('buku', $this->judul_buku)
            ->where('status', 'Dipinjam')
            ->count();

        return $this->stok - $dipinjam;
    }

    public function isAvailable()
    {
        return $this->getStokTersedia() > 0;
    }

    // === KURANGI STOK ===
    public function kurangiStok()
    {
        Log::info('📌 kurangiStok dipanggil untuk: ' . $this->judul_buku);
        Log::info('📌 Stok SEBELUM: ' . $this->stok);

        // ❌ HAPUS INI - JANGAN KURANGI TOTAL STOK
        // $this->decrement('stok');

        // ✅ TOTAL STOK TETAP, TIDAK BERKURANG
        // Stok tersedia akan dihitung dari total stok - dipinjam

        Log::info('📌 Stok TETAP: ' . $this->stok);
        return true;
    }

    public function tambahStok()
    {
        Log::info('📌 tambahStok dipanggil untuk: ' . $this->judul_buku);
        Log::info('📌 Stok SEBELUM: ' . $this->stok);

        // ❌ HAPUS INI - JANGAN TAMBAH TOTAL STOK
        // $this->increment('stok');

        // ✅ TOTAL STOK TETAP, TIDAK BERTAMBAH
        Log::info('📌 Stok TETAP: ' . $this->stok);
        return true;
    }

    // === BOOT ===
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (empty($model->kode_buku)) {
                $model->kode_buku = self::generateKodeBuku();
            }
        });
    }

    private static function generateKodeBuku(): string
    {
        $tahunBulan = date('Ym');

        $lastBuku = self::where('kode_buku', 'like', "B-{$tahunBulan}-%")
            ->orderBy('kode_buku', 'desc')
            ->first();

        if ($lastBuku) {
            $lastNumber = (int) substr($lastBuku->kode_buku, -3);
            $newNumber = str_pad($lastNumber + 1, 3, '0', STR_PAD_LEFT);
        } else {
            $newNumber = '001';
        }

        return "B-{$tahunBulan}-{$newNumber}";
    }

    // === SCOPES ===
    public function scopeSearch($query, $keyword)
    {
        return $query->where('judul_buku', 'like', "%{$keyword}%")
            ->orWhere('pengarang', 'like', "%{$keyword}%")
            ->orWhere('penerbit', 'like', "%{$keyword}%")
            ->orWhere('kode_buku', 'like', "%{$keyword}%");
    }

    // === METHODS ===
    public static function isBukuExists($judul_buku, $pengarang, $penerbit, $excludeId = null)
    {
        $query = self::where('judul_buku', $judul_buku)
            ->where('pengarang', $pengarang)
            ->where('penerbit', $penerbit);

        if ($excludeId) {
            $query->where('id', '!=', $excludeId);
        }

        return $query->exists();
    }
}
