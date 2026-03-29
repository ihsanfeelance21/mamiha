<?php

namespace App\Controllers;

use App\Models\UnduhanModel;

class Unduhan extends BaseController
{
    public function index()
    {
        $unduhanModel = new UnduhanModel();

        $data = [
            'title'   => 'Pusat Unduhan | Madrasah',
            // Ambil semua data unduhan, urutkan dari yang paling baru diupload
            'unduhan' => $unduhanModel->orderBy('created_at', 'DESC')->findAll()
        ];

        return view('unduhan_index', $data);
    }
}
