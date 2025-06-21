<?php
require_once "config/database.php";
require"page-views.php";

// Get the slug from the URL
$authorSlug = basename($_SERVER['REQUEST_URI']);
$authorSlug = filter_var($authorSlug, FILTER_SANITIZE_STRING);

// Function to get author details by slug
function getAuthorDetailsBySlug($authorSlug, $conn) {
    $stmt = $conn->prepare("SELECT id, name, author_img, about, instagram_handle, twitter_handle, linkedin_handle, slug, status FROM author WHERE slug = :slug LIMIT 1");
    $stmt->execute(['slug' => $authorSlug]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

// Fetch author details
$authorDetails = getAuthorDetailsBySlug($authorSlug, $conn);

// If author details not found, handle the error (optional)
if (!$authorDetails) {
    echo "Author not found.";
    exit;
}

// Fetch posts by the author
function getPostsByAuthorId($authorId, $conn) {
    $stmt = $conn->prepare("SELECT id, title, description, featured_img, category, slug, post_type, published_at FROM post WHERE author_id = :author_id AND status = :status ORDER BY published_at DESC");
    $stmt->execute(['author_id' => $authorId, 'status' => 'true']);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

$posts = getPostsByAuthorId($authorDetails['id'], $conn);
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
    
    
    <title><?php echo htmlspecialchars($authorDetails['name']); ?> - Author</title>
    <meta name="description" content="<?php echo htmlspecialchars(substr($authorDetails['about'], 0, 150)); ?>... Explore articles by <?php echo htmlspecialchars($authorDetails['name']); ?> on The Indic Voice." />
    <link rel="canonical" href="https://theindicvoice.com/author/<?php echo htmlspecialchars($authorDetails['slug']); ?>" />
    <meta property="og:locale" content="en_US" />
    <meta property="og:type" content="article" />
    <meta property="og:title" content="<?php echo htmlspecialchars($authorDetails['name']); ?> - Author" />
    <meta property="og:description" content="<?php echo htmlspecialchars(substr($authorDetails['about'], 0, 150)); ?>... Explore articles by <?php echo htmlspecialchars($authorDetails['name']); ?> on The Indic Voice." />
    <meta property="og:url" content="https://theindicvoice.com/author/<?php echo htmlspecialchars($authorDetails['slug']); ?>" />
    <meta property="og:site_name" content="<?php echo htmlspecialchars($authorDetails['name']); ?> - Author" />
    <meta property="article:published_time" content="2025-02-12T06:07:07+00:00" />
    <meta property="article:modified_time" content="2025-02-12T06:07:07+00:00" />
    <meta name="datePublished" content="2025-02-12T06:07:07+00:00" />
    <meta name="dateModified" content="2025-02-12T06:07:07+00:00" />
    <meta property="og:updated_time" content="2025-02-12T06:07:07+00:00" />
    <meta property="og:image" content="https://theindicvoice.com/assets/images/author/<?php echo htmlspecialchars($authorDetails['author_img']); ?>?auto=compress&fm=png&ixlib=p" />
    <meta property="og:image:width" content="2400" />
    <meta property="og:image:height" content="1500" />
    <meta property="og:image:type" content="image/png" />
    <meta name="twitter:card" content="summary_large_image" />
    <meta name="twitter:title" content="<?php echo htmlspecialchars($authorDetails['name']); ?> - Author" />
    <script type="application/ld+json">
        {
            "@context": "https://schema.org",
            "@graph": [{
                "@type": "WebPage",
                "@id": "https://theindicvoice.com/author/<?php echo htmlspecialchars($authorDetails['slug']); ?>",
                "url": "https://theindicvoice.com/author/<?php echo htmlspecialchars($authorDetails['slug']); ?>",
                "name": "<?php echo htmlspecialchars($authorDetails['name']); ?> - Author",
                "isPartOf": {
                    "@id": "https://theindicvoice.com/#website"
                },
                "primaryImageOfPage": {
                    "@id": "https://theindicvoice.com/author/<?php echo htmlspecialchars($authorDetails['slug']); ?>#primaryimage"
                },
                "image": {
                    "@id": "https://theindicvoice.com/author/<?php echo htmlspecialchars($authorDetails['slug']); ?>#primaryimage"
                },
                "thumbnailUrl": "https://theindicvoice.com/assets/images/author/<?php echo htmlspecialchars($authorDetails['author_img']); ?>?auto=compress&amp;fit=scale&amp;fm=pjpg&amp;h=1024&amp;ixlib=php-3.3.1&amp;w=728&amp;wpsize=large",
                "datePublished": "2025-02-12T06:07:07+00:00",
                "dateModified": "2025-02-12T06:07:07+00:00",
                "description": "<?php echo htmlspecialchars(substr($authorDetails['about'], 0, 150)); ?>... Explore articles by <?php echo htmlspecialchars($authorDetails['name']); ?> on The Indic Voice.",
                "breadcrumb": {
                    "@id": "https://theindicvoice.com/author/<?php echo htmlspecialchars($authorDetails['slug']); ?>#breadcrumb"
                },
                "inLanguage": "en-US",
                "potentialAction": [{
                    "@type": "ReadAction",
                    "target": ["https://theindicvoice.com/author/<?php echo htmlspecialchars($authorDetails['slug']); ?>"]
                }]
            }, {
              "@context": "https://schema.org",
              "@type": "Person",
              "name": "<?php echo htmlspecialchars($authorDetails['name']); ?>",
              "url": "https://theindicvoice.com/author/<?php echo htmlspecialchars($authorDetails['slug']); ?>",
              "image": "https://theindicvoice.com/assets/images/author/<?php echo htmlspecialchars($authorDetails['author_img']); ?>",
              "description": "<?php echo htmlspecialchars($authorDetails['about']); ?>",
              "sameAs": [
                "<?php echo !empty($authorDetails['instagram_handle']) ? '' . htmlspecialchars($authorDetails['instagram_handle']) : ''; ?>",
                "<?php echo !empty($authorDetails['twitter_handle']) ? '' . htmlspecialchars($authorDetails['twitter_handle']) : ''; ?>",
                "<?php echo !empty($authorDetails['linkedin_handle']) ? '' . htmlspecialchars($authorDetails['linkedin_handle']) : ''; ?>"
              ]
            }, {
                "@type": "ImageObject",
                "inLanguage": "en-US",
                "@id": "https://theindicvoice.com/author/<?php echo htmlspecialchars($authorDetails['slug']); ?>#primaryimage",
                "url": "https://theindicvoice.com/assets/images/author/<?php echo htmlspecialchars($authorDetails['author_img']); ?>?auto=compress&amp;fit=scale&amp;fm=pjpg&amp;h=1024&amp;ixlib=php-3.3.1&amp;w=728&amp;wpsize=large",
                "contentUrl": "https://theindicvoice.com/assets/images/author/<?php echo htmlspecialchars($authorDetails['author_img']); ?>?auto=compress&amp;fit=scale&amp;fm=pjpg&amp;h=1024&amp;ixlib=php-3.3.1&amp;w=728&amp;wpsize=large"
            }, {
                "@type": "WebSite",
                "@id": "https://theindicvoice.com/#website",
                "url": "https://theindicvoice.com/",
                "name": "The Indic Voice",
                "description": "The Indic Voice is a platform dedicated to exploring and presenting diverse worldviews across philosophy, society, history, culture, and architecture through the lens of India’s indigenous knowledge systems.",
                "potentialAction": [{
                    "@type": "SearchAction",
                    "target": {
                        "@type": "EntryPoint",
                        "urlTemplate": "https://theindicvoice.com/s?search={search_term_string}"
                    },
                    "query-input": {
                        "@type": "PropertyValueSpecification",
                        "valueRequired": true,
                        "valueName": "search_term_string"
                    }
                }],
                "inLanguage": "en-US"
            }]
        }, {
          "@context": "https://schema.org",
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
              "name": "Authors",
            },
            {
              "@type": "ListItem",
              "position": 3,
              "name": "<?php echo htmlspecialchars($authorDetails['name']); ?>",
              "item": "https://theindicvoice.com/author/<?php echo htmlspecialchars($authorDetails['slug']); ?>"
            }
          ]
        }
    </script>
	<link rel="alternate" type="application/rss+xml" title="The Indic Voice &raquo; Feed" href="https://theindicvoice.com/rss/" />
	<link rel="shortcut icon" href="https://theindicvoice.com/assets/images/favicon.png" >

    <link rel="preload" href="/assets/css/styles.css" as="style">
    <link rel="preload" href="/assets/js/script.js" as="script">

    <link rel="stylesheet" href="/assets/css/styles.css">
    <link rel="stylesheet" href="/assets/css/page-index.css">
<style>.author-profile-section { display: flex; flex-direction: column; align-items: center; text-align: center; padding: 50px 20px; border-radius: 10px; margin: 50px auto; max-width: 900px; } .author-profile-img { width: 150px; height: 150px; object-fit: cover; border-radius: 50%; border: 5px solid #ddd; margin-bottom: 15px; } .author-details h1 { font-size: 28px; font-weight: 600; color: #333; margin-bottom: 10px; } .author-about { font-size: 16px; line-height: 1.6; color: #555; max-width: 700px; margin-bottom: 20px; } .author-social-links { display: flex; justify-content: center; margin-top: 15px; } .social-icon { display: inline-flex; align-items: center; justify-content: center; width: 40px; height: 40px; border-radius: 50%; color: white; font-size: 18px; text-decoration: none; transition: transform 0.3s ease, opacity 0.3s ease; } .social-icon:hover { transform: scale(1.1); opacity: 0.85; } @media (max-width: 600px) { .author-profile-section { padding: 30px; } .author-profile-img { width: 120px; height: 120px; } .author-details h1 { font-size: 24px; } .author-about { font-size: 14px; } .social-icon { width: 35px; height: 35px; font-size: 16px; } } .h2 { font-size: 26px; font-weight: 600; color: #222; text-align: center; margin: 40px 0 20px; position: relative; padding-bottom: 10px; } .h2::after { content: ""; display: block; width: 80px; height: 3px; background: #0077b5; margin: 8px auto 0; border-radius: 5px; } @media (max-width: 768px) { .h2 { font-size: 22px; } .h2::after { width: 60px; height: 2.5px; } }</style>
    <script src="/assets/js/jquery/jquery.min.js"></script>
</head>
<body>
    <div class="iv-site-block">
        <div class="main-body">
            <?php require_once "srcComponents/header.php"; ?>

            <!-- Author Profile Section -->
            <div class="author-profile-section">
                <div class="author-profile-banner">
                    <img src="https://theindicvoice.com/assets/images/author/<?php echo htmlspecialchars($authorDetails['author_img']); ?>" alt="Profile picture of <?php echo htmlspecialchars($authorDetails['name']); ?>" class="author-profile-img">
                </div>
                <div class="author-details">
                    <h1><?php echo htmlspecialchars($authorDetails['name']); ?></h1>
                    <p class="author-about"><?php echo nl2br(htmlspecialchars($authorDetails['about'])); ?></p>
                    <div class="author-social-links">
                        <?php if (!empty($authorDetails['instagram_handle'])): ?>
                            <a href="https://instagram.com/<?php echo htmlspecialchars($authorDetails['instagram_handle']); ?>" target="_blank" class="social-icon instagram"><img src="/assets/images/icons/instagram-icon.svg" width="30"></a>
                        <?php endif; ?>
                        <?php if (!empty($authorDetails['linkedin_handle'])): ?>
                            <a href="https://linkedin.com/in/<?php echo htmlspecialchars($authorDetails['linkedin_handle']); ?>" target="_blank" class="social-icon linkedin"><img src="/assets/images/icons/linkedin-icon.svg" width="30"></a>
                        <?php endif; ?>
                        <?php if (!empty($authorDetails['twitter_handle'])): ?>
                            <a href="https://twitter.com/<?php echo htmlspecialchars($authorDetails['twitter_handle']); ?>" target="_blank" class="social-icon twitter"><img src="/assets/images/icons/twitter-icon.svg" width="30"><a>
                        <?php endif; ?>
                    </div>
                </div>
            </div>

            <!-- Author's Articles -->
            <h2 class="h2">Articles by <?php echo htmlspecialchars($authorDetails['name']); ?></h2>
            <div class="author-posts-section">
                <div class="wrapper article-card-section inner-wrapper">
                    <ul class="article-list padd-left-none">
                        <?php
                        if (count($posts) > 0) {
                            foreach ($posts as $fetch_post) {
                                $time = date('d M Y', strtotime($fetch_post['published_at']));
                        ?>
                        <li class="article-list_item">
                            <div class="article-list_item-img">
                                <a href="/<?php echo htmlspecialchars($fetch_post['post_type']); ?>/<?php echo htmlspecialchars($fetch_post['slug']); ?>" class="article-box snippet-article_content">
                                    <img alt="Article Image" src="https://theindicvoice.com/assets/images/blog-post/<?php echo htmlspecialchars($fetch_post['featured_img']); ?>?q=65&auto=format&w=700&ar=16:9&fit=crop">
                                </a>
                            </div>
                            <div class="article-list_item-content">
                                <ul class="article-list_item-byline padd-left-none margin-top-none">
                                    <li class="cat-list-item">
                                        <a href="/<?php echo htmlspecialchars($fetch_post['category']); ?>/"><?php echo htmlspecialchars($fetch_post['category']); ?></a>
                                    </li>
                                </ul>
                                <a href="/<?php echo htmlspecialchars($fetch_post['post_type']); ?>/<?php echo htmlspecialchars($fetch_post['slug']); ?>">
                                    <h2 class="article-list_item-head margin-top-none"><?php echo htmlspecialchars($fetch_post['title']); ?></h2>
                                </a>
                                <ul class="article-list_item-byline padd-left-none margin-top-none">
                                    <li>Published on <?php echo $time; ?></li>
                                </ul>
                                <div class="article-list_item-desc">
                                    <?php
                                    $description = htmlspecialchars($fetch_post['description']);
                                    $words = explode(' ', $description);
                                    $limited_description = implode(' ', array_slice($words, 0, 15));
                                    echo $limited_description . (count($words) > 10 ? '...' : '');
                                    ?>
                                </div>
                            </div>
                        </li>
                        <?php
                            }
                        } else {
                            echo "<p>No articles found by this author.</p>";
                        }
                        ?>
                    </ul>
                </div>
            </div>

            <?php require_once "srcComponents/footer.php"; ?>
        </div>
    </div>

    <script src="/assets/js/script.js"></script>
    <script src="/assets/js/slick.min.js"></script>
</body>
</html>
