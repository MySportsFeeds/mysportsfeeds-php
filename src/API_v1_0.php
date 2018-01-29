<?php

namespace MySportsFeeds;

class API_v1_0 extends BaseApi {
    protected function getBaseUrlForVersion($version)
    {
        return "https://www.mysportsfeeds.com/api/feed/pull";
    }
}
