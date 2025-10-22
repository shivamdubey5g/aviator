<?php
// Mock player data (in real app, this would come from API)
$players = [
    ['id' => 1, 'name' => 'Virat Kohli', 'team' => 'India', 'role' => 'Batsman', 'rating' => 890],
    ['id' => 2, 'name' => 'Babar Azam', 'team' => 'Pakistan', 'role' => 'Batsman', 'rating' => 865],
    ['id' => 3, 'name' => 'Joe Root', 'team' => 'England', 'role' => 'Batsman', 'rating' => 838],
    ['id' => 4, 'name' => 'Steve Smith', 'team' => 'Australia', 'role' => 'Batsman', 'rating' => 820],
    ['id' => 5, 'name' => 'Kane Williamson', 'team' => 'New Zealand', 'role' => 'Batsman', 'rating' => 810],
    ['id' => 6, 'name' => 'Pat Cummins', 'team' => 'Australia', 'role' => 'Bowler', 'rating' => 785],
    ['id' => 7, 'name' => 'Jasprit Bumrah', 'team' => 'India', 'role' => 'Bowler', 'rating' => 780],
    ['id' => 8, 'name' => 'Trent Boult', 'team' => 'New Zealand', 'role' => 'Bowler', 'rating' => 775],
];
?>

<div class="players-page">
    <div class="card">
        <div class="card-header">
            <h1 class="card-title">
                <i class="fas fa-users"></i>
                Cricket Players
            </h1>
            <p>Browse cricket player profiles and statistics</p>
        </div>
        
        <!-- Search and Filter -->
        <div class="player-filters">
            <div class="search-container">
                <input type="text" id="playerSearch" placeholder="Search players..." class="search-input">
                <i class="fas fa-search search-icon"></i>
            </div>
            
            <div class="filter-container">
                <select id="teamFilter" class="filter-select">
                    <option value="">All Teams</option>
                    <option value="India">India</option>
                    <option value="Australia">Australia</option>
                    <option value="England">England</option>
                    <option value="Pakistan">Pakistan</option>
                    <option value="New Zealand">New Zealand</option>
                </select>
                
                <select id="roleFilter" class="filter-select">
                    <option value="">All Roles</option>
                    <option value="Batsman">Batsman</option>
                    <option value="Bowler">Bowler</option>
                    <option value="All-rounder">All-rounder</option>
                    <option value="Wicket-keeper">Wicket-keeper</option>
                </select>
            </div>
        </div>
        
        <!-- Players Grid -->
        <div class="players-grid" id="playersGrid">
            <?php foreach ($players as $player): ?>
                <div class="player-card" data-player-id="<?php echo $player['id']; ?>" data-player-name="<?php echo $player['name']; ?>">
                    <div class="player-avatar">
                        <?php echo substr($player['name'], 0, 1); ?>
                    </div>
                    
                    <div class="player-info">
                        <h3 class="player-name"><?php echo formatPlayerName($player['name']); ?></h3>
                        <p class="player-team"><?php echo $player['team']; ?></p>
                        <p class="player-role"><?php echo $player['role']; ?></p>
                    </div>
                    
                    <div class="player-stats">
                        <div class="stat-item">
                            <div class="stat-value"><?php echo $player['rating']; ?></div>
                            <div class="stat-label">Rating</div>
                        </div>
                    </div>
                    
                    <div class="player-actions">
                        <a href="<?php echo getPlayerUrl($player['id'], $player['name']); ?>" class="btn btn-primary">
                            View Profile
                        </a>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
        
        <!-- Load More Button -->
        <div class="load-more-container">
            <button class="btn btn-secondary" id="loadMoreBtn">
                <i class="fas fa-plus"></i>
                Load More Players
            </button>
        </div>
    </div>
</div>

<style>
.player-filters {
    display: flex;
    gap: 2rem;
    margin-bottom: 2rem;
    align-items: center;
    flex-wrap: wrap;
}

.search-container {
    position: relative;
    flex: 1;
    min-width: 250px;
}

.search-input {
    width: 100%;
    padding: 0.7rem 1rem 0.7rem 2.5rem;
    border: 2px solid #e1e8ed;
    border-radius: 25px;
    outline: none;
    transition: all 0.3s ease;
}

.search-input:focus {
    border-color: #667eea;
    box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
}

.search-icon {
    position: absolute;
    left: 1rem;
    top: 50%;
    transform: translateY(-50%);
    color: #666;
}

.filter-container {
    display: flex;
    gap: 1rem;
}

.filter-select {
    padding: 0.7rem 1rem;
    border: 2px solid #e1e8ed;
    border-radius: 8px;
    background: white;
    outline: none;
    cursor: pointer;
    transition: all 0.3s ease;
}

.filter-select:focus {
    border-color: #667eea;
}

.players-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
    gap: 1.5rem;
    margin-bottom: 2rem;
}

.player-info {
    text-align: center;
    margin: 1rem 0;
}

.player-role {
    color: #667eea;
    font-weight: 500;
    font-size: 0.9rem;
}

.player-actions {
    text-align: center;
    margin-top: 1rem;
}

.load-more-container {
    text-align: center;
    margin-top: 2rem;
}

@media (max-width: 768px) {
    .player-filters {
        flex-direction: column;
        align-items: stretch;
    }
    
    .filter-container {
        flex-direction: column;
    }
    
    .players-grid {
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
    }
}
</style>

<script>
// Player search and filter functionality
document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.getElementById('playerSearch');
    const teamFilter = document.getElementById('teamFilter');
    const roleFilter = document.getElementById('roleFilter');
    const playersGrid = document.getElementById('playersGrid');
    const playerCards = playersGrid.querySelectorAll('.player-card');
    
    function filterPlayers() {
        const searchTerm = searchInput.value.toLowerCase();
        const selectedTeam = teamFilter.value;
        const selectedRole = roleFilter.value;
        
        playerCards.forEach(card => {
            const playerName = card.querySelector('.player-name').textContent.toLowerCase();
            const playerTeam = card.querySelector('.player-team').textContent;
            const playerRole = card.querySelector('.player-role').textContent;
            
            const matchesSearch = playerName.includes(searchTerm);
            const matchesTeam = !selectedTeam || playerTeam === selectedTeam;
            const matchesRole = !selectedRole || playerRole === selectedRole;
            
            if (matchesSearch && matchesTeam && matchesRole) {
                card.style.display = 'block';
            } else {
                card.style.display = 'none';
            }
        });
    }
    
    searchInput.addEventListener('input', filterPlayers);
    teamFilter.addEventListener('change', filterPlayers);
    roleFilter.addEventListener('change', filterPlayers);
    
    // Load more functionality (mock)
    document.getElementById('loadMoreBtn').addEventListener('click', function() {
        this.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Loading...';
        
        setTimeout(() => {
            this.innerHTML = '<i class="fas fa-plus"></i> Load More Players';
            showNotification('More players loaded!', 'success');
        }, 1500);
    });
});
</script>