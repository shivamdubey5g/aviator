<?php
$liveMatches = getLiveMatches();
$recentMatches = getRecentMatches();
$upcomingMatches = getUpcomingMatches();
?>

<div class="home-page">
    <!-- Hero Section -->
    <section class="hero-section">
        <div class="card">
            <div class="card-header">
                <h1 class="card-title">
                    <i class="fas fa-cricket-bat-ball"></i>
                    Welcome to CricLive
                </h1>
                <p>Your ultimate destination for live cricket scores and updates</p>
            </div>
        </div>
    </section>

    <!-- Live Matches Section -->
    <?php if ($liveMatches && isset($liveMatches['typeMatches'])): ?>
    <section class="live-matches-section">
        <div class="card">
            <div class="card-header">
                <h2 class="card-title">
                    <span class="live-indicator"></span>
                    Live Matches
                </h2>
                <a href="?page=live" class="btn btn-primary">View All Live</a>
            </div>
            <div class="live-scores-container">
                <div class="matches-grid">
                    <?php 
                    $count = 0;
                    foreach ($liveMatches['typeMatches'] as $typeMatch): 
                        if ($count >= 3) break;
                        foreach ($typeMatch['seriesMatches'] as $series):
                            foreach ($series['seriesAdWrapper']['matches'] as $match):
                                if ($count >= 3) break;
                                $matchInfo = $match['matchInfo'];
                    ?>
                    <div class="match-card" data-match-id="<?php echo $matchInfo['matchId']; ?>">
                        <div class="match-header">
                            <span class="match-type <?php echo getMatchTypeBadge($matchInfo['matchFormat']); ?>">
                                <?php echo strtoupper($matchInfo['matchFormat']); ?>
                            </span>
                            <span class="match-status <?php echo isMatchLive($matchInfo['status']) ? 'live' : ''; ?>">
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
                    <?php 
                                $count++;
                            endforeach;
                        endforeach;
                    endforeach; 
                    ?>
                </div>
            </div>
        </div>
    </section>
    <?php endif; ?>

    <!-- Recent Matches Section -->
    <?php if ($recentMatches && isset($recentMatches['typeMatches'])): ?>
    <section class="recent-matches-section">
        <div class="card">
            <div class="card-header">
                <h2 class="card-title">
                    <i class="fas fa-history"></i>
                    Recent Matches
                </h2>
                <a href="?page=recent" class="btn btn-secondary">View All Recent</a>
            </div>
            <div class="matches-grid">
                <?php 
                $count = 0;
                foreach ($recentMatches['typeMatches'] as $typeMatch): 
                    if ($count >= 4) break;
                    foreach ($typeMatch['seriesMatches'] as $series):
                        foreach ($series['seriesAdWrapper']['matches'] as $match):
                            if ($count >= 4) break;
                            $matchInfo = $match['matchInfo'];
                ?>
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
                <?php 
                            $count++;
                        endforeach;
                    endforeach;
                endforeach; 
                ?>
            </div>
        </div>
    </section>
    <?php endif; ?>

    <!-- Upcoming Matches Section -->
    <?php if ($upcomingMatches && isset($upcomingMatches['typeMatches'])): ?>
    <section class="upcoming-matches-section">
        <div class="card">
            <div class="card-header">
                <h2 class="card-title">
                    <i class="fas fa-calendar-alt"></i>
                    Upcoming Matches
                </h2>
                <a href="?page=upcoming" class="btn btn-secondary">View All Upcoming</a>
            </div>
            <div class="matches-grid">
                <?php 
                $count = 0;
                foreach ($upcomingMatches['typeMatches'] as $typeMatch): 
                    if ($count >= 4) break;
                    foreach ($typeMatch['seriesMatches'] as $series):
                        foreach ($series['seriesAdWrapper']['matches'] as $match):
                            if ($count >= 4) break;
                            $matchInfo = $match['matchInfo'];
                ?>
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
                </div>
                <?php 
                            $count++;
                        endforeach;
                    endforeach;
                endforeach; 
                ?>
            </div>
        </div>
    </section>
    <?php endif; ?>

    <!-- Quick Stats Section -->
    <section class="quick-stats-section">
        <div class="stats-grid">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-trophy"></i>
                        ICC Rankings
                    </h3>
                </div>
                <div class="quick-rankings">
                    <p>Top Test Batsmen, ODI Players, and T20I Rankings</p>
                    <a href="?page=standings" class="btn btn-primary">View Rankings</a>
                </div>
            </div>
            
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-users"></i>
                        Player Profiles
                    </h3>
                </div>
                <div class="quick-players">
                    <p>Detailed statistics and career information</p>
                    <a href="?page=players" class="btn btn-primary">Browse Players</a>
                </div>
            </div>
            
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-list"></i>
                        Series & Tournaments
                    </h3>
                </div>
                <div class="quick-series">
                    <p>Ongoing and upcoming cricket series</p>
                    <a href="?page=series" class="btn btn-primary">View Series</a>
                </div>
            </div>
        </div>
    </section>
</div>