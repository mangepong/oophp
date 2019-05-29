<article>
    <header>
        <h1><?= htmlentities($content->title) ?></h1>
        <p><i>Published: <time datetime="<?= htmlentities($content->published_iso8601) ?>" pubdate><?= htmlentities($content->published) ?></time></i></p>
    </header>
    <?= htmlentities($content->data) ?>
</article>
