// Mobile Menu Toggle
document.addEventListener('DOMContentLoaded', function() {
    const mobileMenuToggle = document.querySelector('.mobile-menu-toggle');
    const navMenu = document.querySelector('.nav-menu');
    
    if (mobileMenuToggle && navMenu) {
        mobileMenuToggle.addEventListener('click', function() {
            navMenu.classList.toggle('active');
            const icon = this.querySelector('i');
            icon.classList.toggle('fa-bars');
            icon.classList.toggle('fa-times');
        });
    }
    
    // Close mobile menu when clicking on a link
    const navLinks = document.querySelectorAll('.nav-menu a');
    navLinks.forEach(link => {
        link.addEventListener('click', () => {
            navMenu.classList.remove('active');
            const icon = mobileMenuToggle.querySelector('i');
            icon.classList.add('fa-bars');
            icon.classList.remove('fa-times');
        });
    });
});

// Live Score Auto Refresh
function refreshLiveScores() {
    const liveScoreContainers = document.querySelectorAll('.live-scores-container');
    
    liveScoreContainers.forEach(container => {
        // Add loading indicator
        const loadingDiv = document.createElement('div');
        loadingDiv.className = 'loading';
        loadingDiv.innerHTML = '<div class="spinner"></div>';
        
        // Refresh every 30 seconds for live matches
        setInterval(() => {
            if (document.querySelector('.match-status.live')) {
                fetch(window.location.href)
                    .then(response => response.text())
                    .then(html => {
                        const parser = new DOMParser();
                        const newDoc = parser.parseFromString(html, 'text/html');
                        const newContainer = newDoc.querySelector('.live-scores-container');
                        
                        if (newContainer) {
                            container.innerHTML = newContainer.innerHTML;
                            addMatchCardListeners();
                        }
                    })
                    .catch(error => console.log('Refresh failed:', error));
            }
        }, 30000); // 30 seconds
    });
}

// Add click listeners to match cards
function addMatchCardListeners() {
    const matchCards = document.querySelectorAll('.match-card');
    
    matchCards.forEach(card => {
        card.addEventListener('click', function() {
            const matchId = this.dataset.matchId;
            if (matchId) {
                window.location.href = `?page=match&id=${matchId}`;
            }
        });
    });
}

// Add click listeners to player cards
function addPlayerCardListeners() {
    const playerCards = document.querySelectorAll('.player-card');
    
    playerCards.forEach(card => {
        card.addEventListener('click', function() {
            const playerId = this.dataset.playerId;
            const playerName = this.dataset.playerName;
            if (playerId) {
                window.location.href = `?page=player&id=${playerId}&name=${encodeURIComponent(playerName)}`;
            }
        });
    });
}

// Search functionality
function initializeSearch() {
    const searchForm = document.querySelector('.search-box form');
    const searchInput = document.querySelector('.search-box input');
    
    if (searchForm && searchInput) {
        // Auto-complete functionality
        let searchTimeout;
        
        searchInput.addEventListener('input', function() {
            clearTimeout(searchTimeout);
            const query = this.value.trim();
            
            if (query.length >= 2) {
                searchTimeout = setTimeout(() => {
                    showSearchSuggestions(query);
                }, 300);
            } else {
                hideSearchSuggestions();
            }
        });
        
        // Hide suggestions when clicking outside
        document.addEventListener('click', function(e) {
            if (!e.target.closest('.search-box')) {
                hideSearchSuggestions();
            }
        });
    }
}

// Show search suggestions
function showSearchSuggestions(query) {
    // Create suggestions dropdown if it doesn't exist
    let suggestionsDiv = document.querySelector('.search-suggestions');
    
    if (!suggestionsDiv) {
        suggestionsDiv = document.createElement('div');
        suggestionsDiv.className = 'search-suggestions';
        suggestionsDiv.style.cssText = `
            position: absolute;
            top: 100%;
            left: 0;
            right: 0;
            background: white;
            border: 1px solid #e1e8ed;
            border-radius: 8px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
            z-index: 1000;
            max-height: 200px;
            overflow-y: auto;
        `;
        document.querySelector('.search-box').appendChild(suggestionsDiv);
    }
    
    // Mock suggestions (in real app, this would be an API call)
    const suggestions = [
        'Virat Kohli', 'Rohit Sharma', 'MS Dhoni', 'Babar Azam', 
        'Joe Root', 'Steve Smith', 'Kane Williamson', 'David Warner'
    ].filter(name => name.toLowerCase().includes(query.toLowerCase()));
    
    suggestionsDiv.innerHTML = suggestions.map(suggestion => 
        `<div class="suggestion-item" style="padding: 10px; cursor: pointer; border-bottom: 1px solid #f1f3f4;">
            ${suggestion}
        </div>`
    ).join('');
    
    // Add click listeners to suggestions
    suggestionsDiv.querySelectorAll('.suggestion-item').forEach(item => {
        item.addEventListener('click', function() {
            document.querySelector('.search-box input').value = this.textContent;
            hideSearchSuggestions();
            document.querySelector('.search-box form').submit();
        });
    });
}

// Hide search suggestions
function hideSearchSuggestions() {
    const suggestionsDiv = document.querySelector('.search-suggestions');
    if (suggestionsDiv) {
        suggestionsDiv.remove();
    }
}

// Smooth scroll to top
function addScrollToTop() {
    const scrollBtn = document.createElement('button');
    scrollBtn.innerHTML = '<i class="fas fa-arrow-up"></i>';
    scrollBtn.className = 'scroll-to-top';
    scrollBtn.style.cssText = `
        position: fixed;
        bottom: 20px;
        right: 20px;
        width: 50px;
        height: 50px;
        background: linear-gradient(135deg, #667eea, #764ba2);
        color: white;
        border: none;
        border-radius: 50%;
        cursor: pointer;
        display: none;
        z-index: 1000;
        transition: all 0.3s ease;
    `;
    
    document.body.appendChild(scrollBtn);
    
    // Show/hide scroll button
    window.addEventListener('scroll', function() {
        if (window.pageYOffset > 300) {
            scrollBtn.style.display = 'block';
        } else {
            scrollBtn.style.display = 'none';
        }
    });
    
    // Scroll to top functionality
    scrollBtn.addEventListener('click', function() {
        window.scrollTo({
            top: 0,
            behavior: 'smooth'
        });
    });
}

// Add fade-in animation to cards
function addFadeInAnimation() {
    const cards = document.querySelectorAll('.card, .match-card, .player-card, .series-card');
    
    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add('fade-in');
            }
        });
    }, {
        threshold: 0.1
    });
    
    cards.forEach(card => {
        observer.observe(card);
    });
}

// Format numbers with commas
function formatNumber(num) {
    return num.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
}

// Time formatting
function formatTime(timestamp) {
    const date = new Date(timestamp);
    const now = new Date();
    const diff = now - date;
    
    const minutes = Math.floor(diff / 60000);
    const hours = Math.floor(diff / 3600000);
    const days = Math.floor(diff / 86400000);
    
    if (minutes < 1) return 'Just now';
    if (minutes < 60) return `${minutes}m ago`;
    if (hours < 24) return `${hours}h ago`;
    return `${days}d ago`;
}

// Initialize tooltips
function initializeTooltips() {
    const tooltipElements = document.querySelectorAll('[data-tooltip]');
    
    tooltipElements.forEach(element => {
        element.addEventListener('mouseenter', function() {
            const tooltip = document.createElement('div');
            tooltip.className = 'tooltip';
            tooltip.textContent = this.dataset.tooltip;
            tooltip.style.cssText = `
                position: absolute;
                background: rgba(0,0,0,0.8);
                color: white;
                padding: 5px 10px;
                border-radius: 4px;
                font-size: 12px;
                z-index: 1000;
                pointer-events: none;
            `;
            
            document.body.appendChild(tooltip);
            
            const rect = this.getBoundingClientRect();
            tooltip.style.left = rect.left + (rect.width / 2) - (tooltip.offsetWidth / 2) + 'px';
            tooltip.style.top = rect.top - tooltip.offsetHeight - 5 + 'px';
        });
        
        element.addEventListener('mouseleave', function() {
            const tooltip = document.querySelector('.tooltip');
            if (tooltip) tooltip.remove();
        });
    });
}

// Copy to clipboard functionality
function copyToClipboard(text) {
    navigator.clipboard.writeText(text).then(() => {
        showNotification('Copied to clipboard!', 'success');
    }).catch(() => {
        showNotification('Failed to copy', 'error');
    });
}

// Show notification
function showNotification(message, type = 'info') {
    const notification = document.createElement('div');
    notification.className = `notification ${type}`;
    notification.textContent = message;
    notification.style.cssText = `
        position: fixed;
        top: 20px;
        right: 20px;
        padding: 15px 20px;
        border-radius: 8px;
        color: white;
        z-index: 1000;
        animation: slideIn 0.3s ease;
    `;
    
    if (type === 'success') notification.style.background = '#2ed573';
    if (type === 'error') notification.style.background = '#ff4757';
    if (type === 'info') notification.style.background = '#667eea';
    
    document.body.appendChild(notification);
    
    setTimeout(() => {
        notification.remove();
    }, 3000);
}

// Initialize all functionality when DOM is loaded
document.addEventListener('DOMContentLoaded', function() {
    addMatchCardListeners();
    addPlayerCardListeners();
    initializeSearch();
    addScrollToTop();
    addFadeInAnimation();
    initializeTooltips();
    refreshLiveScores();
    
    // Add loading states to buttons
    const buttons = document.querySelectorAll('.btn');
    buttons.forEach(btn => {
        btn.addEventListener('click', function() {
            if (!this.classList.contains('loading')) {
                this.classList.add('loading');
                this.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Loading...';
            }
        });
    });
});

// Service Worker for offline functionality (optional)
if ('serviceWorker' in navigator) {
    window.addEventListener('load', function() {
        navigator.serviceWorker.register('/sw.js')
            .then(registration => console.log('SW registered'))
            .catch(error => console.log('SW registration failed'));
    });
}