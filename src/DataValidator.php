<?php
/**
 * Data Validator for Digital Reliance Processing
 */

class DataValidator
{
    private $errors = [];
    
    /**
     * Validate input data
     *
     * @param array $data Data to validate
     * @return array Validation result
     */
    public function validate($data)
    {
        $this->errors = [];
        
        // Check if data is provided
        if (empty($data)) {
            $this->addError('Data cannot be empty');
            return $this->getValidationResult();
        }
        
        // Validate data structure
        $this->validateStructure($data);
        
        // Validate assets if provided
        if (isset($data['assets'])) {
            $this->validateAssets($data['assets']);
        }
        
        // Validate dependencies if provided
        if (isset($data['dependencies'])) {
            $this->validateDependencies($data['dependencies']);
        }
        
        // Validate reliability data if provided
        if (isset($data['reliability'])) {
            $this->validateReliabilityData($data['reliability']);
        }
        
        // Validate performance metrics if provided
        if (isset($data['performance'])) {
            $this->validatePerformanceMetrics($data['performance']);
        }
        
        return $this->getValidationResult();
    }
    
    /**
     * Validate basic data structure
     *
     * @param array $data Input data
     */
    private function validateStructure($data)
    {
        if (!is_array($data)) {
            $this->addError('Data must be an array');
            return;
        }
        
        // Check for required fields
        $requiredFields = ['assets', 'dependencies', 'reliability'];
        $missingFields = [];
        
        foreach ($requiredFields as $field) {
            if (!isset($data[$field])) {
                $missingFields[] = $field;
            }
        }
        
        if (!empty($missingFields)) {
            $this->addError('Missing required fields: ' . implode(', ', $missingFields));
        }
    }
    
    /**
     * Validate assets data
     *
     * @param array $assets Assets data
     */
    private function validateAssets($assets)
    {
        if (!is_array($assets)) {
            $this->addError('Assets must be an array');
            return;
        }
        
        foreach ($assets as $index => $asset) {
            if (!is_array($asset)) {
                $this->addError("Asset at index {$index} must be an array");
                continue;
            }
            
            // Validate asset structure
            if (!isset($asset['id'])) {
                $this->addError("Asset at index {$index} missing required 'id' field");
            }
            
            if (!isset($asset['type'])) {
                $this->addError("Asset at index {$index} missing required 'type' field");
            }
            
            // Validate asset type
            if (isset($asset['type'])) {
                $validTypes = ['server', 'database', 'service', 'application', 'network'];
                if (!in_array($asset['type'], $validTypes)) {
                    $this->addError("Asset at index {$index} has invalid type. Valid types: " . implode(', ', $validTypes));
                }
            }
            
            // Validate status if provided
            if (isset($asset['status'])) {
                $validStatuses = ['active', 'inactive', 'maintenance', 'error'];
                if (!in_array($asset['status'], $validStatuses)) {
                    $this->addError("Asset at index {$index} has invalid status. Valid statuses: " . implode(', ', $validStatuses));
                }
            }
        }
    }
    
    /**
     * Validate dependencies data
     *
     * @param array $dependencies Dependencies data
     */
    private function validateDependencies($dependencies)
    {
        if (!is_array($dependencies)) {
            $this->addError('Dependencies must be an array');
            return;
        }
        
        foreach ($dependencies as $index => $dependency) {
            if (!is_array($dependency)) {
                $this->addError("Dependency at index {$index} must be an array");
                continue;
            }
            
            // Check required fields
            $requiredFields = ['source', 'target', 'type'];
            foreach ($requiredFields as $field) {
                if (!isset($dependency[$field])) {
                    $this->addError("Dependency at index {$index} missing required '{$field}' field");
                }
            }
            
            // Validate dependency type
            if (isset($dependency['type'])) {
                $validTypes = ['critical', 'important', 'optional'];
                if (!in_array($dependency['type'], $validTypes)) {
                    $this->addError("Dependency at index {$index} has invalid type. Valid types: " . implode(', ', $validTypes));
                }
            }
        }
    }
    
    /**
     * Validate reliability data
     *
     * @param array $reliability Reliability data
     */
    private function validateReliabilityData($reliability)
    {
        if (!is_array($reliability)) {
            $this->addError('Reliability data must be an array');
            return;
        }
        
        // Validate reliability metrics
        $numericFields = ['uptime', 'availability', 'response_time', 'error_rate'];
        foreach ($numericFields as $field) {
            if (isset($reliability[$field])) {
                if (!is_numeric($reliability[$field])) {
                    $this->addError("Reliability field '{$field}' must be numeric");
                }
                
                // Validate ranges
                if ($field === 'uptime' || $field === 'availability') {
                    if ($reliability[$field] < 0 || $reliability[$field] > 100) {
                        $this->addError("Reliability field '{$field}' must be between 0 and 100");
                    }
                }
                
                if ($field === 'error_rate') {
                    if ($reliability[$field] < 0) {
                        $this->addError("Reliability field '{$field}' cannot be negative");
                    }
                }
            }
        }
    }
    
    /**
     * Validate performance metrics
     *
     * @param array $performance Performance data
     */
    private function validatePerformanceMetrics($performance)
    {
        if (!is_array($performance)) {
            $this->addError('Performance metrics must be an array');
            return;
        }
        
        $numericFields = ['cpu_usage', 'memory_usage', 'disk_usage', 'network_latency'];
        foreach ($numericFields as $field) {
            if (isset($performance[$field])) {
                if (!is_numeric($performance[$field])) {
                    $this->addError("Performance field '{$field}' must be numeric");
                }
                
                // Validate percentage fields
                if (in_array($field, ['cpu_usage', 'memory_usage', 'disk_usage'])) {
                    if ($performance[$field] < 0 || $performance[$field] > 100) {
                        $this->addError("Performance field '{$field}' must be between 0 and 100");
                    }
                }
            }
        }
    }
    
    /**
     * Add validation error
     *
     * @param string $message Error message
     */
    private function addError($message)
    {
        $this->errors[] = $message;
    }
    
    /**
     * Get validation result
     *
     * @return array Validation result
     */
    private function getValidationResult()
    {
        return [
            'valid' => empty($this->errors),
            'errors' => $this->errors
        ];
    }
}
?>