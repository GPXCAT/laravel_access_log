# gpxcat's laravel_access_log

Add the routeMiddleware to your `app/Http/Kernel.php` file:

```
    protected $routeMiddleware = [
        ...
        'accesslog.handle' => \Gpxcat\LaravelAccessLog\Http\Middleware\AccessLogHandle::class,
        ...
    ];

```

Add the middleware to your `routes/web.php` or `routes/api.php` file:

```

Route::group([
    'prefix' => 'XXXX',
    'middleware' => [
        'accesslog.handle',
    ],
], function () {
    ...
});

```
