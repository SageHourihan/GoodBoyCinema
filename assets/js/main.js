$(document).ready(() => {
    const $searchInput = $("#movie-search");
    const $moviesContainer = $("#movies-container");

    $searchInput.on("keyup", () => {
        const searchValue = $searchInput.val().toLowerCase();
        const $movies = $moviesContainer.find(".movie-card");

        $movies.each(function () {
            const title = $(this).data("title").toLowerCase();
            if (title.includes(searchValue)) {
                $(this).show(); // Show matching movie
            } else {
                $(this).hide(); // Hide non-matching movie
            }
        });
    });
});
