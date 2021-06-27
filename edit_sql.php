<?php

require("connect.php");

$title = $year = $genre = $rating = null;
$movie = $_POST["movie"];
$set = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title = test_input($_POST["title"]);
    $year = test_input($_POST["year"]);
    $genre = test_input($_POST["genre"]);
    $rating = test_input($_POST["rating"]);
}

function test_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

if (!empty($_POST["title"])) {
    $title = $_POST["title"];
    $set.= "title = :title AND ";
}

if (!empty($_POST["genre"])) {
    $genre = $_POST["genre"];
    $set.="genre = :genre AND ";
}

if (!empty($_POST["year"])) {
    $year = $_POST["year"];
    $set.= "year = :year AND ";
}

if (!empty($_POST["rating"])) {
    $rating = $_POST["rating"];
    $set.="rating = :rating AND ";
}

$set = rtrim($set, " AND ");

try {
    $sql = "UPDATE movies
            SET $set
            WHERE title = :movie;";

    $stmt = $conn->prepare($sql);
    $stmt->bindParam(":movie", $movie);

    if (!empty($_POST["title"])) {
        $stmt->bindParam(":title", $title);
    }

    if (!empty($_POST["genre"])) {
        $stmt->bindParam(":genre", $genre);
    }

    if (!empty($_POST["year"])) {
        $stmt->bindParam(":year", $year);
    }

    if (!empty($_POST["rating"])) {
        $stmt->bindParam(":rating", $rating);
    }

    $stmt->execute();

    echo "<p>" . $movie . " has been edited!</p>";

} catch (PDOException $e) {
    echo $e;
}

$conn = null;
?>
<a href="admin_search_form.php">Click here to go back to admin search form</a>