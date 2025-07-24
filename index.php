<?php
/**
 * Digital Reliance Processing System
 * Main Entry Point
 */

require_once 'config/config.php';
require_once 'src/DigitalRelianceProcessor.php';
require_once 'src/DataValidator.php';
require_once 'src/RelianceCalculator.php';

try {
    $processor = new DigitalRelianceProcessor();
    
    // Handle different request methods
    $method = $_SERVER['REQUEST_METHOD'] ?? 'GET';
    
    switch ($method) {
        case 'GET':
            // Display the main interface
            include 'views/index.html';
            break;
            
        case 'POST':
            // Process digital reliance data
            $input = json_decode(file_get_contents('php://input'), true);
            $result = $processor->processRelianceData($input);
            
            header('Content-Type: application/json');
            echo json_encode($result);
            break;
            
        default:
            http_response_code(405);
            echo json_encode(['error' => 'Method not allowed']);
    }
    
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode([
        'error' => 'Internal server error',
        'message' => $e->getMessage()
    ]);
}
?>