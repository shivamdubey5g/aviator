<?php
$upcomingMatches = getUpcomingMatches();
?>

<div class="upcoming-page">
    <div class="card">
        <div class="card-header">
            <h1 class="card-title">
                <i class="fas fa-calendar-alt"></i>
                Upcoming Cricket Matches
            </h1>
            <p>Scheduled cricket matches and fixtures</p>
        </div>
        
        <?php if ($upcomingMatches && isset($upcomingMatches['typeMatches'])): ?>
            <div class="matches-grid">
                <?php foreach ($upcomingMatches['typeMatches'] as $typeMatch): ?>
                    <?php foreach ($typeMatch['seriesMatches'] as $series): ?>
                        <div class="series-header">
                            <h3><?php echo $series['seriesAdWrapper']['seriesName']; ?></h3>
                        </div>
                        <?php foreach ($series['seriesAdWrapper']['matches'] as $match): ?>
                            <?php $matchInfo = $match['matchInfo']; ?>
                            <div class="match-card" data-match-id="<?php echo $matchInfo['matchId']; ?>">
                                <div class="match-header">
                                    <span class="match-type <?php echo getMatchTypeBadge($matchInfo['matchFormat']); ?>">
                                        <?php echo strtoupper($matchInfo['matchFormat']); ?>
                                    </span>
                                    <span class="match-status">
                                        <?php echo date('M j, Y H:i', $matchInfo['startDate'] / 1000); ?>
                                    </span>
                                </div>
                                
                                <div class="teams-container">
                                    <div class="team">
                                        <div class="team-info">
                                            <span class="team-name"><?php echo formatTeamName($matchInfo['team1']['teamName']); ?></span>
                                        </div>
                                    </div>
                                    
                                    <div class="vs-divider">VS</div>
                                    
                                    <div class="team">
                                        <div class="team-info">
                                            <span class="team-name"><?php echo formatTeamName($matchInfo['team2']['teamName']); ?></span>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="match-venue">
                                    <i class="fas fa-map-marker-alt"></i>
                                    <?php echo $matchInfo['venueInfo']['ground'] . ', ' . $matchInfo['venueInfo']['city']; ?>
                                </div>
                                
                                <div class="match-time">
                                    <i class="fas fa-clock"></i>
                                    <?php echo date('l, F j, Y \a\t g:i A', $matchInfo['startDate'] / 1000); ?>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php endforeach; ?>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <div class="no-matches">
                <i class="fas fa-calendar-alt"></i>
                <h3>No Upcoming Matches</h3>
                <p>No upcoming match fixtures available at the moment.</p>
            </div>
        <?php endif; ?>
    </div>
</div>