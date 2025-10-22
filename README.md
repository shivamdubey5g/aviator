# 🏏 CricLive - Live Cricket Score Website

A comprehensive PHP-based cricket score website similar to Cricbuzz with beautiful design and real-time updates.

## ✨ Features

### 🔴 Live Cricket Scores
- Real-time live match updates
- Auto-refresh every 30 seconds
- Live score indicators with animations
- Ball-by-ball commentary

### 📊 Match Information
- **Recent Matches** - Completed match results
- **Live Matches** - Ongoing matches with live scores
- **Upcoming Matches** - Future match fixtures
- **Match Details** - Detailed scorecards, commentary, statistics

### 🏆 Series & Tournaments
- Ongoing cricket series
- Upcoming tournament schedules
- Series-wise match grouping
- Tournament brackets and standings

### 👨‍💼 Player Profiles
- Detailed player biographies
- Career statistics (Test, ODI, T20I)
- Recent performance history
- Player search functionality
- Clickable player cards

### 🏅 ICC Rankings
- Official ICC player rankings
- Batsmen, Bowlers, All-rounders rankings
- Format-wise rankings (Test, ODI, T20I)
- Interactive ranking tables

### 🔍 Advanced Search
- Player search with filters
- Team-based filtering
- Auto-complete suggestions
- Search history and popular searches

### 📱 Modern UI/UX
- Beautiful responsive design
- Mobile-first approach
- Smooth animations and transitions
- Glass-morphism design elements
- Beautiful gradients and modern typography

## 🛠️ Tech Stack

- **Backend**: PHP 7.4+
- **Frontend**: HTML5, CSS3, JavaScript (ES6+)
- **API**: Cricbuzz Cricket API (RapidAPI)
- **Icons**: Font Awesome 6.0
- **Fonts**: Google Fonts (Poppins)
- **Design**: Responsive CSS Grid & Flexbox

## 🚀 Installation

### Prerequisites
- PHP 7.4 or higher
- Web server (Apache/Nginx)
- cURL extension enabled
- Internet connection for API calls

### Quick Setup

1. **Clone the repository**
```bash
git clone https://github.com/your-username/criclive-cricket-website.git
cd criclive-cricket-website
```

2. **Configure API Key**
   - Open `includes/config.php`
   - Replace the API key with your RapidAPI key:
```php
define('RAPIDAPI_KEY', 'your-rapidapi-key-here');
```

3. **Set up web server**
   - Place files in your web server directory
   - Ensure PHP and cURL are enabled

4. **Create data directory**
```bash
mkdir data
chmod 755 data
```

5. **Access the website**
   - Open `http://localhost/criclive-cricket-website`
   - Or your configured domain

## 🔑 API Configuration

This website uses the Cricbuzz Cricket API from RapidAPI. To get your API key:

1. Visit [RapidAPI Cricbuzz Cricket](https://rapidapi.com/cricketapi/api/cricbuzz-cricket/)
2. Subscribe to the API (free tier available)
3. Copy your API key
4. Update `includes/config.php` with your key

## 📁 Project Structure

```
criclive-cricket-website/
├── index.php              # Main entry point
├── includes/
│   ├── config.php         # Configuration & API settings
│   └── functions.php      # Helper functions & API calls
├── pages/
│   ├── home.php          # Homepage with live scores
│   ├── live.php          # Live matches page
│   ├── recent.php        # Recent matches
│   ├── upcoming.php      # Upcoming fixtures
│   ├── series.php        # Cricket series
│   ├── standings.php     # ICC rankings
│   ├── players.php       # Player listings
│   ├── player-profile.php # Individual player profile
│   ├── search.php        # Search results
│   └── match-details.php # Detailed match view
├── css/
│   └── style.css         # Main stylesheet
├── js/
│   └── script.js         # JavaScript functionality
├── data/                 # Cache directory (auto-created)
└── README.md            # This file
```

## 🎨 Design Features

- **Modern Glass-morphism** design
- **Responsive layout** for all devices
- **Beautiful gradients** and animations
- **Live indicators** with pulsing effects
- **Interactive cards** with hover effects
- **Smooth transitions** throughout
- **Mobile-optimized** navigation

## 📱 Mobile Responsive

The website is fully responsive and works perfectly on:
- 📱 Mobile phones (320px+)
- 📱 Tablets (768px+)
- 💻 Laptops (1024px+)
- 🖥️ Desktop computers (1200px+)

## 🔧 Customization

### Changing Colors
Edit the CSS variables in `css/style.css`:
```css
:root {
  --primary-color: #667eea;
  --secondary-color: #764ba2;
  --accent-color: #ff6b6b;
}
```

### Adding New Pages
1. Create new PHP file in `pages/` directory
2. Add route in `index.php` switch statement
3. Add navigation link in header

### Modifying API Endpoints
Update the functions in `includes/functions.php` to add new API calls.

## 🚀 Performance Features

- **Caching System** - API responses cached for 5 minutes
- **Lazy Loading** - Images and content loaded on demand
- **Minified Assets** - Optimized CSS and JavaScript
- **CDN Integration** - Font Awesome and Google Fonts via CDN

## 🤝 Contributing

1. Fork the repository
2. Create feature branch (`git checkout -b feature/amazing-feature`)
3. Commit changes (`git commit -m 'Add amazing feature'`)
4. Push to branch (`git push origin feature/amazing-feature`)
5. Open a Pull Request

## 📄 License

This project is licensed under the MIT License - see the [LICENSE](LICENSE) file for details.

## 🙏 Acknowledgments

- [Cricbuzz Cricket API](https://rapidapi.com/cricketapi/api/cricbuzz-cricket/) for providing cricket data
- [Font Awesome](https://fontawesome.com/) for beautiful icons
- [Google Fonts](https://fonts.google.com/) for typography
- Cricket community for inspiration

## 📞 Support

If you have any questions or need help:
- Create an issue on GitHub
- Contact: your-email@example.com

---

**Made with ❤️ for Cricket Fans**

🏏 Enjoy live cricket scores with CricLive!
