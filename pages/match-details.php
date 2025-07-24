<?php
$matchId = isset($_GET['id']) ? $_GET['id'] : 1;

// Mock match data (in real app, this would come from API)
$match = [
    'id' => $matchId,
    'team1' => ['name' => 'India', 'shortName' => 'IND'],
    'team2' => ['name' => 'Australia', 'shortName' => 'AUS'],
    'format' => 'Test',
    'status' => 'India won by 6 wickets',
    'venue' => 'Melbourne Cricket Ground, Melbourne',
    'date' => '2023-12-26',
    'series' => 'Border-Gavaskar Trophy 2023-24',
    'scores' => [
        'team1' => [
            'innings1' => ['runs' => 326, 'wickets' => 10, 'overs' => '87.3'],
            'innings2' => ['runs' => 155, 'wickets' => 4, 'overs' => '42.2']
        ],
        'team2' => [
            'innings1' => ['runs' => 267, 'wickets' => 10, 'overs' => '72.1'],
            'innings2' => ['runs' => 175, 'wickets' => 10, 'overs' => '56.4']
        ]
    ]
];
?>

<div class="match-details-page">
    <!-- Match Header -->
    <div class="card match-header-card">
        <div class="match-header-content">
            <div class="match-series">
                <i class="fas fa-trophy"></i>
                <?php echo $match['series']; ?>
            </div>
            
            <div class="match-teams-display">
                <div class="team-display">
                    <div class="team-name"><?php echo $match['team1']['name']; ?></div>
                    <div class="team-short"><?php echo $match['team1']['shortName']; ?></div>
                    <div class="team-score">
                        <?php if (isset($match['scores']['team1']['innings1'])): ?>
                            <?php echo $match['scores']['team1']['innings1']['runs']; ?>/<?php echo $match['scores']['team1']['innings1']['wickets']; ?>
                            <?php if (isset($match['scores']['team1']['innings2'])): ?>
                                & <?php echo $match['scores']['team1']['innings2']['runs']; ?>/<?php echo $match['scores']['team1']['innings2']['wickets']; ?>
                            <?php endif; ?>
                        <?php endif; ?>
                    </div>
                </div>
                
                <div class="vs-section">
                    <div class="vs-text">VS</div>
                    <div class="match-format"><?php echo $match['format']; ?></div>
                </div>
                
                <div class="team-display">
                    <div class="team-name"><?php echo $match['team2']['name']; ?></div>
                    <div class="team-short"><?php echo $match['team2']['shortName']; ?></div>
                    <div class="team-score">
                        <?php if (isset($match['scores']['team2']['innings1'])): ?>
                            <?php echo $match['scores']['team2']['innings1']['runs']; ?>/<?php echo $match['scores']['team2']['innings1']['wickets']; ?>
                            <?php if (isset($match['scores']['team2']['innings2'])): ?>
                                & <?php echo $match['scores']['team2']['innings2']['runs']; ?>/<?php echo $match['scores']['team2']['innings2']['wickets']; ?>
                            <?php endif; ?>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
            
            <div class="match-result">
                <div class="result-text"><?php echo $match['status']; ?></div>
            </div>
            
            <div class="match-info">
                <div class="info-item">
                    <i class="fas fa-map-marker-alt"></i>
                    <?php echo $match['venue']; ?>
                </div>
                <div class="info-item">
                    <i class="fas fa-calendar"></i>
                    <?php echo date('F j, Y', strtotime($match['date'])); ?>
                </div>
            </div>
        </div>
    </div>

    <!-- Match Navigation -->
    <div class="card">
        <div class="match-nav">
            <button class="nav-btn active" data-tab="scorecard">Scorecard</button>
            <button class="nav-btn" data-tab="commentary">Commentary</button>
            <button class="nav-btn" data-tab="stats">Statistics</button>
            <button class="nav-btn" data-tab="highlights">Highlights</button>
        </div>
    </div>

    <!-- Scorecard Tab -->
    <div class="tab-content active" id="scorecard">
        <div class="innings-container">
            <!-- Team 1 Innings -->
            <div class="card innings-card">
                <div class="innings-header">
                    <h3><?php echo $match['team1']['name']; ?> 1st Innings</h3>
                    <div class="innings-score">
                        <?php echo $match['scores']['team1']['innings1']['runs']; ?>/<?php echo $match['scores']['team1']['innings1']['wickets']; ?>
                        (<?php echo $match['scores']['team1']['innings1']['overs']; ?> overs)
                    </div>
                </div>
                
                <div class="batting-scorecard">
                    <table class="scorecard-table">
                        <thead>
                            <tr>
                                <th>Batsman</th>
                                <th>R</th>
                                <th>B</th>
                                <th>4s</th>
                                <th>6s</th>
                                <th>SR</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>Rohit Sharma (c)</td>
                                <td>43</td>
                                <td>60</td>
                                <td>6</td>
                                <td>0</td>
                                <td>71.67</td>
                            </tr>
                            <tr>
                                <td>Shubman Gill</td>
                                <td>31</td>
                                <td>51</td>
                                <td>4</td>
                                <td>0</td>
                                <td>60.78</td>
                            </tr>
                            <tr>
                                <td>Virat Kohli</td>
                                <td>85</td>
                                <td>124</td>
                                <td>11</td>
                                <td>1</td>
                                <td>68.55</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Team 2 Innings -->
            <div class="card innings-card">
                <div class="innings-header">
                    <h3><?php echo $match['team2']['name']; ?> 1st Innings</h3>
                    <div class="innings-score">
                        <?php echo $match['scores']['team2']['innings1']['runs']; ?>/<?php echo $match['scores']['team2']['innings1']['wickets']; ?>
                        (<?php echo $match['scores']['team2']['innings1']['overs']; ?> overs)
                    </div>
                </div>
                
                <div class="batting-scorecard">
                    <table class="scorecard-table">
                        <thead>
                            <tr>
                                <th>Batsman</th>
                                <th>R</th>
                                <th>B</th>
                                <th>4s</th>
                                <th>6s</th>
                                <th>SR</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>David Warner</td>
                                <td>56</td>
                                <td>73</td>
                                <td>8</td>
                                <td>0</td>
                                <td>76.71</td>
                            </tr>
                            <tr>
                                <td>Steve Smith</td>
                                <td>38</td>
                                <td>87</td>
                                <td>3</td>
                                <td>0</td>
                                <td>43.68</td>
                            </tr>
                            <tr>
                                <td>Marnus Labuschagne</td>
                                <td>72</td>
                                <td>145</td>
                                <td>7</td>
                                <td>0</td>
                                <td>49.66</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Commentary Tab -->
    <div class="tab-content" id="commentary">
        <div class="card">
            <div class="card-header">
                <h3>Live Commentary</h3>
            </div>
            <div class="commentary-feed">
                <div class="commentary-item">
                    <div class="over-info">45.3</div>
                    <div class="commentary-text">
                        <strong>FOUR!</strong> Kohli drives beautifully through the covers for a boundary. Excellent timing and placement.
                    </div>
                </div>
                <div class="commentary-item">
                    <div class="over-info">45.2</div>
                    <div class="commentary-text">
                        Single taken. Kohli pushes to mid-on and takes a quick single.
                    </div>
                </div>
                <div class="commentary-item">
                    <div class="over-info">45.1</div>
                    <div class="commentary-text">
                        Dot ball. Good length delivery, defended back to the bowler.
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Statistics Tab -->
    <div class="tab-content" id="stats">
        <div class="stats-grid">
            <div class="card">
                <div class="card-header">
                    <h3>Match Statistics</h3>
                </div>
                <div class="stats-comparison">
                    <div class="stat-row">
                        <span>Total Runs</span>
                        <span>481</span>
                        <span>442</span>
                    </div>
                    <div class="stat-row">
                        <span>Total Wickets</span>
                        <span>14</span>
                        <span>20</span>
                    </div>
                    <div class="stat-row">
                        <span>Total Overs</span>
                        <span>129.5</span>
                        <span>128.5</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Highlights Tab -->
    <div class="tab-content" id="highlights">
        <div class="card">
            <div class="card-header">
                <h3>Match Highlights</h3>
            </div>
            <div class="highlights-list">
                <div class="highlight-item">
                    <div class="highlight-icon">
                        <i class="fas fa-star"></i>
                    </div>
                    <div class="highlight-text">
                        <strong>Virat Kohli 85</strong> - Brilliant knock by Kohli in the first innings
                    </div>
                </div>
                <div class="highlight-item">
                    <div class="highlight-icon">
                        <i class="fas fa-bowling-ball"></i>
                    </div>
                    <div class="highlight-text">
                        <strong>Jasprit Bumrah 5/42</strong> - Excellent bowling figures in the second innings
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.match-header-card {
    background: linear-gradient(135deg, #667eea, #764ba2);
    color: white;
    margin-bottom: 1.5rem;
}

.match-header-content {
    text-align: center;
    padding: 2rem;
}

.match-series {
    font-size: 1.1rem;
    margin-bottom: 1.5rem;
    opacity: 0.9;
}

.match-teams-display {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin: 2rem 0;
    max-width: 600px;
    margin-left: auto;
    margin-right: auto;
}

.team-display {
    text-align: center;
    flex: 1;
}

.team-name {
    font-size: 1.5rem;
    font-weight: 700;
    margin-bottom: 0.5rem;
}

.team-short {
    font-size: 1rem;
    opacity: 0.8;
    margin-bottom: 1rem;
}

.team-score {
    font-size: 1.8rem;
    font-weight: 700;
}

.vs-section {
    text-align: center;
    margin: 0 2rem;
}

.vs-text {
    font-size: 1.2rem;
    font-weight: 600;
    margin-bottom: 0.5rem;
}

.match-format {
    background: rgba(255, 255, 255, 0.2);
    padding: 0.3rem 0.8rem;
    border-radius: 20px;
    font-size: 0.9rem;
    font-weight: 600;
}

.match-result {
    font-size: 1.3rem;
    font-weight: 600;
    margin: 1.5rem 0;
    padding: 1rem;
    background: rgba(255, 255, 255, 0.1);
    border-radius: 8px;
}

.match-info {
    display: flex;
    justify-content: center;
    gap: 2rem;
    flex-wrap: wrap;
    opacity: 0.9;
}

.info-item {
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

.match-nav {
    display: flex;
    gap: 0;
    border-bottom: 2px solid #f1f3f4;
}

.nav-btn {
    padding: 1rem 2rem;
    border: none;
    background: none;
    cursor: pointer;
    font-weight: 600;
    color: #666;
    border-bottom: 3px solid transparent;
    transition: all 0.3s ease;
}

.nav-btn.active {
    color: #667eea;
    border-bottom-color: #667eea;
}

.nav-btn:hover {
    color: #667eea;
}

.tab-content {
    display: none;
    margin-top: 1.5rem;
}

.tab-content.active {
    display: block;
}

.innings-container {
    display: flex;
    flex-direction: column;
    gap: 1.5rem;
}

.innings-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 1rem;
    padding-bottom: 1rem;
    border-bottom: 2px solid #f1f3f4;
}

.innings-header h3 {
    color: #667eea;
    margin: 0;
}

.innings-score {
    font-size: 1.5rem;
    font-weight: 700;
    color: #333;
}

.scorecard-table {
    width: 100%;
    border-collapse: collapse;
}

.scorecard-table th,
.scorecard-table td {
    padding: 0.8rem;
    text-align: left;
    border-bottom: 1px solid #f1f3f4;
}

.scorecard-table th {
    background: #f8f9fa;
    font-weight: 600;
    color: #333;
}

.scorecard-table tr:hover {
    background: #f8f9fa;
}

.commentary-feed {
    max-height: 500px;
    overflow-y: auto;
}

.commentary-item {
    display: flex;
    gap: 1rem;
    padding: 1rem;
    border-bottom: 1px solid #f1f3f4;
}

.over-info {
    background: #667eea;
    color: white;
    padding: 0.3rem 0.8rem;
    border-radius: 20px;
    font-weight: 600;
    font-size: 0.9rem;
    min-width: 60px;
    text-align: center;
}

.commentary-text {
    flex: 1;
    line-height: 1.6;
}

.stats-comparison {
    display: flex;
    flex-direction: column;
    gap: 1rem;
}

.stat-row {
    display: grid;
    grid-template-columns: 1fr auto auto;
    gap: 2rem;
    padding: 0.8rem;
    background: #f8f9fa;
    border-radius: 8px;
}

.highlights-list {
    display: flex;
    flex-direction: column;
    gap: 1rem;
}

.highlight-item {
    display: flex;
    align-items: center;
    gap: 1rem;
    padding: 1rem;
    background: #f8f9fa;
    border-radius: 8px;
}

.highlight-icon {
    width: 40px;
    height: 40px;
    background: #667eea;
    color: white;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
}

@media (max-width: 768px) {
    .match-teams-display {
        flex-direction: column;
        gap: 1rem;
    }
    
    .vs-section {
        margin: 1rem 0;
    }
    
    .match-info {
        flex-direction: column;
        gap: 1rem;
    }
    
    .match-nav {
        flex-wrap: wrap;
    }
    
    .nav-btn {
        padding: 0.8rem 1rem;
        font-size: 0.9rem;
    }
    
    .scorecard-table {
        font-size: 0.9rem;
    }
    
    .commentary-item {
        flex-direction: column;
        gap: 0.5rem;
    }
}
</style>

<script>
// Tab functionality
document.addEventListener('DOMContentLoaded', function() {
    const navBtns = document.querySelectorAll('.nav-btn');
    const tabContents = document.querySelectorAll('.tab-content');
    
    navBtns.forEach(btn => {
        btn.addEventListener('click', function() {
            const tabId = this.dataset.tab;
            
            // Remove active class from all tabs
            navBtns.forEach(b => b.classList.remove('active'));
            tabContents.forEach(c => c.classList.remove('active'));
            
            // Add active class to clicked tab
            this.classList.add('active');
            document.getElementById(tabId).classList.add('active');
        });
    });
});
</script>