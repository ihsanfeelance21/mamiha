<?php

namespace App\Controllers;

class Profil extends BaseController
{
    public function madrasah()
    {
        $data = [
            'title' => 'Profil Madrasah'
        ];
        return view('profil/madrasah', $data);
    }

    public function struktur()
    {
        $data = [
            'title' => 'Struktur Organisasi'
        ];
        return view('profil/struktur', $data);
    }
}
