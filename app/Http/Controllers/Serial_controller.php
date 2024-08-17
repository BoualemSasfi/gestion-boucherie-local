<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
// use Fawno\PhpSerial\Serial;
use Tvelu77\Src\PhpSerial; 
class Serial_controller extends Controller
{
    // public function getWeight()
    // {
    //     $serial1 = new Serial();
    //     $serial1->deviceSet('/dev/ttyUSB0'); // Chemin du port série
    //     $serial1->confBaudRate(9600);
    //     $serial1->deviceOpen();

    //     $weight = $serial1->readPort();
    //     $serial1->deviceClose();

    //     // return response()->json(['weight' => trim($weight)]);
    //     return view('caisse.balance', ['weight' => trim($weight)]);
    // }

        public function showBalance()
        {
            // Instancier la classe PhpSerial
            $serial = new PhpSerial();
    
            // Configurer le port série
            $serial->deviceSet('COM8'); // Chemin du port série
            $serial->confBaudRate(9600);
            $serial->deviceOpen();
    
            // Lire les données du port série
            $weight = $serial->readPort();
            $serial->deviceClose();
    
            // Retourner la vue avec les données du poids
            return view('caisse.balance', ['weight' => trim($weight)]);
        }

}
