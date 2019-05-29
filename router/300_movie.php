<?php
/**
 * Create routes using $app programming style.
 */
//var_dump(array_keys(get_defined_vars()));


/**
 * Show all movies.
 */
$app->router->get("movie", function () use ($app) {
    $title = "Movie database | oophp";
    //
    // $title = "Show all movies";
    // $view[] = "view/show-all.php";
    // $sql = "SELECT * FROM movie;";
    // $resultset = $db->executeFetchAll($sql);

    $app->db->connect();
    $sql = "SELECT * FROM movie;";
    $res = $app->db->executeFetchAll($sql);

    $app->page->add("movie/index", [
        "resultset" => $res,
    ]);

    return $app->page->render([
        "title" => $title,
    ]);
});


$app->router->get("movie-select", function () use ($app) {
    // $movieId = getPost("movieId");
    $app->db->connect();
    $movieId = $_POST["movieId"] ?? "";


    $title = "Select a movie";
    $sql = "SELECT id, title FROM movie;";
    $movies = $app->db->executeFetchAll($sql);

    $app->page->add("movie/movie-select", [
        "movies" => $movies,
    ]);

    return $app->page->render([
        "title" => $title,
    ]);
});


$app->router->post("movie-select", function () use ($app) {
    // $movieId = getPost("movieId");
    $app->db->connect();
    $movieId = $_POST["movieId"] ?? "";
    $doDelete = $_POST["doDelete"] ?? "";
    $doAdd = $_POST["doAdd"] ?? "";
    $doEdit = $_POST["doEdit"] ?? "";
    if ($doDelete) {
        $sql = "DELETE FROM movie WHERE id = ?;";
        $app->db->execute($sql, [$movieId]);
        header("Location: movie-select");
    } elseif ($doAdd) {
        $sql = "INSERT INTO movie (title, year, image) VALUES (?, ?, ?);";
        $app->db->execute($sql, ["A title", 2017, "img/noimage.png"]);
        $movieId = $app->db->lastInsertId();
        header("Location: movie-edit?movieId=$movieId");
        exit;
    } elseif ($doEdit && is_numeric($movieId)) {
        header("Location: movie-edit?movieId=$movieId");
        exit;
    }


    $title = "Select a movie";
    $sql = "SELECT id, title FROM movie;";
    $movies = $app->db->executeFetchAll($sql);

    $app->page->add("movie/movie-select", [
        "movies" => $movies,
    ]);

    return $app->page->render([
        "title" => $title,
    ]);
});

$app->router->get("movie-edit", function () use ($app) {
    // $movieId = getPost("movieId");
    $title = "Edit a move";
    $app->db->connect();
    $movieId = $app->request->getGet("movieId");
    $sql = "SELECT * FROM movie WHERE id = ?";
    $movies = $app->db->executeFetch($sql, [$movieId]);


    $app->page->add("movie/movie-edit", [
        "movie" => $movies,
    ]);

    return $app->page->render([
        "title" => $title,
    ]);
});


$app->router->post("movie-edit", function () use ($app) {
    // $movieId = getPost("movieId");
    $title = "Edit a move";
    $app->db->connect();

    $movieId    = $app->request->getPost("movieId") ?: $app->request->getGet("movieId");
    $movieTitle = $app->request->getPost("movieTitle");
    $movieYear  = $app->request->getPost("movieYear");
    $movieImage = $app->request->getPost("movieImage");

    if ($app->request->getPost("doSave")) {
        $sql = "UPDATE movie SET title = ?, year = ?, image = ? WHERE id = ?;";
        $app->db->execute($sql, [$movieTitle, $movieYear, $movieImage, $movieId]);
        header("Location: movie");
        exit;
    }
});

$app->router->get("search-title", function () use ($app) {
    // $movieId = getPost("movieId");
    $title = "Search for a title";
    $searchTitle = "";
    $app->db->connect();

    if($app->request->getGet("doSearch")) {
        $searchTitle = $app->request->getGet("searchTitle");
        $sql = "SELECT * FROM movie WHERE title LIKE ?;";
        $resultset = $app->db->executeFetchAll($sql, [$searchTitle]);
        $app->page->add("movie/search", ["resultset" => $resultset]);
    }
        $app->page->add("movie/search-title", [
            "searchTitle" => $searchTitle,
        ]);
        return $app->page->render([
            "title" => $title,
        ]);
});

$app->router->get("search-year", function () use ($app) {
    $title = "Search for a year";
    $app->db->connect();
    $year1 = $app->request->getGet("year1");
    $year2 = $app->request->getGet("year2");
    if ($year1 && $year2) {
        $sql = "SELECT * FROM movie WHERE year >= ? AND year <= ?;";
        $resultset = $app->db->executeFetchAll($sql, [$year1, $year2]);
        $app->page->add("movie/search2", ["resultset" => $resultset]);
    } elseif ($year1) {
        $sql = "SELECT * FROM movie WHERE year >= ?;";
        $resultset = $app->db->executeFetchAll($sql, [$year1]);
        $app->page->add("movie/search2", ["resultset" => $resultset]);
    } elseif ($year2) {
        $sql = "SELECT * FROM movie WHERE year <= ?;";
        $resultset = $app->db->executeFetchAll($sql, [$year2]);
        $app->page->add("movie/search2", ["resultset" => $resultset]);
    }
    $app->page->add("movie/search-year", [
        "year1" => $year1,
        "year2" => $year2
    ]);
    return $app->page->render([
        "title" => $title,
    ]);
});