<?php
/**
 * Created by PhpStorm.
 * User: souzajbr
 * Date: 03/07/18
 * Time: 18:09
 */

namespace App\Interop\Fullteaching;

use App\Interop\ClientInterface;
use App\User;
use RestClient;

class FullteachingClient implements ClientInterface
{
    private static $httpClient = null;

    /**
     * @return RestClient
     */
    private static function getHttpClient()
    {
        return self::$httpClient ? self::$httpClient :
            self::$httpClient = new RestClient([
                'base_url' => 'https://localhost:5000',
                'format' => 'json',
                'curl_options' => [
                    CURLOPT_SSL_VERIFYPEER => 0,
                    CURLOPT_SSL_VERIFYHOST => 0
                ]
            ]);
    }

    protected static function getRoleId($role) {
        return [
            'ROLE_TEACHER' => 1,
            'ROLE_STUDENT' => 2
        ][$role];
    }

    /**
     * @param $username
     * @param $password
     * @return null
     */
    public static function login($username, $password)
    {

        $data = self::getHttpClient()->get('api-logIn', [], [
            'Authorization' => 'Basic ' . base64_encode("{$username}:{$password}")
        ]);

        if ($data->info->http_code != 200)
            return null;

        $user_data = json_decode($data->response);

        $user = User::firstOrCreate([
            'provider' => 'fullteaching',
            'external_id' => $user_data->id
        ]);

        //Se tem que atualizar a sessão, então atualiza os dados do usuário
        if ($data->headers->set_cookie) {
            $cookie = explode(';', explode('=', $data->headers->set_cookie)[1])[0];

            $user->external_token = $cookie;
            $user->email = $user_data->name;
            $user->name = $user_data->nickName;

            foreach($user_data->roles as $role) {
                $user->attachRole([self::getRoleId($role)]);
            }

            $user->save();
        }

        return $user;

    }

    public static function getUserCourses(User $user) {
        $data = self::getHttpClient()->get('api-courses/user/'.$user->external_id, [],
            [
                'Cookie' => 'JSESSIONID='.$user->external_token
            ]);

        if($data->info->http_code != 200)
            return null;

        return json_decode($data->response);

    }

    public static function getCourseInfo($token, $courseId) {
        $data = self::getHttpClient()->get('api-courses/course/'.$courseId, [],
            [
                'Cookie' => 'JSESSIONID='.$token
            ]);

        if($data->info->http_code != 200)
            return null;

        return json_decode($data->response);
    }
}