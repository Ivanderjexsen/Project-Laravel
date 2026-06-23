<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Buku extends Model
{
    use HasFactory;

    protected $fillable = [
        'judul_buku',
        'pengarang',
        'penerbit',
        'stok'
    ];

    protected $casts = [
        'stok' => 'integer',
    ];

    public function scopeSearch($query, $keyword)
    {
        return $query->where('judul_buku', 'like', "%{$keyword}%")
            ->orWhere('pengarang', 'like', "%{$keyword}%")
            ->orWhere('penerbit', 'like', "%{$keyword}%")
            ->orWhere('kode_buku', 'like', "%{$keyword}%");
    }

    
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
            $lastCode = $lastBuku->kode_buku;
            $lastNumber = (int) substr($lastCode, -3);
            $newNumber = str_pad($lastNumber + 1, 3, '0', STR_PAD_LEFT);
        } else {
            $newNumber = '001';
        }

        return "B-{$tahunBulan}-{$newNumber}";
    }
}
