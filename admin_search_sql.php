<!DOCTYPE html>
<html lang="en">

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1" charset="utf-8" />
    <title>Movie Rental</title>
    <link rel="stylesheet" href="movies.css">
</head>

<body>
    <div id="top">
        <h1>Movie Rental</h1>
    </div>
    
    <div id="searchBar">
        <ul id="ul">
            <li><a href="search.php">Search Movie</a></li>
            <li><a href="top_movies.php">Top 10</a></li>
            <li><a href="register.php">Register</a></li>
        </ul>
    </div>

    <div id="content">
    <?php

    require("connect.php");

    $title = null;
    $movieName = null;
    $year = null;
    $genre = null;
    $rating = null;
    
    $where="";
    $searching="Searching";

    if (!empty($_POST["title"])) {
        $movieName = $_POST["title"];
        $title = "%" . $movieName . "%";
        $where.= "title LIKE :title AND ";
        $searching.= " for " . $_POST["title"];
    }

    if (!empty($_POST["genre"])) {
        $genre = $_POST["genre"];
        $where.="genre = :genre AND ";
        $searching.= " in " . $_POST["genre"];
    }

    if (!empty($_POST["year"])) {
        $year = $_POST["year"];
        $where.= "year = :year AND ";
        $searching.= " from " . $_POST["year"];
    }

    if (!empty($_POST["rating"])) {
        $rating = $_POST["rating"];
        $where.="rating = :rating AND ";
        $searching.= " with rating " . $_POST["rating"];
    }

    $where = rtrim($where, " AND ");

    try {
        $sql = "SELECT title, year, genre, rating
                FROM movies 
                WHERE $where
                ORDER BY title;";

        // echo "<p>" . $sql . "</p><br>";
        echo "<p>" . $searching . "</p><br>";

        $stmt = $conn->prepare($sql);

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
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

        if ($result) {

            echo "<table style class='table';>";
            echo "<tr><th>Title</th><th>Year</th><th>Genre</th><th>Rating</th><th>Delete or Edit</th></tr>";
            
            foreach ($result as $row) {
            ?>
                <tr>
                <td><?php echo $row['title'];?></td>
                <td><?php echo $row['year'];?></td>
                <td><?php echo $row['genre'];?></td>
                <td><?php echo $row['rating'];?></td>
                <td>
                    <form action="delete_edit_movie.php" method="post">

                    <input type="submit" value="Add" id="add" name="add" class="score"><br>

                    <input type="submit" value="Delete" id="delete" name="delete" class="score"><br>

                    <input type="submit" value="Edit" id="edit" name="edit" class="score"><br>

                    <input type="hidden" id="movie" name="movie" value="<?php echo htmlspecialchars($row['title']); ?>">

                    </form>
                </td>
                </tr>
            <?php
            }

        } else {
            echo "<p>Your search returned no movies</p>";
        }
        
    } catch (PDOException $e) {
        echo "<p>Your search returned no movies</p>";
    }

    $conn = null;

    ?>

    </div>
</body>
</html>
