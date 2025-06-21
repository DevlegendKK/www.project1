<?php
include "config/database.php"; // Ensure database connection is included
require"page-views.php";
// Get the search query from the URL or POST request
$searchQuery = isset($_GET['search']) ? $_GET['search'] : '';
$currentPage = isset($_GET['page']) ? $_GET['page'] : 1;
$limit = 5; // Number of articles per page
$offset = ($currentPage - 1) * $limit;

// Query to fetch the total number of results
$postCount = 0;
if ($searchQuery) {
    // Modified query to search across title, description, category, and sub_category
    $stmtCount = $conn->prepare("SELECT COUNT(*) FROM post WHERE status = :status AND (title LIKE :searchQuery OR description LIKE :searchQuery OR category LIKE :searchQuery OR sub_category LIKE :searchQuery)");
    $stmtCount->execute(['status' => 'true', 'searchQuery' => '%' . $searchQuery . '%']);
    $postCount = $stmtCount->fetchColumn();
}

// Calculate total pages
$totalPages = ceil($postCount / $limit);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <!-- Google tag (gtag.js) -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=G-0F0FSFK6B3"></script>
    <script>
      window.dataLayer = window.dataLayer || [];
      function gtag(){dataLayer.push(arguments);}
      gtag('js', new Date());
    
      gtag('config', 'G-0F0FSFK6B3');
    </script>
    
    <title>Search Results for <?php echo htmlspecialchars($searchQuery); ?> - The Indic Voice</title>
<meta name="description" content="Browse search results for <?php echo htmlspecialchars($searchQuery); ?> at The Indic Voice. Find insightful articles, analyses, and perspectives on your topic of interest.">

<!-- Canonical & Pagination -->
<link rel="canonical" href="https://theindicvoice.com/s?search=<?php echo htmlspecialchars($searchQuery); ?>" />

<!-- Open Graph (OG) Metadata for Social Media -->
<meta property="og:locale" content="en_GB" />
<meta property="og:type" content="website" />
<meta property="og:title" content="Search Results for <?php echo htmlspecialchars($searchQuery); ?> - The Indic Voice" />
<meta property="og:description" content="Browse search results for <?php echo htmlspecialchars($searchQuery); ?> at The Indic Voice. Find insightful articles, analyses, and perspectives on your topic of interest." />
<meta property="og:url" content="https://theindicvoice.com/s?search=<?php echo htmlspecialchars($searchQuery); ?>" />
<meta property="og:site_name" content="The Indic Voice" />

<!-- Twitter Card Metadata -->
<meta name="twitter:card" content="summary_large_image" />
<meta name="twitter:title" content="Search Results for <?php echo htmlspecialchars($searchQuery); ?> - The Indic Voice" />
<meta name="twitter:description" content="Browse search results for <?php echo htmlspecialchars($searchQuery); ?> at The Indic Voice. Find insightful articles, analyses, and perspectives on your topic of interest." />
<meta name="twitter:site" content="@TheIndicVoice" />

<!-- JSON-LD Structured Data -->
<script type="application/ld+json">
{
  "@context": "https://schema.org",
  "@type": "CollectionPage",
  "headline": "Search Results for <?php echo htmlspecialchars($searchQuery); ?> - The Indic Voice",
  "description": "Browse search results for <?php echo htmlspecialchars($searchQuery); ?> at The Indic Voice. Find insightful articles, analyses, and perspectives on your topic of interest.",
  "url": "https://theindicvoice.com/s?search=<?php echo htmlspecialchars($searchQuery); ?>",
  "isPartOf": {
    "@type": "WebSite",
    "@id": "https://theindicvoice.com/#website"
  },
  "breadcrumb": {
    "@type": "BreadcrumbList",
    "itemListElement": [
      {
        "@type": "ListItem",
        "position": 1,
        "name": "Home",
        "item": "https://theindicvoice.com/"
      },
      {
        "@type": "ListItem",
        "position": 2,
        "name": "<?php echo htmlspecialchars($searchQuery); ?>",
        "item": "https://theindicvoice.com/s?search=<?php echo htmlspecialchars($searchQuery); ?>"
      }
    ]
  },
  "inLanguage": "en-GB"
}
</script>

	<link rel="alternate" type="application/rss+xml" title="The Indic Voice &raquo; Feed" href="https://theindicvoice.com/rss/" />
	<link rel="shortcut icon" href="https://theindicvoice.com/assets/images/favicon.png" >

    <link rel="preload" href="/assets/css/styles.css" as="style">
    <link rel="preload" href="/assets/js/script.js" as="script">

    <link rel="stylesheet" href="/assets/css/styles.css">
    <link rel="stylesheet" href="/assets/css/page-index.css">
    <style>.search-form { display: flex; justify-content: center; margin-top: 20px; } .search-form input[type="text"] { width: 60%; padding: 15px; border: 1px solid #ddd; border-radius: 30px; font-size: 16px; outline: none; box-shadow: 0 0 8px rgba(0, 0, 0, 0.1); } .search-form button { padding: 15px 30px; background-color: #ffce54; color: black; font-size: 16px; border: none; border-radius: 30px; cursor: pointer; margin-left: 10px; transition: all 0.3s ease; } .search-form button:hover { background-color: #e5b846; } .pagination { text-align: center; margin-top: 30px; } .pagination a { background-color: #ffce54; color: black; padding: 10px 20px; border-radius: 30px; font-size: 16px; text-decoration: none; margin: 0 10px; transition: background-color 0.3s ease; } .pagination a:hover { background-color: #e5b846; } .pagination a.disabled { background-color: #ddd; cursor: not-allowed; } /* No Results Found Styling */ .no-results-message { font-size: 18px; font-weight: 500; color: #888; margin-top: 30px; } @media (max-width: 480px) { .search-form input[type="text"] { width: 100%; } .search-form button { width: 100%; margin-left: 0; } }</style>
    
    <script src="/assets/js/jquery/jquery.min.js"></script>
</head>
<body>
    <div class="iv-site-block">
        <div class="main-body">
            <?php require_once "srcComponents/header.php"; ?>

            <!-- Search Section -->
            <div class="article-stream custom-width-section">
                <div class="static-title-section">
                    <h1 class="static-title">Search Results</h1>
                    <?php if ($searchQuery): ?>
                        <span><?php echo $postCount; ?> Items Found</span>
                    <?php else: ?>
                        <span>No search query provided. Please enter a term to search.</span>
                    <?php endif; ?>
                </div>
                
                <!-- Search Form -->
                <form method="GET" class="search-form">
                    <input type="text" name="search" value="<?php echo htmlspecialchars($searchQuery); ?>" placeholder="Search for articles..." required>
                    <button type="submit" class="cta-button">Search</button>
                </form>
            </div>

            <!-- Articles List Section -->
            <div class="wrapper article-card-section inner-wrapper">
                <ul class="article-list padd-left-none">
                    <?php
                    if ($searchQuery && $postCount > 0) {
                        try {
                            // Fetch posts based on the search query
                            $stmt = $conn->prepare("SELECT * FROM post WHERE status = :status AND (title LIKE :searchQuery OR description LIKE :searchQuery OR category LIKE :searchQuery OR sub_category LIKE :searchQuery) ORDER BY published_at DESC LIMIT 0, 5");
                            $stmt->execute(['status' => 'true', 'searchQuery' => '%' . $searchQuery . '%']);
                            $posts = $stmt->fetchAll(PDO::FETCH_ASSOC);

                            foreach ($posts as $fetch_post) {
                                $authorid = $fetch_post['author_id'];
                                $time = date('d M Y', strtotime($fetch_post['published_at']));
                                
                                // Fetch the author details
                                $author_stmt = $conn->prepare("SELECT * FROM author WHERE id = :authorid");
                                $author_stmt->execute(['authorid' => $authorid]);
                                $fetch_author = $author_stmt->fetch(PDO::FETCH_ASSOC);
                    ?>
                    <li class="article-list_item">
                        <div class="article-list_item-img">
                            <a href="/<?php echo htmlspecialchars($fetch_post['post_type']); ?>/<?php echo htmlspecialchars($fetch_post['slug']); ?>" class="article-box snippet-article_content">
                                <img class="" style="aspect-ratio:16/9" alt="Article Image" src="https://theindicvoice.com/assets/images/blog-post/<?php echo htmlspecialchars($fetch_post['featured_img']); ?>?q=65&auto=format&w=700&ar=16:9&fit=crop">
                            </a>
                        </div>
                        <div class="article-list_item-content">
                            <ul class="article-list_item-byline padd-left-none margin-top-none">
                                <li class="cat-list-item">
                                    <a href="/"> <?php echo htmlspecialchars($fetch_post['category']); ?> </a>
                                </li>
                            </ul>
                            <a href="/<?php echo htmlspecialchars($fetch_post['post_type']); ?>/<?php echo htmlspecialchars($fetch_post['slug']); ?>">
                                <h2 class="article-list_item-head margin-top-none"><?php echo htmlspecialchars($fetch_post['title']); ?></h2>
                            </a>
                            <ul class="article-list_item-byline padd-left-none margin-top-none">
                                <li>By <a href="/author/<?php echo htmlspecialchars($fetch_author['slug']); ?>"><?php echo htmlspecialchars($fetch_author['name']); ?></a></li>
                                <li>
                                    <time datetime="<?php echo htmlspecialchars($fetch_post['published_at']); ?>"> <?php echo $time; ?> </time>
                                </li>
                            </ul>
                            <?php
                                $description = htmlspecialchars($fetch_post['description']);
                                $words = explode(' ', $description);
                                $limited_description = implode(' ', array_slice($words, 0, 15));
                            ?>
                            <div class="article-list_item-desc"> <?php echo $limited_description; ?><?php if (count($words) > 10) echo '...'; ?> </div>
                        </div>
                    </li>
                    <?php
                            }
                        } catch (PDOException $e) {
                            echo "Error: " . $e->getMessage();
                        }
                    } else {
                        echo '<li>No results found for your search.</li>';
                    }
                    ?>
                </ul>
            </div>

            <!-- Pagination for More Results -->
            <div class="pagination">
                <?php if ($currentPage > 1): ?>
                    <a href="?search=<?php echo urlencode($searchQuery); ?>&page=<?php echo $currentPage - 1; ?>" class="prev">Previous</a>
                <?php endif; ?>

                <span>Page <?php echo $currentPage; ?> of <?php echo $totalPages; ?></span>

                <?php if ($currentPage < $totalPages): ?>
                    <a href="?search=<?php echo urlencode($searchQuery); ?>&page=<?php echo $currentPage + 1; ?>" class="next">Next</a>
                <?php endif; ?>
            </div>

            <?php require_once "srcComponents/footer.php"; ?>
        </div>
    </div>

    <script src="/assets/js/script.js"></script>
    <script src="/assets/js/slick.min.js"></script>
</body>
</html>
