<?php

namespace App\Http\Controllers;

class LandingController extends Controller
{
    public function index()
    {
        $nimPoints = [
            [
                'id'      => 1,
                'name'    => 'NIM Ankorondrano',
                'address' => 'Immeuble Arboretum, Ex-Village des Jeux, Ankorondrano',
                'city'    => 'Antananarivo',
                'lat'     => -18.9080,
                'lng'     => 47.5291,
                'hours'   => [
                    ['day' => 'Lun – Ven', 'time' => '08h00 – 15h30'],
                    ['day' => 'Samedi',    'time' => '08h00 – 12h00'],
                    ['day' => 'Dimanche',  'time' => 'Fermé'],
                ],
            ],
            [
                'id'      => 2,
                'name'    => 'NIM 67 Ha',
                'address' => '106 sis aux cités des 67ha Sud',
                'city'    => 'Antananarivo',
                'lat'     => -18.9385,
                'lng'     => 47.5265,
                'hours'   => [
                    ['day' => 'Lun – Ven', 'time' => '08h00 – 15h30'],
                    ['day' => 'Samedi',    'time' => '08h00 – 12h00'],
                    ['day' => 'Dimanche',  'time' => 'Fermé'],
                ],
            ],
            [
                'id'      => 3,
                'name'    => 'NIM Ambohidahy',
                'address' => '4 Rue Razafindratandra, Ambohidahy 101',
                'city'    => 'Antananarivo',
                'lat'     => -18.9097,
                'lng'     => 47.5348,
                'hours'   => [
                    ['day' => 'Lun – Ven', 'time' => '08h00 – 15h30'],
                    ['day' => 'Samedi',    'time' => '08h00 – 12h00'],
                    ['day' => 'Dimanche',  'time' => 'Fermé'],
                ],
            ],
            [
                'id'      => 4,
                'name'    => 'NIM Tamatave',
                'address' => 'LOT 2120 Plle 21/52 Mangarivotra-Sud, 501 Toamasina',
                'city'    => 'Toamasina',
                'lat'     => -18.1520,
                'lng'     => 49.4024,
                'hours'   => [
                    ['day' => 'Lun – Ven', 'time' => '08h00 – 15h30'],
                    ['day' => 'Samedi',    'time' => '08h00 – 12h00'],
                    ['day' => 'Dimanche',  'time' => 'Fermé'],
                ],
            ],
            [
                'id'      => 5,
                'name'    => 'NIM Tuléar',
                'address' => 'Bd Gallieni (à côté Présidence Université TULEAR CENTRE), 601 Toliara',
                'city'    => 'Toliara',
                'lat'     => -23.3532,
                'lng'     => 43.6742,
                'hours'   => [
                    ['day' => 'Lun – Ven', 'time' => '08h00 – 15h30'],
                    ['day' => 'Samedi',    'time' => '08h00 – 12h00'],
                    ['day' => 'Dimanche',  'time' => 'Fermé'],
                ],
            ],
        ];

        return view('welcome', compact('nimPoints'));
    }
}
