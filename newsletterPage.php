<?php
include "config/database.php"; // Ensure database connection is included
require"page-views.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_STRING);
    $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);

    // Check if name and email are not empty
    if (empty($name) || empty($email)) {
        echo json_encode(['status' => 'error', 'message' => 'Both name and email are required.']);
        exit();
    }

    try {
        // Check if the email already exists
        $stmt = $conn->prepare("SELECT id FROM iv_newsletter WHERE email = :email");
        $stmt->execute(['email' => $email]);
        if ($stmt->fetch()) {
            echo json_encode(['status' => 'error', 'message' => 'This email is already subscribed.']);
            exit();
        }

        // Insert into database
        $stmt = $conn->prepare("INSERT INTO iv_newsletter (name, email) VALUES (:name, :email)");
        $stmt->execute(['name' => $name, 'email' => $email]);

        echo json_encode(['status' => 'success', 'message' => 'You have successfully subscribed!']);
    } catch (PDOException $e) {
        echo json_encode(['status' => 'error', 'message' => 'Database error: ' . $e->getMessage()]);
    }
    exit();
}

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
    
    
    <title>Newsletter - The Indic Voice</title>
    <meta name="description" content="At The Indic Voice, we go beyond headlines and trending narratives. Our newsletter delivers rigorous, thought-provoking, and well-researched insights on India's intellectual traditions, history, philosophy, and global relevance—straight to your inbox." />
    <link rel="canonical" href="https://theindicvoice.com/newsletter" />
    <meta property="og:locale" content="en_US" />
    <meta property="og:type" content="article" />
    <meta property="og:title" content="Newsletter - The Indic Voice" />
    <meta property="og:description" content="At The Indic Voice, we go beyond headlines and trending narratives. Our newsletter delivers rigorous, thought-provoking, and well-researched insights on India's intellectual traditions, history, philosophy, and global relevance—straight to your inbox." />
    <meta property="og:url" content="https://theindicvoice.com/newsletter" />
    <meta property="og:site_name" content="Newsletter - The Indic Voice" />
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
    <meta name="twitter:title" content="Newsletter - The Indic Voice" />
    <script type="application/ld+json">
        {
            "@context": "https://schema.org",
            "@graph": [{
                "@type": "WebPage",
                "@id": "https://theindicvoice.com/newsletter",
                "url": "https://theindicvoice.com/newsletter",
                "name": "Newsletter - The Indic Voice",
                "isPartOf": {
                    "@id": "https://theindicvoice.com/#website"
                },
                "primaryImageOfPage": {
                    "@id": "https://theindicvoice.com/newsletter#primaryimage"
                },
                "image": {
                    "@id": "https://theindicvoice.com/newsletter#primaryimage"
                },
                "thumbnailUrl": "https://theindicvoice.com/assets/images/large_twitter.png?auto=compress&amp;fit=scale&amp;fm=pjpg&amp;h=1024&amp;ixlib=php-3.3.1&amp;w=728&amp;wpsize=large",
                "datePublished": "<?php echo $createdDate; ?>",
                "dateModified": "<?php echo $modifiedDate; ?>",
                "description": "At The Indic Voice, we go beyond headlines and trending narratives. Our newsletter delivers rigorous, thought-provoking, and well-researched insights on India's intellectual traditions, history, philosophy, and global relevance—straight to your inbox.",
                "breadcrumb": {
                    "@id": "https://theindicvoice.com/newsletter#breadcrumb"
                },
                "inLanguage": "en-US",
                "potentialAction": [{
                    "@type": "ReadAction",
                    "target": ["https://theindicvoice.com/newsletter"]
                }]
            }, {
                "@type": "ImageObject",
                "inLanguage": "en-US",
                "@id": "https://theindicvoice.com/newsletter#primaryimage",
                "url": "https://theindicvoice.com/assets/images/large_twitter.png?auto=compress&amp;fit=scale&amp;fm=pjpg&amp;h=1024&amp;ixlib=php-3.3.1&amp;w=728&amp;wpsize=large",
                "contentUrl": "https://theindicvoice.com/assets/images/large_twitter.png?auto=compress&amp;fit=scale&amp;fm=pjpg&amp;h=1024&amp;ixlib=php-3.3.1&amp;w=728&amp;wpsize=large"
            }, {
                "@type": "BreadcrumbList",
                "@id": "https://theindicvoice.com/newsletter#breadcrumb",
                "itemListElement": [{
                    "@type": "ListItem",
                    "position": 1,
                    "name": "Home",
                    "item": "https://theindicvoice.com/"
                }, {
                    "@type": "ListItem",
                    "position": 2,
                    "name": "Newsletter"
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
    <link rel="stylesheet" href="/assets/css/styles.css">
    <link rel="stylesheet" href="/assets/css/page-index.css">
    <link rel="stylesheet" href="/assets/css/style.min.css">
    <script src="/assets/js/jquery/jquery.min.js"></script>
    <style>
        html, body {
            height: 100%; /* Ensure full height for the overlay */
            margin: 0;
            padding: 0;
            font-family: var(--iv-font-body);
        }
        body {
            position: relative;
            background: url(/assets/images/newsletter_image.png);
            background-size: cover;
            background-position: center;
        }
        .overlay {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: rgba(255, 255, 255, 0.1); /* White with 70% opacity */
            z-index: 1; /* Ensure it sits above the background */
        }
        .container {
            position: relative; /* Ensure container is above overlay */
            z-index: 2; /* Ensure container is above overlay */
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
            border-radius: 8px;
            text-align: left;
        }
        h1 {
            font-size: 2.5em;
            color: #333;
            text-align: left;
            margin-bottom: 20px;
            font-family: var(--iv-font-heading);
            font-weight: 600;
        }
        h2 {
            font-size: 1.5em;
            color: #333;
            text-align: left;
            margin: 10px 0;
            font-family: var(--iv-font-heading);
            font-weight: 600;
        }
        h3 {
            font-size: 1.25em;
            text-align: left;
            color: #333;
            margin: 10px 0;
            font-family: var(--iv-font-body);
            font-weight: 400;
        }
        p {
            font-size: 0.9em;
            color: #555;
            text-align: left;
            margin-bottom: 20px;
            font-family: var(--iv-font-body);
            font-weight: 400;
            max-width: 500px;
        }
        .newsletter-form {
            display: flex;
            flex-direction: column;
            align-items: left;
            margin-top: 20px;
        }
        .newsletter-form input[type="text"],
        .newsletter-form input[type="email"] {
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
            margin-bottom: 10px;
            width: 100%;
            max-width: 400px;
            font-size: 1em;
        }
        .newsletter-form button {
            padding: 10px 20px;
            background-color: #efcf81;
            border: none;
            border-radius: 4px;
            font-size: 1em;
            cursor: pointer;
            width: fit-content;
            transition: background-color 0.3s;
        }
        .newsletter-form button:hover {
            background-color: #d4b76e;
        }
        .footer {
            margin-top: 20px;
            font-size: 0.9em;
            color: #777;
            text-align: center;
        }
        label {display: none;}
    </style>
</head>
<body>
    <div class="overlay"></div>
    <div class="container">
        <h1>Stay Informed. Stay Inspired.</h1>
        <h2>Subscribe to The Indic Voice Newsletter.</h2>
        <h4>Bringing India’s Intellectual Heritage to the World</h4>
        <p>At The Indic Voice, we go beyond headlines and trending narratives. Our newsletter delivers rigorous, thought-provoking, and well-researched insights on India's intellectual traditions, history, philosophy, and global relevance—straight to your inbox.</p>
        
        <!-- Response Message -->
        <div id="newsletter-message" style="text-align: center; margin-top: 10px; font-weight: bold;"></div>

        <form class="newsletter-form" id="form_newsletter-signup" method="post">
            <label for="name">Name</label>
            <input type="text" id="name" name="name" placeholder="Enter your Name" required>
            <label for="email">Email</label>
            <input type="email" id="email" name="email" placeholder="Enter your email address" required>
            <button type="submit">Sign up for free</button>
        </form>
        
        <div class="footer">
            <p>Delivered 4 times per month. <strong>Unsubscribe anytime.</strong></p>
        </div>
    </div>
    <script src="/assets/js/script.js"></script>
    <script>
        jQuery(document).ready(function() {
    jQuery('#form_newsletter-signup').on('submit', function(e) {
        e.preventDefault();
        var formData = jQuery(this).serialize();

        jQuery.ajax({
            type: "POST",
            data: formData,
            dataType: "json",
            success: function(response) {
                jQuery("#newsletter-message").text(response.message)
                    .css("color", response.status === "success" ? "green" : "red");

                if (response.status === "success") {
                    jQuery('#form_newsletter-signup')[0].reset(); // Clear form after success
                }
            },
            error: function() {
                jQuery("#newsletter-message").text("An error occurred. Please try again.").css("color", "red");
            }
        });
    });
});

    </script>
</body>
</html>