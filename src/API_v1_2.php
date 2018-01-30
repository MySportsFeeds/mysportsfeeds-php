<?php

namespace MySportsFeeds;

class API_v1_2 extends BaseApi {
    protected function getBaseUrlForVersion($version)
    {
        return "https://api.mysportsfeeds.com/v1.2/pull";
    }
}
