<article>
    <header>
        <h1><?= htmlentities($content->title) ?></h1>
        <p><i>Latest update: <time datetime="<?= htmlentities($content->modified_iso8601) ?>" pubdate><?= htmlentities($content->modified) ?></time></i></p>
    </header>
    <?= $filteredText ?>
</article>
