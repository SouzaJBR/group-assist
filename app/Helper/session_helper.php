<?php
/**
 * Created by PhpStorm.
 * User: souzajbr
 * Date: 04/07/18
 * Time: 20:34
 * @param null $key
 * @param null $value
 * @return \Illuminate\Foundation\Application|mixed
 */

function user_temp($key = null, $value = null)
{
    $store = app('user.storage.temp');

    if (is_null($key)) {
        return $store;
    }

    if (!is_null($value)) {
        return $store->put($key, $value);
    }

    return $store->get($key);
}