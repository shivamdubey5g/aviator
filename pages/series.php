<?php
$seriesList = getSeriesList();
?>

<div class="series-page">
    <div class="card">
        <div class="card-header">
            <h1 class="card-title">
                <i class="fas fa-list"></i>
                Cricket Series & Tournaments
            </h1>
            <p>Ongoing and upcoming cricket series around the world</p>
        </div>
        
        <?php if ($seriesList && isset($seriesList['seriesMapProto'])): ?>
            <div class="series-container">
                <?php foreach ($seriesList['seriesMapProto'] as $seriesGroup): ?>
                    <div class="series-group">
                        <h2 class="series-group-title"><?php echo $seriesGroup['series'][0]['seriesName']; ?></h2>
                        
                        <div class="series-grid">
                            <?php foreach ($seriesGroup['series'] as $series): ?>
                                <div class="series-card">
                                    <div class="series-header">
                                        <h3 class="series-title"><?php echo $series['seriesName']; ?></h3>
                                        <span class="series-status <?php echo strtolower($series['seriesStatus']); ?>">
                                            <?php echo $series['seriesStatus']; ?>
                                        </span>
                                    </div>
                                    
                                    <div class="series-dates">
                                        <i class="fas fa-calendar"></i>
                                        <?php echo date('M j, Y', $series['startDt'] / 1000); ?> - 
                                        <?php echo date('M j, Y', $series['endDt'] / 1000); ?>
                                    </div>
                                    
                                    <?php if (isset($series['matches'])): ?>
                                        <div class="series-matches">
                                            <h4>Matches (<?php echo count($series['matches']); ?>)</h4>
                                            <div class="series-teams">
                                                <?php foreach ($series['matches'] as $match): ?>
                                                    <div class="match-teams">
                                                        <?php echo $match['team1']['teamName']; ?> vs <?php echo $match['team2']['teamName']; ?>
                                                    </div>
                                                <?php endforeach; ?>
                                            </div>
                                        </div>
                                    <?php endif; ?>
                                    
                                    <div class="series-actions">
                                        <a href="?page=series&id=<?php echo $series['id']; ?>" class="btn btn-primary">
                                            View Details
                                        </a>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <div class="no-series">
                <i class="fas fa-list"></i>
                <h3>No Series Available</h3>
                <p>No cricket series data available at the moment.</p>
            </div>
        <?php endif; ?>
    </div>
</div>

<style>
.series-group {
    margin-bottom: 2rem;
}

.series-group-title {
    color: #667eea;
    font-size: 1.5rem;
    margin-bottom: 1rem;
    padding-bottom: 0.5rem;
    border-bottom: 2px solid #f1f3f4;
}

.series-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(350px, 1fr));
    gap: 1.5rem;
}

.series-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 1rem;
}

.series-status {
    padding: 0.3rem 0.8rem;
    border-radius: 20px;
    font-size: 0.8rem;
    font-weight: 600;
    text-transform: uppercase;
}

.series-status.ongoing {
    background: #2ed573;
    color: white;
}

.series-status.upcoming {
    background: #3742fa;
    color: white;
}

.series-status.completed {
    background: #747d8c;
    color: white;
}

.series-dates {
    color: #666;
    font-size: 0.9rem;
    margin-bottom: 1rem;
}

.series-matches h4 {
    color: #333;
    margin-bottom: 0.5rem;
}

.match-teams {
    background: #f8f9fa;
    padding: 0.5rem;
    margin-bottom: 0.5rem;
    border-radius: 5px;
    font-size: 0.9rem;
}

.series-actions {
    margin-top: 1rem;
    text-align: center;
}

.no-series {
    text-align: center;
    padding: 3rem;
    color: #666;
}

.no-series i {
    font-size: 4rem;
    margin-bottom: 1rem;
    color: #ccc;
}
</style>