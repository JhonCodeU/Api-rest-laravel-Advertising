<?php

namespace Database\Seeders;

use App\Models\City;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $cities = [
            ['name' => 'Medellín', 'departament_id' => 2],
            ['name' => 'Cali', 'departament_id' => 30],
            ['name' => 'Barranquilla', 'departament_id' => 4],
            ['name' => 'Cartagena', 'departament_id' => 5],
            ['name' => 'Cúcuta', 'departament_id' => 22],
            ['name' => 'Soledad', 'departament_id' => 4],
            ['name' => 'Ibagué', 'departament_id' => 29],
            ['name' => 'Soacha', 'departament_id' => 14],
            ['name' => 'Bucaramanga', 'departament_id' => 27],
            ['name' => 'Villavicencio', 'departament_id' => 20],
            ['name' => 'Santa Marta', 'departament_id' => 19],
            ['name' => 'Valledupar', 'departament_id' => 11],
            ['name' => 'Bello', 'departament_id' => 2],
            ['name' => 'Pereira', 'departament_id' => 25],
            ['name' => 'Monteria', 'departament_id' => 13],
            ['name' => 'San Juan de Pasto', 'departament_id' => 21],
            ['name' => 'Buenaventura', 'departament_id' => 30],
            ['name' => 'Manizales', 'departament_id' => 7],
            ['name' => 'Neiva', 'departament_id' => 17],
            ['name' => 'Palmira', 'departament_id' => 30],
            ['name' => 'Armenia', 'departament_id' => 24],
            ['name' => 'Riohacha', 'departament_id' => 18],
            ['name' => 'Sincelejo', 'departament_id' => 28],
            ['name' => 'Popayán', 'departament_id' => 10],
            ['name' => 'Itagüí', 'departament_id' => 2],
            ['name' => 'Floridablanca', 'departament_id' => 27],
            ['name' => 'Envigado', 'departament_id' => 2],
            ['name' => 'Tuluá', 'departament_id' => 30],
            ['name' => 'Tumaco', 'departament_id' => 21],
            ['name' => 'Dosquebradas', 'departament_id' => 25],
            ['name' => 'Tunja', 'departament_id' => 6],
            ['name' => 'San Juan de Girón', 'departament_id' => 27],
            ['name' => 'Apartadó', 'departament_id' => 2],
            ['name' => 'Uribia', 'departament_id' => 18],
            ['name' => 'Barrancabermeja', 'departament_id' => 27],
            ['name' => 'Florencia', 'departament_id' => 8],
            ['name' => 'Turbo', 'departament_id' => 2],
            ['name' => 'Maicao', 'departament_id' => 18],
            ['name' => 'Piedecuesta', 'departament_id' => 27],
            ['name' => 'Yopal', 'departament_id' => 9],
            ['name' => 'Ipiales', 'departament_id' => 21],
            ['name' => 'Fusagasugá', 'departament_id' => 14],
            ['name' => 'Facatativá', 'departament_id' => 14],
            ['name' => 'Chía', 'departament_id' => 14],
            ['name' => 'Cartago', 'departament_id' => 30],
            ['name' => 'Pitalito', 'departament_id' => 17],
            ['name' => 'Zipaquirá', 'departament_id' => 14],
            ['name' => 'Jamundí', 'departament_id' => 30],
            ['name' => 'Malambo', 'departament_id' => 4],
            ['name' => 'Rionegro', 'departament_id' => 2],
            ['name' => 'Yumbo', 'departament_id' => 30],
            ['name' => 'Magangué', 'departament_id' => 5],
            ['name' => 'Santa Cruz de Lorica', 'departament_id' => 13],
            ['name' => 'Caucasia', 'departament_id' => 2],
            ['name' => 'Manaure', 'departament_id' => 18],
            ['name' => 'Quibdó', 'departament_id' => 12],
            ['name' => 'Guadalajara de Buga', 'departament_id' => 30],
            ['name' => 'Duitama', 'departament_id' => 6],
            ['name' => 'Sogamoso', 'departament_id' => 6],
            ['name' => 'Tierralta', 'departament_id' => 13],
            ['name' => 'Girardot', 'departament_id' => 14],
            ['name' => 'Ciénaga', 'departament_id' => 19],
            ['name' => 'Sabanalarga', 'departament_id' => 4],
            ['name' => 'Ocaña', 'departament_id' => 22]
        ];

        foreach ($cities as $city) {
            City::create($city);
        }
    }
}
