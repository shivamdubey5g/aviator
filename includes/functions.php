<?php

/**
 * Make API call to Cricbuzz API with error handling
 */
function makeApiCall($endpoint) {
    $url = API_BASE_URL . $endpoint;
    
    $curl = curl_init();
    curl_setopt_array($curl, [
        CURLOPT_URL => $url,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 30,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "GET",
        CURLOPT_HTTPHEADER => [
            "x-rapidapi-host: " . RAPIDAPI_HOST,
            "x-rapidapi-key: " . RAPIDAPI_KEY
        ],
    ]);
    
    $response = curl_exec($curl);
    $httpCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
    $err = curl_error($curl);
    curl_close($curl);
    
    // Debug: Log API response
    error_log("API Call: $url");
    error_log("HTTP Code: $httpCode");
    error_log("Response: " . substr($response, 0, 200));
    
    if ($err) {
        error_log("cURL Error: $err");
        return false;
    }
    
    $data = json_decode($response, true);
    
    // Check if API returned an error
    if (isset($data['message']) && strpos($data['message'], 'not subscribed') !== false) {
        error_log("API Subscription Error: " . $data['message']);
        return false;
    }
    
    return $data;
}

/**
 * Get cached data or make fresh API call with fallback
 */
function getCachedData($cacheKey, $endpoint, $fallbackData = null) {
    $cacheFile = 'data/cache_' . md5($cacheKey) . '.json';
    
    // Check if cache exists and is still valid
    if (file_exists($cacheFile) && (time() - filemtime($cacheFile)) < CACHE_DURATION) {
        return json_decode(file_get_contents($cacheFile), true);
    }
    
    // Make fresh API call
    $data = makeApiCall($endpoint);
    
    if ($data && !isset($data['message'])) {
        // Save to cache if data is valid
        if (!is_dir('data')) {
            mkdir('data', 0777, true);
        }
        file_put_contents($cacheFile, json_encode($data));
        return $data;
    } else {
        // API failed, return fallback data or cached data if available
        if (file_exists($cacheFile)) {
            // Return old cached data
            return json_decode(file_get_contents($cacheFile), true);
        } elseif ($fallbackData) {
            // Return mock data
            return $fallbackData;
        }
        return false;
    }
}

/**
 * Get recent matches with fallback data
 */
function getRecentMatches() {
    $fallbackData = [
        'typeMatches' => [
            [
                'matchType' => 'International',
                'seriesMatches' => [
                    [
                        'seriesAdWrapper' => [
                            'seriesName' => 'India vs Australia Test Series 2023',
                            'matches' => [
                                [
                                    'matchInfo' => [
                                        'matchId' => 1,
                                        'team1' => ['teamName' => 'India', 'teamSName' => 'IND'],
                                        'team2' => ['teamName' => 'Australia', 'teamSName' => 'AUS'],
                                        'matchFormat' => 'TEST',
                                        'status' => 'India won by 6 wickets',
                                        'venueInfo' => ['ground' => 'Melbourne Cricket Ground', 'city' => 'Melbourne'],
                                        'startDate' => time() * 1000 - 86400000 // Yesterday
                                    ],
                                    'matchScore' => [
                                        'team1Score' => [
                                            'inngs1' => ['runs' => 326, 'wickets' => 10, 'overs' => '87.3']
                                        ],
                                        'team2Score' => [
                                            'inngs1' => ['runs' => 267, 'wickets' => 10, 'overs' => '72.1']
                                        ]
                                    ]
                                ],
                                [
                                    'matchInfo' => [
                                        'matchId' => 2,
                                        'team1' => ['teamName' => 'England', 'teamSName' => 'ENG'],
                                        'team2' => ['teamName' => 'Pakistan', 'teamSName' => 'PAK'],
                                        'matchFormat' => 'ODI',
                                        'status' => 'England won by 3 wickets',
                                        'venueInfo' => ['ground' => 'Lords', 'city' => 'London'],
                                        'startDate' => time() * 1000 - 172800000 // 2 days ago
                                    ],
                                    'matchScore' => [
                                        'team1Score' => [
                                            'inngs1' => ['runs' => 285, 'wickets' => 7, 'overs' => '50.0']
                                        ],
                                        'team2Score' => [
                                            'inngs1' => ['runs' => 284, 'wickets' => 10, 'overs' => '49.2']
                                        ]
                                    ]
                                ]
                            ]
                        ]
                    ]
                ]
            ]
        ]
    ];
    
    return getCachedData('recent_matches', '/matches/v1/recent', $fallbackData);
}

/**
 * Get live matches with fallback data
 */
function getLiveMatches() {
    $fallbackData = [
        'typeMatches' => [
            [
                'matchType' => 'International',
                'seriesMatches' => [
                    [
                        'seriesAdWrapper' => [
                            'seriesName' => 'ICC World Cup 2023',
                            'matches' => [
                                [
                                    'matchInfo' => [
                                        'matchId' => 3,
                                        'team1' => ['teamName' => 'India', 'teamSName' => 'IND'],
                                        'team2' => ['teamName' => 'South Africa', 'teamSName' => 'SA'],
                                        'matchFormat' => 'ODI',
                                        'status' => 'Live - India batting',
                                        'venueInfo' => ['ground' => 'Wankhede Stadium', 'city' => 'Mumbai'],
                                        'startDate' => time() * 1000
                                    ],
                                    'matchScore' => [
                                        'team1Score' => [
                                            'inngs1' => ['runs' => 156, 'wickets' => 3, 'overs' => '28.4']
                                        ],
                                        'team2Score' => [
                                            'inngs1' => ['runs' => 248, 'wickets' => 10, 'overs' => '47.3']
                                        ]
                                    ]
                                ]
                            ]
                        ]
                    ]
                ]
            ]
        ]
    ];
    
    return getCachedData('live_matches', '/matches/v1/live', $fallbackData);
}

/**
 * Get upcoming matches with fallback data
 */
function getUpcomingMatches() {
    $fallbackData = [
        'typeMatches' => [
            [
                'matchType' => 'International',
                'seriesMatches' => [
                    [
                        'seriesAdWrapper' => [
                            'seriesName' => 'India vs New Zealand T20I Series 2024',
                            'matches' => [
                                [
                                    'matchInfo' => [
                                        'matchId' => 4,
                                        'team1' => ['teamName' => 'India', 'teamSName' => 'IND'],
                                        'team2' => ['teamName' => 'New Zealand', 'teamSName' => 'NZ'],
                                        'matchFormat' => 'T20I',
                                        'status' => 'Upcoming',
                                        'venueInfo' => ['ground' => 'Eden Gardens', 'city' => 'Kolkata'],
                                        'startDate' => time() * 1000 + 86400000 // Tomorrow
                                    ]
                                ],
                                [
                                    'matchInfo' => [
                                        'matchId' => 5,
                                        'team1' => ['teamName' => 'Australia', 'teamSName' => 'AUS'],
                                        'team2' => ['teamName' => 'England', 'teamSName' => 'ENG'],
                                        'matchFormat' => 'TEST',
                                        'status' => 'Upcoming',
                                        'venueInfo' => ['ground' => 'The Oval', 'city' => 'London'],
                                        'startDate' => time() * 1000 + 172800000 // Day after tomorrow
                                    ]
                                ]
                            ]
                        ]
                    ]
                ]
            ]
        ]
    ];
    
    return getCachedData('upcoming_matches', '/matches/v1/upcoming', $fallbackData);
}

/**
 * Get series list with fallback data
 */
function getSeriesList() {
    $fallbackData = [
        'seriesMapProto' => [
            [
                'series' => [
                    [
                        'id' => 1,
                        'seriesName' => 'ICC Cricket World Cup 2023',
                        'seriesStatus' => 'Ongoing',
                        'startDt' => (time() - 2592000) * 1000, // 30 days ago
                        'endDt' => (time() + 2592000) * 1000, // 30 days from now
                        'matches' => [
                            ['team1' => ['teamName' => 'India'], 'team2' => ['teamName' => 'Australia']],
                            ['team1' => ['teamName' => 'England'], 'team2' => ['teamName' => 'Pakistan']]
                        ]
                    ],
                    [
                        'id' => 2,
                        'seriesName' => 'Border-Gavaskar Trophy 2023-24',
                        'seriesStatus' => 'Upcoming',
                        'startDt' => (time() + 604800) * 1000, // 7 days from now
                        'endDt' => (time() + 3196800) * 1000, // 37 days from now
                        'matches' => [
                            ['team1' => ['teamName' => 'India'], 'team2' => ['teamName' => 'Australia']]
                        ]
                    ]
                ]
            ]
        ]
    ];
    
    return getCachedData('series_list', '/series/v1/list', $fallbackData);
}

/**
 * Get match details with fallback data
 */
function getMatchDetails($matchId) {
    $fallbackData = [
        'matchHeader' => [
            'matchId' => $matchId,
            'team1' => ['teamName' => 'India', 'teamSName' => 'IND'],
            'team2' => ['teamName' => 'Australia', 'teamSName' => 'AUS'],
            'matchFormat' => 'TEST',
            'status' => 'India won by 6 wickets',
            'venueInfo' => ['ground' => 'Melbourne Cricket Ground', 'city' => 'Melbourne'],
            'seriesName' => 'Border-Gavaskar Trophy 2023-24'
        ]
    ];
    
    return getCachedData('match_' . $matchId, '/matches/v1/' . $matchId, $fallbackData);
}

/**
 * Get player details with fallback data
 */
function getPlayerDetails($playerId) {
    $fallbackData = [
        'id' => $playerId,
        'name' => 'Virat Kohli',
        'country' => 'India',
        'role' => 'Batsman',
        'battingStyle' => 'Right-handed',
        'bowlingStyle' => 'Right-arm medium'
    ];
    
    return getCachedData('player_' . $playerId, '/stats/v1/player/' . $playerId, $fallbackData);
}

/**
 * Get ICC rankings with fallback data
 */
function getICCRankings($category = 'batsmen', $format = 'test') {
    $fallbackData = [
        'rank' => [
            ['rank' => 1, 'name' => 'Virat Kohli', 'country' => 'India', 'rating' => 890, 'id' => 1],
            ['rank' => 2, 'name' => 'Babar Azam', 'country' => 'Pakistan', 'rating' => 865, 'id' => 2],
            ['rank' => 3, 'name' => 'Joe Root', 'country' => 'England', 'rating' => 838, 'id' => 3],
            ['rank' => 4, 'name' => 'Steve Smith', 'country' => 'Australia', 'rating' => 820, 'id' => 4],
            ['rank' => 5, 'name' => 'Kane Williamson', 'country' => 'New Zealand', 'rating' => 810, 'id' => 5]
        ]
    ];
    
    return getCachedData('rankings_' . $category . '_' . $format, '/stats/v1/rankings/' . $category . '?formatType=' . $format, $fallbackData);
}

/**
 * Search players with fallback data
 */
function searchPlayers($query) {
    $fallbackData = [
        'player' => [
            ['id' => 1, 'name' => 'Virat Kohli', 'teamName' => 'India'],
            ['id' => 2, 'name' => 'Babar Azam', 'teamName' => 'Pakistan'],
            ['id' => 3, 'name' => 'Joe Root', 'teamName' => 'England']
        ]
    ];
    
    return getCachedData('search_' . md5($query), '/stats/v1/player/search?plrN=' . urlencode($query), $fallbackData);
}

/**
 * Format match status
 */
function formatMatchStatus($status) {
    if (empty($status)) return 'Not Started';
    return htmlspecialchars($status);
}

/**
 * Format team name
 */
function formatTeamName($teamName) {
    return htmlspecialchars($teamName);
}

/**
 * Format player name
 */
function formatPlayerName($playerName) {
    return htmlspecialchars($playerName);
}

/**
 * Get match type badge class
 */
function getMatchTypeBadge($matchType) {
    $type = strtolower($matchType);
    switch($type) {
        case 'test':
            return 'badge-test';
        case 'odi':
            return 'badge-odi';
        case 't20':
        case 't20i':
            return 'badge-t20';
        case 'ipl':
            return 'badge-ipl';
        default:
            return 'badge-default';
    }
}

/**
 * Time ago function
 */
function timeAgo($datetime) {
    $time = time() - strtotime($datetime);
    
    if ($time < 60) return 'just now';
    if ($time < 3600) return floor($time/60) . ' minutes ago';
    if ($time < 86400) return floor($time/3600) . ' hours ago';
    if ($time < 2592000) return floor($time/86400) . ' days ago';
    
    return date('M j, Y', strtotime($datetime));
}

/**
 * Truncate text
 */
function truncateText($text, $length = 100) {
    if (strlen($text) <= $length) return $text;
    return substr($text, 0, $length) . '...';
}

/**
 * Generate player profile URL
 */
function getPlayerUrl($playerId, $playerName = '') {
    return '?page=player&id=' . $playerId . '&name=' . urlencode($playerName);
}

/**
 * Generate match details URL
 */
function getMatchUrl($matchId) {
    return '?page=match&id=' . $matchId;
}

/**
 * Check if match is live
 */
function isMatchLive($status) {
    $liveStatuses = ['live', 'in progress', 'innings break', 'rain delay'];
    return in_array(strtolower($status), $liveStatuses);
}

/**
 * Get country flag URL
 */
function getCountryFlag($countryCode) {
    return "https://flagcdn.com/24x18/" . strtolower($countryCode) . ".png";
}

/**
 * Format score display
 */
function formatScore($runs, $wickets, $overs, $target = null) {
    $score = $runs;
    if ($wickets < 10) {
        $score .= '/' . $wickets;
    }
    if ($overs) {
        $score .= ' (' . $overs . ')';
    }
    if ($target) {
        $score .= ' - Need ' . ($target - $runs) . ' runs';
    }
    return $score;
}

?>