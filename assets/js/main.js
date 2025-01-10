document.addEventListener("DOMContentLoaded", () => {
    const searchInput = document.getElementById("movie-search");
    const moviesContainer = document.getElementById("movies-container");

    searchInput.addEventListener("keyup", () => {
        const searchValue = searchInput.value.toLowerCase();
        const movies = moviesContainer.getElementsByClassName("movie-card");

        Array.from(movies).forEach(movie => {
            const title = movie.getAttribute("data-title").toLowerCase();
            if (title.includes(searchValue)) {
                movie.style.display = "block"; // Show matching movie
            } else {
                movie.style.display = "none"; // Hide non-matching movie
            }
        });
    });
});
