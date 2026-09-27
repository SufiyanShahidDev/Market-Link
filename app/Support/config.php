<?php
if (session_status() === PHP_SESSION_NONE) { session_start(); }
date_default_timezone_set('Asia/Karachi');

const DB_HOST = 'localhost';
const DB_NAME = 'marketlink';
const DB_USER = 'root';
const DB_PASS = '';
// Detect the project folder automatically (works with /MarketLink, /MarketLink_MVC, etc.).
// Apache's rewrite keeps SCRIPT_NAME pointing to the front controller.
$scriptName = str_replace('\\', '/', $_SERVER['SCRIPT_NAME'] ?? '/index.php');
$basePath = rtrim(str_replace('\\', '/', dirname($scriptName)), '/');
define('BASE_URL', $basePath);
const APP_ROOT = __DIR__ . '/..';
const UPLOAD_DIR = __DIR__ . '/../../uploads';
const MAX_UPLOAD_SIZE = 3145728;
