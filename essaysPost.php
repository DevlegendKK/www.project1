<?php
include "config/database.php";
require"page-views.php";

$current_url = $_SERVER['REQUEST_URI'];
$slug = basename($current_url);
$slug = filter_var($slug, FILTER_SANITIZE_STRING);

// Function to fetch post details by slug
function getPostDetailsBySlug($slug, $conn) {
    $stmt = $conn->prepare("SELECT id, title, description, featured_img, category, sub_category, tags, slug, content, author_id, published_at, modified_at, post_type, views FROM post WHERE slug = :slug AND status = :status LIMIT 1");
    $stmt->execute(['slug' => $slug, 'status' => 'true']);
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

$postDetails = getPostDetailsBySlug($slug, $conn);

$author_id = $postDetails['author_id'];

// Function to fetch author by ID
function getAuthorById($author_id, $conn) {
    $stmt = $conn->prepare("SELECT name, slug, twitter_handle FROM author WHERE id = :author_id LIMIT 1");
    $stmt->execute(['author_id' => $author_id]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

$authorDetails = getAuthorById($postDetails['author_id'], $conn);

$post_id = $postDetails['id'];

$views = $postDetails['views'];
$sql = "UPDATE post SET views = views + 1 WHERE id = :postid";
try {
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':postid', $post_id, PDO::PARAM_INT);
    $stmt->execute();
    
    if ($stmt->rowCount() > 0) {
        // echo "Views updated successfully.";
    } else {
        // echo "No rows updated.";
    }
} catch (PDOException $e) {
    echo "Error updating views: " . $e->getMessage();
}





// Function to fetch comments by post ID
function getCommentsByPostId($post_id, $conn) {
    $stmt = $conn->prepare("SELECT id, userName, userEmail, comment, created_at, parent_comment_id FROM iv_postComments WHERE post_id = :post_id and status = 'true' ORDER BY created_at DESC");
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
        $stmt = $conn->prepare("INSERT INTO iv_postComments (post_id, userName, userEmail, comment, parent_comment_id) VALUES (:post_id, :userName, :userEmail, :comment, :parent_comment_id)");
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
        $stmt = $conn->prepare("INSERT INTO iv_postComments (post_id, userName, userEmail, comment, parent_comment_id) VALUES (:post_id, :userName, :userEmail, :comment, :parent_comment_id)");
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


$baseImageUrl = "https://www.theindicvoice.com/assets/images/blog-post/";
$featuredImage = htmlspecialchars($postDetails['featured_img']);

// Extract filename without extension
$pathInfo = pathinfo($featuredImage);
$slug = htmlspecialchars($postDetails['slug']);
$extension = isset($pathInfo['extension']) ? $pathInfo['extension'] : 'jpg'; // Default to jpg if missing

// Generate different image versions
$defaultImage = "{$baseImageUrl}{$featuredImage}";
$facebookImage = "{$baseImageUrl}{$slug}_facebook.{$extension}";
$twitterImage = "{$baseImageUrl}{$slug}_twitter.{$extension}";
$linkedinImage = "{$baseImageUrl}{$slug}_linkedin.{$extension}";
$thumbnailImage = "{$baseImageUrl}{$slug}_thumbnail.{$extension}";

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
    
    <title><?php echo htmlspecialchars($postDetails['title']); ?> - The Indic Voice</title>
<meta name="description" content="<?php echo htmlspecialchars($postDetails['description']); ?>">

<!-- Canonical URL -->
<link rel="canonical" href="https://www.theindicvoice.com/<?php echo htmlspecialchars($postDetails['post_type']); ?>/<?php echo htmlspecialchars($postDetails['slug']); ?>" />

<!-- Open Graph (OG) Metadata for Social Media -->
<meta property="og:locale" content="en_GB" />
<meta property="og:type" content="article" />
<meta property="og:title" content="<?php echo htmlspecialchars($postDetails['title']); ?> - The Indic Voice" />
<meta property="og:description" content="<?php echo htmlspecialchars($postDetails['description']); ?>" />
<meta property="og:url" content="https://www.theindicvoice.com/<?php echo htmlspecialchars($postDetails['post_type']); ?>/<?php echo htmlspecialchars($postDetails['slug']); ?>" />
<meta property="og:site_name" content="The Indic Voice" />
<!-- Open Graph (Facebook & LinkedIn) -->
<meta property="og:image" content="<?php echo $facebookImage; ?>" />
<meta property="og:image:secure_url" content="<?php echo $facebookImage; ?>" />
<meta property="og:image:width" content="1200" />
<meta property="og:image:height" content="630" />
<meta property="og:image:type" content="image/<?php echo $extension; ?>" />
<meta property="og:image:alt" content="<?php echo htmlspecialchars($postDetails['title']); ?>" />
<meta property="fb:app_id" content="594379443466387" />

<!-- Twitter Card Metadata -->
<meta name="twitter:title" content="<?php echo htmlspecialchars($postDetails['title']); ?> - The Indic Voice" />
<meta name="twitter:description" content="<?php echo htmlspecialchars($postDetails['description']); ?>" />
<meta name="twitter:site" content="@TheIndicVoice" />
<meta name="twitter:card" content="summary_large_image" />
<meta name="twitter:domain" content="www.theindicvoice.com">
<meta name="twitter:url" content="https://www.theindicvoice.com/<?php echo htmlspecialchars($postDetails['post_type']); ?>/<?php echo htmlspecialchars($postDetails['slug']); ?>" />
<meta name="twitter:image" content="<?php echo $twitterImage; ?>" />
<meta name="twitter:image:alt" content="<?php echo htmlspecialchars($postDetails['title']); ?>" />
<meta name="twitter:creator" content="@TheIndicVoice" />

<!-- Author & Publishing Details -->
<meta name="author" content="<?php echo htmlspecialchars($authorDetails['name']); ?>" />
<meta property="article:published_time" content="<?php echo htmlspecialchars($postDetails['published_at']); ?>" />
<meta property="article:modified_time" content="<?php echo htmlspecialchars($postDetails['modified_at']); ?>" />
<meta property="article:author" content="https://www.theindicvoice.com/author/<?php echo htmlspecialchars($authorDetails['slug']); ?>" />
<meta property="article:section" content="<?php echo htmlspecialchars($postDetails['category']); ?>" />
<meta property="article:tag" content="<?php echo htmlspecialchars($postDetails['tags']); ?>" />

<!-- JSON-LD Structured Data -->
<script type="application/ld+json">
{
  "@context": "https://schema.org",
  "@type": "Article",
  "headline": "<?php echo htmlspecialchars($postDetails['title']); ?>",
  "description": "<?php echo htmlspecialchars($postDetails['description']); ?>",
  "image": "https://www.theindicvoice.com/assets/images/blog-post/<?php echo htmlspecialchars($postDetails['featured_img']); ?>",
  "author": {
    "@type": "Person",
    "name": "<?php echo htmlspecialchars($authorDetails['name']); ?>",
    "url": "https://www.theindicvoice.com/author/<?php echo htmlspecialchars($authorDetails['slug']); ?>"
  },
  "publisher": {
    "@type": "Organization",
    "name": "The Indic Voice",
    "logo": {
      "@type": "ImageObject",
      "url": "https://www.theindicvoice.com/assets/images/logo/logo.svg"
    }
  },
  "datePublished": "<?php echo htmlspecialchars($postDetails['published_at']); ?>",
  "dateModified": "<?php echo htmlspecialchars($postDetails['modified_at']); ?>",
  "mainEntityOfPage": {
    "@type": "WebPage",
    "@id": "https://www.theindicvoice.com/<?php echo htmlspecialchars($postDetails['post_type']); ?>/<?php echo htmlspecialchars($postDetails['slug']); ?>"
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
      "item": "https://www.theindicvoice.com/"
    },
    {
      "@type": "ListItem",
      "position": 2,
      "name": "<?php echo htmlspecialchars($postDetails['category']); ?>",
      "item": "https://www.theindicvoice.com/<?php echo htmlspecialchars($postDetails['category']); ?>/}"
    },
    {
      "@type": "ListItem",
      "position": 3,
      "name": "<?php echo htmlspecialchars($postDetails['title']); ?>",
      "item": "https://www.theindicvoice.com/<?php echo htmlspecialchars($postDetails['post_type']); ?>/<?php echo htmlspecialchars($postDetails['slug']); ?>"
    }
  ]
}
</script>

	<link rel="alternate" type="application/rss+xml" title="The Indic Voice &raquo; Feed" href="https://www.theindicvoice.com/rss/" />
	<link rel="shortcut icon" href="https://www.theindicvoice.com/assets/images/favicon.png" >
	<meta name="robots" content="index, follow, max-snippet:-1, max-video-preview:-1, max-image-preview:large" />
	
        <link rel="preload" href="/assets/css/styles.css" as="style">
        <link rel="preload" href="/assets/js/script.js" as="script">
        <link rel="stylesheet" href="/assets/css/styles.css">
        <link rel="stylesheet" href="/assets/css/page-index.css">
        <link rel="stylesheet" href="/assets/css/page-article.css">
        <style>
            .channel-banner .article-box_content { position: relative; left: 0; margin: auto; /*bottom: 150px;*/ background-color: #f9f9f9; border-radius: 5px 5px 0 0; padding: 16px calc(16px* 2); width: 900px; } .channel-banner .article-box_content .article-box_byline { position: relative; display: flex; justify-content: space-between; bottom: auto; border: none; } .article-content p { font-size: 21px; } .dropcap p:first-child::first-letter { display: block; color: #dd4b39; float: left; font-size: 5em; font-weight: 700; line-height: 1; margin: 5px 18px 10px 0; } .dropcap blockquote p:first-child::first-letter { display: inline; float: none; font-size: inherit; font-weight: inherit; line-height: inherit; margin: 0; padding: 0; } @media (max-width: 767px) { .channel-banner figure img { height: 311px; } .channel-banner .article-box_content { bottom: 0; left: 0; } } /* Main Comment Section Styles */ /* Comment Toggle Button */ /* Main Comment Section Styles */ #main-post-comments-toggle-wrap { margin-bottom: 20px; text-align: center; } #main-post-comments-toggle { display: inline-flex; align-items: center; background-color: var(--iv-color-secondary); color: white; border: none; padding: 12px 24px; border-radius: 25px; cursor: pointer; font-size: 16px; transition: background-color 0.3s ease; } #main-post-comments-toggle img { margin-right: 8px; width: 20px; height: 20px; } /* Comment Form */ .comment-form { display: flex; flex-direction: column; gap: 15px; padding: 20px; background-color: #ffffff; border-radius: 8px; margin-bottom: 20px; box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1); } .comment-form input, .comment-form textarea { padding: 12px; border: 1px solid #ddd; border-radius: 5px; font-size: 16px; transition: border-color 0.3s ease; } .comment-form input:focus, .comment-form textarea:focus { border-color: var(--iv-color-secondary); outline: none; } .comment-form button { background-color: var(--iv-color-secondary); color: white; border: none; padding: 12px; cursor: pointer; font-size: 16px; border-radius: 5px; transition: background-color 0.3s ease; } .comment-form button:hover { background-color: #45a049; } /* Comment Box */ .comments-list { margin-top: 20px; } .comment-box { background-color: #ffffff; padding: 20px; border-radius: 8px; margin-bottom: 15px; border-left: 5px solid var(--iv-color-secondary); box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1); transition: transform 0.3s ease; } .comment-box:hover { transform: translateY(-2px); } .comment-box strong { color: #333; font-size: 18px; display: block; margin-bottom: 5px; } .comment-date { font-size: 14px; color: #777; margin-bottom: 10px; } .comment-box p { font-size: 16px; margin-top: 10px; color: #555; } /* Reply Button */ .reply-btn { background-color: #007bff; color: white; border: none; padding: 8px 16px; margin-top: 10px; cursor: pointer; border-radius: 5px; font-size: 14px; transition: background-color 0.3s ease; } .reply-btn:hover { background-color: #0056b3; } /* Nested Replies */ .nested-replies { background-color: #f9f9f9; padding: 15px; margin-left: 20px; border-left: 4px solid #007bff; border-radius: 5px; margin-top: 10px; } .nested-replies strong { color: #007bff; } .nested-replies .comment-date { color: #999; } /* Reply Form */ .reply-form { display: none; background-color: #ffffff; padding: 15px; margin-top: 10px; border-radius: 8px; box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1); } .reply-form input, .reply-form textarea { width: 100%; padding: 12px; border: 1px solid #ddd; border-radius: 5px; font-size: 16px; transition: border-color 0.3s ease; } .reply-form input:focus, .reply-form textarea:focus { border-color: #f6423c; outline: none; } .reply-form button { background-color: #007bff; color: white; border: none; padding: 12px; cursor: pointer; font-size: 16px; border-radius: 5px; transition: background-color 0.3s ease; } .reply-form button:hover { background-color: #0056b3; } /* Toggle Visibility of Comment and Reply Sections */ #main-post-comments-wrapper { display: none; margin-top: 30px; } #main-post-comments-wrapper.active { display: block; } .parent-0{ display: block !important; } .author-label{ background: #92928d33; padding: 2px 7px; font-size: 14px; font-weight: 600; font-family: 'EconomistSerifOsF'; } figure figcaption{font-size: 13px; font-family: var(--iv-font-body); font-weight: 400; text-align:center; margin-bottom: 16px;} .article-content img {margin-bottom: 8px !important;}figure{text-align: center;}a sup, sup a {color: var(--iv-color-secondary)!important;}.channel-banner .article-box_content .article-box_head{text-align: center;}.share-button,.tag{transition:background-color .3s}.tags-section{margin-bottom:20px}.post-tags{margin-top:30px;padding:20px;border-radius:8px}.post-tags h4{font-size:18px;font-weight:600;margin-bottom:10px}.tags-list{list-style:none;padding-left:0;display:flex;flex-wrap:wrap;gap:10px;justify-content:center}.tags-list li{margin:0}.tag{background-color:#ffce54;color:#000;padding:5px 10px;font-size:14px;border-radius:20px;text-decoration:none;font-family:var(--iv-font-body);font-weight:600}.tag:hover{background-color:#e5b846}.tag:active{background-color:#d9a537}.floating-share-buttons{position:fixed;right:20px;bottom:20px;display:flex;flex-direction:column;gap:10px}.share-button{background-color:#fff;border-radius:50%;width:25px;height:25px;display:flex;align-items:center;justify-content:center;box-shadow:0 2px 5px rgba(0,0,0,.2)}.share-button:hover{background-color:#f0f0f0}.share-button img{font-size:20px;width:25px!important;color:#333}
        </style>
        
        <script src="/assets/js/jquery/jquery.min.js"></script>
    </head>
    <body>
        <div class="iv-site-block">
            <div class="main-body">
                <?php require_once "srcComponents/header.php"; ?> 
                <!--<a href="#comments">go to comment</a>-->
                <div class="channel-banner">
                    <figure>
                        <img src="https://www.theindicvoice.com/assets/images/blog-post/<?php echo htmlspecialchars($postDetails['featured_img']); ?>" alt="channel_image">
                    </figure>
                    <div class="wrapper">
                        <div class="article-box_content">
                            <h3 class="article-box_head"> <?php echo htmlspecialchars($postDetails['title']); ?> </h3>
                            <div class="article-box_desc">
                                <p> <?php echo $postDetails['description']; ?> </p>
                            </div>
                            <ul class="article-box_byline margin-v-none padd-left-none no-style">
                                <li>By <a href="/author/<?php echo htmlspecialchars($authorDetails['slug']); ?>"><?php echo htmlspecialchars($authorDetails['name']); ?></a> </li>
                                <li><a href="/<?php echo htmlspecialchars($postDetails['category']); ?>/"><?php echo htmlspecialchars($postDetails['category']); ?></a> / <a href="/s?search=<?php echo htmlspecialchars($postDetails['sub_category']); ?>"><?php echo htmlspecialchars($postDetails['sub_category']); ?></a></li>
                                <li>At <?php echo date("F j, Y", strtotime($postDetails['published_at'])); ?> </li>
                            </ul>
                        </div>
                    </div>
                </div>
                
                <?php 
                require_once "srcComponents/newsletterSection.php"; 
                ?>
                <div class="wrapper article-details-section">
                    <div class="inplace-article sdsad">
                        <div class="article-content dropcap" style="font-size: 21px;"> <?php echo $postDetails['content']; ?> </div>
                    </div>
                </div>
                <div class="wrapper tags-section">
                    <?php if (!empty($postDetails['tags'])): ?>
                        <div class="post-tags">
                            <!--<h4>Tags:</h4>-->
                            <ul class="tags-list">
                                <?php 
                                // Split the tags by comma and display them
                                $tags = explode(',', $postDetails['tags']);
                                foreach ($tags as $tag): 
                                    $tag = trim($tag); // Remove leading/trailing spaces
                                ?>
                                    <li><a href="/s?search=<?php echo urlencode($tag); ?>" class="tag"><?php echo htmlspecialchars($tag); ?></a></li>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                    <?php endif; ?>
                 </div>
                    
                    
                
                <div id="comments"></div>
                <div class="main-post-comments-toggle-wrap" id="main-post-comments-toggle-wrap comments">
                    <button class="btn btn-secondary btn-pill" id="main-post-comments-toggle">
                        <img src="/assets/images/icons/comment-plus.svg" alt="Comment Icon">
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
                
                
                                            <p><?php echo nl2br(htmlspecialchars($comment['comment'])); ?></p>
                                            <button class="reply-btn" onclick="toggleReplyForm(<?php echo $comment['id']; ?>)">Reply</button>
                
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
                                                // Get replies for this comment
                                                $replies = getCommentsByPostId($post_id, $conn);
                                                foreach ($replies as $reply) {
                                                    if ($reply['parent_comment_id'] == $comment['id']) {
                                                        echo "<div class='nested-replies'>";
                                                        echo "<strong>" . htmlspecialchars($reply['userName']) . "</strong>";
                                                        echo "<span class='comment-date'>" . date("F j, Y", strtotime($reply['created_at']));
                
                            // Check if the reply's userEmail matches the author email
                            if (isset($reply['userEmail']) && strtolower(trim($reply['userEmail'])) === "abhishekiitd267@gmail.com") {
                                echo " <span class='author-label'>Author</span>";
                            }
                
                            echo "</span>";
                                                        echo "<p>" . nl2br(htmlspecialchars($reply['comment'])) . "</p>";
                                                        echo "</div>";
                                                    }
                                                }
                                            ?>
                                        </div>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <p>No comments yet. Be the first to comment!</p>
                                <?php endif; ?>
                            </div>
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


<style>.wp-block-group { box-sizing: border-box; margin-top: 20px; } .wp-block-group.is-layout-constrained { position: relative; } /* Styles for groups with background */ .wp-block-group.has-background { padding: 1.25em 2.375em; } /* Styles for flex layout groups */ .wp-block-group.is-layout-flex { display: flex; flex-wrap: nowrap; justify-content: flex-start; align-items: flex-end; } /* Styles for the spacer block */ .wp-block-spacer { height: 50px; width: 0px; visibility: hidden; } /* Styles for the heading block */ .wp-block-heading { font-family: var(--iv-font-heading); font-size: 2.566rem; font-weight: 600; line-height: 1.15; } .wp-block-heading a { color: #333; text-decoration: none; } .wp-block-heading a:hover { text-decoration: underline; } /* Styles for the separator block */ .wp-block-separator { border: none; border-bottom: 2px solid; margin-left: auto; margin-right: auto; } .wp-block-separator.has-alpha-channel-opacity { opacity: 1;margin-top:0; } .wp-block-separator.is-style-wide { width: 100%; } /* Container-specific styles */ .wp-container-core-group-is-layout-5 { flex-wrap: nowrap; justify-content: flex-start; align-items: flex-end; } .wp-container-core-group-is-layout-6 > :where(:not(.alignleft):not(.alignright):not(.alignfull)) { max-width: 1130px; margin-left: auto !important; margin-right: auto !important; } .wp-container-core-group-is-layout-6 > .alignwide { max-width: 1130px; } .wp-container-core-group-is-layout-6 .alignfull { max-width: none; } .wp-container-content-5, .wp-container-content-6 { flex-basis: 20px; }</style>
            <div class="wp-block-group is-layout-constrained wp-container-core-group-is-layout-6 wp-block-group-is-layout-constrained">
                <div class="wp-block-group alignwide is-content-justification-left is-nowrap is-layout-flex wp-container-core-group-is-layout-5 wp-block-group-is-layout-flex">
                    <div style="height:50px;width:0px" aria-hidden="true" class="wp-block-spacer wp-container-content-5"></div>
                    <h2 class="wp-block-heading" id="h-culture">
                        Suggested Post
                    </h2>
                    <div style="" aria-hidden="true" class="wp-block-spacer wp-container-content-6"></div>
                </div>
                <hr class="wp-block-separator has-alpha-channel-opacity is-style-wide"/>
            </div>

            <div class="horizontal-article-card-section wrapper inner-wrapper">
                <ul class="snippet-article home-bottom-article">
                    
                    <?php
                    try {
                        $stmt = $conn->prepare("SELECT * FROM post WHERE status = :status AND recommended = :recommended ORDER BY published_at DESC LIMIT 0, 3");
                        $stmt->execute(['status' => 'true', 'recommended' => 'true']);
                        
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
                                        <img src="https://www.theindicvoice.com/assets/images/blog-post/<?php echo htmlspecialchars($fetch_post['featured_img']); ?>?auto=compress&#038;fm=png&#038;ixlib=php-3.3.1?crop=entropy&#038;auto=compress&#038;fit=crop&#038;h=605&#038;w=1440" alt="channel_image">
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

                
                
                
            <div class="floating-share-buttons">
                <a href="https://www.facebook.com/sharer/sharer.php?u=<?php echo urlencode("https://www.theindicvoice.com/{$postDetails['post_type']}/{$postDetails['slug']}"); ?>" target="_blank" class="share-button facebook">
                    <img src="/assets/images/icons/facebook-icon.svg" width="20px">
                </a>
                <a href="https://twitter.com/intent/tweet?url=<?php echo urlencode("https://www.theindicvoice.com/{$postDetails['post_type']}/{$postDetails['slug']}"); ?>&text=<?php echo urlencode($postDetails['title']); ?>" target="_blank" class="share-button twitter">
                    <img src="/assets/images/icons/twitter-icon.svg" width="20px">
                </a>
                <a href="https://www.linkedin.com/shareArticle?mini=true&url=<?php echo urlencode("https://www.theindicvoice.com/{$postDetails['post_type']}/{$postDetails['slug']}"); ?>&title=<?php echo urlencode($postDetails['title']); ?>" target="_blank" class="share-button linkedin">
                    <img src="/assets/images/icons/linkedin-icon.svg" width="20px">
                </a>
                <a href="https://wa.me/?text=<?php echo urlencode("Check this out: https://www.theindicvoice.com/{$postDetails['post_type']}/{$postDetails['slug']}"); ?>" target="_blank" class="share-button whatsapp">
                    <img src="/assets/images/icons/whatsapp-icon.svg" width="20px">
                </a>
            </div>
            
            
                
                
            
                
                <?php require_once "srcComponents/footer.php"; ?>
            </div>
        </div>
        <script src="/assets/js/script.js"></script>
        <script src="/assets/js/slick.min.js"></script>
    </body>
</html>