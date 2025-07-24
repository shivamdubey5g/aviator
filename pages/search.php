<?php
$query = isset($_GET['q']) ? trim($_GET['q']) : '';
$results = [];

if (!empty($query)) {
    // Mock search results (in real app, this would use the API)
    $mockPlayers = [
        ['id' => 1, 'name' => 'Virat Kohli', 'team' => 'India', 'role' => 'Batsman'],
        ['id' => 2, 'name' => 'Babar Azam', 'team' => 'Pakistan', 'role' => 'Batsman'],
        ['id' => 3, 'name' => 'Joe Root', 'team' => 'England', 'role' => 'Batsman'],
        ['id' => 4, 'name' => 'Steve Smith', 'team' => 'Australia', 'role' => 'Batsman'],
        ['id' => 5, 'name' => 'Kane Williamson', 'team' => 'New Zealand', 'role' => 'Batsman'],
    ];
    
    // Filter players based on search query
    $results = array_filter($mockPlayers, function($player) use ($query) {
        return stripos($player['name'], $query) !== false || 
               stripos($player['team'], $query) !== false;
    });
}
?>

<div class="search-page">
    <div class="card">
        <div class="card-header">
            <h1 class="card-title">
                <i class="fas fa-search"></i>
                Search Results
            </h1>
            <?php if (!empty($query)): ?>
                <p>Showing results for: <strong>"<?php echo htmlspecialchars($query); ?>"</strong></p>
            <?php endif; ?>
        </div>
        
        <!-- Enhanced Search Form -->
        <div class="advanced-search">
            <form action="?page=search" method="GET" class="search-form">
                <input type="hidden" name="page" value="search">
                <div class="search-inputs">
                    <div class="search-input-group">
                        <input type="text" name="q" value="<?php echo htmlspecialchars($query); ?>" 
                               placeholder="Search players, teams, series..." class="search-input" required>
                        <button type="submit" class="search-btn">
                            <i class="fas fa-search"></i>
                            Search
                        </button>
                    </div>
                </div>
                
                <div class="search-filters">
                    <select name="type" class="filter-select">
                        <option value="">All Types</option>
                        <option value="players">Players</option>
                        <option value="teams">Teams</option>
                        <option value="series">Series</option>
                    </select>
                    
                    <select name="country" class="filter-select">
                        <option value="">All Countries</option>
                        <option value="India">India</option>
                        <option value="Australia">Australia</option>
                        <option value="England">England</option>
                        <option value="Pakistan">Pakistan</option>
                        <option value="New Zealand">New Zealand</option>
                    </select>
                </div>
            </form>
        </div>
        
        <?php if (!empty($query)): ?>
            <?php if (!empty($results)): ?>
                <div class="search-results">
                    <div class="results-header">
                        <h3>Found <?php echo count($results); ?> result(s)</h3>
                    </div>
                    
                    <div class="results-grid">
                        <?php foreach ($results as $player): ?>
                            <div class="result-card player-result" 
                                 data-player-id="<?php echo $player['id']; ?>" 
                                 data-player-name="<?php echo $player['name']; ?>">
                                <div class="result-avatar">
                                    <?php echo substr($player['name'], 0, 1); ?>
                                </div>
                                
                                <div class="result-info">
                                    <h4 class="result-title"><?php echo formatPlayerName($player['name']); ?></h4>
                                    <p class="result-subtitle"><?php echo $player['team']; ?> • <?php echo $player['role']; ?></p>
                                    <div class="result-type">
                                        <i class="fas fa-user"></i>
                                        Player
                                    </div>
                                </div>
                                
                                <div class="result-actions">
                                    <a href="<?php echo getPlayerUrl($player['id'], $player['name']); ?>" 
                                       class="btn btn-primary btn-sm">
                                        View Profile
                                    </a>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            <?php else: ?>
                <div class="no-results">
                    <div class="no-results-icon">
                        <i class="fas fa-search"></i>
                    </div>
                    <h3>No results found</h3>
                    <p>Sorry, we couldn't find any results for "<strong><?php echo htmlspecialchars($query); ?></strong>"</p>
                    
                    <div class="search-suggestions">
                        <h4>Try searching for:</h4>
                        <div class="suggestion-tags">
                            <a href="?page=search&q=Virat+Kohli" class="suggestion-tag">Virat Kohli</a>
                            <a href="?page=search&q=Babar+Azam" class="suggestion-tag">Babar Azam</a>
                            <a href="?page=search&q=Joe+Root" class="suggestion-tag">Joe Root</a>
                            <a href="?page=search&q=India" class="suggestion-tag">India</a>
                            <a href="?page=search&q=Australia" class="suggestion-tag">Australia</a>
                        </div>
                    </div>
                </div>
            <?php endif; ?>
        <?php else: ?>
            <div class="search-guide">
                <div class="guide-section">
                    <h3><i class="fas fa-lightbulb"></i> Search Tips</h3>
                    <ul>
                        <li>Search for player names (e.g., "Virat Kohli", "Babar Azam")</li>
                        <li>Search for team names (e.g., "India", "Australia")</li>
                        <li>Search for series names (e.g., "World Cup", "Ashes")</li>
                        <li>Use filters to narrow down your search</li>
                    </ul>
                </div>
                
                <div class="guide-section">
                    <h3><i class="fas fa-star"></i> Popular Searches</h3>
                    <div class="popular-searches">
                        <a href="?page=search&q=Virat+Kohli" class="popular-search">Virat Kohli</a>
                        <a href="?page=search&q=Babar+Azam" class="popular-search">Babar Azam</a>
                        <a href="?page=search&q=Joe+Root" class="popular-search">Joe Root</a>
                        <a href="?page=search&q=Steve+Smith" class="popular-search">Steve Smith</a>
                        <a href="?page=search&q=Kane+Williamson" class="popular-search">Kane Williamson</a>
                    </div>
                </div>
            </div>
        <?php endif; ?>
    </div>
</div>

<style>
.advanced-search {
    margin-bottom: 2rem;
    padding: 1.5rem;
    background: #f8f9fa;
    border-radius: 12px;
}

.search-form {
    display: flex;
    flex-direction: column;
    gap: 1rem;
}

.search-input-group {
    display: flex;
    gap: 1rem;
    align-items: center;
}

.search-input {
    flex: 1;
    padding: 0.8rem 1rem;
    border: 2px solid #e1e8ed;
    border-radius: 8px;
    font-size: 1rem;
    outline: none;
    transition: all 0.3s ease;
}

.search-input:focus {
    border-color: #667eea;
    box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
}

.search-btn {
    padding: 0.8rem 1.5rem;
    background: linear-gradient(135deg, #667eea, #764ba2);
    color: white;
    border: none;
    border-radius: 8px;
    cursor: pointer;
    font-weight: 600;
    transition: all 0.3s ease;
}

.search-btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 5px 15px rgba(102, 126, 234, 0.3);
}

.search-filters {
    display: flex;
    gap: 1rem;
    flex-wrap: wrap;
}

.results-header {
    margin-bottom: 1.5rem;
    padding-bottom: 1rem;
    border-bottom: 2px solid #f1f3f4;
}

.results-header h3 {
    color: #667eea;
    font-size: 1.3rem;
}

.results-grid {
    display: grid;
    gap: 1rem;
}

.result-card {
    display: flex;
    align-items: center;
    gap: 1rem;
    padding: 1rem;
    background: white;
    border: 2px solid #f1f3f4;
    border-radius: 12px;
    transition: all 0.3s ease;
    cursor: pointer;
}

.result-card:hover {
    border-color: #667eea;
    transform: translateY(-2px);
    box-shadow: 0 5px 15px rgba(102, 126, 234, 0.1);
}

.result-avatar {
    width: 50px;
    height: 50px;
    border-radius: 50%;
    background: linear-gradient(135deg, #667eea, #764ba2);
    color: white;
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: 600;
    font-size: 1.2rem;
}

.result-info {
    flex: 1;
}

.result-title {
    font-size: 1.2rem;
    font-weight: 600;
    color: #333;
    margin-bottom: 0.3rem;
}

.result-subtitle {
    color: #666;
    font-size: 0.9rem;
    margin-bottom: 0.5rem;
}

.result-type {
    display: inline-flex;
    align-items: center;
    gap: 0.3rem;
    padding: 0.2rem 0.6rem;
    background: #e3f2fd;
    color: #1976d2;
    border-radius: 15px;
    font-size: 0.8rem;
    font-weight: 500;
}

.btn-sm {
    padding: 0.5rem 1rem;
    font-size: 0.9rem;
}

.no-results {
    text-align: center;
    padding: 3rem;
    color: #666;
}

.no-results-icon {
    font-size: 4rem;
    color: #ccc;
    margin-bottom: 1rem;
}

.search-suggestions {
    margin-top: 2rem;
}

.suggestion-tags {
    display: flex;
    gap: 0.5rem;
    flex-wrap: wrap;
    justify-content: center;
    margin-top: 1rem;
}

.suggestion-tag {
    padding: 0.5rem 1rem;
    background: #667eea;
    color: white;
    text-decoration: none;
    border-radius: 20px;
    font-size: 0.9rem;
    transition: all 0.3s ease;
}

.suggestion-tag:hover {
    background: #764ba2;
    transform: translateY(-2px);
}

.search-guide {
    padding: 2rem;
}

.guide-section {
    margin-bottom: 2rem;
}

.guide-section h3 {
    color: #667eea;
    margin-bottom: 1rem;
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

.guide-section ul {
    list-style: none;
    padding-left: 0;
}

.guide-section li {
    padding: 0.5rem 0;
    color: #666;
    position: relative;
    padding-left: 1.5rem;
}

.guide-section li:before {
    content: "•";
    color: #667eea;
    position: absolute;
    left: 0;
    font-weight: bold;
}

.popular-searches {
    display: flex;
    gap: 0.5rem;
    flex-wrap: wrap;
}

.popular-search {
    padding: 0.5rem 1rem;
    background: #f8f9fa;
    color: #333;
    text-decoration: none;
    border-radius: 20px;
    border: 2px solid #e1e8ed;
    transition: all 0.3s ease;
}

.popular-search:hover {
    border-color: #667eea;
    color: #667eea;
}

@media (max-width: 768px) {
    .search-input-group {
        flex-direction: column;
    }
    
    .search-filters {
        flex-direction: column;
    }
    
    .result-card {
        flex-direction: column;
        text-align: center;
    }
    
    .suggestion-tags,
    .popular-searches {
        justify-content: center;
    }
}
</style>