<?php
/**
 * Show textfilters.
 */
$app->router->get("textfilter", function () use ($app) {
    $title = "Textfilter";
    $app->page->add("textfilter/textfilter-index");
    return $app->page->render([
        "title" => $title,
    ]);
});

$app->router->get("textfilter/bbcode", function () use ($app) {
    $title = "Textfilter med bbcode";
    $textfilter = new Emmu18\MyTextFilter\MyTextFilter();
    $filter = "bbcodefilter";
    $text = file_get_contents(__DIR__ . "/../content/text/bbcode.txt");
    $html = $textfilter->parse($text, $filter);
    $data = [
        "filterName" => "BBCode",
        "text" => $text ?? null,
        "html" => $html ?? null
    ];
    $app->page->add("textfilter/textfilterExample", $data);
    return $app->page->render([
        "title" => $title,
    ]);
});

$app->router->get("textfilter/clickable", function () use ($app) {
    $title = "Textfilter med clickable";
    $textfilter = new Emmu18\MyTextFilter\MyTextFilter();
    $filter = "link";
    $text = file_get_contents(__DIR__ . "/../content/text/clickable.txt");
    $html = $textfilter->parse($text, $filter);
    $data = [
        "filterName" => "Clickablefilter",
        "text" => $text ?? null,
        "html" => $html ?? null
    ];
    $app->page->add("textfilter/textfilterExample", $data);
    return $app->page->render([
        "title" => $title,
    ]);
});

$app->router->get("textfilter/markdown", function () use ($app) {
    $title = "Textfilter med markdown";
    $textfilter = new Emmu18\MyTextFilter\MyTextFilter();
    $filter = "markdown";
    $text = file_get_contents(__DIR__ . "/../content/text/sample.md");
    $html = $textfilter->parse($text, $filter);
    $data = [
        "filterName" => "Markdownfilter",
        "text" => $text ?? null,
        "html" => $html ?? null
    ];
    $app->page->add("textfilter/textfilterExample", $data);
    return $app->page->render([
        "title" => $title,
    ]);
});


$app->router->get("textfilter/nl2br", function () use ($app) {
    $title = "Textfilter med nl2br";
    $textfilter = new Emmu18\MyTextFilter\MyTextFilter();
    $filter = "bbcode, nl2br";
    $text = file_get_contents(__DIR__ . "/../content/text/bbcode.txt");
    $html = $textfilter->parse($text, $filter);
    $data = [
        "filterName" => "BBCode med en kombination av Nl2br",
        "text" => $text ?? null,
        "html" => $html ?? null
    ];
    $app->page->add("textfilter/textfilterExample", $data);
    return $app->page->render([
        "title" => $title,
    ]);
});