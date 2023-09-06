<?php

namespace App\Services;

class CdnService
{
    private static $cdn_url;
    private static $cdn_secret;

    public function __construct()
    {
        self::$cdn_url = env('API_CDN');
        self::$cdn_secret = env('APP_SECRET_CDN');
    }

    public function sendPhotoToCdn($image, $path)
    {

        $img = file_get_contents($image);
        $data_img = ['path' => $path, 'img' => base64_encode($img)];

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, self::$cdn_url . self::$cdn_secret);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data_img);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

        $response = curl_exec($ch);
        $response = json_decode($response);
        $link = $response->url ?? false;
        curl_close($ch);

        return $link;
    }

    public function cdn_path($path = '')
    {
        return env('API_CDN') . env('IMAGES_PATH') . '/' . $path ?? '';
    }
}
