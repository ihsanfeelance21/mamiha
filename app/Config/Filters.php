<?php

namespace Config;

use CodeIgniter\Config\Filters as BaseFilters;
// ... (use statements lainnya tetap sama)

class Filters extends BaseFilters
{
    /**
     * 1. DAFTARKAN ALIAS
     * Kita tambahkan 'auth' agar sistem mengenali Class AuthFilter kita.
     */
    public array $aliases = [
        'csrf'          => \CodeIgniter\Filters\CSRF::class,
        'toolbar'       => \CodeIgniter\Filters\DebugToolbar::class,
        'honeypot'      => \CodeIgniter\Filters\Honeypot::class,
        'invalidchars'  => \CodeIgniter\Filters\InvalidChars::class,
        'secureheaders' => \CodeIgniter\Filters\SecureHeaders::class,
        'cors'          => \CodeIgniter\Filters\Cors::class,
        'forcehttps'    => \CodeIgniter\Filters\ForceHTTPS::class,
        'pagecache'     => \CodeIgniter\Filters\PageCache::class,
        'performance'   => \CodeIgniter\Filters\PerformanceMetrics::class,

        // Tambahkan baris ini:
        'auth'          => \App\Filters\AuthFilter::class,
    ];

    public array $required = [
        'before' => ['forcehttps', 'pagecache'],
        'after'  => ['pagecache', 'performance', 'toolbar'],
    ];

    public array $globals = [
        'before' => [],
        'after'  => [],
    ];

    public array $methods = [];

    /**
     * 2. AKTIFKAN FILTER PADA RUTE TERTENTU
     * Di sini kita instruksikan sistem: "Semua URL yang diawali admin/ WAJIB lewat filter auth"
     */
    public array $filters = [
        'auth' => [
            'before' => [
                'admin',
                'admin/*', // Mengunci dashboard, kegiatan, user, dll.
            ]
        ],
    ];
}
