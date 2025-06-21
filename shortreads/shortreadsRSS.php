<?php
include "../config/database.php";

header("Content-Type: text/xml; charset=UTF-8");

// Start the XML document
echo '<?xml version="1.0" encoding="UTF-8"?>
    <rss version="2.0" xmlns:content="http://purl.org/rss/1.0/modules/content/" xmlns:atom="http://www.w3.org/2005/Atom" xmlns:dc="http://purl.org/dc/elements/1.1/">
        <channel>
            <title>ShortReads - The Indic Voice</title>
            <link>https://theindicvoice.com/shortreads/</link>
            <description>Explore thought-provoking India-centric discussions on decoloniality, philosophy, geopolitics, history, tradition, and more.</description>
            <language>en</language>
            <atom:link type="application/rss+xml" rel="self" href="https://theindicvoice.com/feed/"/>
            
            <image>
                <title>The Indic Voice</title>
                <url>https://theindicvoice.com/logo.png</url>
                <link>https://theindicvoice.com/</link>
            </image>';

// Fetch articles from database
$sql = "SELECT * FROM iv_shortreadsPosts ORDER BY published_at DESC";
$stmt = $conn->prepare($sql);
$stmt->execute();

if ($stmt->rowCount() > 0) {
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        echo '
                <item>
                    <title>' . htmlspecialchars($row['title']) . '</title>
                    <link>https://theindicvoice.com/' . htmlspecialchars($row['post_type']) . '/' . htmlspecialchars($row['slug']) . '</link>
                    <description>' . htmlspecialchars($row['description']) . '</description>
                    <category>' . htmlspecialchars($row['category']) . '</category>';
                    
        $authorid = htmlspecialchars($row['author_id']);
        $select_author = $conn->prepare("SELECT * FROM author WHERE id = :authorid");
        $select_author->bindParam(':authorid', $authorid, PDO::PARAM_INT);
        $select_author->execute();
        
        while ($fetch_author = $select_author->fetch(PDO::FETCH_ASSOC)) {
            echo '
                    <dc:creator>' . htmlspecialchars($fetch_author['name']) . '</dc:creator>';
        }
        
        $date = new DateTime($row['published_at']);
        $date->setTimezone(new DateTimeZone('Asia/Kolkata'));
        $formattedDate = $date->format(DateTime::ATOM);
        
        echo '
                    <pubDate>' . $formattedDate . '</pubDate>
                </item>';
    }
} else {
    echo '<item>';
    echo '<title>No articles found</title>';
    echo '<description>No articles found in the database</description>';
    echo '</item>';
}

// Close the XML document
echo '</channel>';
echo '</rss>';

// Close the database connection
$conn = null; // PDO uses null to close the connection
?>