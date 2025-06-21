<?php
require_once "../config/database.php";

$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$perPage = isset($_GET['per_page']) ? (int)$_GET['per_page'] : 9;
$offset = 1 + ($page - 1) * $perPage;

try {
    $stmt = $conn->prepare("SELECT * FROM post WHERE status = :status ORDER BY published_at DESC LIMIT :offset, :per_page");
    $stmt->bindValue(':status', 'true', PDO::PARAM_STR);
    $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
    $stmt->bindValue(':per_page', $perPage, PDO::PARAM_INT);
    $stmt->execute();
    
    $posts = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    foreach ($posts as $fetch_post) {
        // Your existing post rendering code here
        $authorid = $fetch_post['author_id'];
        $time = date('d M Y', strtotime($fetch_post['published_at']));
        
        $author_stmt = $conn->prepare("SELECT * FROM author WHERE id = :authorid");
        $author_stmt->execute(['authorid' => $authorid]);
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
    error_log("Database error: " . $e->getMessage());
}

?>