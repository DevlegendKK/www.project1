<?php
require_once "config/database.php";
require"page-views.php";
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
    
    
    <title>The Indic Voice</title>
	<meta name="description" content="The Indic Voice is a platform dedicated to exploring and presenting diverse worldviews across philosophy, society, history, culture, and architecture through the lens of India’s indigenous knowledge systems." />
	<link rel="canonical" href="https://theindicvoice.com/" />
	<meta property="og:locale" content="en_US" />
	<meta property="og:type" content="website" />
	<meta property="og:title" content="The Indic Voice" />
	<meta property="og:description" content="The Indic Voice is a platform dedicated to exploring and presenting diverse worldviews across philosophy, society, history, culture, and architecture through the lens of India’s indigenous knowledge systems." />
	<meta property="og:url" content="https://theindicvoice.com/" />
	<meta property="og:site_name" content="The Indic Voice" />
	<meta property="article:modified_time" content="2025-02-12T06:07:07+00:00" />
	<meta property="og:image" content="https://theindicvoice.com/assets/images/large_twitter.png?auto=compress&fm=png&ixlib=p" />
	<meta property="og:image:width" content="2400" />
	<meta property="og:image:height" content="1500" />
	<meta property="og:image:type" content="image/png" />
	<meta name="twitter:card" content="summary_large_image" />
	<meta name="twitter:title" content="The Indic Voice" />
	<script type="application/ld+json">{"@context":"https://schema.org","@graph":[{"@type":"WebPage","@id":"https://theindicvoice.com/","url":"https://theindicvoice.com/","name":"The Indic Voice","isPartOf":{"@id":"https://theindicvoice.com/#website"},"datePublished":"2021-09-15T14:57:52+00:00","dateModified":"2023-03-31T19:39:07+00:00","description":"The Indic Voice is a platform dedicated to exploring and presenting diverse worldviews across philosophy, society, history, culture, and architecture through the lens of India’s indigenous knowledge systems.","breadcrumb":{"@id":"https://theindicvoice.com/#breadcrumb"},"inLanguage":"en-US","potentialAction":[{"@type":"ReadAction","target":["https://theindicvoice.com/"]}]},{"@type":"BreadcrumbList","@id":"https://theindicvoice.com/#breadcrumb","itemListElement":[{"@type":"ListItem","position":1,"name":"Home"}]},{"@type":"WebSite","@id":"https://theindicvoice.com/#website","url":"https://theindicvoice.com/","name":"The Indic Voice","description":"The Indic Voice is a platform dedicated to exploring and presenting diverse worldviews across philosophy, society, history, culture, and architecture through the lens of India’s indigenous knowledge systems.","potentialAction":[{"@type":"SearchAction","target":{"@type":"EntryPoint","urlTemplate":"https://theindicvoice.com/s?search={search_term_string}"},"query-input":{"@type":"PropertyValueSpecification","valueRequired":true,"valueName":"search_term_string"}}],"inLanguage":"en-US"}]}</script>
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
            <?php require_once "srcComponents/topicSlider.php"; ?>

            <div class="channel-banner">
                <?php
                try {
                    $stmt = $conn->prepare("SELECT * FROM post WHERE status = :status ORDER BY published_at DESC LIMIT 0, 1");
                    $stmt->execute(['status' => 'true']);
                    
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
                        <figure>
                            <a href="/<?php echo htmlspecialchars($fetch_post['post_type']); ?>/<?php echo htmlspecialchars($fetch_post['slug']); ?>">
                                <img src="https://theindicvoice.com/assets/images/blog-post/<?php echo htmlspecialchars($fetch_post['featured_img']); ?>?auto=compress&#038;fm=png&#038;ixlib=php-3.3.1?crop=entropy&#038;auto=compress&#038;fit=crop&#038;h=605&#038;w=1440" alt="channel_image">
                            </a>
                        </figure>
                        <div class="wrapper">
                            <div class="article-box_content">
                                <h3 class="article-box_head">
                                    <a href="/<?php echo htmlspecialchars($fetch_post['post_type']); ?>/<?php echo htmlspecialchars($fetch_post['slug']); ?>"><?php echo htmlspecialchars($fetch_post['title']); ?></a>
                                </h3>
                                <div class="article-box_desc">
                                    <?php
                                    // Limit the description to 10 words
                                    $description = htmlspecialchars($fetch_post['description']);
                                    $words = explode(' ', $description);
                                    $limited_description = implode(' ', array_slice($words, 0, 10));
                                    ?>
                                    <p><?php echo $limited_description; ?><?php if (count($words) > 10) echo '...'; ?></p>
                                </div>
                                <ul class="article-box_byline margin-v-none padd-left-none no-style">
                                    <li>By <a href="/author/<?php echo htmlspecialchars($fetch_author['slug']); ?>"><?php echo htmlspecialchars($fetch_author['name']); ?></a></li>
                                </ul>
                            </div>
                        </div>
                        <?php
                    }
                } catch (PDOException $e) {
                    echo "Error: " . $e->getMessage();
                }
                ?>
            </div>



            <div class="article-stream container channel-article-stream inner-wrapper">
                <div>
                    <div class="horizontal-article-card-section article-stream custom-width-section">
                        <ul class="snippet-article home-bottom-article">
                            
                            <?php
                            try {
                                $stmt = $conn->prepare("SELECT * FROM post WHERE status = :status ORDER BY published_at DESC LIMIT 1, 6");
                                $stmt->execute(['status' => 'true']);
                                
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
                                                <li>By <a href="/author/<?php echo htmlspecialchars($fetch_author['slug']); ?>"><?php echo htmlspecialchars($fetch_author['name']); ?></a> </li>
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
                </div>
            </div>
            
            <hr class="wp-block-separator has-alpha-channel-opacity is-style-wide" style="margin-bottom:0;border-bottom: 1.3px solid var(--iv-color-secondary);">
            <style>.wp-block-group { box-sizing: border-box; } .wp-block-group.is-layout-constrained { position: relative; } /* Styles for groups with background */ .wp-block-group.has-background { padding: 1.25em 2.375em; } /* Styles for flex layout groups */ .wp-block-group.is-layout-flex { display: flex; flex-wrap: nowrap; justify-content: flex-start; align-items: flex-end; } /* Styles for the spacer block */ .wp-block-spacer { height: 50px; width: 0px; visibility: hidden; } /* Styles for the heading block */ .wp-block-heading { font-family: var(--iv-font-heading); font-size: 2.566rem; font-weight: 600; line-height: 1.15; } .wp-block-heading a { color: #333; text-decoration: none; } .wp-block-heading a:hover { text-decoration: underline; } /* Styles for the separator block */ .wp-block-separator { border: none; border-bottom: 2px solid; margin-left: auto; margin-right: auto; } .wp-block-separator.has-alpha-channel-opacity { opacity: 1;margin-top:0; } .wp-block-separator.is-style-wide { width: 100%; } /* Container-specific styles */ .wp-container-core-group-is-layout-5 { flex-wrap: nowrap; justify-content: flex-start; align-items: flex-end; } .wp-container-core-group-is-layout-6 > :where(:not(.alignleft):not(.alignright):not(.alignfull)) { max-width: 1130px; margin-left: auto !important; margin-right: auto !important; } .wp-container-core-group-is-layout-6 > .alignwide { max-width: 1130px; } .wp-container-core-group-is-layout-6 .alignfull { max-width: none; } .wp-container-content-5, .wp-container-content-6 { flex-basis: 20px; }</style>
            <div class="wp-block-group is-layout-constrained wp-container-core-group-is-layout-6 wp-block-group-is-layout-constrained">
                <div class="wp-block-group alignwide is-content-justification-left is-nowrap is-layout-flex wp-container-core-group-is-layout-5 wp-block-group-is-layout-flex">
                    <div style="height:50px;width:0px" aria-hidden="true" class="wp-block-spacer wp-container-content-5"></div>
                    <h2 class="wp-block-heading" id="h-culture">
                        <a href="/shortreads/" target="_blank"><img src="/assets/images/logo/logo-shortreads.svg" width="150"/></a>
                    </h2>
                </div>
            </div>


<!-- Add to your CSS -->
<style>
    /* Slick Slider Overrides */
    .slick-slider {
        position: relative;
        display: block;
        box-sizing: border-box;
    }

    .slick-list {
        overflow: hidden;
        margin: 0 -15px;
    }

    .slick-slide {
        float: left;
        height: 100%;
        min-height: 1px;
        padding: 0 15px;
    }

    .slick-arrow {
        position: absolute;
        top: 50%;
        transform: translateY(-50%);
        z-index: 1;
        background: transparent;
        border: none;
        font-size: 0;
        cursor: pointer;
    }

    .slick-prev {
        left: -40px;
    }

    .slick-next {
        right: -40px;
    }

    .slick-arrow::before {
        content: '';
        display: block;
        width: 30px;
        height: 30px;
        border: solid #333;
        border-width: 3px 3px 0 0;
    }

    .slick-prev::before {
        transform: rotate(-135deg);
    }

    .slick-next::before {
        transform: rotate(45deg);
    }

    .slick-dots {
        text-align: center;
    }

    .slick-dots li {
        display: inline-block;
        margin: 0 5px;
    }

    .slick-dots button {
        font-size: 0;
        width: 12px;
        height: 12px;
        border-radius: 50%;
        border: 1px solid #ccc;
        background: transparent;
    }

    .slick-dots .slick-active button {
        background: #333;
    }
</style>

<div class="horizontal-article-card-section wrapper inner-wrapper">
    <div class="posts-carousel">
        <?php
        try {
            $stmt = $conn->prepare("SELECT * FROM iv_shortreadsPosts WHERE status = :status ORDER BY published_at DESC LIMIT 0, 9");
            $stmt->execute(['status' => 'true']);
            $posts = $stmt->fetchAll(PDO::FETCH_ASSOC);
            
            foreach ($posts as $fetch_post) {
                $authorid = $fetch_post['author_id'];
                $time = date('d M Y', strtotime($fetch_post['published_at']));
                
                $author_stmt = $conn->prepare("SELECT * FROM author WHERE id = :authorid");
                $author_stmt->execute(['authorid' => $authorid]);
                $fetch_author = $author_stmt->fetch(PDO::FETCH_ASSOC);
                ?>
                <div class="carousel-item"> <!-- Changed from li to div -->
                    <div class="article-box snippet-article_content">
                        <a href="/shortreads/<?= htmlspecialchars($fetch_post['slug']) ?>">
                            <img src="https://theindicvoice.com/assets/images/shortreadsPost/<?= htmlspecialchars($fetch_post['cover_img']) ?>?auto=compress&#038;fm=png&#038;ixlib=php-3.3.1?crop=entropy&#038;auto=compress&#038;fit=crop&#038;h=605&#038;w=1440" 
                                 alt="<?= htmlspecialchars($fetch_post['title']) ?>">
                        </a>
                        <h3 class="margin-bottom-none snippet-article_content-head">
                            <a href="/shortreads/<?= htmlspecialchars($fetch_post['slug']) ?>">
                                <?= htmlspecialchars($fetch_post['title']) ?>
                            </a>
                        </h3>
                        <ul class="snippet-article_content-byline lg margin-bottom-none no-style" style="position: relative;">
                            <li>By <a href="/author/<?= htmlspecialchars($fetch_author['slug']) ?>"><?= htmlspecialchars($fetch_author['name']) ?></a></li>
                            <li class="pull-right">
                                <time datetime="<?= htmlspecialchars($fetch_post['published_at']) ?>"><?= $time ?></time>
                            </li>
                        </ul>
                    </div>
                </div>
                <?php
            }
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
        ?>
    </div>
</div>

<!-- Add these right before </body> -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.css"/>
<script src="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.min.js"></script>

<script>
$(document).ready(function(){
    $('.posts-carousel').slick({
        dots: true,
        arrows: true,
        infinite: true,
        speed: 300,
        slidesToShow: 3,
        slidesToScroll: 2,
        responsive: [
            {
                breakpoint: 1024,
                settings: {
                    slidesToShow: 2,
                    slidesToScroll: 1
                }
            },
            {
                breakpoint: 768,
                settings: {
                    slidesToShow: 1,
                    slidesToScroll: 1,
                    arrows: false
                }
            }
        ]
    });
});
</script>
            
            
            
            <hr class="wp-block-separator has-alpha-channel-opacity is-style-wide" style="margin-top:10px;border-bottom: 1.3px solid var(--iv-color-secondary);">
            
            <div class="article-stream container channel-article-stream inner-wrapper">
                <div>
                    <div class="horizontal-article-card-section article-stream custom-width-section">
                        <ul class="snippet-article load-more-content home-bottom-article">
                            
                            <?php
                            try {
                                $stmt = $conn->prepare("SELECT * FROM post WHERE status = :status ORDER BY published_at DESC LIMIT 7, 6");
                                $stmt->execute(['status' => 'true']);
                                
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
                                                <li>By <a href="/author/<?php echo htmlspecialchars($fetch_author['slug']); ?>"><?php echo htmlspecialchars($fetch_author['name']); ?></a> </li>
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
                        
                        <div class="load-more-container">
                            <button id="load-more" class="load-more-btn">Load More</button>
                        </div>
                        <style>/* Add to your CSS file */
.load-more-container {
    text-align: center;
    margin: 40px 0;
}

.load-more-btn {
    padding: 12px 30px;
    background-color: #2c3e50;
    color: white;
    border: none;
    border-radius: 4px;
    cursor: pointer;
    font-size: 16px;
    transition: background-color 0.3s ease;
}

.load-more-btn:hover {
    background-color: #34495e;
}

.loading .load-more-btn {
    background-color: #95a5a6;
    cursor: not-allowed;
}</style>
                    </div>
                </div>
            </div>




            <?php require_once "srcComponents/newsletterSection.php"; ?>
            <?php require_once "srcComponents/footer.php"; ?>

        </div>
    </div>

    <script src="/assets/js/script.js"></script>
    <script src="/assets/js/slick.min.js"></script>
    <script>
    $(document).ready(function() {
        let currentPage = 1;
        const postsPerPage = 12; // Match your initial limit
        
        $('#load-more').click(function() {
            const $button = $(this);
            $button.addClass('loading').prop('disabled', true);
            
            $.ajax({
                type: 'GET',
                url: 'srcComponents/load-more.php',
                data: {
                    page: ++currentPage,
                    per_page: postsPerPage
                },
                success: function(response) {
                    if (response.trim()) {
                        $('.load-more-content').append(response);
                    } else {
                        $button.hide();
                    }
                },
                error: function() {
                    console.error('Error loading more posts');
                },
                complete: function() {
                    $button.removeClass('loading').prop('disabled', false);
                }
            });
        });
    });
    </script>
    
<script>
(function () {
    const endpoint = "/track/session.php"; // PHP handler
    const storageKey = "user_visited_urls";
    const now = new Date().toISOString();
    const sessionId = sessionStorage.getItem("session_id") || crypto.randomUUID();
    sessionStorage.setItem("session_id", sessionId);

    // Track visited pages
    let visited = JSON.parse(sessionStorage.getItem(storageKey)) || [];
    visited.push(window.location.href);
    sessionStorage.setItem(storageKey, JSON.stringify(visited));

    const payload = {
        session_id: sessionId,
        user_type: document.body.dataset.userType || "guest", // or inject from PHP
        referrer: document.referrer,
        entry_page: visited[0],
        exit_page: window.location.href,
        query_string: window.location.search,
        visited_urls: visited,
        url: window.location.href,
        user_agent: navigator.userAgent,
        start_time: sessionStorage.getItem("session_start_time") || now,
        end_time: now
    };

    // First page: capture geolocation
    if (!sessionStorage.getItem("session_sent")) {
        sessionStorage.setItem("session_start_time", now);

        navigator.geolocation.getCurrentPosition(
            pos => {
                payload.latitude = pos.coords.latitude;
                payload.longitude = pos.coords.longitude;
                sendSession(payload);
            },
            () => {
                payload.latitude = null;
                payload.longitude = null;
                sendSession(payload);
            },
            { timeout: 2000 }
        );
    }

    // On page unload: send final info
    window.addEventListener("beforeunload", function () {
        payload.exit_page = window.location.href;
        payload.end_time = new Date().toISOString();
        navigator.sendBeacon(endpoint, JSON.stringify(payload));
    });

    function sendSession(data) {
        fetch(endpoint, {
            method: "POST",
            headers: { "Content-Type": "application/json" },
            body: JSON.stringify(data)
        });
        sessionStorage.setItem("session_sent", "1");
    }
})();
</script>




</body>
</html>