# Digital Reliance Processing System

A comprehensive PHP-based system for analyzing and evaluating the reliability of digital systems and infrastructure.

## Overview

The Digital Reliance Processing System provides a robust framework for assessing the reliability, performance, and overall health of digital assets, dependencies, and system components. It calculates various metrics including availability, performance, security, scalability, and maintainability scores to provide a comprehensive reliability assessment.

## Features

- **Comprehensive Analysis**: Evaluates multiple aspects of digital systems including availability, performance, security, scalability, and maintainability
- **Dependency Risk Assessment**: Analyzes system dependencies and calculates associated risks
- **Data Validation**: Robust input validation to ensure data integrity
- **Web Interface**: User-friendly HTML interface for easy data input and result visualization
- **JSON API**: RESTful API for programmatic access
- **Logging**: Comprehensive logging system for monitoring and debugging
- **Configurable**: Flexible configuration options for different environments

## System Architecture

### Core Components

1. **DigitalRelianceProcessor**: Main processing engine that orchestrates the analysis
2. **DataValidator**: Validates input data structure and content
3. **RelianceCalculator**: Performs reliability calculations and scoring
4. **Logger**: Handles system logging and monitoring

### Scoring Metrics

The system evaluates five key areas:

- **Availability Score** (30% weight): Based on asset status and uptime metrics
- **Performance Score** (25% weight): Calculated from CPU, memory usage, and response times
- **Security Score** (20% weight): Evaluates security incidents and asset criticality
- **Scalability Score** (15% weight): Assesses system's ability to scale
- **Maintainability Score** (10% weight): Based on asset update frequency and maintenance

## Installation

1. Clone or download the project files
2. Ensure PHP 7.4+ is installed
3. Configure your web server to serve the project directory
4. Update `config/config.php` with your specific settings

## Usage

### Web Interface

1. Open `index.php` in your web browser
2. Enter your system data in JSON format
3. Click "Process Digital Reliance" to analyze the data
4. View the comprehensive results including individual scores and overall reliability

### API Usage

Send a POST request to `index.php` with JSON data:

```bash
curl -X POST -H "Content-Type: application/json" \
     -d @example_data.json \
     http://your-domain/index.php
```

### Command Line Testing

Run the test script to verify system functionality:

```bash
php test.php
```

## Data Format

The system expects JSON data with the following structure:

```json
{
    "assets": [
        {
            "id": "unique-asset-id",
            "type": "server|database|service|application|network",
            "status": "active|inactive|maintenance|error",
            "last_updated": "YYYY-MM-DD HH:MM:SS"
        }
    ],
    "dependencies": [
        {
            "source": "source-asset-id",
            "target": "target-asset-id",
            "type": "critical|important|optional"
        }
    ],
    "reliability": {
        "uptime": 99.5,
        "availability": 99.2,
        "response_time": 150,
        "error_rate": 0.02,
        "security_incidents": 0
    },
    "performance": {
        "cpu_usage": 45,
        "memory_usage": 60,
        "disk_usage": 35,
        "network_latency": 25
    }
}
```

## Configuration

Edit `config/config.php` to customize:

- Database settings
- Reliability thresholds
- Processing limits
- Logging configuration
- Debug mode settings

## Example Output

```json
{
    "success": true,
    "data": {
        "reliability_score": 85.67,
        "reliance_metrics": {
            "availability_score": 95.0,
            "performance_score": 80.0,
            "security_score": 85.0,
            "scalability_score": 75.0,
            "maintainability_score": 70.0,
            "dependency_risk": 15.0,
            "overall_health": 81.0
        },
        "timestamp": "2024-01-15 12:30:45",
        "processing_time": "45.67ms"
    }
}
```

## File Structure

```
├── index.php              # Main entry point
├── config/
│   └── config.php         # Configuration settings
├── src/
│   ├── DigitalRelianceProcessor.php
│   ├── DataValidator.php
│   ├── RelianceCalculator.php
│   └── Logger.php
├── views/
│   └── index.html         # Web interface
├── logs/                  # Log files (created automatically)
├── example_data.json      # Sample data for testing
├── test.php              # Test script
└── README.md             # This file
```

## Requirements

- PHP 7.4 or higher
- Web server (Apache, Nginx, etc.)
- Write permissions for logs directory

## License

This project is open source and available under the MIT License.

## Support

For issues, questions, or contributions, please refer to the project documentation or contact the development team.
