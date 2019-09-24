<?php
/**
 * Created by PhpStorm.
 * User: betit
 * Date: 15/09/2019
 * Time: 21:53
 */

namespace Betitoglez\Geoip;
use GuzzleHttp\Client;

class IpApi extends AbstractGeoip
{

    private $baseUrl = 'http://ip-api.com/json/';

    private function _getInfo($ipaddress)
    {
        $url = $this->baseUrl . $ipaddress;

        if (config('geoip.cache',TRUE)){
            $resultFromCache = $this->get(base64_encode($url));
            if (!empty($resultFromCache)){
                return $resultFromCache;
            }
        }
        $client = new Client();
        $response = $client->request('GET', $url);

        $result=json_decode($response->getBody());

        if (config('geoip.cache',TRUE)){
            $this->set($url,$result);
        }

        return $result;
    }


    public function getCountry($ipaddress)
    {
        return $this->_getInfo($ipaddress)->country;
    }

    public function getLatLong($ipaddress)
    {
        return [
            'lat' => $this->_getInfo($ipaddress)->lat,
            'long' => $this->_getInfo($ipaddress)->lon,
        ];
    }

    public function getCity($ipaddress)
    {
        return $this->_getInfo($ipaddress)->city;
    }

    public function getInfo($ipaddress)
    {
        return $this->_getInfo($ipaddress);
    }
}