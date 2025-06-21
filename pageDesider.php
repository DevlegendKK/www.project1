<?php
include "config/database.php";

$slug = isset($_GET['slug']) ? $_GET['slug'] : '';

try {
    if (strpos($slug, 'shortreads') === 0) {
        include "shortreads/index.php";
        exit();
    }
    
    // Check if slug exists in topics table
    $stmt = $conn->prepare("SELECT * FROM iv_postTopics WHERE name = :slug");
    $stmt->bindParam(":slug", $slug, PDO::PARAM_STR);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($result) {
        include "topicsPage.php";
        exit();
    }

    // Check if slug exists in pages table
    $stmt = $conn->prepare("SELECT * FROM iv_pagesList WHERE slug = :slug");
    $stmt->bindParam(":slug", $slug, PDO::PARAM_STR);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($result) {
        include $result['pageName'];
        exit();
    }

    // If not found in both tables, redirect to 404
    include "404.php";
    exit();
} catch (PDOException $e) {
    die("Database error: " . $e->getMessage());
}
?>