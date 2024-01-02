<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\State;

class StateSeeder extends Seeder
{

    public function __construct()
    {
        $this->BASE_URL = 'https://servicodados.ibge.gov.br/api/v1/localidades/estados';
    }

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $states = json_decode(file_get_contents($this->BASE_URL));
        foreach ($states as $state) {
            State::create([
                'ibge_code' => $state->id,
                'name' => $state->nome,
            ]);
        }
    }
}
