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
    
    <title>ShortReads - The Indic Voice</title>
<meta name="description" content="Explore thought-provoking India-centric discussions on decoloniality, philosophy, geopolitics, history, tradition, and more.">

<!-- Canonical & Pagination -->
<link rel="canonical" href="https://www.theindicvoice.com/shortreads/" />

<!-- Open Graph (OG) Metadata for Social Media -->
<meta property="og:locale" content="en_GB" />
<meta property="og:type" content="website" />
<meta property="og:title" content="ShortReads - The Indic Voice" />
<meta property="og:description" content="Explore thought-provoking India-centric discussions on decoloniality, philosophy, geopolitics, history, tradition, and more." />
<meta property="og:url" content="https://www.theindicvoice.com/shortreads/" />
<meta property="og:site_name" content="The Indic Voice" />
<meta property="og:image" content="https://www.theindicvoice.com/assets/images/metaimages/shortreads-1024x512.png" />
<meta property="og:image:width" content="1200" />
<meta property="og:image:height" content="630" />

<!-- Twitter Card Metadata -->
<meta name="twitter:card" content="summary_large_image" />
<meta name="twitter:title" content="ShortReads - The Indic Voice" />
<meta name="twitter:description" content="Explore thought-provoking India-centric discussions on decoloniality, philosophy, geopolitics, history, tradition, and more." />
<meta name="twitter:image" content="https://www.theindicvoice.com/assets/images/metaimages/shortreads-1024x512.png" />
<meta name="twitter:url" content="https://www.theindicvoice.com/shortreads/" />
<meta name="twitter:site" content="@TheIndicVoice" />

<!-- JSON-LD Structured Data -->
<script type="application/ld+json">
{
  "@context": "https://schema.org",
  "@type": "CollectionPage",
  "headline": "ShortReads - The Indic Voice",
  "description": "Explore thought-provoking India-centric discussions on decoloniality, philosophy, geopolitics, history, tradition, and more.",
  "url": "https://www.theindicvoice.com/shortreads/",
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
        "name": "ShortReads",
        "item": "https://www.theindicvoice.com/shortreads/"
      }
    ]
  },
  "inLanguage": "en-GB"
}
</script>
    
    <link rel="alternate" type="application/rss+xml" title="The Indic Voice &raquo; Feed" href="https://theindicvoice.com/shortreads/rss/" />
	<link rel="shortcut icon" href="https://theindicvoice.com/assets/images/favicon.png" >
    <meta name="robots" content="index, follow, max-snippet:-1, max-video-preview:-1, max-image-preview:large" />
    
    <link rel="preload" href="https://theindicvoice.com/assets/css/styles.css" as="style">
    <link rel="preload" href="https://theindicvoice.com/assets/js/script.js" as="script">
    <link rel="stylesheet" href="https://theindicvoice.com/assets/css/styles.css" />
    <link rel="stylesheet" href="https://theindicvoice.com/assets/css/page-index.css" />
    <script src="https://theindicvoice.com/assets/js/jquery/jquery.min.js"></script>
</head>
<body>
    <?php
    if (file_exists("srcComponents/header.php")) {
        include "srcComponents/header.php";
    } else {
        include "../srcComponents/header.php";
    }
    ?>
    
    <div class="horizontal-article-card-section wrapper inner-wrapper" style="margin-top: 40px;">
        <ul class="snippet-article home-bottom-article">
            <?php
            try {
                $stmt = $conn->prepare("SELECT * FROM iv_shortreadsPosts WHERE status = :status ORDER BY published_at DESC");
                $stmt->execute(['status' => 'true']);
                            
                // Fetch all posts
                $posts = $stmt->fetchAll(PDO::FETCH_ASSOC);
                
                foreach ($posts as $fetch_post) {
                    $time = date('d M Y', strtotime($fetch_post['published_at']));
                    
                    $authorid = $fetch_post['author_id'];
                    $author_stmt = $conn->prepare("SELECT * FROM author WHERE id = :authorid");
                    $author_stmt->execute(['authorid' => $authorid]);
                    $fetch_author = $author_stmt->fetch(PDO::FETCH_ASSOC);
            ?>
            <li class="snippet-article_post">
                <div class="article-box snippet-article_content ">
                    <a href="<?php echo htmlspecialchars($fetch_post['slug']); ?>">
                        <img src="https://theindicvoice.com/assets/images/shortreadsPost/<?php echo htmlspecialchars($fetch_post['cover_img']); ?>" alt="channel_image" style="object-fit: fill;">
                    </a>
                    <h3 class="margin-bottom-none snippet-article_content-head">
                        <a data-ev-cat="page undefined" data-ev-act="article" data-ev-label="label undefined" href="<?php echo htmlspecialchars($fetch_post['slug']); ?>"><?php echo htmlspecialchars($fetch_post['title']); ?></a>
                    </h3>
                    <ul class="snippet-article_content-byline lg margin-bottom-none no-style">
                        <li>By <a href="/author/<?php echo htmlspecialchars($fetch_author['slug']); ?>"><?php echo htmlspecialchars($fetch_author['name']); ?></a>
                        </li>
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
    
    
    <?php
    if (file_exists("srcComponents/newsletterSection.php")) {
        include "srcComponents/newsletterSection.php";
    } else {
        include "../srcComponents/newsletterSection.php";
    }
    ?>
    
    
    <?php
    if (file_exists("srcComponents/footer.php")) {
        include "srcComponents/footer.php";
    } else {
        include "../srcComponents/footer.php";
    }
    ?>
    
    <script src="https://theindicvoice.com/assets/js/script.js"></script>
    <script src="https://theindicvoice.com/assets/js/slick.min.js"></script>
    
</body>
</html>