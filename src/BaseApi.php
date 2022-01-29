<?php

namespace MySportsFeeds;

class BaseApi
{
    protected $auth;

    protected $baseUrl;
    protected $verbose;
    protected $storeType;
    protected $storeLocation;
    protected $storeOutput;
    protected $version;
    protected $validFeeds = [];

    # Constructor
    public function __construct($version, $verbose, $storeType = null, $storeLocation = null) {

        $this->auth = null;
        $this->verbose = $verbose;
        $this->storeType = $storeType;
        $this->storeLocation = $storeLocation;
        $this->version = $version;
        $this->baseUrl = $this->getBaseUrlForVersion($version);
    }

    protected function getBaseUrlForVersion($version)
    {
        return "https://api.mysportsfeeds.com/v{$version}/pull";
    }

    # Verify a feed
    protected function __verifyFeedName($feed) {
        $isValid = false;

        foreach ( $this->validFeeds as $value ) {
            if ( $value == $feed ) {
                $isValid = true;
                break;
            }
        }

        return $isValid;
    }

    # Verify output format
    protected function __verifyFormat($format) {
        $isValid = true;

        if ( $format != "json" and $format != "xml" and $format != "csv" ) {
            $isValid = false;
        }

        return $isValid;
    }

    # Feed URL
    protected function __determineUrl($league, $season, $feed, $outputFormat, ...$kvParams) {
        return $this->baseUrl . "/" . $league . "/" . $season . "/" . $feed . "." . $outputFormat;
    }

    # Generate the appropriate filename for a feed request
    protected function __makeOutputFilename($league, $season, $feed, $outputFormat, ...$kvParams) {

        if ($this->verbose) {
            echo "<br>" . __CLASS__ . "::" . __METHOD__ . "<pre>" . print_r($kvParams, true) . "</pre><br>";
        }

        # create associative array from ... optional params array
        $params = [];
        foreach ( $kvParams as $kvPair ) {
            $pieces = explode("=", $kvPair);
            if (count($pieces) <> 2) {
              throw new \ErrorException("Optional parameter '{$kvPair}' is invalid, must be of form 'xxxx=yyyyyyy'");
            }
            $key = trim($pieces[0]);
            $value = trim($pieces[1]);
            $params[$key] = $value;
        }

        $filename = $feed . "-" . $league . "-" . $season;

        if ( array_key_exists("gameid", $params) ) {
            $filename .= "-" . $params["gameid"];
        }

        if ( array_key_exists("fordate", $params) ) {
            $filename .= "-" . $params["fordate"];
        }

        $filename .= "." . $outputFormat;

        return $filename;
    }

    # Save a feed response based on the store_type
    protected function __saveFeed($response, $league, $season, $feed, $outputFormat, ...$kvParams) {

        if ($this->verbose) {
            echo "<br>" . __CLASS__ . "::" . __METHOD__ . "<pre>" . print_r($kvParams, true) . "</pre><br>";
        }

        # Save to memory regardless of selected method
        if ( $outputFormat == "json" ) {
            $this->storeOutput = (array) json_decode($response);
        } elseif ( $outputFormat == "xml" ) {
            $this->storeOutput = simplexml_load_string($response);
        } elseif ( $outputFormat == "csv" ) {
            $this->storeOutput = $response;
        }

        if ( $this->storeType == "file" ) {
            if ( ! is_dir($this->storeLocation) ) {
                mkdir($this->storeLocation, 0, true);
            }

            $filename = $this->__makeOutputFilename($league, $season, $feed, $outputFormat, ...$kvParams);

            file_put_contents($this->storeLocation . $filename, $response);
        }
    }

    # Indicate this version does support BASIC auth
    public function supportsBasicAuth() {
        return true;
    }

    # Establish BASIC auth credentials
    public function setAuthCredentials($apikey, $password) {
        $this->auth = ['username' => $apikey, 'password' => $password];
    }

    # Request data (and store it if applicable)
    public function getData($league, $season, $feed, $format, ...$kvParams) {

        if ($this->verbose) {
            echo "<br>" . __CLASS__ . "::" . __METHOD__ . "<pre>" . print_r($kvParams, true) . "</pre><br>";
        }

        if ( !$this->auth ) {
            throw new \ErrorException("You must authenticate() before making requests.");
        }

        # create associative array from ... optional params array
        $params = [];
        foreach ( $kvParams as $kvPair ) {
            $pieces = explode("=", $kvPair);
            if (count($pieces) <> 2) {
              throw new \ErrorException("Optional parameter '{$kvPair}' is invalid, must be of form 'xxxx=yyyyyyy'");
            }
            $key = trim($pieces[0]);
            $value = trim($pieces[1]);
            $params[$key] = $value;
        }

        # add force=false parameter (helps prevent unnecessary bandwidth use)
	    # Only adds if storeType == file, else you won't have any data to retrieve.
        if ( ! array_key_exists("force", $params) ) {
	        if ( $this->storeType == "file" ) {
		        $params['force'] = 'false';
	        } else {
		        $params['force'] = 'true';
	        }
        }

        if ( !$this->__verifyFeedName($feed) ) {
            throw new \ErrorException("Unknown feed '" . $feed . "'.  Supported values are: [" . print_r($this->validFeeds, true) . "]");
        }

        if ( !$this->__verifyFormat($format) ) {
            throw new \ErrorException("Unsupported format '" . $format . "'.");
        }

        $url = $this->__determineUrl($league, $season, $feed, $format, ...$kvParams);

        $delim = "?";
        if ( strpos($url, '?') !== false ) {
            $delim = "&";
        }

        # Create &xxx=yyy querystring variables for ALL optional params,
        # to go after the '?' in the URL, even those that __determineUrl() 
        # may have already chosen to put into the URL.
        foreach ( $params as $key => $value ) {
            $url .= $delim . $key . "=" . $value;
            $delim = "&";
        }

        if ( $this->verbose ) {
            print("Making API request to '" . $url . "' ... \n");
        }

        // Establish a curl handle for the request
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_ENCODING, "gzip"); // Enable compression
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); // If you have issues with SSL verification
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            "Authorization: Basic " . base64_encode($this->auth['username'] . ":" . $this->auth['password'])
        ]); // Authenticate using HTTP Basic with account credentials

        // Send the request & retrieve response
        $resp = curl_exec($ch);

        // Uncomment the following if you're having trouble:
        // print(curl_error($ch));

        // Get the response code and then close the curl handle
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        $data = "";

        if ( $httpCode == 200 ) {
	        // Fixes MySportsFeeds/mysportsfeeds-php#1
	        // Remove if storeType == null so data gets stored in memory regardless.
	        $this->__saveFeed($resp, $league, $season, $feed, $format, ...$kvParams);

            $data = $this->storeOutput;
        } elseif ( $httpCode == 304 ) {
            if ( $this->verbose ) {
                print("Data hasn't changed since last call.\n");
            }

            $filename = $this->__makeOutputFilename($league, $season, $feed, $format, ...$kvParams);

            $data = file_get_contents($this->storeLocation . $filename);

            if ( $format == "json" ) {
                $this->storeOutput = (array) json_decode($data);
            } elseif ( $format == "xml" ) {
                $this->storeOutput = simplexml_load_string($data);
            } elseif ( $format == "csv" ) {
                $this->storeOutput = $data;
            }

            $data = $this->storeOutput;
        } else {
            throw new \ErrorException("API call failed with response code: " . $httpCode);
        }

        return $data;
    }

}
