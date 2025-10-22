<?php
session_start();
include_once 'includes/config.php';
include_once 'includes/functions.php';

$page = isset($_GET['page']) ? $_GET['page'] : 'home';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CricLive - Live Cricket Scores & Updates</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">
</head>
<body>
    <!-- Header -->
    <header class="header">
        <div class="container">
            <div class="nav-brand">
                <h1><i class="fas fa-cricket-bat-ball"></i> CricLive</h1>
            </div>
            <nav class="nav-menu">
                <ul>
                    <li><a href="?page=home" class="<?php echo $page == 'home' ? 'active' : ''; ?>">Home</a></li>
                    <li><a href="?page=live" class="<?php echo $page == 'live' ? 'active' : ''; ?>">Live Scores</a></li>
                    <li><a href="?page=recent" class="<?php echo $page == 'recent' ? 'active' : ''; ?>">Recent Matches</a></li>
                    <li><a href="?page=upcoming" class="<?php echo $page == 'upcoming' ? 'active' : ''; ?>">Upcoming</a></li>
                    <li><a href="?page=series" class="<?php echo $page == 'series' ? 'active' : ''; ?>">Series</a></li>
                    <li><a href="?page=standings" class="<?php echo $page == 'standings' ? 'active' : ''; ?>">ICC Rankings</a></li>
                    <li><a href="?page=players" class="<?php echo $page == 'players' ? 'active' : ''; ?>">Players</a></li>
                </ul>
            </nav>
            <div class="search-box">
                <form action="?page=search" method="GET">
                    <input type="hidden" name="page" value="search">
                    <input type="text" name="q" placeholder="Search players, teams..." required>
                    <button type="submit"><i class="fas fa-search"></i></button>
                </form>
            </div>
            <div class="mobile-menu-toggle">
                <i class="fas fa-bars"></i>
            </div>
        </div>
    </header>

    <!-- Main Content -->
    <main class="main-content">
        <div class="container">
            <?php
            switch($page) {
                case 'live':
                    include 'pages/live.php';
                    break;
                case 'recent':
                    include 'pages/recent.php';
                    break;
                case 'upcoming':
                    include 'pages/upcoming.php';
                    break;
                case 'series':
                    include 'pages/series.php';
                    break;
                case 'standings':
                    include 'pages/standings.php';
                    break;
                case 'players':
                    include 'pages/players.php';
                    break;
                case 'player':
                    include 'pages/player-profile.php';
                    break;
                case 'search':
                    include 'pages/search.php';
                    break;
                case 'match':
                    include 'pages/match-details.php';
                    break;
                default:
                    include 'pages/home.php';
            }
            ?>
        </div>
    </main>

    <!-- Footer -->
    <footer class="footer">
        <div class="container">
            <div class="footer-content">
                <div class="footer-section">
                    <h3>CricLive</h3>
                    <p>Your ultimate destination for live cricket scores, updates, and cricket news.</p>
                </div>
                <div class="footer-section">
                    <h4>Quick Links</h4>
                    <ul>
                        <li><a href="?page=live">Live Scores</a></li>
                        <li><a href="?page=upcoming">Upcoming Matches</a></li>
                        <li><a href="?page=series">Series</a></li>
                        <li><a href="?page=standings">ICC Rankings</a></li>
                    </ul>
                </div>
                <div class="footer-section">
                    <h4>Follow Us</h4>
                    <div class="social-links">
                        <a href="#"><i class="fab fa-facebook"></i></a>
                        <a href="#"><i class="fab fa-twitter"></i></a>
                        <a href="#"><i class="fab fa-instagram"></i></a>
                        <a href="#"><i class="fab fa-youtube"></i></a>
                    </div>
                </div>
            </div>
            <div class="footer-bottom">
                <p>&copy; 2024 CricLive. All rights reserved.</p>
            </div>
        </div>
    </footer>

    <script src="js/script.js"></script>
</body>
</html>