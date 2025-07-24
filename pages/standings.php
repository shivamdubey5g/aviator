<?php
$format = isset($_GET['format']) ? $_GET['format'] : 'test';
$category = isset($_GET['category']) ? $_GET['category'] : 'batsmen';

$rankings = getICCRankings($category, $format);
?>

<div class="standings-page">
    <div class="card">
        <div class="card-header">
            <h1 class="card-title">
                <i class="fas fa-trophy"></i>
                ICC Cricket Rankings
            </h1>
            <p>Official ICC player and team rankings</p>
        </div>
        
        <!-- Format and Category Filters -->
        <div class="filters">
            <div class="filter-group">
                <label>Format:</label>
                <div class="filter-buttons">
                    <a href="?page=standings&format=test&category=<?php echo $category; ?>" 
                       class="btn <?php echo $format == 'test' ? 'btn-primary' : 'btn-secondary'; ?>">Test</a>
                    <a href="?page=standings&format=odi&category=<?php echo $category; ?>" 
                       class="btn <?php echo $format == 'odi' ? 'btn-primary' : 'btn-secondary'; ?>">ODI</a>
                    <a href="?page=standings&format=t20i&category=<?php echo $category; ?>" 
                       class="btn <?php echo $format == 't20i' ? 'btn-primary' : 'btn-secondary'; ?>">T20I</a>
                </div>
            </div>
            
            <div class="filter-group">
                <label>Category:</label>
                <div class="filter-buttons">
                    <a href="?page=standings&format=<?php echo $format; ?>&category=batsmen" 
                       class="btn <?php echo $category == 'batsmen' ? 'btn-primary' : 'btn-secondary'; ?>">Batsmen</a>
                    <a href="?page=standings&format=<?php echo $format; ?>&category=bowlers" 
                       class="btn <?php echo $category == 'bowlers' ? 'btn-primary' : 'btn-secondary'; ?>">Bowlers</a>
                    <a href="?page=standings&format=<?php echo $format; ?>&category=allrounders" 
                       class="btn <?php echo $category == 'allrounders' ? 'btn-primary' : 'btn-secondary'; ?>">All-rounders</a>
                </div>
            </div>
        </div>
        
        <?php if ($rankings && isset($rankings['rank'])): ?>
            <div class="rankings-container">
                <h2><?php echo ucfirst($category); ?> Rankings - <?php echo strtoupper($format); ?></h2>
                
                <div class="rankings-table-container">
                    <table class="rankings-table">
                        <thead>
                            <tr>
                                <th>Rank</th>
                                <th>Player</th>
                                <th>Team</th>
                                <th>Rating</th>
                                <th>Career Best</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($rankings['rank'] as $player): ?>
                                <tr onclick="window.location.href='<?php echo getPlayerUrl($player['id'], $player['name']); ?>'" style="cursor: pointer;">
                                    <td>
                                        <span class="rank-position"><?php echo $player['rank']; ?></span>
                                        <?php if (isset($player['trend'])): ?>
                                            <span class="rank-trend <?php echo $player['trend'] > 0 ? 'up' : ($player['trend'] < 0 ? 'down' : 'same'); ?>">
                                                <?php if ($player['trend'] > 0): ?>
                                                    <i class="fas fa-arrow-up"></i> +<?php echo $player['trend']; ?>
                                                <?php elseif ($player['trend'] < 0): ?>
                                                    <i class="fas fa-arrow-down"></i> <?php echo $player['trend']; ?>
                                                <?php else: ?>
                                                    <i class="fas fa-minus"></i>
                                                <?php endif; ?>
                                            </span>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <div class="player-info">
                                            <div class="player-avatar">
                                                <?php echo substr($player['name'], 0, 1); ?>
                                            </div>
                                            <div class="player-details">
                                                <div class="player-name"><?php echo formatPlayerName($player['name']); ?></div>
                                                <div class="player-country"><?php echo $player['country']; ?></div>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <span class="team-name"><?php echo $player['country']; ?></span>
                                    </td>
                                    <td>
                                        <span class="rating-points"><?php echo $player['rating']; ?></span>
                                    </td>
                                    <td>
                                        <span class="career-best"><?php echo isset($player['bestRating']) ? $player['bestRating'] : '-'; ?></span>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        <?php else: ?>
            <div class="no-rankings">
                <i class="fas fa-trophy"></i>
                <h3>No Rankings Available</h3>
                <p>ICC rankings data is not available at the moment.</p>
            </div>
        <?php endif; ?>
    </div>
</div>

<style>
.filters {
    display: flex;
    gap: 2rem;
    margin-bottom: 2rem;
    flex-wrap: wrap;
}

.filter-group {
    display: flex;
    align-items: center;
    gap: 1rem;
}

.filter-group label {
    font-weight: 600;
    color: #333;
}

.filter-buttons {
    display: flex;
    gap: 0.5rem;
}

.filter-buttons .btn {
    padding: 0.5rem 1rem;
    font-size: 0.9rem;
}

.rankings-container h2 {
    color: #667eea;
    margin-bottom: 1.5rem;
    text-align: center;
}

.rankings-table-container {
    overflow-x: auto;
}

.player-info {
    display: flex;
    align-items: center;
    gap: 1rem;
}

.player-avatar {
    width: 40px;
    height: 40px;
    border-radius: 50%;
    background: linear-gradient(135deg, #667eea, #764ba2);
    color: white;
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: 600;
}

.player-details {
    flex: 1;
}

.player-country {
    font-size: 0.8rem;
    color: #666;
}

.rank-trend {
    font-size: 0.8rem;
    margin-left: 0.5rem;
}

.rank-trend.up {
    color: #2ed573;
}

.rank-trend.down {
    color: #ff4757;
}

.rank-trend.same {
    color: #747d8c;
}

.rating-points {
    font-weight: 700;
    color: #667eea;
    font-size: 1.1rem;
}

.career-best {
    color: #666;
}

.no-rankings {
    text-align: center;
    padding: 3rem;
    color: #666;
}

.no-rankings i {
    font-size: 4rem;
    margin-bottom: 1rem;
    color: #ccc;
}

@media (max-width: 768px) {
    .filters {
        flex-direction: column;
        gap: 1rem;
    }
    
    .filter-group {
        flex-direction: column;
        align-items: flex-start;
    }
    
    .player-info {
        flex-direction: column;
        text-align: center;
    }
}
</style>