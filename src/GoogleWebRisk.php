<?php

namespace Harrisonratcliffe\LaravelGoogleWebRisk;

class GoogleWebRisk
{
    /**
     * Invokes the Google Web Risk API
     *
     * @param  $url  string
     * @return array JSON
     */
    public static function checkUrl($url)
    {
        $encodedUrl = rawurlencode($url);
        $postUrl = 'https://webrisk.googleapis.com/v1/uris:search?key=' . config('google-web-risk.google.api_key') . "&uri=$encodedUrl";

        $threatTypes = config('google-web-risk.google.threat_types');

        if (!empty($threatTypes) && is_array($threatTypes)) {
            $threatTypesParams = array_map(function ($type) {
                return 'threatTypes=' . urlencode($type);
            }, $threatTypes);

            $threatTypesQuery = implode('&', $threatTypesParams);
            $postUrl .= '&' . $threatTypesQuery;
        }

        $ch = curl_init();
        $timeout = config('google-web-risk.google.timeout');
        curl_setopt($ch, CURLOPT_URL, $postUrl);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Content-Type: application/json',
            'Connection: Keep-Alive',
        ]);

        $data = curl_exec($ch);
        $responseDecoded = json_decode($data, true);
        $responseCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        if ($responseCode !== 200) {
            return ['error' => 'Google Web Risk API Failed', 'details' => $responseDecoded];
        }

        return $responseDecoded;
    }


    /**
     * Checks whether a url is safe or not
     *
     * @param  $url  string
     * @return bool
     */
    public static function isSafe($url)
    {
        $response = self::checkUrl($url);

        if (isset($response['threat']) && isset($response['threat']['threatTypes'])) {
            return false;
        }

        return true;
    }
}
