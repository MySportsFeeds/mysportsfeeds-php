<?php

namespace MySportsFeeds;

class ApiFactory
{
    public static function create($version, $verbose, $storeType, $storeLocation)
    {
        $apiVersion = null;
        switch($version) {
            case '1.0':
                $apiVersion = new API_v1_0($verbose, $storeType, $storeLocation);
                break;
            case '1.1':
                $apiVersion = new API_v1_1($verbose, $storeType, $storeLocation);
                break;
            default:
                throw new \ErrorException("Unrecognized version specified.  Supported versions are: '1.0, 1.1'");
        }

        return $apiVersion;
    }
}