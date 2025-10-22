<?php
$playerId = isset($_GET['id']) ? $_GET['id'] : 1;
$playerName = isset($_GET['name']) ? $_GET['name'] : 'Player';

// Mock player data (in real app, this would come from API)
$player = [
    'id' => $playerId,
    'name' => $playerName,
    'team' => 'India',
    'role' => 'Batsman',
    'age' => 34,
    'birthDate' => '1988-11-05',
    'birthPlace' => 'Delhi, India',
    'battingStyle' => 'Right-handed',
    'bowlingStyle' => 'Right-arm medium',
    'stats' => [
        'test' => ['matches' => 104, 'runs' => 8043, 'average' => 49.95, 'centuries' => 27, 'fifties' => 28],
        'odi' => ['matches' => 262, 'runs' => 12344, 'average' => 57.32, 'centuries' => 43, 'fifties' => 64],
        't20i' => ['matches' => 115, 'runs' => 4008, 'average' => 52.73, 'centuries' => 1, 'fifties' => 37]
    ]
];
?>

<div class="player-profile-page">
    <!-- Player Header -->
    <div class="card">
        <div class="player-header">
            <div class="player-avatar-large">
                <?php echo substr($player['name'], 0, 1); ?>
            </div>
            
            <div class="player-basic-info">
                <h1 class="player-name"><?php echo formatPlayerName($player['name']); ?></h1>
                <div class="player-details">
                    <span class="player-team">
                        <i class="fas fa-flag"></i>
                        <?php echo $player['team']; ?>
                    </span>
                    <span class="player-role">
                        <i class="fas fa-user"></i>
                        <?php echo $player['role']; ?>
                    </span>
                    <span class="player-age">
                        <i class="fas fa-birthday-cake"></i>
                        <?php echo $player['age']; ?> years
                    </span>
                </div>
            </div>
            
            <div class="player-actions">
                <button class="btn btn-primary" onclick="sharePlayer()">
                    <i class="fas fa-share"></i>
                    Share
                </button>
                <button class="btn btn-secondary" onclick="followPlayer()">
                    <i class="fas fa-heart"></i>
                    Follow
                </button>
            </div>
        </div>
    </div>

    <!-- Player Information -->
    <div class="player-content">
        <div class="stats-grid">
            <!-- Personal Information -->
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-info-circle"></i>
                        Personal Information
                    </h3>
                </div>
                <div class="info-list">
                    <div class="info-item">
                        <span class="info-label">Full Name:</span>
                        <span class="info-value"><?php echo $player['name']; ?></span>
                    </div>
                    <div class="info-item">
                        <span class="info-label">Birth Date:</span>
                        <span class="info-value"><?php echo date('F j, Y', strtotime($player['birthDate'])); ?></span>
                    </div>
                    <div class="info-item">
                        <span class="info-label">Birth Place:</span>
                        <span class="info-value"><?php echo $player['birthPlace']; ?></span>
                    </div>
                    <div class="info-item">
                        <span class="info-label">Batting Style:</span>
                        <span class="info-value"><?php echo $player['battingStyle']; ?></span>
                    </div>
                    <div class="info-item">
                        <span class="info-label">Bowling Style:</span>
                        <span class="info-value"><?php echo $player['bowlingStyle']; ?></span>
                    </div>
                </div>
            </div>

            <!-- Career Statistics -->
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-chart-bar"></i>
                        Career Statistics
                    </h3>
                </div>
                <div class="stats-tabs">
                    <div class="tab-buttons">
                        <button class="tab-btn active" data-tab="test">Test</button>
                        <button class="tab-btn" data-tab="odi">ODI</button>
                        <button class="tab-btn" data-tab="t20i">T20I</button>
                    </div>
                    
                    <?php foreach ($player['stats'] as $format => $stats): ?>
                    <div class="tab-content <?php echo $format == 'test' ? 'active' : ''; ?>" id="<?php echo $format; ?>-stats">
                        <div class="stats-row">
                            <div class="stat-box">
                                <div class="stat-value"><?php echo $stats['matches']; ?></div>
                                <div class="stat-label">Matches</div>
                            </div>
                            <div class="stat-box">
                                <div class="stat-value"><?php echo number_format($stats['runs']); ?></div>
                                <div class="stat-label">Runs</div>
                            </div>
                            <div class="stat-box">
                                <div class="stat-value"><?php echo $stats['average']; ?></div>
                                <div class="stat-label">Average</div>
                            </div>
                            <div class="stat-box">
                                <div class="stat-value"><?php echo $stats['centuries']; ?></div>
                                <div class="stat-label">100s</div>
                            </div>
                            <div class="stat-box">
                                <div class="stat-value"><?php echo $stats['fifties']; ?></div>
                                <div class="stat-label">50s</div>
                            </div>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>

        <!-- Recent Performances -->
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">
                    <i class="fas fa-history"></i>
                    Recent Performances
                </h3>
            </div>
            <div class="recent-matches">
                <div class="match-performance">
                    <div class="match-info">
                        <span class="match-teams">IND vs AUS</span>
                        <span class="match-date">Dec 15, 2023</span>
                    </div>
                    <div class="performance-stats">
                        <span class="runs">87* (124)</span>
                        <span class="result">Won by 6 wickets</span>
                    </div>
                </div>
                <div class="match-performance">
                    <div class="match-info">
                        <span class="match-teams">IND vs ENG</span>
                        <span class="match-date">Dec 10, 2023</span>
                    </div>
                    <div class="performance-stats">
                        <span class="runs">45 (67)</span>
                        <span class="result">Lost by 3 runs</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.player-header {
    display: flex;
    align-items: center;
    gap: 2rem;
    padding: 2rem;
    background: linear-gradient(135deg, #667eea, #764ba2);
    color: white;
    border-radius: 15px;
}

.player-avatar-large {
    width: 120px;
    height: 120px;
    border-radius: 50%;
    background: rgba(255, 255, 255, 0.2);
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 3rem;
    font-weight: 700;
    backdrop-filter: blur(10px);
}

.player-basic-info {
    flex: 1;
}

.player-basic-info h1 {
    font-size: 2.5rem;
    margin-bottom: 1rem;
}

.player-details {
    display: flex;
    gap: 2rem;
    flex-wrap: wrap;
}

.player-details span {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    font-size: 1.1rem;
}

.player-actions {
    display: flex;
    flex-direction: column;
    gap: 1rem;
}

.info-list {
    display: flex;
    flex-direction: column;
    gap: 1rem;
}

.info-item {
    display: flex;
    justify-content: space-between;
    padding: 0.5rem 0;
    border-bottom: 1px solid #f1f3f4;
}

.info-label {
    font-weight: 600;
    color: #666;
}

.info-value {
    color: #333;
}

.stats-tabs {
    margin-top: 1rem;
}

.tab-buttons {
    display: flex;
    gap: 1rem;
    margin-bottom: 1.5rem;
    border-bottom: 2px solid #f1f3f4;
}

.tab-btn {
    padding: 0.7rem 1.5rem;
    border: none;
    background: none;
    cursor: pointer;
    font-weight: 600;
    color: #666;
    border-bottom: 3px solid transparent;
    transition: all 0.3s ease;
}

.tab-btn.active {
    color: #667eea;
    border-bottom-color: #667eea;
}

.tab-content {
    display: none;
}

.tab-content.active {
    display: block;
}

.stats-row {
    display: flex;
    gap: 1rem;
    flex-wrap: wrap;
}

.stat-box {
    flex: 1;
    min-width: 100px;
    text-align: center;
    padding: 1rem;
    background: #f8f9fa;
    border-radius: 8px;
}

.recent-matches {
    display: flex;
    flex-direction: column;
    gap: 1rem;
}

.match-performance {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 1rem;
    background: #f8f9fa;
    border-radius: 8px;
}

.match-info {
    display: flex;
    flex-direction: column;
    gap: 0.5rem;
}

.match-teams {
    font-weight: 600;
    color: #333;
}

.match-date {
    color: #666;
    font-size: 0.9rem;
}

.performance-stats {
    display: flex;
    flex-direction: column;
    gap: 0.5rem;
    text-align: right;
}

.runs {
    font-weight: 700;
    color: #667eea;
    font-size: 1.1rem;
}

.result {
    color: #666;
    font-size: 0.9rem;
}

@media (max-width: 768px) {
    .player-header {
        flex-direction: column;
        text-align: center;
    }
    
    .player-details {
        justify-content: center;
    }
    
    .player-actions {
        flex-direction: row;
    }
    
    .stats-row {
        flex-direction: column;
    }
    
    .match-performance {
        flex-direction: column;
        gap: 1rem;
    }
    
    .performance-stats {
        text-align: center;
    }
}
</style>

<script>
// Tab functionality
document.addEventListener('DOMContentLoaded', function() {
    const tabBtns = document.querySelectorAll('.tab-btn');
    const tabContents = document.querySelectorAll('.tab-content');
    
    tabBtns.forEach(btn => {
        btn.addEventListener('click', function() {
            const tabId = this.dataset.tab;
            
            // Remove active class from all tabs
            tabBtns.forEach(b => b.classList.remove('active'));
            tabContents.forEach(c => c.classList.remove('active'));
            
            // Add active class to clicked tab
            this.classList.add('active');
            document.getElementById(tabId + '-stats').classList.add('active');
        });
    });
});

function sharePlayer() {
    if (navigator.share) {
        navigator.share({
            title: '<?php echo $player["name"]; ?> - CricLive',
            text: 'Check out <?php echo $player["name"]; ?>\'s cricket profile',
            url: window.location.href
        });
    } else {
        copyToClipboard(window.location.href);
        showNotification('Profile link copied to clipboard!', 'success');
    }
}

function followPlayer() {
    showNotification('Following <?php echo $player["name"]; ?>!', 'success');
}
</script>