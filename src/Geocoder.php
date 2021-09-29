<?php

namespace JMac\TestingStrategies;

class Geocoder
{
    public function fetchLocation(string $ip): array
    {
        $curl = curl_init();

        curl_setopt_array($curl, [
            CURLOPT_URL => 'https://freegeoip.app/json/' . $ip,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'GET',
            CURLOPT_HTTPHEADER => [
                'accept: application/json',
                'content-type: application/json',
            ],
        ]);

        $response = curl_exec($curl);
        $status = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        $err = curl_error($curl);
        curl_close($curl);

        if ($err) {
            throw new \RuntimeException('Geocoder failed: ' . $err);
        }

        if ($status !== 200) {
            return [];
        }

        return json_decode($response, true) ?? [];
    }
}
