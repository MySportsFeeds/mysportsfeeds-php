# mysportsfeeds-php

MySportsFeeds PHP Wrapper brought to you by [@MySportsFeeds](https://twitter.com/MySportsFeeds).

Makes use of the [MySportsFeeds API](https://www.mysportsfeeds.com) - a flexible, developer-friendly Sports Data API.

Free for Non-Commercial Use.

##Install

Using composer, simply add it to the "require" section of your composer.json:
    
    "require": {
        "mysportsfeeds/mysportsfeeds-php": ">=2.1.0"
    }

If you haven't signed up for API access, do so here [https://www.mysportsfeeds.com/index.php/register/](https://www.mysportsfeeds.com/index.php/register/)

##Usage

Create main MySportsFeeds object with API version as input parameter

For v1.x feed requests (free non-commercial access available):

    use MySportsFeeds\MySportsFeeds;

    $msf = new MySportsFeeds("1.2");

For v2.0 feed requests (donation required for non-commercial access):

    use MySportsFeeds\MySportsFeeds;

    $msf = new MySportsFeeds("2.0");


Authenticate for v1.x (uses your MySportsFeeds account password)

    $msf->authenticate("<YOUR_API_KEY>", "<YOUR_ACCOUNT_PASSWORD>");

Authenticate for v2.0 (simply uses "MYSPORTSFEEDS" as password)

    $msf->authenticate("<YOUR_API_KEY>", "MYSPORTSFEEDS");


Start making requests, specifying in this order: $league, $season, $feed, $format, and any other applicable params for the feed.  See example.php for sample usage.

Example (v1.x): Get all NBA 2016-2017 regular season gamelogs for Stephen Curry, in JSON format

```
    $data = $msf->getData('nba', '2016-2017-regular', 'player_gamelogs', 'json', 'player=stephen-curry');
```

Example (v1.x): Get all NFL 2015-2016 regular season seasonal stats totals for all Dallas Cowboys players, in XML format

```
    $data = $msf->getData('nfl', '2015-2016-regular', 'cumulative_player_stats', 'xml', 'team=dallas-cowboys');
```

Example (v1.x): Get full game schedule for the MLB 2016 playoff season, in CSV format

```
    $data = $msf->getData('mlb', '2016-playoff', 'full_game_schedule', 'csv');
```

Example (v2.0): Get all NBA 2016-2017 regular season gamelogs for Stephen Curry, in JSON format

```
    $data = $msf->getData('nba', '2016-2017-regular', 'seasonal_player_gamelogs', 'json', 'player=stephen-curry');
```

Example (v2.0): Get all NFL 2015 regular season  stats totals for all Dallas Cowboys players, in XML format

```
    $data = $msf->getData('nfl', '2015-regular', 'seasonal_player_stats', 'xml', 'team=dallas-cowboys');
```

Example (v2.0): Get full game schedule and scores for the MLB 2016 playoff season, in CSV format

```
    $data = $msf->getData('mlb', '2016-playoff', 'seasonal_games', 'csv');
```

That's it!  Returned data is also stored locally under "results/" by default, in appropriately named files.
