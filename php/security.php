<?php
/**
 * Security Utilities for Ratsstuben Germering
 * Provides CSRF protection, input sanitization, and security headers
 * Compatible with PHP 7.0+
 */

// Start session if not already started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

/**
 * Generate and store CSRF token
 */
function generateCsrfToken() {
    if (empty($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
        $_SESSION['csrf_token_time'] = time();
    }
    return $_SESSION['csrf_token'];
}

/**
 * Validate CSRF token
 */
function validateCsrfToken($token) {
    if (empty($_SESSION['csrf_token']) || empty($token)) {
        return false;
    }

    // Token expires after 2 hours
    $max_time = 2 * 60 * 60;
    if (isset($_SESSION['csrf_token_time']) && (time() - $_SESSION['csrf_token_time']) > $max_time) {
        unset($_SESSION['csrf_token']);
        unset($_SESSION['csrf_token_time']);
        return false;
    }

    return hash_equals($_SESSION['csrf_token'], $token);
}

/**
 * Sanitize string input
 */
function sanitizeString($input, $maxLength = 255) {
    $input = trim($input);
    $input = strip_tags($input);
    $input = htmlspecialchars($input, ENT_QUOTES | ENT_HTML5, 'UTF-8');
    // Use substr() with mbstring fallback
    if (function_exists('mb_substr')) {
        return mb_substr($input, 0, $maxLength);
    }
    return substr($input, 0, $maxLength);
}

/**
 * Sanitize email input
 */
function sanitizeEmail($input) {
    $input = trim($input);
    $input = filter_var($input, FILTER_SANITIZE_EMAIL);
    return htmlspecialchars($input, ENT_QUOTES | ENT_HTML5, 'UTF-8');
}

/**
 * Sanitize integer input
 */
function sanitizeInt($input) {
    return (int) filter_var($input, FILTER_SANITIZE_NUMBER_INT);
}

/**
 * Validate date format (YYYY-MM-DD)
 */
function validateDate($date) {
    $d = DateTime::createFromFormat('Y-m-d', $date);
    return $d && $d->format('Y-m-d') === $date;
}

/**
 * Validate time format (HH:MM)
 */
function validateTime($time) {
    $d = DateTime::createFromFormat('H:i', $time);
    return $d && $d->format('H:i') === $time;
}

/**
 * Set security headers
 */
function setSecurityHeaders() {
    // Prevent clickjacking
    header("X-Frame-Options: SAMEORIGIN");

    // Prevent MIME type sniffing
    header("X-Content-Type-Options: nosniff");

    // Enable XSS protection
    header("X-XSS-Protection: 1; mode=block");

    // Content Security Policy
    header("Content-Security-Policy: default-src 'self'; script-src 'self' 'unsafe-inline'; style-src 'self' 'unsafe-inline'; img-src 'self' data:; font-src 'self'; connect-src 'self'; frame-ancestors 'self';");

    // HSTS (uncomment when HTTPS is fully configured)
    // header("Strict-Transport-Security: max-age=31536000; includeSubDomains");

    // Referrer Policy
    header("Referrer-Policy: strict-origin-when-cross-origin");

    // Permissions Policy
    header("Permissions-Policy: geolocation=(), microphone=(), camera=()");
}

/**
 * Set caching headers for static assets
 */
function setCacheHeaders($maxAge = 3600, $public = true) {
    $policy = $public ? 'public' : 'private, no-cache';
    $pragma = $public ? 'public' : 'no-cache';
    header("Cache-Control: $policy, max-age=$maxAge, must-revalidate");
    header("Pragma: $pragma");
    header("Expires: " . gmdate('D, d M Y H:i:s', time() + $maxAge) . ' GMT');
}

/**
 * Get safe error message (don't expose internal details)
 */
function getSafeErrorMessage() {
    return "Es ist ein Fehler aufgetreten.<br>Bitte reservieren Sie telefonisch<br><a href='tel:+4989847989'>+49 89 847989</a><br>oder per E-Mail an <a href='mailto:ratsstuben.germering@gmail.com'>ratsstuben.germering@gmail.com</a>.";
}

/**
 * Advanced honeypot validation
 * Checks multiple bot detection methods
 */
function validateHoneypot() {
    // Check if honeypot field is filled (basic)
    if (!empty($_POST['address'])) {
        return false;
    }

    // Check for suspiciously fast submission (less than 2 seconds)
    if (isset($_POST['form_timestamp'])) {
        $submitTime = time();
        $formTime = (int) $_POST['form_timestamp'];
        if (($submitTime - $formTime) < 2) {
            return false;
        }
    }

    // Check for empty required fields hidden from bots
    if (isset($_POST['website_url']) && !empty($_POST['website_url'])) {
        return false;
    }

    return true;
}

/**
 * Log error securely (without exposing sensitive data)
 */
function logError($message, $context = []) {
    $logFile = __DIR__ . '/error.log';
    $timestamp = date('Y-m-d H:i:s');
    $logEntry = "[$timestamp] $message";

    if (!empty($context)) {
        // Sanitize context data
        $safeContext = array_map(function($item) {
            return is_string($item) ? sanitizeString($item, 100) : '[filtered]';
        }, $context);
        $logEntry .= ' | Context: ' . json_encode($safeContext);
    }

    $logEntry .= "\n";

    // Append to log file
    @file_put_contents($logFile, $logEntry, FILE_APPEND | LOCK_EX);
}
