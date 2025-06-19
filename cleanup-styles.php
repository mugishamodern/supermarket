<?php

/**
 * Cleanup script to remove inline styles from view files
 * and replace them with external CSS classes
 */

$viewsPath = __DIR__ . '/resources/views';
$processedFiles = 0;
$removedStyles = 0;

function processDirectory($dir) {
    global $processedFiles, $removedStyles;
    
    $files = glob($dir . '/*');
    
    foreach ($files as $file) {
        if (is_dir($file)) {
            processDirectory($file);
        } elseif (pathinfo($file, PATHINFO_EXTENSION) === 'blade.php') {
            $content = file_get_contents($file);
            $originalContent = $content;
            
            // Remove inline <style> tags and their content
            $content = preg_replace('/<style[^>]*>.*?<\/style>/s', '', $content);
            
            // Remove inline style attributes and replace with classes
            $content = preg_replace('/\s+style\s*=\s*["\'][^"\']*["\']/', '', $content);
            
            // Remove inline <script> tags (keep @section('scripts'))
            $content = preg_replace('/<script[^>]*>.*?<\/script>/s', '', $content);
            
            // Remove redundant empty lines
            $content = preg_replace('/\n\s*\n\s*\n/', "\n\n", $content);
            
            if ($content !== $originalContent) {
                file_put_contents($file, $content);
                $processedFiles++;
                $removedStyles++;
                echo "Processed: " . str_replace(__DIR__, '', $file) . "\n";
            }
        }
    }
}

echo "Starting cleanup of inline styles...\n";
processDirectory($viewsPath);
echo "\nCleanup completed!\n";
echo "Files processed: $processedFiles\n";
echo "Style blocks removed: $removedStyles\n"; 