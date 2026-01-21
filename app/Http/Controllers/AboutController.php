<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AboutController extends Controller
{
    public function index()
    {
        $team = [
            [
                'name' => 'Adam Atma Wiguna',
                'desc' => 'NIM : 10123284',
                'photo' => '/images/karakter.png'
            ],
            [
                'name' => 'Arbi Fadhlurrahman',
                'desc' => 'NIM : 10123276',
                'photo' => '/images/team2.png'
            ],
            [
                'name' => 'M.Gilang Romadhon',
                'desc' => 'NIM : 10123288',
                'photo' => '/images/team3.jpg'
            ],
            [
                'name' => 'Muhammad Azka',
                'desc' => 'NIM : 10123701',
                'photo' => '/images/team4.jpg'
            ],
            [
                'name' => 'Muhammad Raffi Murshalat',
                'desc' => 'NIM : 10123271',
                'photo' => '/images/team5.png'
            ],
        ];
        

        return view('about.index', compact('team'));
    }
}
