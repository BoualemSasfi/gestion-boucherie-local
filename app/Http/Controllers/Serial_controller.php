<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
// use Fawno\PhpSerial\Serial;
// use Tvelu77\Src\PhpSerial; 
// use Gregwar\Serial\Serial;
// use PhpSerial;
// use App\Services\SerializationService;

// use Lepiaf\SerialPort\SerialPort; 
class Serial_controller extends Controller
{
    public function showBalance()
    {
        $port = 'COM8'; // Remplacez par le port approprié
        $baudRate = 9600; // Remplacez par le baud rate approprié
    
        // Ouvrir le port série
        $fp = fopen("com{$port}", 'w+');
        if (!$fp) {
            return view('caisse.test')->with('data', 'Impossible d\'ouvrir le port série.');
        }
    
        // Configurer le port série
        exec("mode {$port} baud={$baudRate} data=8 parity=n stop=1");
    
        // Écrire des données sur le port série
        fwrite($fp, "Test data\n");
    
        // Lire les données depuis le port série
        $data = fread($fp, 1024);
    
        // Fermer le port série
        fclose($fp);
    
        // return view('caisse.balance')->with('data', $data);
        return view('caisse.test')->with('data', $data);
    }

}



