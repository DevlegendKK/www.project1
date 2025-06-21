<?php
include "../config/database.php";

$request_uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$path_segments = explode('/', trim($request_uri, '/'));
$slug = end($path_segments);


try {
if (strpos($slug, 'rss') === 0) {
    include "shortreadsRSS.php";
    exit();
}
    $stmt = $conn->prepare("SELECT * FROM iv_shortreadsPosts WHERE slug = :slug");
    $stmt->bindParam(':slug', $slug, PDO::PARAM_STR);
    $stmt->execute();
    
    $post = $stmt->fetch(PDO::FETCH_ASSOC);

    if(!$post) {
        header("HTTP/1.0 404 Not Found");
        include '../404.php';
        exit();
    }
} catch(PDOException $e) {
    die("Database error: " . $e->getMessage());
}

$author_id = $post['author_id'];
// Function to fetch author by ID
function getAuthorById($author_id, $conn) {
    $stmt = $conn->prepare("SELECT name, slug, twitter_handle FROM author WHERE id = :author_id LIMIT 1");
    $stmt->execute(['author_id' => $author_id]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
}
$authorDetails = getAuthorById($post['author_id'], $conn);


$post_id = $post['id'];

// Function to fetch comments by post ID
function getCommentsByPostId($post_id, $conn) {
    $stmt = $conn->prepare("SELECT id, userName, userEmail, comment, created_at, parent_comment_id FROM iv_shortreadsPostComments WHERE post_id = :post_id and status = 'true' ORDER BY created_at DESC");
    $stmt->execute(['post_id' => $post_id]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

$comments = getCommentsByPostId($post_id, $conn);

// Handle form submission for adding a comment
if ($_SERVER["REQUEST_METHOD"] == "POST" && !isset($_POST['replyTo'])) {
    $name = filter_input(INPUT_POST, 'userName', FILTER_SANITIZE_STRING);
    $email = filter_input(INPUT_POST, 'userEmail', FILTER_SANITIZE_EMAIL);
    $comment = filter_input(INPUT_POST, 'comment', FILTER_SANITIZE_STRING);
    $parent_comment_id = 0;  // No parent for main comments

    if ($name && $email && $comment) {
        $stmt = $conn->prepare("INSERT INTO iv_shortreadsPostComments (post_id, userName, userEmail, comment, parent_comment_id) VALUES (:post_id, :userName, :userEmail, :comment, :parent_comment_id)");
        $stmt->execute([
            'post_id' => $post_id,
            'userName' => $name,
            'userEmail' => $email,
            'comment' => $comment,
            'parent_comment_id' => $parent_comment_id
        ]);
        header("Location: " . $_SERVER['HTTP_REFERER']."#comments");
        exit();
    }
}

// Handle form submission for replying to a comment
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['replyTo'])) {
    $parent_comment_id = filter_input(INPUT_POST, 'replyTo', FILTER_SANITIZE_NUMBER_INT);
    $name = filter_input(INPUT_POST, 'userName', FILTER_SANITIZE_STRING);
    $email = filter_input(INPUT_POST, 'userEmail', FILTER_SANITIZE_EMAIL);
    $comment = filter_input(INPUT_POST, 'comment', FILTER_SANITIZE_STRING);

    if ($name && $email && $comment) {
        $stmt = $conn->prepare("INSERT INTO iv_shortreadsPostComments (post_id, userName, userEmail, comment, parent_comment_id) VALUES (:post_id, :userName, :userEmail, :comment, :parent_comment_id)");
        $stmt->execute([
            'post_id' => $post_id,
            'userName' => $name,
            'userEmail' => $email,
            'comment' => $comment,
            'parent_comment_id' => $parent_comment_id
        ]);
        header("Location: " . $_SERVER['HTTP_REFERER']."#comments");
        exit();
    }
}

$baseImageUrl = "https://theindicvoice.com/assets/images/shortreadsPost/";
$featuredImage = htmlspecialchars($post['cover_img']);

// Extract filename without extension
$pathInfo = pathinfo($featuredImage);
$slug = htmlspecialchars($post['slug']);
$extension = isset($pathInfo['extension']) ? $pathInfo['extension'] : 'jpg'; // Default to jpg if missing

// Generate different image versions
$defaultImage = "{$baseImageUrl}{$featuredImage}";
$facebookImage = "{$baseImageUrl}{$slug}_facebook.{$extension}";
$twitterImage = "{$baseImageUrl}{$slug}_twitter.{$extension}";
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
    
    <title><?php echo htmlspecialchars($post['title']); ?> - ShortReads</title>
    <meta name="description" content="<?php echo htmlspecialchars($post['description']); ?>">
    
    <!-- Canonical URL -->
    <link rel="canonical" href="https://theindicvoice.com/shortreads/<?php echo $slug; ?>" />
    
    <!-- Open Graph (OG) Metadata for Social Media -->
    <meta property="og:locale" content="en_GB" />
    <meta property="og:type" content="article" />
    <meta property="og:title" content="<?php echo htmlspecialchars($post['title']); ?> - ShortReads" />
    <meta property="og:description" content="<?php echo htmlspecialchars($post['description']); ?>" />
    <meta property="og:url" content="https://theindicvoice.com/shortreads/<?php echo $slug; ?>" />
    <meta property="og:site_name" content="The Indic Voice" />
    <!-- Open Graph (Facebook & LinkedIn) -->
    <meta property="og:image" content="<?php echo $facebookImage; ?>" />
    <meta property="og:image:secure_url" content="<?php echo $facebookImage; ?>" />
    <meta property="og:image:width" content="1200" />
    <meta property="og:image:height" content="630" />
    <meta property="og:image:alt" content="<?php echo htmlspecialchars($post['title']); ?>" />
    <meta property="fb:app_id" content="594379443466387" />
    
    <!-- Twitter Card Metadata -->
    <meta name="twitter:title" content="<?php echo htmlspecialchars($post['title']); ?> - ShortReads" />
    <meta name="twitter:description" content="<?php echo htmlspecialchars($post['description']); ?>" />
    <meta name="twitter:site" content="@TheIndicVoice" />
    <meta name="twitter:card" content="summary_large_image" />
    <meta name="twitter:domain" content="theindicvoice.com">
    <meta name="twitter:url" content="https://theindicvoice.com/shortreads/<?php echo $slug; ?>" />
    <meta name="twitter:image" content="<?php echo $twitterImage; ?>" />
    <meta name="twitter:image:alt" content="<?php echo htmlspecialchars($post['title']); ?>" />
    <meta name="twitter:creator" content="@TheIndicVoice" />
    
    <!-- Author & Publishing Details -->
    <meta name="author" content="Abhishek" />
    <meta property="article:published_time" content="<?php echo htmlspecialchars($post['published_at']); ?>" />
    <meta property="article:modified_time" content="<?php echo htmlspecialchars($post['modified_at']); ?>" />
    <meta property="article:author" content="https://theindicvoice.com/author/Abhishek" />
    
    <!-- JSON-LD Structured Data -->
    <script type="application/ld+json">
    {
      "@context": "https://schema.org",
      "@type": "Article",
      "headline": "<?php echo htmlspecialchars($post['title']); ?>",
      "description": "<?php echo htmlspecialchars($post['description']); ?>",
      "image": "https://theindicvoice.com/assets/images/shortreadsPost/<?php echo htmlspecialchars($post['cover_img']); ?>",
      "author": {
        "@type": "Person",
        "name": "<?php echo htmlspecialchars($authorDetails['name']); ?>",
        "url": "https://theindicvoice.com/author/<?php echo htmlspecialchars($authorDetails['slug']); ?>"
      },
      "publisher": {
        "@type": "Organization",
        "name": "The Indic Voice",
        "logo": {
          "@type": "ImageObject",
          "url": "https://theindicvoice.com/assets/images/logo/logo-shortreads.svg"
        }
      },
      "datePublished": "<?php echo htmlspecialchars($post['published_at']); ?>",
      "dateModified": "<?php echo htmlspecialchars($post['modified_at']); ?>",
      "mainEntityOfPage": {
        "@type": "WebPage",
        "@id": "https://theindicvoice.com/shortreads/<?php echo $slug; ?>"
      }
    }
    </script>
    
    <!-- Breadcrumb Schema Markup -->
    <script type="application/ld+json">
    {
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
          "name": "ShortReads",
          "item": "https://theindicvoice.com/ShortReads/}"
        },
        {
          "@type": "ListItem",
          "position": 3,
          "name": "<?php echo htmlspecialchars($post['title']); ?>",
          "item": "https://theindicvoice.com/shortreads/<?php echo $slug; ?>"
        }
      ]
    }
    </script>
    
    <link rel="preload" href="https://theindicvoice.com/assets/css/styles.css" as="style">
    <link rel="preload" href="https://theindicvoice.com/assets/js/script.js" as="script">
    <link rel="alternate" type="application/rss+xml" title="The Indic Voice &raquo; Feed" href="https://theindicvoice.com/shortreads/rss/">
    <link rel="shortcut icon" href="https://theindicvoice.com/assets/images/favicon.png">
    <link rel="stylesheet" href="https://theindicvoice.com/assets/css/styles.css">
	<meta name="robots" content="index, follow, max-snippet:-1, max-video-preview:-1, max-image-preview:large" />
    <script src="https://theindicvoice.com/assets/js/jquery/jquery.min.js"></script>
    <style>.wrapper.has_featured{display:flex;gap:2rem;align-items:flex-start;max-width:1200px;margin:0 auto;padding:2rem 1rem; margin-top:40px}.feature-image{flex:0 1 40%;position:relative;min-width:600px}.article-banner{flex:1 1 60%;padding-left:2rem;position:sticky;top:1rem;margin:auto}.article-banner-img{width:100%;height:auto;object-fit:cover;border-radius:8px}@media (max-width:768px){.wrapper.has_featured{flex-direction:column}.feature-image{width:100%;flex:none;min-width:auto}.article-banner{padding-left:0;width:100%}}.feature-image::after{content:'';position:absolute;right:-1rem;top:0;bottom:0;width:1px;background:#e2e8f0}.article-content p{font-size:21px}.dropcap p:first-child::first-letter{display:block;color:#dd4b39;float:left;font-size:4em;font-weight:700;line-height:1;margin:5px 18px 10px 0}.dropcap blockquote p:first-child::first-letter{display:inline;float:none;font-size:inherit;font-weight:inherit;line-height:inherit;margin:0;padding:0}.article-details-section{padding-top:calc(16px - 10px);display:flex;flex-flow:row nowrap;justify-content:center;height:auto;gap:10px}@media (min-width:1200px) and (max-width:1319px){.inplace-article{max-width:650px}}@media (min-width:1200px){.article-details-section .article-content{padding-right:25px}}.article-content{color:#000;flex:1 1 600px;padding-left:20px;position:relative}.article-content p{margin-top:0;margin-bottom:22px;line-height:1.7;font-family:var(--iv-font-body),Sans-Serif}.floating-share-buttons{position:fixed;right:20px;bottom:20px;display:flex;flex-direction:column;gap:10px}.share-button{background-color:#fff;border-radius:50%;width:25px;height:25px;display:flex;align-items:center;justify-content:center;box-shadow:0 2px 5px rgba(0,0,0,.2)}.share-button:hover{background-color:#f0f0f0}.share-button img{font-size:20px;width:25px!important;color:#333}.article-deck{font-family:var(--iv-font-body),Sans-Serif;}.article-title{font-size:50px;text-align:center;margin:0;}.article-box_content{max-width:850px;margin:auto}.article-box_byline{justify-content:space-between;display:flex;gap:1.5rem;align-items:center;padding:1rem 0;border-top:1px solid #e9ecef;margin-top:1.5rem}.article-box_desc p{font-size:17px;font-style:italic;line-height:1.7;color:#495057;margin-bottom:1.5rem;font-family:Georgia,serif}.article-box_byline li{font-size:15px;color:#6c757d;display:flex;align-items:center}.article-box_byline li:first-child{position:relative}.article-box_byline li:first-child::after{content:"•";margin-left:1rem;color:#dee2e6}.article-box_byline a{color:#2b2d42;text-decoration:none;font-weight:600;transition:color .3s}.article-box_byline a:hover{color:#d90429}@media (max-width:768px){.article-box_content{padding:1.5rem}.article-box_byline{flex-direction:column;align-items:flex-start;gap:.5rem}.article-box_byline li:first-child::after{display:none} .article-title{font-size:35px;}}
    #main-post-comments-toggle-wrap { margin-bottom: 20px; text-align: center; } #main-post-comments-toggle { display: inline-flex; align-items: center; background-color: var(--iv-color-secondary); color: white; border: none; padding: 12px 24px; border-radius: 25px; cursor: pointer; font-size: 16px; transition: background-color 0.3s ease; } #main-post-comments-toggle img { margin-right: 8px; width: 20px; height: 20px; } /* Comment Form */ .comment-form { display: flex; flex-direction: column; gap: 15px; padding: 20px; background-color: #ffffff; border-radius: 8px; margin-bottom: 20px; box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1); } .comment-form input, .comment-form textarea { padding: 12px; border: 1px solid #ddd; border-radius: 5px; font-size: 16px; transition: border-color 0.3s ease; } .comment-form input:focus, .comment-form textarea:focus { border-color: var(--iv-color-secondary); outline: none; } .comment-form button { background-color: var(--iv-color-secondary); color: white; border: none; padding: 12px; cursor: pointer; font-size: 16px; border-radius: 5px; transition: background-color 0.3s ease; } .comment-form button:hover { background-color: #45a049; } /* Comment Box */ .comments-list { margin-top: 20px; } .comment-box { background-color: #ffffff; padding: 20px; border-radius: 8px; margin-bottom: 15px; border-left: 5px solid var(--iv-color-secondary); box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1); transition: transform 0.3s ease; } .comment-box:hover { transform: translateY(-2px); } .comment-box strong { color: #333; font-size: 18px; display: block; margin-bottom: 5px; } .comment-date { font-size: 14px; color: #777; margin-bottom: 10px; } .comment-box p { font-size: 16px; margin-top: 10px; color: #555; } /* Reply Button */ .reply-btn { background-color: #007bff; color: white; border: none; padding: 8px 16px; margin-top: 10px; cursor: pointer; border-radius: 5px; font-size: 14px; transition: background-color 0.3s ease; } .reply-btn:hover { background-color: #0056b3; } /* Nested Replies */ .nested-replies { background-color: #f9f9f9; padding: 15px; margin-left: 20px; border-left: 4px solid #007bff; border-radius: 5px; margin-top: 10px; } .nested-replies strong { color: #007bff; } .nested-replies .comment-date { color: #999; } /* Reply Form */ .reply-form { display: none; background-color: #ffffff; padding: 15px; margin-top: 10px; border-radius: 8px; box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1); } .reply-form input, .reply-form textarea { width: 100%; padding: 12px; border: 1px solid #ddd; border-radius: 5px; font-size: 16px; transition: border-color 0.3s ease; } .reply-form input:focus, .reply-form textarea:focus { border-color: #f6423c; outline: none; } .reply-form button { background-color: #007bff; color: white; border: none; padding: 12px; cursor: pointer; font-size: 16px; border-radius: 5px; transition: background-color 0.3s ease; } .reply-form button:hover { background-color: #0056b3; } /* Toggle Visibility of Comment and Reply Sections */ #main-post-comments-wrapper { display: none; margin-top: 30px;max-width: 1024px;margin:auto;} #main-post-comments-wrapper.active { display: block; } .parent-0{ display: block !important; } .author-label{ background: #92928d33; padding: 2px 7px; font-size: 14px; font-weight: 600; font-family: 'EconomistSerifOsF'; }.main-post-comments-toggle-wrap{margin-bottom:2rem;text-align:center}.main-post-comments-toggle-wrap #main-post-comments-toggle{height:50px;display:inline-flex;align-items:center;justify-content:center;border-radius:4px}.article-content a{border-bottom:2px dotted #ccc;word-wrap:break-word}.article-content a:focus,.article-content a:hover{color:#033d1b;border-bottom:2px dotted #fead00}.article-content a:focus{outline:0}</style>
</head>
<body>
    <?php
    if (file_exists("srcComponents/header.php")) {
        include "srcComponents/header.php";
    } else {
        include "../srcComponents/header.php";
    }
    ?>

    <div class="wrapper has_featured">
        <div class="feature-image">
            <img class="article-banner-img" alt="Article Lead Image" src="https://theindicvoice.com/assets/images/shortreadsPost/<?php echo htmlspecialchars($post['cover_img']); ?>" loading="eager">
            <!--<img src="https://images.unsplash.com/photo-1558637845-c8b7ead71a3e?w=600&auto=format&fit=crop&q=60&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxzZWFyY2h8M3x8MTYlM0E5fGVufDB8fDB8fHww" class="article-banner-img" alt="Article Lead Image" loading="eager" />-->
        </div>
        <div class="article-banner">
            <div class="article-left-col">
                <h1 class="h1 article-title"> <?php echo htmlspecialchars($post['title']); ?> </h1>
            </div>
        </div>
    </div>
    
    <div class="wrapper">
        <div class="article-box_content">
            <div class="article-box_desc">
                <p><?php echo $post['description']; ?></p>
            </div>
            <ul class="article-box_byline margin-v-none padd-left-none no-style">
                <li>By &nbsp;&nbsp;<a href="/author/<?php echo htmlspecialchars($authorDetails['slug']); ?>"> <?php echo htmlspecialchars($authorDetails['name']); ?> </a></li>
                <li>At <?php echo date("F j, Y", strtotime($post['published_at'])); ?></li>
            </ul>
        </div>
    </div>
    
    <div class="wrapper article-details-section">
        <div class="inplace-article sdsad">
            <div class="article-content dropcap" style="font-size: 21px;">
                <?php echo $post['content']; ?>
            </div>
        </div>
    </div>



    <div id="comments"></div>
    <div class="main-post-comments-toggle-wrap" id="main-post-comments-toggle-wrap comments">
        <button class="btn btn-secondary btn-pill" id="main-post-comments-toggle">
            <img src="https://theindicvoice.com/assets/images/icons/comment-plus.svg" alt="Comment Icon" style="color:#fff;">
            <span>View / Add Comments </span>
        </button>
    </div>
    <div class="post-comments-wrapper" id="main-post-comments-wrapper">
        <div class="spcv_mainContainer">
            <!-- Comment Section -->
            <div class="spcv_conversation">
                <button class="btn btn-primary" onclick="toggleCommentForm()">Add Comment</button>
                <form method="POST" class="comment-form" id="commentForm" style="display:none;">
                    <input type="text" name="userName" placeholder="Your Name" required>
                    <input type="email" name="userEmail" placeholder="Your Email" required>
                    <textarea name="comment" placeholder="Write a comment..." required></textarea>
                    <button type="submit">Submit</button>
                </form>
                <div class="comments-list">
                    <?php if (count($comments) > 0): ?>
                    <?php foreach ($comments as $comment): ?>
                    <div class="comment-box parent-<?php echo htmlspecialchars($comment['parent_comment_id']); ?>" style="display: none;">
                        <strong><?php echo htmlspecialchars($comment['userName']); ?></strong>
                        <span class="comment-date">
                            <?php echo date("F j, Y", strtotime($comment['created_at'])); ?> 
                                            
                            <?php if (isset($comment['userEmail']) && strtolower(trim($comment['userEmail'])) === "abhishekiitd267@gmail.com") : ?>
                                <span class="author-label">Author</span>
                            <?php endif; ?>
                        </span>
                        <p> <?php echo nl2br(htmlspecialchars($comment['comment'])); ?> </p>
                        <button class="reply-btn" onclick="toggleReplyForm(<?php echo $comment['id']; ?>)">Reply </button>
                        <div class="reply-form" id="reply-form-<?php echo $comment['id']; ?>" style="display:none;">
                            <form method="POST" id="replyform">
                                <input type="text" name="userName" placeholder="Your Name" required>
                                <input type="email" name="userEmail" placeholder="Your Email" required>
                                <textarea name="comment" placeholder="Write a reply..." required></textarea>
                                <input type="hidden" name="replyTo" value="<?php echo $comment['id']; ?>" />
                                <button type="submit">Submit Reply</button>
                            </form>
                        </div>
                        <?php
                            $replies = getCommentsByPostId($post_id, $conn);
                            foreach ($replies as $reply) {
                                if ($reply['parent_comment_id'] == $comment['id']) {
                                    echo "<div class='nested-replies'>";
                                    echo "<strong>" . htmlspecialchars($reply['userName']) . "</strong>";
                                    echo "<span class='comment-date'>" . date("F j, Y", strtotime($reply['created_at']));
                                    if (isset($reply['userEmail']) && strtolower(trim($reply['userEmail'])) === "abhishekiitd267@gmail.com") {
                                        echo " <span class='author-label'>Author</span>";
                                    }
                                    echo "</span>";
                                    echo "<p>" . nl2br(htmlspecialchars($reply['comment'])) . "</p>";
                                    echo "</div>";
                                }
                            }
                        ?>
                    </div> <?php endforeach; ?> <?php else: ?> <p>No comments yet. Be the first to comment!</p> <?php endif; ?> </div>
            </div>
        </div>
    </div>
    <script>
        function removeBackslashes(str) {
            return str.replace(/\\/g, '');
        }
        let title = removeBackslashes(document.title);
        let description = removeBackslashes(document.querySelector('meta[name="description"]').content);
        jQuery(document).ready(function() {
            jQuery('#main-post-comments-toggle').on('click', function(e) {
                e.preventDefault();
                jQuery('#main-post-comments-wrapper').toggleClass('active');
                let text = jQuery('#main-post-comments-wrapper').hasClass('active') ? 'Hide Comments' : 'View / Add Comments';
                jQuery('#main-post-comments-toggle span').text(text);
            });
        });
    
        function toggleCommentForm() {
            const commentForm = document.getElementById('commentForm');
            commentForm.style.display = commentForm.style.display === 'none' ? 'block' : 'none';
        }
    
        function toggleReplyForm(commentId) {
            const replyForm = document.getElementById(`reply-form-${commentId}`);
            replyForm.style.display = replyForm.style.display === 'none' ? 'block' : 'none';
        }
        // Handle comment form submission using AJAX
        jQuery(document).ready(function() {
            // Toggle reply form visibility
            window.toggleReplyForm = function(commentId) {
                jQuery(`#reply-form-${commentId}`).toggle();
            };
            // Toggle nested replies visibility
            window.toggleReplyVisibility = function(commentId) {
                jQuery(`#nested-replies-${commentId}`).toggle();
            };
        });
    </script>










    
    <div class="floating-share-buttons">
        <a href="https://www.facebook.com/sharer/sharer.php?u=<?php echo urlencode("https://theindicvoice.com/shortreads/{$slug}"); ?>" target="_blank" class="share-button facebook">
            <img src="/assets/images/icons/facebook-icon.svg" width="20px">
        </a>
        <a href="https://twitter.com/intent/tweet?url=<?php echo urlencode("https://theindicvoice.com/shortreads/{$slug}"); ?>&text=<?php echo urlencode($post['title']); ?>" target="_blank" class="share-button twitter">
            <img src="/assets/images/icons/twitter-icon.svg" width="20px">
        </a>
        <a href="https://www.linkedin.com/shareArticle?mini=true&url=<?php echo urlencode("https://theindicvoice.com/shortreads/{$slug}"); ?>&title=<?php echo urlencode($post['title']); ?>" target="_blank" class="share-button linkedin">
            <img src="/assets/images/icons/linkedin-icon.svg" width="20px">
        </a>
        <a href="https://wa.me/?text=<?php echo urlencode("Check this out: https://theindicvoice.com/shortreads/{$slug}"); ?>" target="_blank" class="share-button whatsapp">
            <img src="/assets/images/icons/whatsapp-icon.svg" width="20px">
        </a>
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