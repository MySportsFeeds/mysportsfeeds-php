<?php

namespace MySportsFeeds;

class ApiFactory
{
    public static function create($version, $verbose, $storeType, $storeLocation)
    {
        $apiVersion = null;
        switch($version) {
            case '1.0':
                $apiVersion = new API_v1_0($version, $verbose, $storeType, $storeLocation);
                break;
            default:
                $apiVersion = new BaseApi($version, $verbose, $storeType, $storeLocation);
                break;
        }

        return $apiVersion;
    }
}