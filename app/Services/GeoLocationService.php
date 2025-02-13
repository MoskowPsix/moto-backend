<?php

namespace App\Services;

use Exception;
use GuzzleHttp\Client;

class GeoLocationService
{
    private string $url = 'https://mdss.fppd.cgkipd.ru/api/v1/dictionary/';

    private string $path = 'database/csvs/city.csv';

    public function getRegion()
    {
        $url = $this->urlBuild('Region');
        return $this->request($url);
    }

    private function request(string $url, array $params = [], string $method = 'GET'): mixed
     {
         $ch = curl_init();
         curl_setopt($ch, CURLOPT_HEADER, 0);
         curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); // Return data inplace of echoing on screen
         curl_setopt($ch, CURLOPT_URL, $url);
         curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0); // Skip SSL Verification
         curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $method);
         curl_setopt( $ch, CURLOPT_POSTFIELDS, $params );


         $rsData = curl_exec($ch);
         curl_close($ch);
         return json_decode($rsData);
     }

     private function urlBuild(string $url): string
     {
         return $this->url. $url;
     }

     public function getCsv():array
     {
         if (($open = fopen($this->path, "r")) !== false) {
             $i = 0;
             while ((($data = fgetcsv($open, 0, ",")) !== false)) {
                 $size = count($data);
                 if($i === 0) {
                     $keys = $data;
                 } else {
                     foreach ($keys as $k => $key) {
                         $data[$key] = $data[$k];
                     }
                     array_splice($data, 0, $size);
                     $array[] = (object)$data;
                 }
                 $i++;
             }

             fclose($open);
         }
         return $array;
     }
}
