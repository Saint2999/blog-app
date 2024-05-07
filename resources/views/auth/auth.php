<?php require_once BASE_PATH . '/resources/views/templates/header.php'; ?>

<main>
    <form id="form_container" class ="container" action="/auth/<?= $type; ?>" method="POST">
        <label for="name">Name:</label>
        <input type="text" name="name" placeholder="Name" id="name" required>

        <label for="password">Password:</label>
        <input type="password" name="password" placeholder="Password" id="password" required>

        <input type="hidden" name="csrf-token" value="<?= $csrfToken; ?>">

        <?php if ($type === 'login'): ?>
            <button type="submit">Sign In</button>
        <?php else: ?>
            <button type="submit">Sign Up</button>
        <?php endif; ?>

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