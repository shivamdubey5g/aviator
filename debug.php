<?php
include_once 'includes/config.php';
include_once 'includes/functions.php';

// Test API endpoints
$endpoints = [
    'Recent Matches' => '/matches/v1/recent',
    'Live Matches' => '/matches/v1/live', 
    'Upcoming Matches' => '/matches/v1/upcoming',
    'Series List' => '/series/v1/list'
];

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CricLive - API Debug</title>
    <link href="css/style.css" rel="stylesheet">
    <style>
        .debug-container {
            max-width: 1000px;
            margin: 2rem auto;
            padding: 2rem;
        }
        .debug-section {
            background: white;
            padding: 2rem;
            margin-bottom: 2rem;
            border-radius: 12px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        }
        .status-good { color: #2ed573; }
        .status-bad { color: #ff4757; }
        .status-warning { color: #ffa502; }
        .api-response {
            background: #f8f9fa;
            padding: 1rem;
            border-radius: 8px;
            font-family: monospace;
            font-size: 0.9rem;
            max-height: 300px;
            overflow-y: auto;
            white-space: pre-wrap;
        }
        .config-item {
            display: flex;
            justify-content: space-between;
            padding: 0.5rem 0;
            border-bottom: 1px solid #f1f3f4;
        }
    </style>
</head>
<body>
    <div class="debug-container">
        <h1>🏏 CricLive - API Debug Dashboard</h1>
        
        <!-- Configuration Status -->
        <div class="debug-section">
            <h2>📋 Configuration Status</h2>
            <div class="config-item">
                <span>API Key:</span>
                <span class="<?php echo !empty(RAPIDAPI_KEY) ? 'status-good' : 'status-bad'; ?>">
                    <?php echo !empty(RAPIDAPI_KEY) ? '✅ Set (' . substr(RAPIDAPI_KEY, 0, 10) . '...)' : '❌ Not Set'; ?>
                </span>
            </div>
            <div class="config-item">
                <span>API Host:</span>
                <span class="status-good">✅ <?php echo RAPIDAPI_HOST; ?></span>
            </div>
            <div class="config-item">
                <span>Base URL:</span>
                <span class="status-good">✅ <?php echo API_BASE_URL; ?></span>
            </div>
            <div class="config-item">
                <span>Cache Duration:</span>
                <span class="status-good">✅ <?php echo CACHE_DURATION; ?> seconds</span>
            </div>
            <div class="config-item">
                <span>Data Directory:</span>
                <span class="<?php echo is_dir('data') && is_writable('data') ? 'status-good' : 'status-warning'; ?>">
                    <?php 
                    if (is_dir('data')) {
                        echo is_writable('data') ? '✅ Exists & Writable' : '⚠️ Exists but not writable';
                    } else {
                        echo '⚠️ Does not exist (will be created)';
                    }
                    ?>
                </span>
            </div>
        </div>

        <!-- API Endpoints Test -->
        <div class="debug-section">
            <h2>🔗 API Endpoints Test</h2>
            <?php foreach ($endpoints as $name => $endpoint): ?>
                <div style="margin-bottom: 2rem;">
                    <h3><?php echo $name; ?></h3>
                    <p><strong>Endpoint:</strong> <?php echo API_BASE_URL . $endpoint; ?></p>
                    
                    <?php
                    $startTime = microtime(true);
                    $response = makeApiCall($endpoint);
                    $endTime = microtime(true);
                    $responseTime = round(($endTime - $startTime) * 1000, 2);
                    ?>
                    
                    <p><strong>Response Time:</strong> <?php echo $responseTime; ?>ms</p>
                    <p><strong>Status:</strong> 
                        <?php if ($response && !isset($response['message'])): ?>
                            <span class="status-good">✅ Success</span>
                        <?php elseif (isset($response['message'])): ?>
                            <span class="status-bad">❌ Error: <?php echo htmlspecialchars($response['message']); ?></span>
                        <?php else: ?>
                            <span class="status-bad">❌ Failed</span>
                        <?php endif; ?>
                    </p>
                    
                    <details>
                        <summary>View Response</summary>
                        <div class="api-response">
                            <?php echo htmlspecialchars(json_encode($response, JSON_PRETTY_PRINT)); ?>
                        </div>
                    </details>
                </div>
            <?php endforeach; ?>
        </div>

        <!-- Sample Data Test -->
        <div class="debug-section">
            <h2>🎯 Sample Data Test</h2>
            <p>Testing fallback data functionality:</p>
            
            <?php
            $sampleData = getRecentMatches();
            ?>
            
            <p><strong>Recent Matches Data:</strong> 
                <span class="<?php echo $sampleData ? 'status-good' : 'status-bad'; ?>">
                    <?php echo $sampleData ? '✅ Available' : '❌ Not Available'; ?>
                </span>
            </p>
            
            <?php if ($sampleData): ?>
                <p><strong>Matches Found:</strong> 
                    <?php 
                    $matchCount = 0;
                    if (isset($sampleData['typeMatches'])) {
                        foreach ($sampleData['typeMatches'] as $typeMatch) {
                            foreach ($typeMatch['seriesMatches'] as $series) {
                                $matchCount += count($series['seriesAdWrapper']['matches']);
                            }
                        }
                    }
                    echo $matchCount;
                    ?>
                </p>
            <?php endif; ?>
        </div>

        <!-- Troubleshooting Guide -->
        <div class="debug-section">
            <h2>🔧 Troubleshooting Guide</h2>
            
            <?php if (empty(RAPIDAPI_KEY)): ?>
                <div class="status-bad">
                    <h3>❌ API Key Missing</h3>
                    <p>Your API key is not set. Please:</p>
                    <ol>
                        <li>Get API key from <a href="https://rapidapi.com/cricketapi/api/cricbuzz-cricket/" target="_blank">RapidAPI Cricbuzz Cricket</a></li>
                        <li>Open <code>includes/config.php</code></li>
                        <li>Replace the API key: <code>define('RAPIDAPI_KEY', 'your-key-here');</code></li>
                    </ol>
                </div>
            <?php endif; ?>

            <?php 
            $testResponse = makeApiCall('/matches/v1/recent');
            if (isset($testResponse['message']) && strpos($testResponse['message'], 'not subscribed') !== false): 
            ?>
                <div class="status-bad">
                    <h3>❌ API Subscription Issue</h3>
                    <p>You are not subscribed to the API. Please:</p>
                    <ol>
                        <li>Visit <a href="https://rapidapi.com/cricketapi/api/cricbuzz-cricket/" target="_blank">RapidAPI Cricbuzz Cricket</a></li>
                        <li>Subscribe to the API (free tier available)</li>
                        <li>Make sure your API key is correct</li>
                    </ol>
                </div>
            <?php endif; ?>

            <div class="status-good">
                <h3>✅ Fallback Data Active</h3>
                <p>Don't worry! Even if the API is not working, the website will still show sample cricket data including:</p>
                <ul>
                    <li>Recent match results</li>
                    <li>Live match simulations</li>
                    <li>Upcoming fixtures</li>
                    <li>Player profiles and rankings</li>
                    <li>Series information</li>
                </ul>
            </div>
        </div>

        <!-- Actions -->
        <div class="debug-section">
            <h2>⚡ Quick Actions</h2>
            <p>
                <a href="index.php" class="btn btn-primary">🏠 Go to Homepage</a>
                <a href="?clear_cache=1" class="btn btn-secondary">🗑️ Clear Cache</a>
                <a href="debug.php" class="btn btn-secondary">🔄 Refresh Debug</a>
            </p>
            
            <?php if (isset($_GET['clear_cache'])): ?>
                <?php
                // Clear cache files
                $cacheFiles = glob('data/cache_*.json');
                foreach ($cacheFiles as $file) {
                    unlink($file);
                }
                ?>
                <div class="status-good">
                    <p>✅ Cache cleared! Cleared <?php echo count($cacheFiles); ?> cache files.</p>
                </div>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>