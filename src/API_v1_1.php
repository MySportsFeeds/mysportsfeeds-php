<?php

namespace MySportsFeeds;

class API_v1_1 extends API_v1_0 {

    # Constructor
    public function __construct($version, $verbose, $storeType = null, $storeLocation = null) {

        parent::__construct($version, $verbose, $storeType, $storeLocation);
    }
}
