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
    
    
    <title>Write For Us - The Indic Voice</title>
    <meta name="description" content="These Terms of Use govern your use of The Indic Voice website The Indic Voice. By accessing or using the Website, you agree to be bound by these Terms of Use." />
    <link rel="canonical" href="https://theindicvoice.com/write-for-us" />
    <meta property="og:locale" content="en_US" />
    <meta property="og:type" content="article" />
    <meta property="og:title" content="Write For Us - The Indic Voice" />
    <meta property="og:description" content="These Terms of Use govern your use of The Indic Voice website The Indic Voice. By accessing or using the Website, you agree to be bound by these Terms of Use." />
    <meta property="og:url" content="https://theindicvoice.com/write-for-us" />
    <meta property="og:site_name" content="Write For Us - The Indic Voice" />
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
    <meta name="twitter:title" content="Write For Us - The Indic Voice" />
    <script type="application/ld+json">
        {
            "@context": "https://schema.org",
            "@graph": [{
                "@type": "WebPage",
                "@id": "https://theindicvoice.com/write-for-us",
                "url": "https://theindicvoice.com/write-for-us",
                "name": "Write For Us - The Indic Voice",
                "isPartOf": {
                    "@id": "https://theindicvoice.com/#website"
                },
                "primaryImageOfPage": {
                    "@id": "https://theindicvoice.com/write-for-us#primaryimage"
                },
                "image": {
                    "@id": "https://theindicvoice.com/write-for-us#primaryimage"
                },
                "thumbnailUrl": "https://theindicvoice.com/assets/images/large_twitter.png?auto=compress&amp;fit=scale&amp;fm=pjpg&amp;h=1024&amp;ixlib=php-3.3.1&amp;w=728&amp;wpsize=large",
                "datePublished": "<?php echo $createdDate; ?>",
                "dateModified": "<?php echo $modifiedDate; ?>",
                "description": "These Terms of Use govern your use of The Indic Voice website The Indic Voice. By accessing or using the Website, you agree to be bound by these Terms of Use.",
                "breadcrumb": {
                    "@id": "https://theindicvoice.com/write-for-us#breadcrumb"
                },
                "inLanguage": "en-US",
                "potentialAction": [{
                    "@type": "ReadAction",
                    "target": ["https://theindicvoice.com/write-for-us"]
                }]
            }, {
                "@type": "ImageObject",
                "inLanguage": "en-US",
                "@id": "https://theindicvoice.com/write-for-us#primaryimage",
                "url": "https://theindicvoice.com/assets/images/large_twitter.png?auto=compress&amp;fit=scale&amp;fm=pjpg&amp;h=1024&amp;ixlib=php-3.3.1&amp;w=728&amp;wpsize=large",
                "contentUrl": "https://theindicvoice.com/assets/images/large_twitter.png?auto=compress&amp;fit=scale&amp;fm=pjpg&amp;h=1024&amp;ixlib=php-3.3.1&amp;w=728&amp;wpsize=large"
            }, {
                "@type": "BreadcrumbList",
                "@id": "https://theindicvoice.com/write-for-us#breadcrumb",
                "itemListElement": [{
                    "@type": "ListItem",
                    "position": 1,
                    "name": "Home",
                    "item": "https://theindicvoice.com/"
                }, {
                    "@type": "ListItem",
                    "position": 2,
                    "name": "Write For Us"
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
                    <h1 class="static-title text-center">Write For Us</h1>
                    <div class="s-content-box">
                        <div class="s-content-box_main">
                            <div style="height:12px" aria-hidden="true" class="wp-block-spacer"></div>
                            <!--<h1 class="wp-block-heading has-text-align-center has-primary-color has-text-color" id="h-welcome-to-nbsp-nautilus">Welcome to&nbsp; <em>The Indic Voice</em>-->
                            <!--</h1>-->
                            <div style="height:14px" aria-hidden="true" class="wp-block-spacer"></div>
                            <div class="dropcap">
                            <p>If you wish to contribute to <em>The Indic Voice</em> with your work or ideas, we welcome submissions. Please contact us at <a href="mailto:contact@theindicvoice.com">contact@theindicvoice.com</a> for more details on how to get published with us.</p>
                            </div>
                        </div>
                        <div class="s-content-box_sidebar">
                            <ul class="s-sidebar-box">
                                <li class="s-sidebar-box_list active">
                                    <a href="/about">
                                        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
                                        <i class="s-list-icon icon-f fa fa-smile"></i>
                                        <span>About</span>
                                    </a>
                                </li>
                                <!--<li class="s-sidebar-box_list">-->
                                <!--    <a href="/faq/">-->
                                <!--        <i class="s-list-icon icon-f fa fa-folder"></i>-->
                                <!--        <span>FAQs</span>-->
                                <!--    </a>-->
                                <!--</li>-->
                                <li class="s-sidebar-box_list">
                                    <a href="/contact">
                                        <i class="s-list-icon icon-f fa  fa-envelope"></i>
                                        <span>Contact</span>
                                    </a>
                                </li>
                                <li class="s-sidebar-box_list">
                                    <a href="/newsletter">
                                        <i class="s-list-icon icon-f fa fa-paper-plane"></i>
                                        <span>Newsletter</span>
                                    </a>
                                </li>
                                <li class="s-sidebar-box_list">
                                    <a href="/terms-of-use-and-privacy-policy">
                                        <i class="s-list-icon icon-f fa fa-file-text"></i>
                                        <span>Terms Of Use & Privacy Policy</span>
                                    </a>
                                </li>
                                <li class="s-sidebar-box_list">
                                    <a href="/rss/" target="_blank">
                                        <i class="s-list-icon icon-f fa fa-rss"></i>
                                        <span>RSS</span>
                                    </a>
                                </li>
                            </ul>
                            <!-- s-sidebar-box -->
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