<?php require_once BASE_PATH . '/resources/views/templates/header.php'; ?>

<main class ="container">
    <?php if (is_object($article)): ?>
        <article>
            <h1><?= $article->name; ?></h1>
            <p><?= $article->description; ?></p>

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
				<h3><?= $comment->description; ?></h3>

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

    <button>
        <a href="/comments/store?article_id=<?= $article->id; ?>">Comment</a>
    </button>
</main>

<?php require_once BASE_PATH . '/resources/views/templates/footer.php'; ?>