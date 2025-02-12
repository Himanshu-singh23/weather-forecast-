<?php

require_once '../vendor/autoload.php';
use Dotenv\Dotenv;
$dotenv = Dotenv::createImmutable(__DIR__.'/../');
$dotenv->load();


$allowed_pages = ['home', 'about', 'contact','login','dashboard'];
$page = isset($_GET['page']) && in_array($_GET['page'], $allowed_pages) ? $_GET['page'] : 'home';
$content = "./$page.php";
if (!file_exists($content)) {
    $content = '404.php';
}

$name = $_ENV['NAME'];

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="./assets/css/output.css" rel="stylesheet">
    <script src="https://unpkg.com/@tailwindcss/browser@4"></script> 

</head>

<body>
    <!-- Navbar -->
    <div>
        <?php include './navbar.php'; ?>
    </div>

    <!-- Main Content -->
    <div>
        <?php include $content; ?>
    </div>

    <!-- Footer -->
    <div>
        <?php include './footer.php'; ?>
    </div>
</body>

</html>
