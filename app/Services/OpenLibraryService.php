<?php
// app/Services/OpenLibraryService.php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class OpenLibraryService
{
    protected string $baseUrl = 'https://openlibrary.org';
    protected string $userAgent;

    public function __construct()
    {
        // GANTI dengan email kamu!
        $this->userAgent = 'MyLaravelBookApp/1.0 (emailanda@gmail.com)';
    }

    /**
     * Cari buku dari OpenLibrary
     */
    public function searchBooks(string $query, int $limit = 5): array
    {
        try {
            $response = Http::withHeaders([
                'User-Agent' => $this->userAgent
            ])->timeout(10)->get("{$this->baseUrl}/search.json", [
                'q' => $query,
                'limit' => $limit,
                'fields' => 'key,title,author_name,first_publish_year,cover_i,publisher,isbn'
            ]);

            if ($response->failed()) {
                Log::error('OpenLibrary API error', [
                    'status' => $response->status(),
                    'query' => $query
                ]);
                return ['docs' => []];
            }

            return $response->json();
        } catch (\Exception $e) {
            Log::error('OpenLibrary API exception', [
                'error' => $e->getMessage(),
                'query' => $query
            ]);
            return ['docs' => []];
        }
    }

    /**
     * Ambil detail buku berdasarkan ID Work
     */
    public function getWork(string $workId): ?array
    {
        try {
            $response = Http::withHeaders([
                'User-Agent' => $this->userAgent
            ])->timeout(10)->get("{$this->baseUrl}/works/{$workId}.json");

            return $response->successful() ? $response->json() : null;
        } catch (\Exception $e) {
            Log::error('OpenLibrary API exception', ['error' => $e->getMessage()]);
            return null;
        }
    }

    /**
     * Ambil data penulis
     */
    public function getAuthor(string $authorKey): ?array
    {
        try {
            $response = Http::withHeaders([
                'User-Agent' => $this->userAgent
            ])->timeout(10)->get("{$this->baseUrl}/authors/{$authorKey}.json");

            return $response->successful() ? $response->json() : null;
        } catch (\Exception $e) {
            Log::error('OpenLibrary API exception', ['error' => $e->getMessage()]);
            return null;
        }
    }

    /**
     * Generate URL cover buku
     */
    public function getCoverUrl(string $olid, string $size = 'M'): string
    {
        // size: S (small), M (medium), L (large)
        return "https://covers.openlibrary.org/b/olid/{$olid}-{$size}.jpg";
    }

    /**
     * Get cover by ISBN
     */
    public function getCoverByIsbn(string $isbn, string $size = 'M'): string
    {
        return "https://covers.openlibrary.org/b/isbn/{$isbn}-{$size}.jpg";
    }
}
