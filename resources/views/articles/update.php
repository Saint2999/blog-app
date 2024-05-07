<?php require_once BASE_PATH . '/resources/views/templates/header.php'; ?>

<main>
    <?php if (is_object($article)): ?>
        <form id="form_container" class="container" action="/articles/update" method="POST">
            <label for="name">Title:</label>
            <input type="text" name="name" placeholder="Title" id="name" required value="<?= $article->name; ?>">

            <label for="description">Description:</label>
            <textarea name="description" placeholder="Description" id="description" required>
                <?= $article->description; ?>
            </textarea>

            <input type="hidden" name="id" value="<?= $article->id; ?>">

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
    <?php endif; ?> 
</main>

<?php require_once BASE_PATH . '/resources/views/templates/footer.php'; ?>