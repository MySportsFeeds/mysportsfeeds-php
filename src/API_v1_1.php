<?php

namespace MySportsFeeds;

class API_v1_1 extends BaseApi {
    protected function getBaseUrlForVersion($version)
    {
        return "https://api.mysportsfeeds.com/v1.1/pull";
    }
}
