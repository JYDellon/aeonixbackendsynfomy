<?php
use App\Kernel;

require_once dirname(__DIR__).'/vendor/autoload_runtime.php';

return function (array $context) {
    $_SERVER['APP_CACHE_DIR'] = '/tmp/cache';
    $_SERVER['APP_LOG_DIR'] = '/tmp/log';

    return new Kernel($context['APP_ENV'], (bool) $context['APP_DEBUG']);
};