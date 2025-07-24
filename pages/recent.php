<?php
$recentMatches = getRecentMatches();
?>

<div class="recent-page">
    <div class="card">
        <div class="card-header">
            <h1 class="card-title">
                <i class="fas fa-history"></i>
                Recent Cricket Matches
            </h1>
            <p>Recently completed cricket matches and results</p>
        </div>
        
        <?php if ($recentMatches && isset($recentMatches['typeMatches'])): ?>
            <div class="matches-grid">
                <?php foreach ($recentMatches['typeMatches'] as $typeMatch): ?>
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
                                        <?php echo formatMatchStatus($matchInfo['status']); ?>
                                    </span>
                                </div>
                                
                                <div class="teams-container">
                                    <div class="team">
                                        <div class="team-info">
                                            <span class="team-name"><?php echo formatTeamName($matchInfo['team1']['teamName']); ?></span>
                                        </div>
                                        <div class="team-score">
                                            <?php if (isset($match['matchScore']['team1Score'])): ?>
                                                <?php echo formatScore(
                                                    $match['matchScore']['team1Score']['inngs1']['runs'],
                                                    $match['matchScore']['team1Score']['inngs1']['wickets'],
                                                    $match['matchScore']['team1Score']['inngs1']['overs']
                                                ); ?>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                    
                                    <div class="vs-divider">VS</div>
                                    
                                    <div class="team">
                                        <div class="team-info">
                                            <span class="team-name"><?php echo formatTeamName($matchInfo['team2']['teamName']); ?></span>
                                        </div>
                                        <div class="team-score">
                                            <?php if (isset($match['matchScore']['team2Score'])): ?>
                                                <?php echo formatScore(
                                                    $match['matchScore']['team2Score']['inngs1']['runs'],
                                                    $match['matchScore']['team2Score']['inngs1']['wickets'],
                                                    $match['matchScore']['team2Score']['inngs1']['overs']
                                                ); ?>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="match-venue">
                                    <i class="fas fa-map-marker-alt"></i>
                                    <?php echo $matchInfo['venueInfo']['ground'] . ', ' . $matchInfo['venueInfo']['city']; ?>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php endforeach; ?>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <div class="no-matches">
                <i class="fas fa-cricket-bat-ball"></i>
                <h3>No Recent Matches</h3>
                <p>No recent match data available at the moment.</p>
            </div>
        <?php endif; ?>
    </div>
</div>