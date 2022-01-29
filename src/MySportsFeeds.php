<?php

namespace MySportsFeeds;

use MySportsFeeds\API_v1_0;
use MySportsFeeds\API_v1_1;
use MySportsFeeds\API_v1_2;
use MySportsFeeds\API_v2_0;

class MySportsFeeds {

  public $buildVersion = "2.0.0";

  private $version;
  private $verbose;
  private $storeType;
  private $storeLocation;

  private $apiInstance;

  public function __construct($version = "1.2", $verbose = false, $storeType = "file",
                              $storeLocation = "results/") {

    $this->__verifyStore($storeType, $storeLocation);

    $this->version = $version;
    $this->verbose = $verbose;
    $this->storeType = $storeType;
    $this->storeLocation = $storeLocation;
    $this->apiInstance = ApiFactory::create($this->version, $this->verbose, $this->storeType, $this->storeLocation);
  }

  # Verify the type and location of the stored data
  private function __verifyStore($storeType, $storeLocation) {
    if ( $storeType != null and $storeType != "file" ) {
      throw new \ErrorException("Unrecognized storage type specified.  Supported values are: {null,'file'}");
    }

    if ( $storeType == "file" ) {
      if ( $storeLocation == null ) {
        throw new \ErrorException("Must specify a location for stored data.");
      }
    }
  }

  # Authenticate against the API (for v1.x, v2.x)
  public function authenticate($apikey, $password) {
    if ( !$this->apiInstance->supportsBasicAuth() ) {
      throw new \ErrorException("BASIC authentication not supported for version " + $this->version);
    }

    $this->apiInstance->setAuthCredentials($apikey, $password);
  }

  # Request data (and store it if applicable)
  public function getData($league, $season, $feed, $format, ...$kvParams) {

    if ($this->verbose) {
      echo "<br>" . __CLASS__ . "::" . __METHOD__ . "<pre>" . print_r($kvParams, true) . "</pre><br>";
    }

    return $this->apiInstance->getData($league, $season, $feed, $format, ...$kvParams);
  }

}
