<?php

namespace MySportsFeeds;

use MySportsFeeds\API_v1_0;

class MySportsFeeds {

  public $buildVersion = "0.1.0";

  private $version;
  private $verbose;
  private $storeType;
  private $storeLocation;

  private $apiInstance;

  public function __construct($version = "1.0", $verbose = false, $storeType = "file",
                              $storeLocation = "results/") {

    $this->__verifyVersion($version);
    $this->__verifyStore($storeType, $storeLocation);

    $this->version = $version;
    $this->verbose = $verbose;
    $this->storeType = $storeType;
    $this->storeLocation = $storeLocation;

    # Instantiate an instance of the appropriate API depending on version
    if ( $this->version == "1.0" ) {
      $this->apiInstance = new API_v1_0($this->verbose, $this->storeType, $this->storeLocation);
    }
  }

  # Make sure the version is supported
  private function __verifyVersion($version) {
    if ( $version != "1.0" ) {
      throw new ErrorException("Unrecognized version specified.  Supported versions are: '1.0'");
    }
  }

  # Verify the type and location of the stored data
  private function __verifyStore($storeType, $storeLocation) {
    if ( $storeType != null and $storeType != "file" ) {
      throw new ErrorException("Unrecognized storage type specified.  Supported values are: {null,'file'}");
    }

    if ( $storeType == "file" ) {
      if ( $storeLocation == null ) {
        throw new ErrorException("Must specify a location for stored data.");
      }
    }
  }

  # Authenticate against the API (for v1.0)
  public function authenticate($username, $password) {
    if ( !$this->apiInstance->supportsBasicAuth() ) {
      throw new ErrorException("BASIC authentication not supported for version " + $this->version);
    }

    $this->apiInstance->setAuthCredentials($username, $password);
  }

  # Request data (and store it if applicable)
  public function getData($league, $season, $feed, $format, ...$params) {
    return $this->apiInstance->getData($league, $season, $feed, $format, $params);
  }

}
