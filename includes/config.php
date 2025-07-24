<?php
// API Configuration
define('RAPIDAPI_KEY', '0bf31ee2a8msh0fa1d5f8b8f7dbdp1eb7efjsn4ebd5d4d70e8');
define('RAPIDAPI_HOST', 'cricbuzz-cricket.p.rapidapi.com');
define('API_BASE_URL', 'https://cricbuzz-cricket.p.rapidapi.com');

// Site Configuration
define('SITE_NAME', 'CricLive');
define('SITE_URL', 'http://localhost');

// Cache settings
define('CACHE_DURATION', 300); // 5 minutes cache for API calls

// Error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Timezone
date_default_timezone_set('UTC');
?>