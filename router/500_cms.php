<?php

/*
* Visar innehållet
*/
$app->router->get("content", function () use ($app) {
    $title = "Blogg database | oophp";
    //
    // $title = "Show all movies";
    // $view[] = "view/show-all.php";
    // $sql = "SELECT * FROM movie;";
    // $resultset = $db->executeFetchAll($sql);

    $app->db->connect();
    $sql = "SELECT * FROM content;";
    $res = $app->db->executeFetchAll($sql);
    $app->page->add("cms/header");
    $app->page->add("cms/index", [
        "resultset" => $res,
    ]);
    return $app->page->render([
        "title" => $title,
    ]);
});

/*
* Visar upp bloggarna
*/

$app->router->get("blogg", function () use ($app) {
    $title = "Blogg database | oophp";
    //
    // $title = "Show all movies";
    // $view[] = "view/show-all.php";
    // $sql = "SELECT * FROM movie;";
    // $resultset = $db->executeFetchAll($sql);

    $app->db->connect();
    $sql = <<<EOD
SELECT
    *,
    DATE_FORMAT(COALESCE(updated, published), '%Y-%m-%dT%TZ') AS published_iso8601,
    DATE_FORMAT(COALESCE(updated, published), '%Y-%m-%d') AS published
FROM content
WHERE type=?
AND (deleted IS NULL OR deleted > NOW())
AND published <= NOW()
ORDER BY published DESC
;
EOD;
    $res = $app->db->executeFetchAll($sql, ["post"]);
    $app->page->add("cms/header");
    $app->page->add("cms/blog", [
        "resultset" => $res,
    ]);
    return $app->page->render([
        "title" => $title,
    ]);
});

/*
* Visar en specifik blogg med filter
*/

$app->router->get("blog-post", function () use ($app) {
    $title = "Blogg post";
    $textfilter = new Emmu18\MyTextFilter\MyTextFilter();
    $app->db->connect();
    $slug = $app->request->getGet("slug");
    $sql = <<<EOD
SELECT
    *,
    DATE_FORMAT(COALESCE(updated, published), '%Y-%m-%dT%TZ') AS published_iso8601,
    DATE_FORMAT(COALESCE(updated, published), '%Y-%m-%d') AS published
FROM content
WHERE
slug = ?
AND (deleted IS NULL OR deleted > NOW())
AND published <= NOW()
;
EOD;
    $content = $app->db->executeFetch($sql, [$slug]);
    $filteredText = $textfilter->parse($content->data, $content->filter);
    $data = [
        "content"   => $content,
        "filteredText"   => $filteredText
    ];
    $app->page->add("cms/header");
    $app->page->add("cms/blogpost", $data);
    return $app->page->render([
        "title" => $title,
    ]);
});

/**
 * Visar alla bloggar med sidor.
 */
$app->router->get("pages", function () use ($app) {
    $title = "View pages";
    $app->db->connect();
    $sql = <<<EOD
    SELECT
        *,
        CASE
            WHEN (deleted <= NOW()) THEN "isDeleted"
            WHEN (published <= NOW()) THEN "isPublished"
            ELSE "notPublished"
        END AS status
    FROM content
    WHERE type=?
    ;
EOD;
    $res = $app->db->executeFetchAll($sql, ["page"]);
    $app->page->add("cms/header");
    $app->page->add("cms/pages", [
        "resultset" => $res,
    ]);
    return $app->page->render([
        "title" => $title,
    ]);
});


/**
 * Visar en spesifik sida
 */
$app->router->get("page", function () use ($app) {
    $title = "View page";
    $app->db->connect();
    $path = $app->request->getGet("path");
    $textfilter = new Emmu18\MyTextFilter\MyTextFilter();
    $sql = <<<EOD
SELECT
    *,
    DATE_FORMAT(COALESCE(updated, published), '%Y-%m-%dT%TZ') AS modified_iso8601,
    DATE_FORMAT(COALESCE(updated, published), '%Y-%m-%d') AS modified
FROM content
WHERE
    path = ?
    AND type = ?
    AND (deleted IS NULL OR deleted > NOW())
    AND published <= NOW()
;
EOD;
    $content = $app->db->executeFetch($sql, [$path, "page"]);
    $filteredText = $textfilter->parse($content->data, $content->filter);
    $app->page->add("cms/header");
    $app->page->add("cms/page", [
        "content" => $content,
        "filteredText" => $filteredText
    ]);
    return $app->page->render([
        "title" => $title,
    ]);
});


/**
 * Visar admin tillgångarna
 */
$app->router->get("admin", function () use ($app) {
    $title = "Admin";
    $app->db->connect();
    $sql = "SELECT * FROM content;";
    $res = $app->db->executeFetchAll($sql);
    $app->page->add("cms/header");
    $app->page->add("cms/admin", [
        "resultset" => $res,
    ]);
    return $app->page->render([
        "title" => $title,
    ]);
});

/**
 * Edit en specifik id.
 */
$app->router->get("edit", function () use ($app) {
    $title = "Edit page";
    $app->db->connect();
    $contentId = $app->request->getGet("id");
    $sql = "SELECT * FROM content WHERE id = ?;";
    $content = $app->db->executeFetch($sql, [(int)$contentId]);
    $app->page->add("cms/header");
    $app->page->add("cms/edit", [
        "content" => $content
    ]);
    return $app->page->render([
        "title" => $title,
    ]);
});

/**
 * Save specific ID.
 */
$app->router->post("edit", function () use ($app) {
    $app->db->connect();
    $params["contentTitle"] = $app->request->getPost("contentTitle");
    $params["contentPath"] = $app->request->getPost("contentPath");
    $params["contentSlug"] = $app->request->getPost("contentSlug");
    $params["contentData"] = $app->request->getPost("contentData");
    $params["contentType"] = $app->request->getPost("contentType");
    $params["contentFilter"] = $app->request->getPost("contentFilter");
    $params["contentPublish"] = $app->request->getPost("contentPublish");
    $params["contentId"] = $app->request->getPost("contentId");

    if (!$params["contentSlug"]) {
        $params["contentTitle"] = mb_strtolower(trim($params["contentTitle"]));
        $params["contentTitle"] = str_replace(['å','ä'], 'a', $params["contentTitle"]);
        $params["contentTitle"] = str_replace('ö', 'o', $params["contentTitle"]);
        $params["contentTitle"] = preg_replace('/[^a-z0-9-]/', '-', $params["contentTitle"]);
        $params["contentTitle"] = trim(preg_replace('/-+/', '-', $params["contentTitle"]), '-');
        $params["contentSlug"] = $params["contentTitle"];
    }
    if (!$params["contentPath"]) {
        $params["contentPath"] = null;
    }
    $sql = "SELECT slug, id FROM content;";
    $contents = $app->db->executeFetchAll($sql);
    foreach ($contents as $content) {
        if ($params["contentSlug"] == $content->slug && $params["contentId"] != $content->id) {
            $params["contentSlug"] = $params["contentSlug"] . "-" . $params["contentId"];
        }
    }
    $sql = "UPDATE content SET title=?, path=?, slug=?, data=?, type=?, filter=?, published=? WHERE id = ?;";
    $app->db->execute($sql, array_values($params));
    return $app->response->redirect("admin");
});


/**
 * GET Radera en specifik blogg.
 */
$app->router->get("delete", function () use ($app) {
    $title = "Delete content";
    $app->db->connect();
    $contentId = $app->request->getGet("id");
    $sql = "SELECT id, title FROM content WHERE id = ?;";
    $content = $app->db->executeFetch($sql, [(int)$contentId]);
    $app->page->add("cms/header");
    $app->page->add("cms/delete", [
        "content" => $content
    ]);
    return $app->page->render([
        "title" => $title,
    ]);
});
/**
 * POST Radera en specifik blogg.
 */
$app->router->post("delete", function () use ($app) {
    $app->db->connect();
    $contentId = $app->request->getPost("contentId");
    $sql = "DELETE FROM content WHERE id=?;";
    $app->db->execute($sql, [(int)$contentId]);
    return $app->response->redirect("admin");
});


/**
 * GET Skapa en blogg.
 */
$app->router->get("create", function () use ($app) {
    $title = "Create content";
    $app->page->add("cms/header");
    $app->page->add("cms/create");
    return $app->page->render([
        "title" => $title,
    ]);
});
/**
 * POST Skapa en blogg.
 */
$app->router->post("create", function () use ($app) {
    $app->db->connect();
    $title = $app->request->getPost("contentTitle");
    $sql = "INSERT INTO content (title) VALUES (?);";
    $app->db->execute($sql, [$title]);
    $id = $app->db->lastInsertId();
    return $app->response->redirect("edit?id=$id");
});