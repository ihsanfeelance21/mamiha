<?php

namespace App\Controllers;

use App\Models\KalenderAkademikModel;

class KalenderController extends BaseController
{
    public function index()
    {
        $kalenderModel = new KalenderAkademikModel();

        // Ambil semua data, urutkan dari tanggal paling awal (ASC)
        $semuaAgenda = $kalenderModel->orderBy('tanggal_mulai', 'ASC')->findAll();

        // Array nama bulan bahasa Indonesia
        $bulanIndo = [
            1 => 'Januari',
            2 => 'Februari',
            3 => 'Maret',
            4 => 'April',
            5 => 'Mei',
            6 => 'Juni',
            7 => 'Juli',
            8 => 'Agustus',
            9 => 'September',
            10 => 'Oktober',
            11 => 'November',
            12 => 'Desember'
        ];

        // Proses Grouping berdasarkan Bulan & Tahun
        $agendaGrouped = [];
        foreach ($semuaAgenda as $agenda) {
            $bulanAngka = (int) date('m', strtotime($agenda['tanggal_mulai']));
            $tahun = date('Y', strtotime($agenda['tanggal_mulai']));

            // Format Key: "Maret 2026"
            $namaGroup = $bulanIndo[$bulanAngka] . ' ' . $tahun;

            $agendaGrouped[$namaGroup][] = $agenda;
        }

        $data = [
            'title' => 'Kalender Akademik',
            'agendaGrouped' => $agendaGrouped,
            'bulanSingkat' => [
                1 => 'JAN',
                2 => 'FEB',
                3 => 'MAR',
                4 => 'APR',
                5 => 'MEI',
                6 => 'JUN',
                7 => 'JUL',
                8 => 'AGS',
                9 => 'SEP',
                10 => 'OKT',
                11 => 'NOV',
                12 => 'DES'
            ]
        ];

        return view('kalender_index', $data);
    }
}
