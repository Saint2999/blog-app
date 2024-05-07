<?php require_once BASE_PATH . '/resources/views/templates/header.php'; ?>

<main class ="container">
    <?php if (is_object($article)): ?>
        <article>
            <h1><?= $article->name; ?></h1>
            <p><?= $article->description; ?></p>

            <button>
                <a href="/articles/update?id=<?= $article->id; ?>">Edit</a>
            </button>
            
            <form style="display: inline-block;" action="/articles/destroy" method="POST">
                <input type="hidden" name="id" value="<?= $article->id; ?>">

                <input type="hidden" name="csrf-token" value="<?= $csrfToken; ?>">

                <button type="submit">Delete</button>
            </form>
        </article>
    <?php endif; ?>
</main>

<?php require_once BASE_PATH . '/resources/views/templates/footer.php'; ?>