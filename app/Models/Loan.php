<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Loan extends Model
{
    use HasFactory;

    protected $table = 'loans';

    protected $fillable = [
        'peminjam',
        'buku',
        'tanggal_pinjam',
        'status',
    ];

    protected $casts = [
        'tanggal_pinjam' => 'date',
    ];

    // === RELATIONSHIPS ===
    public function user()
    {
        return $this->belongsTo(User::class, 'peminjam', 'name');
    }

    public function buku()
    {
        return $this->belongsTo(Buku::class, 'buku', 'judul_buku');
    }

    // === SCOPES ===
    public function scopeDipinjam($query)
    {
        return $query->where('status', 'Dipinjam');
    }

    public function scopeDikembalikan($query)
    {
        return $query->where('status', 'Dikembalikan');
    }

    public function scopeByUser($query, $userName)
    {
        return $query->where('peminjam', $userName);
    }

    // === METHODS ===
    public function isDipinjam()
    {
        return $this->status === 'Dipinjam';
    }

    public function isDikembalikan()
    {
        return $this->status === 'Dikembalikan';
    }

    public function getStatusBadge()
    {
        return match ($this->status) {
            'Dipinjam' => '<span class="badge bg-primary">Dipinjam</span>',
            'Dikembalikan' => '<span class="badge bg-success">Dikembalikan</span>',
            default => '<span class="badge bg-secondary">Unknown</span>',
        };
    }

    public function getStatusText()
    {
        return match ($this->status) {
            'Dipinjam' => 'Dipinjam',
            'Dikembalikan' => 'Dikembalikan',
            default => 'Unknown',
        };
    }
}
