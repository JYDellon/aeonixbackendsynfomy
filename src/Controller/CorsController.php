<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CorsController
{
    #[Route('/{any}', name: 'cors_preflight', methods: ['OPTIONS'], requirements: ['any' => '.*'])]
    public function preflight(): Response
    {
        $response = new Response();
        $response->headers->set('Access-Control-Allow-Origin', '*'); // Remplacez '*' par votre domaine si nécessaire
        $response->headers->set('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, OPTIONS');
        $response->headers->set('Access-Control-Allow-Headers', 'Content-Type, Authorization');

        return $response;
    }
}