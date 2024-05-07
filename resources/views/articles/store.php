<?php require_once BASE_PATH . '/resources/views/templates/header.php'; ?>

<main>
    <form id="form_container" class="container" action="/articles/store" method="POST">
        <label for="name">Title:</label>
        <input type="text" name="name" placeholder="Title" id="name" required>

        <label for="description">Description:</label>
        <textarea name="description" placeholder="Description" id="description" required></textarea>

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