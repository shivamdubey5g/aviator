<?php
/**
 * Test script for Digital Reliance Processing System
 */

require_once 'config/config.php';
require_once 'src/DigitalRelianceProcessor.php';
require_once 'src/DataValidator.php';
require_once 'src/RelianceCalculator.php';
require_once 'src/Logger.php';

echo "=== Digital Reliance Processor Test ===\n\n";

try {
    // Load test data
    $testData = json_decode(file_get_contents('example_data.json'), true);
    
    if (!$testData) {
        throw new Exception('Failed to load test data');
    }
    
    echo "1. Loading test data... ✓\n";
    echo "   - Assets: " . count($testData['assets']) . "\n";
    echo "   - Dependencies: " . count($testData['dependencies']) . "\n\n";
    
    // Initialize processor
    $processor = new DigitalRelianceProcessor();
    echo "2. Initializing processor... ✓\n\n";
    
    // Process the data
    echo "3. Processing digital reliance data...\n";
    $result = $processor->processRelianceData($testData);
    
    if ($result['success']) {
        echo "   ✓ Processing successful!\n\n";
        
        // Display results
        echo "4. Results:\n";
        echo "   - Reliability Score: " . $result['data']['reliability_score'] . "%\n";
        echo "   - Processing Time: " . $result['data']['processing_time'] . "\n";
        
        echo "\n   Individual Metrics:\n";
        $metrics = $result['data']['reliance_metrics'];
        echo "   - Availability: " . $metrics['availability_score'] . "%\n";
        echo "   - Performance: " . $metrics['performance_score'] . "%\n";
        echo "   - Security: " . $metrics['security_score'] . "%\n";
        echo "   - Scalability: " . $metrics['scalability_score'] . "%\n";
        echo "   - Maintainability: " . $metrics['maintainability_score'] . "%\n";
        echo "   - Dependency Risk: " . $metrics['dependency_risk'] . "%\n";
        echo "   - Overall Health: " . $metrics['overall_health'] . "%\n";
        
    } else {
        echo "   ✗ Processing failed: " . $result['error'] . "\n";
        if (isset($result['details'])) {
            echo "   Details: " . implode(', ', $result['details']) . "\n";
        }
    }
    
    echo "\n5. Testing validation with invalid data...\n";
    
    // Test with invalid data
    $invalidData = ['invalid' => 'data'];
    $invalidResult = $processor->processRelianceData($invalidData);
    
    if (!$invalidResult['success']) {
        echo "   ✓ Validation correctly rejected invalid data\n";
        echo "   Error: " . $invalidResult['error'] . "\n";
    } else {
        echo "   ✗ Validation should have failed\n";
    }
    
    echo "\n6. Testing statistics...\n";
    $stats = $processor->getStatistics();
    echo "   - Total Processed: " . $stats['total_processed'] . "\n";
    echo "   - Average Reliability: " . $stats['average_reliability'] . "\n";
    echo "   - Last Processed: " . $stats['last_processed'] . "\n";
    
    echo "\n=== Test completed successfully! ===\n";
    
} catch (Exception $e) {
    echo "✗ Test failed: " . $e->getMessage() . "\n";
    echo "Stack trace:\n" . $e->getTraceAsString() . "\n";
}
?>