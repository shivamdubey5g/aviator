<?php
/**
 * Reliance Calculator for Digital Systems
 */

class RelianceCalculator
{
    private $weights = [
        'availability' => 0.3,
        'performance' => 0.25,
        'security' => 0.2,
        'scalability' => 0.15,
        'maintainability' => 0.1
    ];
    
    /**
     * Calculate digital reliance metrics
     *
     * @param array $components System components
     * @return array Calculated metrics
     */
    public function calculateReliance($components)
    {
        $metrics = [
            'availability_score' => $this->calculateAvailabilityScore($components),
            'performance_score' => $this->calculatePerformanceScore($components),
            'security_score' => $this->calculateSecurityScore($components),
            'scalability_score' => $this->calculateScalabilityScore($components),
            'maintainability_score' => $this->calculateMaintainabilityScore($components),
            'dependency_risk' => $this->calculateDependencyRisk($components),
            'overall_health' => 0 // Will be calculated later
        ];
        
        // Calculate overall health based on individual scores
        $metrics['overall_health'] = $this->calculateOverallHealth($metrics);
        
        return $metrics;
    }
    
    /**
     * Calculate reliability score
     *
     * @param array $metrics Reliance metrics
     * @return float Reliability score (0-100)
     */
    public function calculateReliabilityScore($metrics)
    {
        $weightedScore = 0;
        
        $weightedScore += $metrics['availability_score'] * $this->weights['availability'];
        $weightedScore += $metrics['performance_score'] * $this->weights['performance'];
        $weightedScore += $metrics['security_score'] * $this->weights['security'];
        $weightedScore += $metrics['scalability_score'] * $this->weights['scalability'];
        $weightedScore += $metrics['maintainability_score'] * $this->weights['maintainability'];
        
        // Apply dependency risk penalty
        $dependencyPenalty = $metrics['dependency_risk'] * 0.1;
        $weightedScore = max(0, $weightedScore - $dependencyPenalty);
        
        return round($weightedScore, 2);
    }
    
    /**
     * Calculate availability score
     *
     * @param array $components System components
     * @return float Availability score (0-100)
     */
    private function calculateAvailabilityScore($components)
    {
        if (empty($components['digital_assets'])) {
            return 0;
        }
        
        $totalAssets = count($components['digital_assets']);
        $activeAssets = 0;
        
        foreach ($components['digital_assets'] as $asset) {
            if ($asset['status'] === 'active') {
                $activeAssets++;
            }
        }
        
        $baseScore = ($activeAssets / $totalAssets) * 100;
        
        // Apply reliability factors if available
        if (isset($components['reliability_factors']['uptime'])) {
            $uptimeScore = $components['reliability_factors']['uptime'];
            $baseScore = ($baseScore + $uptimeScore) / 2;
        }
        
        return round($baseScore, 2);
    }
    
    /**
     * Calculate performance score
     *
     * @param array $components System components
     * @return float Performance score (0-100)
     */
    private function calculatePerformanceScore($components)
    {
        $performanceMetrics = $components['performance_metrics'] ?? [];
        
        if (empty($performanceMetrics)) {
            return 75; // Default neutral score
        }
        
        $scores = [];
        
        // CPU usage score (lower is better)
        if (isset($performanceMetrics['cpu_usage'])) {
            $scores[] = max(0, 100 - $performanceMetrics['cpu_usage']);
        }
        
        // Memory usage score (lower is better)
        if (isset($performanceMetrics['memory_usage'])) {
            $scores[] = max(0, 100 - $performanceMetrics['memory_usage']);
        }
        
        // Response time score (lower is better, assume milliseconds)
        if (isset($performanceMetrics['response_time'])) {
            $responseTime = $performanceMetrics['response_time'];
            if ($responseTime <= 100) {
                $scores[] = 100;
            } elseif ($responseTime <= 500) {
                $scores[] = 80;
            } elseif ($responseTime <= 1000) {
                $scores[] = 60;
            } elseif ($responseTime <= 2000) {
                $scores[] = 40;
            } else {
                $scores[] = 20;
            }
        }
        
        return empty($scores) ? 75 : round(array_sum($scores) / count($scores), 2);
    }
    
    /**
     * Calculate security score
     *
     * @param array $components System components
     * @return float Security score (0-100)
     */
    private function calculateSecurityScore($components)
    {
        // Base security score
        $securityScore = 80; // Default assumption of good security
        
        // Check for security-related reliability factors
        if (isset($components['reliability_factors']['security_incidents'])) {
            $incidents = $components['reliability_factors']['security_incidents'];
            $securityScore -= min(50, $incidents * 10); // Penalty for incidents
        }
        
        // Check asset types for security implications
        $securityCriticalTypes = ['database', 'server'];
        $criticalAssets = 0;
        $totalAssets = count($components['digital_assets']);
        
        foreach ($components['digital_assets'] as $asset) {
            if (in_array($asset['type'], $securityCriticalTypes)) {
                $criticalAssets++;
            }
        }
        
        if ($totalAssets > 0) {
            $criticalRatio = $criticalAssets / $totalAssets;
            // Higher ratio of critical assets requires better security
            $securityScore = $securityScore * (1 - ($criticalRatio * 0.2));
        }
        
        return round(max(0, $securityScore), 2);
    }
    
    /**
     * Calculate scalability score
     *
     * @param array $components System components
     * @return float Scalability score (0-100)
     */
    private function calculateScalabilityScore($components)
    {
        $scalabilityScore = 70; // Default moderate scalability
        
        // Check performance metrics for scalability indicators
        if (isset($components['performance_metrics']['cpu_usage'])) {
            $cpuUsage = $components['performance_metrics']['cpu_usage'];
            if ($cpuUsage > 80) {
                $scalabilityScore -= 20; // High CPU usage indicates scaling issues
            } elseif ($cpuUsage < 30) {
                $scalabilityScore += 10; // Low usage indicates good headroom
            }
        }
        
        if (isset($components['performance_metrics']['memory_usage'])) {
            $memoryUsage = $components['performance_metrics']['memory_usage'];
            if ($memoryUsage > 85) {
                $scalabilityScore -= 15; // High memory usage
            }
        }
        
        // Consider asset diversity for scalability
        $assetTypes = [];
        foreach ($components['digital_assets'] as $asset) {
            $assetTypes[] = $asset['type'];
        }
        $uniqueTypes = count(array_unique($assetTypes));
        
        if ($uniqueTypes > 3) {
            $scalabilityScore += 10; // Diverse architecture is more scalable
        }
        
        return round(max(0, min(100, $scalabilityScore)), 2);
    }
    
    /**
     * Calculate maintainability score
     *
     * @param array $components System components
     * @return float Maintainability score (0-100)
     */
    private function calculateMaintainabilityScore($components)
    {
        $maintainabilityScore = 75; // Default good maintainability
        
        // Check asset update frequency
        $now = time();
        $outdatedAssets = 0;
        
        foreach ($components['digital_assets'] as $asset) {
            if (isset($asset['last_updated'])) {
                $lastUpdated = strtotime($asset['last_updated']);
                $daysSinceUpdate = ($now - $lastUpdated) / (24 * 3600);
                
                if ($daysSinceUpdate > 90) { // More than 3 months
                    $outdatedAssets++;
                }
            }
        }
        
        if (count($components['digital_assets']) > 0) {
            $outdatedRatio = $outdatedAssets / count($components['digital_assets']);
            $maintainabilityScore -= $outdatedRatio * 30; // Penalty for outdated assets
        }
        
        return round(max(0, $maintainabilityScore), 2);
    }
    
    /**
     * Calculate dependency risk
     *
     * @param array $components System components
     * @return float Dependency risk score (0-100, higher is worse)
     */
    private function calculateDependencyRisk($components)
    {
        if (empty($components['dependencies'])) {
            return 0; // No dependencies, no risk
        }
        
        $totalDependencies = count($components['dependencies']);
        $criticalDependencies = 0;
        
        foreach ($components['dependencies'] as $dependency) {
            if ($dependency['type'] === 'critical') {
                $criticalDependencies++;
            }
        }
        
        // Risk increases with number of critical dependencies
        $riskScore = ($criticalDependencies / max(1, $totalDependencies)) * 50;
        
        // Additional risk for high total dependency count
        if ($totalDependencies > 10) {
            $riskScore += min(25, ($totalDependencies - 10) * 2);
        }
        
        return round($riskScore, 2);
    }
    
    /**
     * Calculate overall health score
     *
     * @param array $metrics Individual metric scores
     * @return float Overall health score (0-100)
     */
    private function calculateOverallHealth($metrics)
    {
        $scores = [
            $metrics['availability_score'],
            $metrics['performance_score'],
            $metrics['security_score'],
            $metrics['scalability_score'],
            $metrics['maintainability_score']
        ];
        
        $averageScore = array_sum($scores) / count($scores);
        
        // Apply dependency risk penalty
        $dependencyPenalty = $metrics['dependency_risk'] * 0.5;
        $overallHealth = max(0, $averageScore - $dependencyPenalty);
        
        return round($overallHealth, 2);
    }
}
?>