<?php require_once BASE_PATH . '/resources/views/templates/header.php'; ?>

<main class ="container">
    <?php if (isset($article) && is_object($article)): ?>
        <article>
            <h1><?= htmlspecialchars($article->name); ?></h1>
            <p><?= htmlspecialchars($article->description); ?></p>
            <h2>Likes: <?= $likeCount; ?></h2>

            <?php if (app\Core\SessionManager::has('authenticated')): ?>
                <form style="display: inline-block;" action="/likes/store" method="POST">
                    <input type="hidden" name="article_id" value="<?= $article->id; ?>">

                    <input type="hidden" name="csrf-token" value="<?= $csrfToken; ?>">

                    <button type="submit">Like</button>
                </form>
                
                <form style="display: inline-block;" action="/likes/destroy" method="POST">
                    <input type="hidden" name="article_id" value="<?= $article->id; ?>">

                    <input type="hidden" name="csrf-token" value="<?= $csrfToken; ?>">

                    <button type="submit">Remove like</button>
                </form>
            <?php endif; ?>
            
            <br><br>

            <?php if ($article->user_id == app\Core\SessionManager::get('id')): ?>
                <button>
                    <a href="/articles/update?id=<?= $article->id; ?>&user_id=<?= $article->user_id; ?>">Edit</a>
                </button>
                
                <form style="display: inline-block;" action="/articles/destroy" method="POST">
                    <input type="hidden" name="id" value="<?= $article->id; ?>">

                    <input type="hidden" name="user_id" value="<?= $article->user_id; ?>">

                    <input type="hidden" name="csrf-token" value="<?= $csrfToken; ?>">

                    <button type="submit">Delete</button>
                </form>
            <?php endif; ?>
        </article>
    <?php endif; ?>

    <?php if (!empty($comments)): ?>
		<?php foreach ($comments as $comment): ?>
			<div class="comment">
                <h3><?= htmlspecialchars($comment->description); ?></h3>

				<p><?= $comment->created_at; ?></p>

                <?php if ($comment->user_id == app\Core\SessionManager::get('id')): ?>
                    <button>
                        <a href="/comments/update?id=<?= $comment->id; ?>&article_id=<?= $comment->article_id; ?>&user_id=<?= $comment->user_id; ?>">
                            Edit
                        </a>
                    </button>
                    
                    <form style="display: inline-block;" action="/comments/destroy" method="POST">
                        <input type="hidden" name="id" value="<?= $comment->id; ?>">

                        <input type="hidden" name="article_id" value="<?= $comment->article_id; ?>">

                        <input type="hidden" name="user_id" value="<?= $comment->user_id; ?>">

                        <input type="hidden" name="csrf-token" value="<?= $csrfToken; ?>">

                        <button type="submit">Delete</button>
                    </form>
                <?php endif; ?>
            </div>
		<?php endforeach; ?>
	<?php endif; ?>

    <?php if (app\Core\SessionManager::has('authenticated')): ?>
        <button>
            <a href="/comments/store?article_id=<?= $article->id; ?>">Comment</a>
        </button>
    <?php endif; ?>
</main>

<?php require_once BASE_PATH . '/resources/views/templates/footer.php'; ?>