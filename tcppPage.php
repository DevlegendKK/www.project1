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
    
    
    <title>Terms Of Use & Privacy Policy - The Indic Voice</title>
    <meta name="description" content="These Terms of Use govern your use of The Indic Voice website The Indic Voice. By accessing or using the Website, you agree to be bound by these Terms of Use." />
    <link rel="canonical" href="https://theindicvoice.com/terms-of-use-and-privacy-policy" />
    <meta property="og:locale" content="en_US" />
    <meta property="og:type" content="article" />
    <meta property="og:title" content="Terms Of Use & Privacy Policy - The Indic Voice" />
    <meta property="og:description" content="These Terms of Use govern your use of The Indic Voice website The Indic Voice. By accessing or using the Website, you agree to be bound by these Terms of Use." />
    <meta property="og:url" content="https://theindicvoice.com/terms-of-use-and-privacy-policy" />
    <meta property="og:site_name" content="Terms Of Use & Privacy Policy - The Indic Voice" />
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
    <meta name="twitter:title" content="Terms Of Use & Privacy Policy - The Indic Voice" />
    <script type="application/ld+json">
        {
            "@context": "https://schema.org",
            "@graph": [{
                "@type": "WebPage",
                "@id": "https://theindicvoice.com/terms-of-use-and-privacy-policy",
                "url": "https://theindicvoice.com/terms-of-use-and-privacy-policy",
                "name": "Terms Of Use & Privacy Policy - The Indic Voice",
                "isPartOf": {
                    "@id": "https://theindicvoice.com/#website"
                },
                "primaryImageOfPage": {
                    "@id": "https://theindicvoice.com/terms-of-use-and-privacy-policy#primaryimage"
                },
                "image": {
                    "@id": "https://theindicvoice.com/terms-of-use-and-privacy-policy#primaryimage"
                },
                "thumbnailUrl": "https://theindicvoice.com/assets/images/large_twitter.png?auto=compress&amp;fit=scale&amp;fm=pjpg&amp;h=1024&amp;ixlib=php-3.3.1&amp;w=728&amp;wpsize=large",
                "datePublished": "<?php echo $createdDate; ?>",
                "dateModified": "<?php echo $modifiedDate; ?>",
                "description": "These Terms of Use govern your use of The Indic Voice website The Indic Voice. By accessing or using the Website, you agree to be bound by these Terms of Use.",
                "breadcrumb": {
                    "@id": "https://theindicvoice.com/terms-of-use-and-privacy-policy#breadcrumb"
                },
                "inLanguage": "en-US",
                "potentialAction": [{
                    "@type": "ReadAction",
                    "target": ["https://theindicvoice.com/terms-of-use-and-privacy-policy"]
                }]
            }, {
                "@type": "ImageObject",
                "inLanguage": "en-US",
                "@id": "https://theindicvoice.com/terms-of-use-and-privacy-policy#primaryimage",
                "url": "https://theindicvoice.com/assets/images/large_twitter.png?auto=compress&amp;fit=scale&amp;fm=pjpg&amp;h=1024&amp;ixlib=php-3.3.1&amp;w=728&amp;wpsize=large",
                "contentUrl": "https://theindicvoice.com/assets/images/large_twitter.png?auto=compress&amp;fit=scale&amp;fm=pjpg&amp;h=1024&amp;ixlib=php-3.3.1&amp;w=728&amp;wpsize=large"
            }, {
                "@type": "BreadcrumbList",
                "@id": "https://theindicvoice.com/terms-of-use-and-privacy-policy#breadcrumb",
                "itemListElement": [{
                    "@type": "ListItem",
                    "position": 1,
                    "name": "Home",
                    "item": "https://theindicvoice.com/"
                }, {
                    "@type": "ListItem",
                    "position": 2,
                    "name": "Terms Of Use & Privacy Policy"
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
                    <h1 class="static-title text-center">Terms Of Use & Privacy Policy</h1>
                    <div class="s-content-box">
                        <div class="s-content-box_main">
                            <div style="height:12px" aria-hidden="true" class="wp-block-spacer"></div>
                            <div class="dropcap">
                            <h3>Terms Of Use</h3><p>These Terms of Use govern your use of The Indic Voice website <a href="https://theindicvoice.com" style="color:#004AAD">The Indic Voice</a>. By accessing or using the Website, you agree to be bound by these Terms of Use.</p><ol><li><b>Confidentiality of Information</b>: You acknowledge and agree that any information provided by you is maintained with utmost confidentiality. We will not disclose your information to any person or authority except as required under applicable laws or regulatory requirements. However, you consent that we may disclose your information upon your express permission.</li><li><b>Responsibility for Content</b>: You agree that The Indic Voice is not responsible for any actions, claims, or legal proceedings initiated by statutory, governmental authorities, or third parties arising from any posts, comments, or content (written, pictorial, or otherwise) submitted by you on the Website. You understand that you are solely liable for any such content and The Indic Voice disclaims any liability for consequential, indirect, or special damages arising from such content.</li><li><b>Ownership of Content</b>: All content, including texts, images, videos, software, and other materials ("Content"), accessible on the Website, whether publicly or privately, is the proprietary information of The Indic Voice. You agree not to use, copy, or reproduce the Content without the express written consent of The Indic Voice's editorial team.</li><li><b>Posting Guidelines</b>: You agree not to post or publish any offensive, objectionable, abusive, defamatory, or inflammatory material on the Website. You acknowledge that posting such content may result in legal actions for which you will be solely responsible, and The Indic Voice shall not be liable.</li><li><b>Use Restrictions</b>: <ol><li>You agree not to use or copy any material from the Website or its archives without the express written consent of The Indic Voice's editorial board.</li><li>Commercial use of the Website or its contents is prohibited without the express written consent of The Indic Voice's editorial board.</li><li>You agree not to use the Website in any manner that could give rise to civil or criminal liability against any party, including The Indic Voice.</li></ol></li><li><b>Accuracy of Information</b>: You confirm that all information provided by you is accurate and true to the best of your knowledge. You acknowledge that any loss incurred due to false or incorrect information provided by you will be your sole responsibility and liability.</li></ol><br><br><h3>Privacy Policy</h3><p>Welcome to The Indic Voice. This Privacy Policy outlines how we collect, use, and protect your personal information when you visit or register on our website <a href="https://theindicvoice.com/">https://theindicvoice.com/</a>.</p><ol><li><b>Collection and Use of Personal Information</b>: The Indic Voice ensures the privacy and confidentiality of all personal information provided by visitors and registered users. We do not share any data with third parties for any consideration.</li><li><b>Data Security</b>: All data entered or submitted by visitors or registered users on our website is securely stored and kept private. We employ stringent measures to safeguard this information.</li><li><b>Use of Submitted Data</b>: We may use the information provided by visitors or registered users to:<br><ol type="A"><li>Communicate updates about the website, posts, articles, etc.</li><li>Issue receipts, acknowledgements, newsletters, brochures, or introductory communications related to contributions made on the website.</li></ol></li><li><b>Responses to Communications</b>: The Indic Voice reserves the right to respond to requests, demands, information, data, posts, comments, etc., submitted by visitors or registered users via emails, letters, or other appropriate means.</li><li><b>Ownership and Use of User-Generated Content</b>: Any comments, posts, information, or data posted or submitted by visitors or registered users on our website shall be considered the proprietary information of The Indic Voice. We may use such content and cite the website as the source in print, social media, or other forms of media.</li><li><b>Visual and Audio Content</b>: Unless otherwise indicated, all images, photographs, graphics, artwork, and related visual, video, and audio content sourced from Google searches are used under the Fair Use Policy. The Indic Voice does not claim copyright over such material.</li><li><b>Contact Us</b>: If you have any questions or concerns about this Privacy Policy or our data practices, please contact us at:<ol><li><b>Email</b>: <a href="mailto:contact@theindicvoice.com">contact@theindicvoice.com</a></li><li><b>Secure Email</b>: <a href="mailto:abhishekiitd267@gmail.com">abhishekiitd267@gmail.com</a></li></ol></li></ol>
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