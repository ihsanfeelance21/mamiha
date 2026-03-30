<?php

namespace App\Models;

use CodeIgniter\Model;

class AlumniModel extends Model
{
    protected $table            = 'alumni';
    protected $primaryKey       = 'id_alumni';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;

    // Aktifkan timestamp otomatis
    protected $useTimestamps    = true;
    protected $createdField     = 'created_at';
    protected $updatedField     = 'updated_at';

    protected $allowedFields    = [
        'nama_alumni',
        'tahun_lulus',
        'id_universitas',
        'usulan_universitas',
        'jurusan',
        'foto',
        'pesan_kesan',
        'is_featured',
        'status'
    ];

    /**
     * Mengambil data alumni dengan status 'approved' digabung dengan nama universitasnya
     */
    public function getApprovedAlumni()
    {
        return $this->select('alumni.*, universitas.nama_universitas, universitas.logo')
            ->join('universitas', 'universitas.id_universitas = alumni.id_universitas', 'left')
            ->where('alumni.status', 'approved')
            ->orderBy('alumni.tahun_lulus', 'DESC')
            ->findAll();
    }

    /**
     * Mengambil data alumni khusus untuk ditampilkan di Slider (is_featured = 1)
     */
    public function getFeaturedAlumni()
    {
        return $this->select('alumni.*, universitas.nama_universitas')
            ->join('universitas', 'universitas.id_universitas = alumni.id_universitas', 'left')
            ->where('alumni.status', 'approved')
            ->where('alumni.is_featured', 1)
            ->orderBy('alumni.id_alumni', 'DESC')
            ->findAll();
    }
}
