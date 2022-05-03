<?php

namespace Gpxcat\LaravelAccessLog\Http\Middleware;

use Auth;
use Closure;
use Gpxcat\LaravelAccessLog\Models\AccessLog;
use Illuminate\Http\Request;
use Log;

class AccessLogHandle
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if (filter_var(env('ACCESS_LOG', 0), FILTER_VALIDATE_BOOLEAN)) {
            $skipMethod = collect(explode(',', env('ACCESS_LOG_SKIP_METHOD', '')))->map(function ($item) {
                return trim($item);
            })->toArray();

            $guards = [];
            collect(config('auth.guards'))->each(function ($value, $key) use (&$guards) {
                $auth = auth()->guard($key)->user() ? Auth::guard($key)->user() : null;
                if ($auth) {
                    $guards[$key] = [$auth->getKeyName() => $auth->{$auth->getKeyName()}]; // $auth->{($value['log_show_column'] ?? $auth->getKeyName())};
                    if (isset($value['log_show_column'])) {
                        $guards[$key][$value['log_show_column']] = $auth->{$value['log_show_column']};
                    }
                }
            });

            if (!in_array($request->method(), $skipMethod)) {
                $data = [
                    'guards' => $guards,
                    'method' => $request->method(),
                    'url' => $request->url(),
                    'referer' => $request->header()['referer'] ?? null,
                    'user_agent' => $request->userAgent() ?? '',
                    'input' => $request->input(),
                    'ip' => $request->ip(),
                ];
                Log::info('ACCESSLOG - ' . json_encode($data, JSON_UNESCAPED_UNICODE));

                $data['input'] = $this->removeBase64Data($data['input']);
                $data['input'] = $this->removePasswordData($data['input']);
                try {
                    $accessLogRow = AccessLog::create($data);
                } catch (\Illuminate\Database\QueryException $ex) {
                    Log::error('ACCESSLOG - 無法寫入DB - ' . $ex->getMessage());
                }
            }
        }

        return $next($request);
    }

    /**
     * 將Log中的Base64的資料移除，以節省空間
     * @param array
     * @return array
     */
    public function removeBase64Data($ary)
    {
        foreach ($ary as $key => $val) {
            if (is_array($val)) {
                $ary[$key] = $this->removeBase64Data($ary[$key]);
            } else {
                if (is_string($val) && preg_match('/data:image\/[a-zA-Z]*;base64,/', $val)) {
                    $ary[$key] = '[BASE64-IMAGE-DATA]';
                }
            }
        }
        return $ary;
    }

    /**
     * 將Log中的password移除
     * @param array
     * @return array
     */
    public function removePasswordData($ary)
    {
        foreach ($ary as $key => $val) {
            if (is_array($val)) {
                $ary[$key] = $this->removePasswordData($ary[$key]);
            } else {
                if (is_string($key) && preg_match('/password/', $key) && strlen($val) > 0) {
                    $ary[$key] = '*';
                }
            }
        }
        return $ary;
    }
}
