<?php

class API_v1_0 {

  private $baseUrl;
  private $headers;
  private $verbose;
  private $storeType;
  private $storeLocation;
  private $validFeeds;

  # Constructor
  public function __construct($verbose, $toreType=null, $storeLocation=null) {
    $this->baseUrl = "https://www.mysportsfeeds.com/api/feed/pull";

    $this->headers = {
        'Accept-Encoding': 'gzip',
        'User-Agent': 'MySportsFeeds PHP/' . MySportsFeeds->buildVersion . '(' . php_uname() . ')')
    };

    $this->verbose = $verbose
    $this->storeType = $storeType
    $this->storeLocation = $storeLocation

    $this->validFeeds = [
        'current_season',
        'cumulative_player_stats',
        'full_game_schedule',
        'daily_game_schedule',
        'daily_player_stats',
        'game_playbyplay',
        'game_boxscore',
        'scoreboard',
        'player_gamelogs',
        'team_gamelogs',
        'roster_players',
        'game_startinglineup',
        'active_players',
        'player_injuries',
        'latest_updates',
        'daily_dfs'
    ];
  }

  # Verify a feed
  private function __verifyFeedName($feed) {
    $isValid = false;

    for ( $value in $this->validFeeds ) {
      if ( $value == $feed ) {
        $isValid = true;
        break;
      }
    }

    return $isValid;
  }

  # Verify output format
  private function __verifyFormat($format) {
    $isValid = true;

    if ( $format != "json" and $format != "xml" and $format != "csv" ) {
      $isValid = false;
    }

    return $isValid;
  }

  # Feed URL (with only a league specified)
  private function __leagueOnlyUrl($league, $feed, $outputFormat, ...$params) {
    return $this->baseUrl . "/" . $league . "/" . $feed . "." . $outputFormat;
  }

  # Feed URL (with league + season specified)
  private function __leagueAndSeasonUrl($league, $season, $feed, $outputFormat, ...$params) {
    return $this->baseUrl . "/" . $league . "/" . $season . "/" . $feed . "." . $outputFormat;
  }

  # Generate the appropriate filename for a feed request
  private function __makeOutputFilename($league, $season, $feed, $outputFormat, ...$params) {
    $filename = $feed . "-" . $league . "-" . $season;

    if ( "gameid" in $params ) {
      $filename .= "-" + $params["gameid"];
    }

    if ( "fordate" in $params ) {
      $filename .= "-" + $params["fordate"];
    }

    $filename .= "." + $outputFormat;

    return filename;
  }

  # Save a feed response based on the store_type
  private function __saveFeed($response, $league, $season, $feed, $outputFormat, ...$params) {
    # Save to memory regardless of selected method
    if ( $output_format == "json" ) {
      $storeOutput = $response.json();
    } elseif ( $outputFormat == "xml" ) {
      $storeOutput = $response.text;
    } elseif ( $outputFormat == "csv" ) {
      #store_output = response.content.split('\n')
      $storeOutput = $response.content.decode('utf-8');
      $storeOutput = csv.reader(store_output.splitlines(), delimiter=',');
      $storeOutput = list($storeOutput);
    }

    if ( $this->storeType == "file" ) {
      if ( ! os.path.isdir($this->storeLocation) ) {
        os.mkdir($this->storeLocation);
      }

      $filename = $this->__makeOutputFilename($league, $season, $feed, $outputFormat, $params);

      // with open(self.store_location + filename, "w") as outfile {
      //   if output_format == "json":  # This is JSON
      //     json.dump(store_output, outfile)
      //   elif output_format == "xml":  # This is xml
      //     outfile.write(store_output)
      //   elif output_format == "csv":  # This is csv
      //     writer = csv.writer(outfile)
      //     for row in store_output:
      //       writer.writerow([row])
      //   else:
      //     raise AssertionError("Could not interpret feed output format")
      // }
    }
  }

  # Indicate this version does support BASIC auth
  public function supportsBasicAuth() {
    return true;
  }

  # Establish BASIC auth credentials
  public function setAuthCredentials($username, $password):
    $this->auth = ($username, $password);
    $this->headers['Authorization'] = 'Basic ' + base64.b64encode('{}:{}'.format(username,password).encode('utf-8')).decode('ascii');
  }

  # Request data (and store it if applicable)
  public function getData($league = "", $season = "", $feed = "", $format = "", ...$params) {
    if ( !$this->auth ) {
      raise AssertionError("You must authenticate() before making requests.");
    }

    # iterate over args and assign vars
    for ( $key, $value in $params ) {
      if ( str($key) == 'league' ) {
        $league = $value;
      } elseif ( str($key) == 'season' ) {
        $season = $value;
      } elseif ( str($key) == 'feed' ) {
        $feed = $value;
      } elseif ( str($key) == 'format' ) {
        $format = value;
      } else {
        $params[$key] = value;
      }

      # add force=false parameter (helps prevent unnecessary bandwidth use)
      if ( ! "force" in $params ) {
        $params['force'] = 'false';
      }

      if ( !$this->__verifyFeedName($feed) ) {
        raise ValueError("Unknown feed '" + $feed + "'.");
      }

      if ( !$this->__verifyFormat($format) ) {
        raise ValueError("Unsupported format '" + $format + "'.");
      }

      if ( $feed == 'current_season' ) {
        $url = $this->__leagueOnlyUrl($league, $feed, $format, $params);
      } else {
        $url = $this->__leagueAndSeasonUrl($league, $season, $feed, $format, $params);
      }

      if ( $this->verbose ) {
        print("Making API request to '" . $url . "'.");
        print("  with headers:");
        print($this->headers);
        print(" and params:");
        print($params);
      }

      $r = requests.get($url, params=$params, headers=$this->headers);

      if ( $r.status_code == 200 ) {
        if ( $this->storeType != null ) {
          $this->__saveFeed($r, $league, $season, $feed, $format, $params);
        }

        $data = "";

        if ( $format == "json" ) {
          $data = json.loads(r.content);
        } elseif ( $format == "xml" ) {
          $data = str(r.content);
        } else {
          $data = r.content.splitlines();
        }
      } elseif ( r.status_code == 304 ) {
        if ( $this->verbose ) {
          print("Data hasn't changed since last call");
        }

        $filename = $this->__makeOutputFilename($league, $season, $feed, $format, $params);

        // with open(self.store_location + filename) as f:
        //   if output_format == "json":
        //       data = json.load(f)
        //   elif output_format == "xml":
        //       data = str(f.readlines()[0])
        //   else:
        //       data = f.read().splitlines()
      } else {
        raise Warning("API call failed with error: " . r.status_code);
      }

      return $data;
  }

}
