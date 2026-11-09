<?php

define('LARAVEL_START', microtime(true));

require __DIR__.'/../vendor/autoload.php';

$app = require __DIR__.'/../bootstrap/app.php';

if (parse_url($_SERVER['REQUEST_URI'] ?? '/', PHP_URL_PATH) === '/__runtime-check') {
    try {
        $kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);
        $kernel->bootstrap();
        $view = $app->make('view');

        header('Content-Type: application/json');
        echo json_encode([
            'bootstrap' => 'ok',
            'view' => get_class($view),
            'view_finder_bound' => $app->bound('view.finder'),
            'view_engine_resolver_bound' => $app->bound('view.engine.resolver'),
            'filesystem_bound' => $app->bound('files'),
            'events_bound' => $app->bound('events'),
            'view_paths_configured' => is_array($app['config']->get('view.paths')),
        ]);
    } catch (Throwable $exception) {
        error_log('Runtime bootstrap failed: '.get_class($exception).': '.$exception->getMessage());
        http_response_code(500);
        header('Content-Type: application/json');
        echo json_encode([
            'error' => get_class($exception),
            'message' => $exception instanceof Illuminate\Contracts\Container\BindingResolutionException
                ? $exception->getMessage()
                : 'Application bootstrap failed.',
        ]);
    }

    return;
}

$app->handleRequest(Illuminate\Http\Request::capture());
