<?php

require_once 'vendor/autoload.php';
require_once __DIR__ . "/src/Initializers/Database.php";

use App\Initializers\Database;
use Dotenv\Dotenv;

$dotenv = Dotenv::createImmutable(__DIR__);
$dotenv->load();

$db = new Database();

ini_set('display_errors', 1);
ini_set('session.cookie_secure', 1);
ini_set('session.cookie_httponly', 1);
ini_set('session.use_only_cookies', 1);

session_start();
session_regenerate_id();
error_reporting(E_ALL);
