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
    require "connect.php";?>

    <form class="form" action="admin_search_sql.php" method="post">
        
        <label>Title:</label><br>
        <input type="text" id="title" name="title"><br>
        
        <label>Genre:</label><br>
        <select id="genre" name="genre">
            <option value="0">Search Genres</option>
            <?php
            $sql = "SELECT DISTINCT genre FROM movies ORDER BY genre;";
            $stmt = $conn->query($sql);
            while ($row = $stmt->fetch()) {
                echo "<option>$row[genre]</option><br>";
            }
            ?>
        </select><br>
        
        <label>Rating:</label><br>
        <select id="rating" name="rating">
            <option value="0">Search Ratings</option>
            <?php
            $sql = "SELECT DISTINCT rating FROM movies ORDER BY rating;";
            $stmt = $conn->query($sql);
            while ($row = $stmt->fetch()) {
                echo "<option>$row[rating]</option><br>";
            }
            ?>
        </select><br>
        
        <label>Year:</label><br>
        <select id="year" name="year">
            <option value="0">Search Years</option>
            <?php
            $sql = "SELECT DISTINCT year FROM movies ORDER BY year DESC;";
            $stmt = $conn->query($sql);
            while ($row = $stmt->fetch()) {
                echo "<option>$row[year]</option><br>";
            }
            ?>
        </select><br>

        <input type="hidden" id="refresh" name="refresh" value="false">
        
        <input type="submit" value="Search" style= "margin-top: 10px;">

    </form>
    </div>
</body>
</html>