<?php
/**
 * Simple Logger for Digital Reliance System
 */

class Logger
{
    private $logFile;
    private $logLevel;
    
    const LEVELS = [
        'DEBUG' => 0,
        'INFO' => 1,
        'WARNING' => 2,
        'ERROR' => 3
    ];
    
    public function __construct($logFile = null, $logLevel = 'INFO')
    {
        $this->logFile = $logFile ?? (defined('LOG_FILE') ? LOG_FILE : 'logs/app.log');
        $this->logLevel = $logLevel;
        
        // Create logs directory if it doesn't exist
        $logDir = dirname($this->logFile);
        if (!is_dir($logDir)) {
            mkdir($logDir, 0755, true);
        }
    }
    
    /**
     * Log debug message
     *
     * @param string $message Log message
     * @param array $context Additional context
     */
    public function debug($message, $context = [])
    {
        $this->log('DEBUG', $message, $context);
    }
    
    /**
     * Log info message
     *
     * @param string $message Log message
     * @param array $context Additional context
     */
    public function info($message, $context = [])
    {
        $this->log('INFO', $message, $context);
    }
    
    /**
     * Log warning message
     *
     * @param string $message Log message
     * @param array $context Additional context
     */
    public function warning($message, $context = [])
    {
        $this->log('WARNING', $message, $context);
    }
    
    /**
     * Log error message
     *
     * @param string $message Log message
     * @param array $context Additional context
     */
    public function error($message, $context = [])
    {
        $this->log('ERROR', $message, $context);
    }
    
    /**
     * Write log entry
     *
     * @param string $level Log level
     * @param string $message Log message
     * @param array $context Additional context
     */
    private function log($level, $message, $context = [])
    {
        // Check if we should log this level
        if (self::LEVELS[$level] < self::LEVELS[$this->logLevel]) {
            return;
        }
        
        $timestamp = date('Y-m-d H:i:s');
        $contextString = empty($context) ? '' : ' ' . json_encode($context);
        
        $logEntry = "[{$timestamp}] {$level}: {$message}{$contextString}" . PHP_EOL;
        
        // Write to file
        file_put_contents($this->logFile, $logEntry, FILE_APPEND | LOCK_EX);
    }
}
?>