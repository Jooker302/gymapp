<?php

namespace App\Http\Controllers;

use App\Models\BodyPart;
use App\Models\Equipment;
use App\Models\Exercise;
use App\Models\TargetMuscle;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class MainController extends Controller
{
    public function get_api_bodypart(){
        // $client = new \GuzzleHttp\Client(['defaults' => [
        //     'verify' => false
        // ]]);
        // $client = new \GuzzleHttp\Client();
        // $client->setDefaultOption('verify', false);
        // $response = $client->request('GET', 'https://exercisedb.p.rapidapi.com/exercises/bodyPartList', [
        //     'headers' => [
        //         'X-RapidAPI-Host' => 'exercisedb.p.rapidapi.com',
        //         'X-RapidAPI-Key' => 'b00b5e5e74mshc35ff6aa606e2dep1e59bfjsn624f458a61fd',
        //     ],
        // ]);

        // var_dump($response->getBody());

        $response = Http::withHeaders([
            'X-RapidAPI-Host' => 'exercisedb.p.rapidapi.com',
            'X-RapidAPI-Key' => 'b00b5e5e74mshc35ff6aa606e2dep1e59bfjsn624f458a61fd',
        ])->get('https://exercisedb.p.rapidapi.com/exercises/bodyPartList');

        $data = $response->json();

        // dd($data);
        foreach($data as $d){
            // dd($d);
            $bp = new BodyPart;
            $bp->name = $d;
            $bp->save();
        }
        return 'success';
    }

    public function get_api_exercise(){


        $bodypart = BodyPart::all();

        foreach($bodypart as $bp){
            $string = 'https://exercisedb.p.rapidapi.com/exercises/bodyPart/'.$bp->name;
            $response = Http::withHeaders([
                'X-RapidAPI-Host' => 'exercisedb.p.rapidapi.com',
                'X-RapidAPI-Key' => 'b00b5e5e74mshc35ff6aa606e2dep1e59bfjsn624f458a61fd',
            ])->get($string);

            $data = $response->json();
            // dd($data);

            foreach($data as $d){
                // dd($d['name']);
                $e = new Exercise;
                $e->name = $d['name'];
                $e->bodyPart = $d['bodyPart'];
                $e->equipment = $d['equipment'];
                $e->gifUrl = $d['gifUrl'];
                $e->target = $d['target'];
                $e->id_coming = $d['id'];
                $e->save();
            }
        }
    }

    public function get_api_equipment(){
        $response = Http::withHeaders([
            'X-RapidAPI-Host' => 'exercisedb.p.rapidapi.com',
            'X-RapidAPI-Key' => 'b00b5e5e74mshc35ff6aa606e2dep1e59bfjsn624f458a61fd',
        ])->get('https://exercisedb.p.rapidapi.com/exercises/equipmentList');

        $data = $response->json();

        // dd($data);
        foreach($data as $d){
            // dd($d);
            $bp = new Equipment();
            $bp->name = $d;
            $bp->save();
        }
        return 'success';

    }

    public function get_api_targetmuscles(){
        $response = Http::withHeaders([
            'X-RapidAPI-Host' => 'exercisedb.p.rapidapi.com',
            'X-RapidAPI-Key' => 'b00b5e5e74mshc35ff6aa606e2dep1e59bfjsn624f458a61fd',
        ])->get('https://exercisedb.p.rapidapi.com/exercises/targetList');

        $data = $response->json();

        // dd($data);
        foreach($data as $d){
            // dd($d);
            $bp = new TargetMuscle();
            $bp->name = $d;
            $bp->save();
        }
        return 'success';

    }

}
