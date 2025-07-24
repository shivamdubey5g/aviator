<?php

/**
 * Make API call to Cricbuzz API
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
    $err = curl_error($curl);
    curl_close($curl);
    
    if ($err) {
        return false;
    }
    
    return json_decode($response, true);
}

/**
 * Get cached data or make fresh API call
 */
function getCachedData($cacheKey, $endpoint) {
    $cacheFile = 'data/cache_' . md5($cacheKey) . '.json';
    
    // Check if cache exists and is still valid
    if (file_exists($cacheFile) && (time() - filemtime($cacheFile)) < CACHE_DURATION) {
        return json_decode(file_get_contents($cacheFile), true);
    }
    
    // Make fresh API call
    $data = makeApiCall($endpoint);
    
    if ($data) {
        // Save to cache
        if (!is_dir('data')) {
            mkdir('data', 0777, true);
        }
        file_put_contents($cacheFile, json_encode($data));
    }
    
    return $data;
}

/**
 * Get recent matches
 */
function getRecentMatches() {
    return getCachedData('recent_matches', '/matches/v1/recent');
}

/**
 * Get live matches
 */
function getLiveMatches() {
    return getCachedData('live_matches', '/matches/v1/live');
}

/**
 * Get upcoming matches
 */
function getUpcomingMatches() {
    return getCachedData('upcoming_matches', '/matches/v1/upcoming');
}

/**
 * Get series list
 */
function getSeriesList() {
    return getCachedData('series_list', '/series/v1/list');
}

/**
 * Get match details
 */
function getMatchDetails($matchId) {
    return getCachedData('match_' . $matchId, '/matches/v1/' . $matchId);
}

/**
 * Get player details
 */
function getPlayerDetails($playerId) {
    return getCachedData('player_' . $playerId, '/stats/v1/player/' . $playerId);
}

/**
 * Get ICC rankings
 */
function getICCRankings($category = 'batsmen', $format = 'test') {
    return getCachedData('rankings_' . $category . '_' . $format, '/stats/v1/rankings/' . $category . '?formatType=' . $format);
}

/**
 * Search players
 */
function searchPlayers($query) {
    return getCachedData('search_' . md5($query), '/stats/v1/player/search?plrN=' . urlencode($query));
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