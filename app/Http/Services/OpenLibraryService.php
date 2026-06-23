<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class OpenLibraryService
{
    /**
     * Search books from OpenLibrary API
     */
    public function searchBooks($query, $limit = 5)
    {
        try {
            // Gunakan dengan verify false untuk testing (jika ada SSL issue)
            $response = Http::withOptions([
                'verify' => false,
                'timeout' => 30
            ])->get('https://openlibrary.org/search.json', [
                'q' => $query,
                'limit' => $limit,
            ]);

            // Log untuk debugging
            Log::info('OpenLibrary Response Status: ' . $response->status());
            Log::info('OpenLibrary Response Body: ' . substr($response->body(), 0, 500));

            if ($response->successful()) {
                $data = $response->json();

                if (isset($data['docs']) && is_array($data['docs'])) {
                    // Format ulang data
                    $data['docs'] = array_map(function ($book) {
                        return [
                            'key' => $book['key'] ?? null,
                            'title' => $book['title'] ?? 'Unknown Title',
                            'author_name' => isset($book['author_name']) && is_array($book['author_name'])
                                ? $book['author_name'][0] ?? 'Unknown Author'
                                : 'Unknown Author',
                            'first_publish_year' => $book['first_publish_year'] ?? null,
                            'publisher' => isset($book['publisher']) && is_array($book['publisher'])
                                ? $book['publisher'][0] ?? 'Unknown Publisher'
                                : 'Unknown Publisher',
                            'cover_i' => $book['cover_i'] ?? null,
                            'cover_url' => isset($book['cover_i'])
                                ? "https://covers.openlibrary.org/b/id/{$book['cover_i']}-M.jpg"
                                : null
                        ];
                    }, $data['docs']);
                }

                return $data;
            }

            Log::error('OpenLibrary API Error: ' . $response->status() . ' - ' . $response->body());
            return ['docs' => [], 'error' => 'API returned status ' . $response->status()];
        } catch (\Exception $e) {
            Log::error('OpenLibrary Exception: ' . $e->getMessage());
            Log::error('OpenLibrary Trace: ' . $e->getTraceAsString());
            return ['docs' => [], 'error' => $e->getMessage()];
        }
    }
}
