<?php

namespace Database\Seeders;

use App\Models\Gol;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class GolSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $goles = [
            [
                'cycle_id' => 2,
                'name' => 'Smaidi',
                'motto' => 'Disfruta la vida con una gran sonrisa',
                'chant' => 'Solo una Sonrisa de Fe',
                'verse' => 'Proverbios 31:25',
            ],
            [
                'cycle_id' => 4,
                'name' => 'Linux',
                'motto' => 'Sin fe nada es posible. Con ella nada es imposible.',
                'chant' => 'Dame fé',
                'verse' => '2 Corintios 5:7',
            ],
            [
                'cycle_id' => 6,
                'name' => 'Alfa y Omega',
                'motto' => '',
                'chant' => 'Cuarteto Adventista Bethel - Alfa y Omega',
                'verse' => 'Apocalipsis 1:8',
            ],
            [
                'cycle_id' => 8,
                'name' => 'Mensajeros Digitales',
                'motto' => 'Llevar el mensaje de Dios a todo el mundo a mi generación.',
                'chant' => 'Jesus en mi ciudad',
                'verse' => 'Santiago 1:22',
            ],
            [
                'cycle_id' => 10,
                'name' => 'Alpha Go',
                'motto' => 'Guardar la palabra de Dios en mi corazón',
                'chant' => 'Canto de alegria porque tengo amor',
                'verse' => 'Salmos 119:9',
            ],
            [
                'cycle_id' => 12,
                'name' => 'Judá',
                'motto' => 'Mi vida en mision con una cancion en el corazon',
                'chant' => '10 mil razones',
                'verse' => 'Salmos 34:1',
            ],
            [
                'cycle_id' => 14,
                'name' => 'Aser',
                'motto' => 'No dejes que el miedo te impida ser feliz',
                'chant' => 'El mejor lugar del mundo',
                'verse' => 'Salmos 109:105',
            ],
            [
                'cycle_id' => 16,
                'name' => 'Kyrios',
                'motto' => 'No temere mal alguno porque tu estas conmigo!',
                'chant' => 'Mi pastor',
                'verse' => 'Salmos 23:1',
            ],
            [
                'cycle_id' => 18,
                'name' => 'Cades',
                'motto' => 'En todo tiempo escucha Dios a sus hijos',
                'chant' => 'Eterna roca',
                'verse' => 'Salmos 119:1',
            ],
            [
                'cycle_id' => 20,
                'name' => 'AGAPE',
                'motto' => '',
                'chant' => '',
                'verse' => '',
            ],
            [
                'cycle_id' => 21,
                'name' => 'Worship',
                'motto' => 'El amor de cristo me motiva',
                'chant' => 'Diez mil razones',
                'verse' => '¡Que todo lo que respira alabe al señor!¡Aleluya!¡Alabado sea el Señor!',
            ],
            [
                'cycle_id' => 22,
                'name' => 'Zimrah',
                'motto' => 'Acuerdate de tu creador en los dias de tu juventud',
                'chant' => 'Yo voy',
                'verse' => 'Proverbios 20:29',
            ],
            [
                'cycle_id' => 24,
                'name' => 'Job',
                'motto' => 'Camino con Jesus cada dia.',
                'chant' => 'Caminar en tus zapatos',
                'verse' => 'Genesis 13:17',
            ],
            [
                'cycle_id' => 26,
                'name' => 'Genesis',
                'motto' => 'De pie ante el mundo y de rodillas ante Dios',
                'chant' => 'Mi pastor - Adoradores',
                'verse' => 'Romanos 14:8',
            ],
            [
                'cycle_id' => 28,
                'name' => 'Light of Hope',
                'motto' => 'El que persevera alcanza',
                'chant' => 'Todo va a estar bien.',
                'verse' => '1 Timoteo 4:12',
            ],

        ];

        foreach ($goles as $gol) {
            Gol::create([
                'cycle_id' => $gol['cycle_id'],
                'name' => $gol['name'],
                'motto' => $gol['motto'],
                'chant' => $gol['chant'],
                'verse' => $gol['verse'],
            ]);
        }
    }
}
