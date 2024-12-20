<?php

use App\Kernel;

// Inclure l'autoload généré par Composer
require_once __DIR__ . '/../vendor/autoload.php';

// Vérification des variables d'environnement pour Vercel
$env = $_SERVER['APP_ENV'] ?? 'prod'; // Par défaut à 'prod'
$debug = $_SERVER['APP_DEBUG'] ?? ($env !== 'prod');

// Initialisation du Kernel Symfony
$kernel = new Kernel($env, (bool) $debug);
$request = Symfony\Component\HttpFoundation\Request::createFromGlobals();
$response = $kernel->handle($request);

// Envoyer la réponse au client
$response->send();
$kernel->terminate($request, $response);