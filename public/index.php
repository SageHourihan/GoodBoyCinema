<?php 
include_once '../src/goodboycinema_helper.php';
include_once '../views/header.php';

$movies = getMovies();
?>

<body>
    <h2>List of movies</h2>
    <ul>
        <?php
            foreach ($movies as $movie) {
                $id = getMovieID($movie['title']);

                $poster = getMoviePoster($id);
                // error_log($poster);
                echo "<li><img src='$poster'></li>";
            }
        ?>
    </ul>
</body>

<?php include_once '../views/footer.php' ?>