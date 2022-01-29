<?php

namespace MySportsFeeds;

class API_v1_0 extends BaseApi {

    # Constructor
    public function __construct($version, $verbose, $storeType = null, $storeLocation = null) {

        parent::__construct($version, $verbose, $storeType, $storeLocation);

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

    protected function __determineUrl($league, $season, $feed, $outputFormat, ...$kvParams)
    {
        if ( $feed == 'current_season' ) {
            return $this->baseUrl . "/" . $league . "/" . $feed . "." . $outputFormat;
        } else {
            return $this->baseUrl . "/" . $league . "/" . $season . "/" . $feed . "." . $outputFormat;
        }
    }

}
