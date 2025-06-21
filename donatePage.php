<?php
include "config/database.php";
require"page-views.php";
$slug = isset($_GET['slug']) ? $_GET['slug'] : '';

function getPostDetailsBySlug($slug, $conn) {
    $stmt = $conn->prepare("SELECT created_at, modified_at FROM iv_pagesList WHERE slug = :slug LIMIT 1");
    $stmt->execute(['slug' => $slug]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

// Fetch post details
$postDetails = getPostDetailsBySlug($slug, $conn);

// Format dates for SEO meta tags
$createdDate = !empty($postDetails['created_at']) ? date('c', strtotime($postDetails['created_at'])) : date('c');
$modifiedDate = !empty($postDetails['modified_at']) ? date('c', strtotime($postDetails['modified_at'])) : $createdDate;

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
    
    
    <title>Support The Indic Voice - The Indic Voice</title>
    <meta name="description" content="This initiative is not funded by external sources but is powered by my dedication to providing high-quality, rigorous content that reflects India’s true intellectual heritage." />
    <link rel="canonical" href="https://theindicvoice.com/donate" />
    <meta property="og:locale" content="en_US" />
    <meta property="og:type" content="article" />
    <meta property="og:title" content="Support The Indic Voice - The Indic Voice" />
    <meta property="og:description" content="This initiative is not funded by external sources but is powered by my dedication to providing high-quality, rigorous content that reflects India’s true intellectual heritage." />
    <meta property="og:url" content="https://theindicvoice.com/donate" />
    <meta property="og:site_name" content="Support The Indic Voice - The Indic Voice" />
    <meta property="article:published_time" content="<?php echo htmlspecialchars($createdDate); ?>" />
    <meta property="article:modified_time" content="<?php echo htmlspecialchars($modifiedDate); ?>" />
    <meta name="datePublished" content="<?php echo htmlspecialchars($createdDate); ?>" />
    <meta name="dateModified" content="<?php echo htmlspecialchars($modifiedDate); ?>" />
    <meta property="og:updated_time" content="<?php echo htmlspecialchars($modifiedDate); ?>" />
    <meta property="og:image" content="https://theindicvoice.com/assets/images/large_twitter.png?auto=compress&fm=png&ixlib=p" />
    <meta property="og:image:width" content="2400" />
    <meta property="og:image:height" content="1500" />
    <meta property="og:image:type" content="image/png" />
    <meta name="twitter:card" content="summary_large_image" />
    <meta name="twitter:title" content="Support The Indic Voice - The Indic Voice" />
    <script type="application/ld+json">
        {
            "@context": "https://schema.org",
            "@graph": [{
                "@type": "WebPage",
                "@id": "https://theindicvoice.com/donate",
                "url": "https://theindicvoice.com/donate",
                "name": "Support The Indic Voice - The Indic Voice",
                "isPartOf": {
                    "@id": "https://theindicvoice.com/#website"
                },
                "primaryImageOfPage": {
                    "@id": "https://theindicvoice.com/donate#primaryimage"
                },
                "image": {
                    "@id": "https://theindicvoice.com/donate#primaryimage"
                },
                "thumbnailUrl": "https://theindicvoice.com/assets/images/large_twitter.png?auto=compress&amp;fit=scale&amp;fm=pjpg&amp;h=1024&amp;ixlib=php-3.3.1&amp;w=728&amp;wpsize=large",
                "datePublished": "<?php echo $createdDate; ?>",
                "dateModified": "<?php echo $modifiedDate; ?>",
                "description": "This initiative is not funded by external sources but is powered by my dedication to providing high-quality, rigorous content that reflects India’s true intellectual heritage.",
                "breadcrumb": {
                    "@id": "https://theindicvoice.com/donate#breadcrumb"
                },
                "inLanguage": "en-US",
                "potentialAction": [{
                    "@type": "ReadAction",
                    "target": ["https://theindicvoice.com/donate"]
                }]
            }, {
                "@type": "ImageObject",
                "inLanguage": "en-US",
                "@id": "https://theindicvoice.com/donate#primaryimage",
                "url": "https://theindicvoice.com/assets/images/large_twitter.png?auto=compress&amp;fit=scale&amp;fm=pjpg&amp;h=1024&amp;ixlib=php-3.3.1&amp;w=728&amp;wpsize=large",
                "contentUrl": "https://theindicvoice.com/assets/images/large_twitter.png?auto=compress&amp;fit=scale&amp;fm=pjpg&amp;h=1024&amp;ixlib=php-3.3.1&amp;w=728&amp;wpsize=large"
            }, {
                "@type": "BreadcrumbList",
                "@id": "https://theindicvoice.com/donate#breadcrumb",
                "itemListElement": [{
                    "@type": "ListItem",
                    "position": 1,
                    "name": "Home",
                    "item": "https://theindicvoice.com/"
                }, {
                    "@type": "ListItem",
                    "position": 2,
                    "name": "Support The Indic Voice"
                }]
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
        }
    </script>
	<link rel="alternate" type="application/rss+xml" title="The Indic Voice &raquo; Feed" href="https://theindicvoice.com/rss/" />
	<link rel="shortcut icon" href="https://theindicvoice.com/assets/images/favicon.png" >

    <link rel="preload" href="/assets/css/styles.css" as="style">
    <link rel="preload" href="/assets/js/script.js" as="script">

    <link rel="stylesheet" href="/assets/css/styles.css">
    <link rel="stylesheet" href="/assets/css/page-index.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    
    <script src="/assets/js/jquery/jquery.min.js"></script>
    <style>.static-title{font-weight:400;} .has-primary-color {color: var(--iv-color-primary) !important;}.dropcap p {margin-top: 0;margin-bottom: 22px;line-height: 1.7;font-size: 21px;font-family: var(--iv-font-body), Sans-Serif;} </style>
    
</head>
<body>
    <div class="iv-site-block">
        <div class="main-body">
            <?php require_once "srcComponents/header.php"; ?>
            
        
            
            
            <div class="body-box">
                <div class="min-wrapper">
                    <h1 class="static-title text-center">Support The Indic Voice</h1>
                    <div class="s-content-box">
                        <div class="s-content-box_main">
                            <div style="height:12px" aria-hidden="true" class="wp-block-spacer"></div>
                            <!--<h1 class="wp-block-heading has-text-align-center has-primary-color has-text-color" id="h-welcome-to-nbsp-nautilus">Welcome to&nbsp; <em>The Indic Voice</em>-->
                            <!--</h1>-->
                            <div style="height:14px" aria-hidden="true" class="wp-block-spacer"></div>
                            <div class="dropcap">
                                <p>As a student, I am driving <em>The Indic Voice</em> solely with a deep passion for presenting India's intellectual traditions to the world. This initiative is not funded by external sources but is powered by my dedication to providing high-quality, rigorous content that reflects India’s true intellectual heritage. To continue our work and make a larger impact, we need your support.</p><p>If you believe in our mission, please consider donating to <em>The Indic Voice</em>. Your contribution will enable us to produce more scholarly articles, amplify voices that need to be heard, and ensure that India’s perspective is properly represented on the global stage.</p> <p>Additionally, if you wish to contribute your own work, we welcome submissions. Please contact us at <a href="mailto:contact@theindicvoice.com">contact@theindicvoice.com</a>. After examining your piece, it may be published on our platform. Together, through both your generous support and intellectual contributions, we can make India’s story louder, clearer, and more impactful.</p>
                            </div>
                        </div>
                        <div class="s-content-box_sidebar">
                            <img src="/assets/images/upi.png"
                        </div>
                    </div>
                    <!-- content-box -->
                </div>
            </div>
            
            
            
            
            
            <?php require_once "srcComponents/footer.php"; ?>
        </div>
    </div>

    <script src="/assets/js/script.js"></script>
    <script src="/assets/js/slick.min.js"></script>
</body>
</html>