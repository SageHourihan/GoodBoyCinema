$(document).ready(() => {
    const searchInput = $("#movie-search");
    const moviesContainer = $("#movies-container");

    searchInput.on("keyup", () => {
        const searchValue = searchInput.val().toLowerCase();
        const movies = moviesContainer.find(".movie-card");

        movies.each(function () {
            const title = $(this).data("title").toLowerCase();
            if (title.includes(searchValue)) {
                $(this).show(); // Show matching movie
            } else {
                $(this).hide(); // Hide non-matching movie
            }
        });
    });

    const movies = [];
    $('.movie-card').each(function(){
        const id = $(this).data('id');
        const poster = $(this).data('poster');

        movies.push({ id, poster });
    });

    localStorage.setItem('movies', JSON.stringify(movies));

    $('.movie-card').on('click', function(){
        // alert($(this).data("id"));
        const id = $(this).data("id");
        const poster = $(this).data("img")

        const url = `../public/details.php?id=${id}`;

        window.location.href = url;
    })
});
