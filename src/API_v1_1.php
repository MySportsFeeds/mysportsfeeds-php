<?php

namespace MySportsFeeds;

class API_v1_1 extends BaseApi
{
    # Constructor
    public function __construct($verbose, $storeType = null, $storeLocation = null) {

        $this->baseUrl = "https://api.mysportsfeeds.com/v1.1/pull";

        /**
         * I am not sure if these changed for v1.1
         */
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

        parent::__construct($verbose, $storeType, $storeLocation);
    }

}