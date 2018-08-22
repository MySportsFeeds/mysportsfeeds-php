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
            case '1.1':
                $apiVersion = new API_v1_1($version, $verbose, $storeType, $storeLocation);
                break;
            case '1.2':
                $apiVersion = new API_v1_2($version, $verbose, $storeType, $storeLocation);
                break;
            case '2.0':
                $apiVersion = new API_v2_0($version, $verbose, $storeType, $storeLocation);
                break;
            default:
                $apiVersion = new BaseApi($version, $verbose, $storeType, $storeLocation);
                break;
        }

        return $apiVersion;
    }
}