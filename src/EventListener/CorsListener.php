<?php

namespace App\EventListener;

use Symfony\Component\HttpKernel\Event\ResponseEvent;

class CorsListener
{
    public function onKernelResponse(ResponseEvent $event): void
    {
        $response = $event->getResponse();
        $request = $event->getRequest();

        // Vérifiez si la route correspond à une API
        if (strpos($request->getPathInfo(), '/api/') === 0) {
            $response->headers->set('Access-Control-Allow-Origin', '*'); // Remplacez '*' par votre domaine si nécessaire
            $response->headers->set('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, OPTIONS');
            $response->headers->set('Access-Control-Allow-Headers', 'Content-Type, Authorization');
        }
    }
}