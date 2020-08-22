<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Cache;

class CacheHelper
{

    /**
     * Крипт-функция для данных кеша
     *
     * @param mixed $data
     * @return string
     */
    private static function crypt($data)
    {
        return md5(json_encode($data));
    }

    /**
     * Получение кеша
     *
     * @param string $namespace
     * @param array $data
     * @param callback $function
     * @return mixed
     */
    public static function get($namespace, $data = [], $function = false)
    {

        $prefix = config('constants.cache.prefixes.' . $namespace) . self::crypt($data);
        $time = config('constants.cache.time.' . $namespace);

        if (!$function) {
            $result = Cache::get($prefix);
        } else {
            $result = Cache::remember($prefix, $time, function () use ($prefix, $function, $namespace) {
                $result = call_user_func($function, $namespace);
                return $result;
            });
        }

        return $result;

    }

    /**
     * Метод удаления кеша
     *
     * @param string $namespace
     * @param array $data
     * @param bool $uselanguage
     * @return bool
     */
    public static function clear($namespace, $data = [], $uselanguage = true)
    {
        $prefix = config('constants.cache.prefixes.' . $namespace) . self::crypt($data, $uselanguage);

        Cache::forget($prefix);

        return true;

    }

}
