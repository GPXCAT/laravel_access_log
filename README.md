# gpxcat's laravel_access_log

migrate:

```
php artisan migrate
```

Add the environment variable to your `.env` file:

```
# 是否記錄(總開關)
ACCESS_LOG=1

# 設定不要記錄的ACCESSLOG用逗號 ex GET,HEAD
ACCESS_LOG_SKIP_METHOD=GET
```

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
