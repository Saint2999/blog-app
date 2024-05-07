<?php require_once BASE_PATH . '/resources/views/templates/header.php'; ?>

<main class ="container">
        <?php if (!empty($articles)): ?>
            <?php foreach ($articles as $article): ?>
                <article>
                    <h2>
                        <a href="/articles/show?id=<?= $article->id; ?>">
                            <?= $article->name; ?>
                        </a>
                    </h2>

                    <p><?= substr($article->description, 0, 255); ?>...</p>
                </article>
            <?php endforeach; ?>
        <?php endif; ?>

        <?php if (ceil($articleCount / $articleCountOnPage) > 0): ?>
			<ul class="pagination">
				<?php if ($page > 1): ?>
				<li class="prev"><a href="/articles?page=<?php echo $page-1 ?>">Prev</a></li>
				<?php endif; ?>

				<?php if ($page > 3): ?>
				<li class="start"><a href="/articles?page=1">1</a></li>
				<li class="dots">...</li>
				<?php endif; ?>

				<?php if ($page-2 > 0): ?><li class="page"><a href="/articles?page=<?php echo $page-2 ?>"><?php echo $page-2 ?></a></li><?php endif; ?>
				<?php if ($page-1 > 0): ?><li class="page"><a href="/articles?page=<?php echo $page-1 ?>"><?php echo $page-1 ?></a></li><?php endif; ?>

				<li class="currentpage"><a href="/articles?page=<?php echo $page ?>"><?php echo $page ?></a></li>

				<?php if ($page+1 < ceil($articleCount / $articleCountOnPage)+1): ?><li class="page"><a href="/articles?page=<?php echo $page+1 ?>"><?php echo $page+1 ?></a></li><?php endif; ?>
				<?php if ($page+2 < ceil($articleCount / $articleCountOnPage)+1): ?><li class="page"><a href="/articles?page=<?php echo $page+2 ?>"><?php echo $page+2 ?></a></li><?php endif; ?>

				<?php if ($page < ceil($articleCount / $articleCountOnPage)-2): ?>
				<li class="dots">...</li>
				<li class="end"><a href="/articles?page=<?php echo ceil($articleCount / $articleCountOnPage) ?>"><?php echo ceil($articleCount / $articleCountOnPage) ?></a></li>
				<?php endif; ?>

				<?php if ($page < ceil($articleCount / $articleCountOnPage)): ?>
				<li class="next"><a href="/articles?page=<?php echo $page+1 ?>">Next</a></li>
				<?php endif; ?>
			</ul>
		<?php endif; ?>

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