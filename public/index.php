<?php 
include_once '../src/goodboycinema_helper.php';
include_once '../views/header.php';

$movies = getMovies(); // Fetch the movies dynamically
?>

<main>
    <div class="search-container">
        <input 
            type="text" 
            id="movie-search" 
            placeholder="Search for a movie..." 
            onkeyup="filterMovies()"
        >
    </div>

    <div class="movies-container" id="movies-container">
        <?php
        foreach ($movies as $movie) {
            $id = getMovieID($movie['title']);
            $poster = getMoviePoster($id);
            $dogTag = getDogId($movie['title']);
            $dogStatus = dogStatus($dogTag);
            echo "<div class='movie-card' data-title='{$movie['title']}'>
                    <img src='$poster' alt='{$movie['title']} Poster'>
                    <h2>{$movie['title']}</h2>
                    <span>{$dogStatus}</span>
                  </div>";
        }
        ?>
    </div>
</main>

<?php include_once '../views/footer.php'; ?>
