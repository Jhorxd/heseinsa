<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Tcsunat extends controller {

    public function index() {
        $params = json_encode([
            'fecha' => date('Y-m-d'), // Puedes modificar esto según lo necesites
            'moneda' => 'USD'         // Puedes modificar esto según lo necesites
        ]);

        $curl = curl_init();
        curl_setopt_array($curl, [
            CURLOPT_URL => "https://apiperu.dev/api/tipo_de_cambio",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_POSTFIELDS => $params,
            CURLOPT_HTTPHEADER => [
                'Accept: application/json',
                'Content-Type: application/json',
                'Authorization: Bearer 6789d6850a660269210834c6e370039ee50a578b090147415998a03371af686f'
            ],
        ]);

        $response = curl_exec($curl);
        $err = curl_error($curl);
        curl_close($curl);

        if ($err) {
            echo json_encode(['success' => false, 'error' => $err]);
        } else {
            echo $response;  // ya es JSON
        }
    }
}

