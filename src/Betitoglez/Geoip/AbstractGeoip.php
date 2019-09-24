<?php
/**
 * Created by PhpStorm.
 * User: betit
 * Date: 15/09/2019
 * Time: 21:50
 */

namespace Betitoglez\Geoip;

use Illuminate\Support\Facades\Cache;

abstract class AbstractGeoip
{

    protected function set ($id,$value,$seconds=172800)
    {
        Cache::put($id,$value,$seconds);
    }

    protected function get($id)
    {
        Cache::has($id)?Cache::get($id):FALSE;
    }


    abstract public function getCountry ($ipaddress);
    abstract public function getLatLong ($ipaddress);
    abstract public function getCity ($ipaddress);
    abstract public function getInfo ($ipaddress);
}