<?php

namespace MySportsFeeds;

class API_v2_0 extends API_v1_2 {

    # Constructor
    public function __construct($version, $verbose, $storeType = null, $storeLocation = null) {

		parent::__construct();

        $this->validFeeds = [
	  		'seasonal_games',
		    'daily_games',
		    'weekly_games',
		    'seasonal_dfs',
		    'daily_dfs',
		    'weekly_dfs',
		    'seasonal_player_gamelogs',
		    'daily_player_gamelogs',
		    'weekly_player_gamelogs',
		    'seasonal_team_gamelogs',
		    'daily_team_gamelogs',
		    'weekly_team_gamelogs',
		    'game_boxscore',
		    'game_playbyplay',
		    'game_lineup',
		    'current_season',
		    'player_injuries',
		    'latest_updates',
		    'seasonal_team_stats',
		    'seasonal_player_stats',
		    'seasonal_venues',
		    'players',
		    'seasonal_standings'
        ];
    }

    protected function __determineUrl($league, $season, $feed, $outputFormat, $params)
    {
        if ( $feed == 'seasonal_games' ) {
	        if ( !$season ) {
	            throw new \ErrorException("You must specify a season for this request.");
	        }

            return $this->baseUrl . "/" . $league . "/" . $season . "/games." . $outputFormat;

        } else if ( $feed == 'daily_games' ) {
	        if ( !$season ) {
	            throw new \ErrorException("You must specify a season for this request.");
	        }
	        if ( !array_key_exists($params, "date") ) {
	            throw new \ErrorException("You must specify a 'date' param for this request.");
	        }

            return $this->baseUrl . "/" . $league . "/" . $season . "/date/" . $params["date"] . "/games." . $outputFormat;

        } else if ( $feed == 'weekly_games' ) {
	        if ( !$season ) {
	            throw new \ErrorException("You must specify a season for this request.");
	        }
	        if ( !array_key_exists($params, "week") ) {
	            throw new \ErrorException("You must specify a 'week' param for this request.");
	        }

            return $this->baseUrl . "/" . $league . "/" . $season . "/week/" . $params["week"] . "/games." . $outputFormat;

        } else if ( $feed == 'seasonal_dfs' ) {
	        if ( !$season ) {
	            throw new \ErrorException("You must specify a season for this request.");
	        }

            return $this->baseUrl . "/" . $league . "/" . $season . "/dfs." . $outputFormat;

        } else if ( $feed == 'daily_dfs' ) {
	        if ( !$season ) {
	            throw new \ErrorException("You must specify a season for this request.");
	        }
	        if ( !array_key_exists($params, "date") ) {
	            throw new \ErrorException("You must specify a 'date' param for this request.");
	        }

            return $this->baseUrl . "/" . $league . "/" . $season . "/date/" . $params["date"] . "/dfs." . $outputFormat;

        } else if ( $feed == 'weekly_dfs' ) {
	        if ( !$season ) {
	            throw new \ErrorException("You must specify a season for this request.");
	        }
	        if ( !array_key_exists($params, "week") ) {
	            throw new \ErrorException("You must specify a 'week' param for this request.");
	        }

            return $this->baseUrl . "/" . $league . "/" . $season . "/week/" . $params["week"] . "/dfs." . $outputFormat;

        } else if ( $feed == 'seasonal_player_gamelogs' ) {
	        if ( !$season ) {
	            throw new \ErrorException("You must specify a season for this request.");
	        }

            return $this->baseUrl . "/" . $league . "/" . $season . "/player_gamelogs." . $outputFormat;

        } else if ( $feed == 'daily_player_gamelogs' ) {
	        if ( !$season ) {
	            throw new \ErrorException("You must specify a season for this request.");
	        }
	        if ( !array_key_exists($params, "date") ) {
	            throw new \ErrorException("You must specify a 'date' param for this request.");
	        }

            return $this->baseUrl . "/" . $league . "/" . $season . "/date/" . $params["date"] . "/player_gamelogs." . $outputFormat;

        } else if ( $feed == 'weekly_player_gamelogs' ) {
	        if ( !$season ) {
	            throw new \ErrorException("You must specify a season for this request.");
	        }
	        if ( !array_key_exists($params, "week") ) {
	            throw new \ErrorException("You must specify a 'week' param for this request.");
	        }

            return $this->baseUrl . "/" . $league . "/" . $season . "/week/" . $params["week"] . "/player_gamelogs." . $outputFormat;

        } else if ( $feed == 'seasonal_team_gamelogs' ) {
	        if ( !$season ) {
	            throw new \ErrorException("You must specify a season for this request.");
	        }

            return $this->baseUrl . "/" . $league . "/" . $season . "/team_gamelogs." . $outputFormat;

        } else if ( $feed == 'daily_team_gamelogs' ) {
	        if ( !$season ) {
	            throw new \ErrorException("You must specify a season for this request.");
	        }
	        if ( !array_key_exists($params, "date") ) {
	            throw new \ErrorException("You must specify a 'date' param for this request.");
	        }

            return $this->baseUrl . "/" . $league . "/" . $season . "/date/" . $params["date"] . "/team_gamelogs." . $outputFormat;

        } else if ( $feed == 'weekly_team_gamelogs' ) {
	        if ( !$season ) {
	            throw new \ErrorException("You must specify a season for this request.");
	        }
	        if ( !array_key_exists($params, "week") ) {
	            throw new \ErrorException("You must specify a 'week' param for this request.");
	        }

            return $this->baseUrl . "/" . $league . "/" . $season . "/week/" . $params["week"] . "/team_gamelogs." . $outputFormat;

        } else if ( $feed == 'game_boxscore' ) {
	        if ( !$season ) {
	            throw new \ErrorException("You must specify a season for this request.");
	        }
	        if ( !array_key_exists($params, "game") ) {
	            throw new \ErrorException("You must specify a 'game' param for this request.");
	        }

            return $this->baseUrl . "/" . $league . "/" . $season . "/games/" . $params["game"] . "/boxscore." . $outputFormat;

        } else if ( $feed == 'game_playbyplay' ) {
	        if ( !$season ) {
	            throw new \ErrorException("You must specify a season for this request.");
	        }
	        if ( !array_key_exists($params, "game") ) {
	            throw new \ErrorException("You must specify a 'game' param for this request.");
	        }

            return $this->baseUrl . "/" . $league . "/" . $season . "/games/" . $params["game"] . "/playbyplay." . $outputFormat;

        } else if ( $feed == 'game_lineup' ) {
	        if ( !$season ) {
	            throw new \ErrorException("You must specify a season for this request.");
	        }
	        if ( !array_key_exists($params, "game") ) {
	            throw new \ErrorException("You must specify a 'game' param for this request.");
	        }

            return $this->baseUrl . "/" . $league . "/" . $season . "/games/" . $params["game"] . "/lineup." . $outputFormat;

        } else if ( $feed == 'current_season' ) {

            return $this->baseUrl . "/" . $league . "/current_season." . $outputFormat;

        } else if ( $feed == 'latest_updates' ) {
	        if ( !$season ) {
	            throw new \ErrorException("You must specify a season for this request.");
	        }

            return $this->baseUrl . "/" . $league . "/" . $season . "/latest_updates." . $outputFormat;

        } else if ( $feed == 'seasonal_team_stats' ) {
	        if ( !$season ) {
	            throw new \ErrorException("You must specify a season for this request.");
	        }

            return $this->baseUrl . "/" . $league . "/" . $season . "/team_stats_totals." . $outputFormat;

        } else if ( $feed == 'seasonal_player_stats' ) {
	        if ( !$season ) {
	            throw new \ErrorException("You must specify a season for this request.");
	        }

            return $this->baseUrl . "/" . $league . "/" . $season . "/player_stats_totals." . $outputFormat;

        } else if ( $feed == 'seasonal_venues' ) {
	        if ( !$season ) {
	            throw new \ErrorException("You must specify a season for this request.");
	        }

            return $this->baseUrl . "/" . $league . "/" . $season . "/venues." . $outputFormat;

        } else if ( $feed == 'seasonal_standings' ) {
	        if ( !$season ) {
	            throw new \ErrorException("You must specify a season for this request.");
	        }

            return $this->baseUrl . "/" . $league . "/" . $season . "/standings." . $outputFormat;

        } else {
            throw new \ErrorException("Unrecognized feed '" . $feed . "'.");
        }

    }

}
