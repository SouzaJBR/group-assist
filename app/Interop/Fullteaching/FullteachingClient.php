<?php
/**
 * Created by PhpStorm.
 * User: souzajbr
 * Date: 03/07/18
 * Time: 18:09
 */

namespace App\Interop\Fullteaching;

use App\Interop\Fullteaching\Helper\Cookie;
use App\User;
use RestClient;

class FullteachingClient
{
    private static $httpClient;

    public function __construct()
    {
        FullteachingClient::$httpClient = new RestClient([
            'base_url' => 'https://localhost:5000',
            'format' => 'json',
            'curl_options' => [
                CURLOPT_SSL_VERIFYPEER => 0,
                CURLOPT_SSL_VERIFYHOST => 0
            ]
        ]);
    }

    /**
     * @param $username
     * @param $password
     * @return null
     */
    public static function login($username, $password)
    {

        $data = FullteachingClient::$httpClient->get('api-logIn', [], [
            'Authorization' => 'Basic ' . base64_encode($username . ':' . $password)
        ]);

        if ($data->info->http_code != 200)
            return null;

        $user_data = json_decode($data->response);

        $user = User::firstOrCreate([
                'provider' => 'fullteaching',
                'external_id' => $user_data->id
        ]);

        if($data->headers->set_cookie)
        {
            $raw_cookie = $data->headers->set_cookie;
            $cookie = explode('=', $raw_cookie)[1];
            $cookie = explode(';', $cookie)[0];

            $user->external_token = $cookie;
        }

        $user->email = $user_data->name;
        $user->name = $user_data->nickName;

        return $user;

    }
}