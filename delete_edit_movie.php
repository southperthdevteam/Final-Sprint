<?php
require("connect.php");

$movie = $_POST["movie"];

if (isset($_POST["delete"])) {

    try {

        $sql = "DELETE FROM movies WHERE title = '$movie';";
        $stmt = $conn->prepare($sql);
        $stmt->execute();

        echo "<p>" . $movie . "was deleted.</p>";
        echo "<a href='admin_search_form.php'>Click here to go back to admin search form</a>";

    } catch (PDOException $e) {
        echo "<p>Unable to delete movie</p>";
    }
}

if (isset($_POST["edit"])) {
?>
    <form class="form" action="edit_sql.php" method="post">
    
    <label>Title:</label><br>
    <input type="text" id="title" name="title"><br>
    
    <label>Genre:</label><br>
    <input type="text" id="genre" name="genre"><br>
    
    <label>Rating:</label><br>
    <input type="text" id="rating" name="rating"><br>
    
    <label>Year:</label><br>
    <input type="text" id="year" name="year"><br>
    
    <input type="submit" value="Edit" style= "margin-top: 10px;">

    <input type="hidden" id="movie" name="movie" value="<?php echo $movie ?>">
    </form>
<?php
}

$conn = null;
?>