<?php
/**
 * Digital Reliance Processing Configuration
 */

// Database configuration
define('DB_HOST', 'localhost');
define('DB_NAME', 'digital_reliance');
define('DB_USER', 'root');
define('DB_PASS', '');

// Application settings
define('APP_NAME', 'Digital Reliance Processor');
define('APP_VERSION', '1.0.0');
define('DEBUG_MODE', true);

// Reliance calculation parameters
define('DEFAULT_RELIABILITY_THRESHOLD', 0.85);
define('MAX_PROCESSING_TIME', 30); // seconds
define('DATA_RETENTION_DAYS', 90);

// API settings
define('API_RATE_LIMIT', 100); // requests per hour
define('MAX_DATA_SIZE', 10485760); // 10MB

// Logging
define('LOG_LEVEL', 'INFO');
define('LOG_FILE', 'logs/digital_reliance.log');

// Error reporting
if (DEBUG_MODE) {
    error_reporting(E_ALL);
    ini_set('display_errors', 1);
} else {
    error_reporting(0);
    ini_set('display_errors', 0);
}

// Timezone
date_default_timezone_set('UTC');
?>