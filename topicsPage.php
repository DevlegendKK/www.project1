<?php
include "config/database.php";
require"page-views.php";
$slug = isset($_GET['slug']) ? $_GET['slug'] : '';

function countPostsBySlug($slug, $conn) {
    $stmt = $conn->prepare("SELECT COUNT(*) AS post_count FROM post WHERE category = :category AND status = :status");
    $stmt->execute(['category' => $slug, 'status' => 'true']);
    return $stmt->fetchColumn();
}

$postCount = countPostsBySlug($slug, $conn);
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
    
    <title><?php echo htmlspecialchars($slug); ?> - The Indic Voice</title>
<meta name="description" content="Explore insightful articles and analyses on <?php echo htmlspecialchars($slug); ?> at The Indic Voice. Stay informed with in-depth discussions, research, and perspectives on <?php echo htmlspecialchars($slug); ?>.">

<!-- Canonical & Pagination -->
<link rel="canonical" href="https://theindicvoice.com/<?php echo htmlspecialchars($slug); ?>/" />

<!-- Open Graph (OG) Metadata for Social Media -->
<meta property="og:locale" content="en_GB" />
<meta property="og:type" content="website" />
<meta property="og:title" content="<?php echo htmlspecialchars($slug); ?> - The Indic Voice" />
<meta property="og:description" content="Stay informed with expert discussions and analyses on <?php echo htmlspecialchars($slug); ?>. Explore the latest insights at The Indic Voice." />
<meta property="og:url" content="https://theindicvoice.com/<?php echo htmlspecialchars($slug); ?>/" />
<meta property="og:site_name" content="The Indic Voice" />

<!-- Twitter Card Metadata -->
<meta name="twitter:card" content="summary_large_image" />
<meta name="twitter:title" content="<?php echo htmlspecialchars($slug); ?> - The Indic Voice" />
<meta name="twitter:description" content="Discover engaging discussions and perspectives on <?php echo htmlspecialchars($slug); ?> at The Indic Voice." />
<meta name="twitter:site" content="@TheIndicVoice" />

<!-- JSON-LD Structured Data -->
<script type="application/ld+json">
{
  "@context": "https://schema.org",
  "@type": "CollectionPage",
  "headline": "<?php echo htmlspecialchars($slug); ?> - The Indic Voice",
  "description": "Explore thought-provoking content on <?php echo htmlspecialchars($slug); ?> at The Indic Voice. Stay updated with the latest articles and analyses.",
  "url": "https://theindicvoice.com/<?php echo htmlspecialchars($slug); ?>/",
  "image": "{{topic.featured_image}}",
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
        "name": "<?php echo htmlspecialchars($slug); ?>",
        "item": "https://theindicvoice.com/<?php echo htmlspecialchars($slug); ?>/"
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
    
    <script src="/assets/js/jquery/jquery.min.js"></script>
</head>
<body>
    <div class="iv-site-block">
        <div class="main-body">
            <?php require_once "srcComponents/header.php"; ?>
            
            <div class="article-stream custom-width-section">
                <div class="static-title-section">
                    <h1 class="static-title"><?php echo htmlspecialchars($slug); ?></h1>
                    <span><?php echo $postCount; ?> Articles</span>
                </div>
            </div>
            
            <div class="wrapper article-card-section inner-wrapper">
                <ul class="article-list padd-left-none ">
                        <?php
                            try {
                                $stmt = $conn->prepare("SELECT * FROM post WHERE status = :status AND category = :category ORDER BY published_at DESC LIMIT 0, 5");
                                $stmt->execute(['status' => 'true', 'category' => $slug]);
                                
                                
                                $posts = $stmt->fetchAll(PDO::FETCH_ASSOC);
                                
                                foreach ($posts as $fetch_post) {
                                    $authorid = $fetch_post['author_id'];
                                    $time = date('d M Y', strtotime($fetch_post['published_at']));
                                    
                                    
                                    $author_stmt = $conn->prepare("SELECT * FROM author WHERE id = :authorid");
                                    $author_stmt->execute(['authorid' => $authorid]);
                                    
                                    
                                    $fetch_author = $author_stmt->fetch(PDO::FETCH_ASSOC);
                                    ?>
                                    <li class="article-list_item">
                                        <div class="article-list_item-img">
                                            <a data-ev-cat="article card block" data-ev-act="article" data-ev-label="article card" href="/<?php echo htmlspecialchars($fetch_post['post_type']); ?>/<?php echo htmlspecialchars($fetch_post['slug']); ?>" class="article-box snippet-article_content hello6">
                                                <img class="" style="aspect-ratio:16/9" alt="Article Image" src="https://theindicvoice.com/assets/images/blog-post/<?php echo htmlspecialchars($fetch_post['featured_img']); ?>?q=65&#038;auto=format&#038;w=700&#038;ar=16:9&#038;fit=crop" srcset="https://theindicvoice.com/assets/images/blog-post/<?php echo htmlspecialchars($fetch_post['featured_img']); ?>?q=65&#038;auto=format&#038;w=700&#038;ar=16:9&#038;fit=crop 1200w,https://theindicvoice.com/assets/images/blog-post/<?php echo htmlspecialchars($fetch_post['featured_img']); ?>?q=65&#038;auto=format&#038;w=1200&#038;ar=16:9&#038;fit=crop 1000w,https://theindicvoice.com/assets/images/blog-post/<?php echo htmlspecialchars($fetch_post['featured_img']); ?>?q=65&#038;auto=format&#038;w=800&#038;ar=16:9&#038;fit=crop 700w" sizes="(max-width: 1100px) 100vw, 800px" loading="eager">
                                            </a>
                                        </div>
                                        <div class="article-list_item-content ">
                                            <ul class="article-list_item-byline padd-left-none margin-top-none">
                                                <li class="cat-list-item">
                                                    <a data-ev-cat="article card block" data-ev-act="article" data-ev-label="article card - <?php echo htmlspecialchars($fetch_post['category']); ?>" href="/<?php echo htmlspecialchars($fetch_post['category']); ?>/"> <?php echo htmlspecialchars($fetch_post['category']); ?> </a>
                                                </li>
                                            </ul>
                                            <a data-ev-cat="article card block" data-ev-act="article" data-ev-label="article card" href="/<?php echo htmlspecialchars($fetch_post['post_type']); ?>/<?php echo htmlspecialchars($fetch_post['slug']); ?>">
                                                <h2 class="article-list_item-head margin-top-none"> <?php echo htmlspecialchars($fetch_post['title']); ?> </h2>
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
                            ?>
                </ul>
            </div>
            
            
            
            
            <div class="horizontal-article-card-section article-stream custom-width-section">
                <ul class="snippet-article home-bottom-article">
                    
                    <?php
                    try {
                        $stmt = $conn->prepare("SELECT * FROM post WHERE status = :status AND category = :category ORDER BY published_at DESC LIMIT 5, 11");
                        $stmt->execute(['status' => 'true', 'category' => $slug]);
                        
                        // Fetch all posts
                        $posts = $stmt->fetchAll(PDO::FETCH_ASSOC);
                        
                        foreach ($posts as $fetch_post) {
                            $authorid = $fetch_post['author_id'];
                            $time = date('d M Y', strtotime($fetch_post['published_at']));
                            
                        
                            
                            // Prepare and execute the query to fetch the author
                            $author_stmt = $conn->prepare("SELECT * FROM author WHERE id = :authorid");
                            $author_stmt->execute(['authorid' => $authorid]);
                            
                            // Fetch the author
                            $fetch_author = $author_stmt->fetch(PDO::FETCH_ASSOC);
                            ?>
                            <li class="snippet-article_post">
                                <div class="article-box snippet-article_content ">
                                    <a href="/<?php echo htmlspecialchars($fetch_post['post_type']); ?>/<?php echo htmlspecialchars($fetch_post['slug']); ?>">
                                        <img src="https://theindicvoice.com/assets/images/blog-post/<?php echo htmlspecialchars($fetch_post['featured_img']); ?>?auto=compress&#038;fm=png&#038;ixlib=php-3.3.1?crop=entropy&#038;auto=compress&#038;fit=crop&#038;h=605&#038;w=1440" alt="channel_image">
                                    </a>
                                    <p class="snippet-article_content-cat">
                                        <a data-ev-cat="page undefined" data-ev-act="article" data-ev-label="label undefined - Psychology" href="/"> <?php echo htmlspecialchars($fetch_post['category']); ?> </a>
                                    </p>
                                    <h3 class="margin-bottom-none snippet-article_content-head">
                                        <a data-ev-cat="page undefined" data-ev-act="article" data-ev-label="label undefined" href="/<?php echo htmlspecialchars($fetch_post['post_type']); ?>/<?php echo htmlspecialchars($fetch_post['slug']); ?>"> <?php echo htmlspecialchars($fetch_post['title']); ?> </a>
                                    </h3>
                                    <?php
                                        // Limit the description to 10 words
                                        $description = htmlspecialchars($fetch_post['description']);
                                        $words = explode(' ', $description);
                                        $limited_description = implode(' ', array_slice($words, 0, 10));
                                    ?>
                                    <p class="margin-top-none snippet-article_content-desc article-list_item-desc"><?php echo $limited_description; ?><?php if (count($words) > 10) echo '...'; ?></p>
                                    <ul class="snippet-article_content-byline lg margin-bottom-none no-style">
                                        <li>By <?php echo htmlspecialchars($fetch_author['name']); ?> </li>
                                        <li class="pull-right">
                                            <time datetime="<?php echo htmlspecialchars($fetch_post['published_at']); ?>"> <?php echo $time; ?> </time>
                                        </li>
                                    </ul>
                                </div>
                            </li>
                            <?php
                            }
                        } catch (PDOException $e) {
                            echo "Error: " . $e->getMessage();
                        }
                    ?>
                </ul>
            </div>
            
            
            
            
            
            <?php require_once "srcComponents/newsletterSection.php"; ?>
            <?php require_once "srcComponents/footer.php"; ?>
        </div>
    </div>

    <script src="/assets/js/script.js"></script>
    <script src="/assets/js/slick.min.js"></script>
</body>
</html>