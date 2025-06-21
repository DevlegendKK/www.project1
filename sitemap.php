<?php
header('Content-Type: application/xml; charset=utf-8');

// Database connection parameters
$servername = "localhost";
$username = "u687264317_dharmicdialog";
$password = "Dharmic^dialogue@267%$";
$database = "u687264317_dharmicdialog";

// Create connection
$conn = new mysqli($servername, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// XML header
echo '<?xml version="1.0" encoding="UTF-8"?>';
echo '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">';


// All the main urls that are required to add manually
echo '<url>
<loc>https://theindicvoice.com/</loc>
<lastmod>2024-06-03T19:09:28+01:00</lastmod>
<priority>1.0</priority>
</url>
<url>
<loc>https://theindicvoice.com/about</loc>
<lastmod>2024-06-03T19:09:28+01:00</lastmod>
<priority>1.0</priority>
</url>
<url>
<loc>https://theindicvoice.com/write-for-us</loc>
<lastmod>2024-06-03T19:09:28+01:00</lastmod>
<priority>1.0</priority>
</url>
<url>
<loc>https://theindicvoice.com/contact</loc>
<lastmod>2024-06-03T19:09:28+01:00</lastmod>
<priority>1.0</priority>
</url>
<url>
<loc>https://theindicvoice.com/newsletter</loc>
<lastmod>2024-06-03T19:09:28+01:00</lastmod>
<priority>1.0</priority>
</url>
<url>
<loc>https://theindicvoice.com/donate</loc>
<lastmod>2024-06-03T19:09:28+01:00</lastmod>
<priority>0.8</priority>
</url>
<url>
<loc>https://theindicvoice.com/Philosophy</loc>
<lastmod>2024-06-03T19:09:28+01:00</lastmod>
<priority>1.0</priority>
</url>
<url>
<loc>https://theindicvoice.com/Science</loc>
<lastmod>2024-06-03T19:09:28+01:00</lastmod>
<priority>1.0</priority>
</url>
<url>
<loc>https://theindicvoice.com/Society</loc>
<lastmod>2024-06-03T19:09:28+01:00</lastmod>
<priority>1.0</priority>
</url>
<url>
<loc>https://theindicvoice.com/Culture</loc>
<lastmod>2024-06-03T19:09:28+01:00</lastmod>
<priority>1.0</priority>
</url>
<url>
<loc>https://theindicvoice.com/Opinion</loc>
<lastmod>2024-06-03T19:09:28+01:00</lastmod>
<priority>1.0</priority>
</url>
<url>
<loc>https://theindicvoice.com/History</loc>
<lastmod>2024-06-03T19:09:28+01:00</lastmod>
<priority>1.0</priority>
</url>
<url>
<loc>https://theindicvoice.com/Architecture</loc>
<lastmod>2024-06-03T19:09:28+01:00</lastmod>
<priority>1.0</priority>
</url>
<url>
<loc>https://theindicvoice.com/Ganit</loc>
<lastmod>2024-06-03T19:09:28+01:00</lastmod>
<priority>1.0</priority>
</url>
<url>
<loc>https://theindicvoice.com/Yoga</loc>
<lastmod>2024-06-03T19:09:28+01:00</lastmod>
<priority>1.0</priority>
</url>
<url>
<loc>https://theindicvoice.com/Auyrveda</loc>
<lastmod>2024-06-03T19:09:28+01:00</lastmod>
<priority>1.0</priority>
</url>
<url>
<loc>https://theindicvoice.com/shortreads/</loc>
<lastmod>2024-06-03T19:09:28+01:00</lastmod>
<priority>1.0</priority>
</url>
';

// Fetch URLs from posts table
$sql = "SELECT * FROM post where status='true'";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        echo '<url>';
        echo '<loc>https://theindicvoice.com/' . htmlspecialchars($row['post_type']) . '/' . htmlspecialchars($row['slug']) . '</loc>';
        echo '<changefreq>HOURLY</changefreq>';
        echo '<priority>0.7</priority>';
        echo '</url>';
    }
}

// Fetch URLs from posts table
$sql = "SELECT * FROM iv_shortreadsPosts where status='True'";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        echo '<url>';
        echo '<loc>https://theindicvoice.com/shortreads/' . htmlspecialchars($row['slug']) . '</loc>';
        echo '<changefreq>HOURLY</changefreq>';
        echo '<priority>0.7</priority>';
        echo '</url>';
    }
}
// Close connection
$conn->close();

echo '</urlset>';
?>
