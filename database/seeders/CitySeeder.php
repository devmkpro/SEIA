<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class CitySeeder extends Seeder
{
    protected $BASE_URL;
    
    public function __construct()
    {
        $this->BASE_URL = 'https://servicodados.ibge.gov.br/api/v1/localidades/municipios';
    }

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $cities = json_decode(file_get_contents($this->BASE_URL));
        foreach ($cities as $city) {
            //City::create([
               // 'name' => $city->nome,
                //'state_id' => $city->microrregiao->mesorregiao->UF->id,
                //'ibge_code' => $city->id,
           // ]);
           if ($city->id == '1100015'){
                City::create([
                    'name' => $city->nome,
                    'state_id' => $city->microrregiao->mesorregiao->UF->id,
                    'ibge_code' => $city->id,
                ]);
                break;
           }
        }
    }
}
