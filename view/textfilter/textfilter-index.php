<?php
namespace Anax\View;
/**
 * Render content within an article.
 */
?>
<div>
    <h1>Exempel på Textfilter</h1>
    <p>Genom att klicka på de olika länkarna kan du testa de olika textfilterna.</p>
    <a href="<?= url("textfilter/bbcode") ?>">Bbcode</a> |
    <a href="<?= url("textfilter/clickable") ?>">Clickable</a> |
    <a href="<?= url("textfilter/markdown") ?>">Markdown</a> |
    <a href="<?= url("textfilter/nl2br") ?>">Nl2br</a>
</div>