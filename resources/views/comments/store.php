<?php require_once BASE_PATH . '/resources/views/templates/header.php'; ?>

<main>
    <form id="form_container" class="container" action="/comments/store" method="POST">
        <label for="description">Description:</label>
        <textarea name="description" placeholder="Description" id="description" required></textarea>

        <input type="hidden" name="article_id" value="<?= $article_id; ?>">

        <input type="hidden" name="csrf-token" value="<?= $csrfToken; ?>">

        <button type="submit">Submit</button>

        <p>Server response:</p>
        <div id="response_message">
            <?php if (!empty($errors)): ?>
                <?php foreach ($errors as $error): ?>
                    <p><?= $error; ?></p>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </form>
</main>

<?php require_once BASE_PATH . '/resources/views/templates/footer.php'; ?>