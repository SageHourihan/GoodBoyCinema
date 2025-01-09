<?php
include_once '/var/www/html/GoodBoyCinema/config/db.php';

function getMovies(){
    global $conn;
    $stmt = $conn->prepare("SELECT * FROM movies");
    $stmt->execute();
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
    return $result;
}

function getMovieID($movie){
    $curl = curl_init();

    curl_setopt_array($curl, array(
    CURLOPT_URL => 'https://api.themoviedb.org/3/search/movie?query=' . urlencode($movie),
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_ENCODING => '',
    CURLOPT_MAXREDIRS => 10,
    CURLOPT_TIMEOUT => 0,
    CURLOPT_FOLLOWLOCATION => true,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => 'GET',
    CURLOPT_HTTPHEADER => array(
        'Authorization: Bearer eyJhbGciOiJIUzI1NiJ9.eyJhdWQiOiI1YjczZGVjOTNhMWZiMzI3ZWM1ZmE1ZDZlMGUwYjdkZSIsIm5iZiI6MTY1MzM1MTY5My45NTI5OTk4LCJzdWIiOiI2MjhjMjUwZDZjODQ5MjcxODdhZGIzYTAiLCJzY29wZXMiOlsiYXBpX3JlYWQiXSwidmVyc2lvbiI6MX0.CaRtDmxuNNYnCRqmpk0D0daxRmP0sCTxod5dWSgUKDw'
    ),
    ));

    $response = curl_exec($curl);

    curl_close($curl);
    
    $searchData = json_decode($response, true);

    return $searchData['results'][0]['id'];
}

function getMoviePoster($id){

    $curl = curl_init();

    curl_setopt_array($curl, [
    CURLOPT_URL => "https://api.themoviedb.org/3/movie/$id/images?include_image_language=en",
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_ENCODING => "",
    CURLOPT_MAXREDIRS => 10,
    CURLOPT_TIMEOUT => 30,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => "GET",
    CURLOPT_HTTPHEADER => [
        "Authorization: Bearer eyJhbGciOiJIUzI1NiJ9.eyJhdWQiOiI1YjczZGVjOTNhMWZiMzI3ZWM1ZmE1ZDZlMGUwYjdkZSIsIm5iZiI6MTY1MzM1MTY5My45NTI5OTk4LCJzdWIiOiI2MjhjMjUwZDZjODQ5MjcxODdhZGIzYTAiLCJzY29wZXMiOlsiYXBpX3JlYWQiXSwidmVyc2lvbiI6MX0.CaRtDmxuNNYnCRqmpk0D0daxRmP0sCTxod5dWSgUKDw",
        "accept: application/json"
    ],
    ]);

    $response = curl_exec($curl);
    $err = curl_error($curl);

    curl_close($curl);


    $response = json_decode($response, true);
    $imagePath = $response['posters'][0]['file_path'];

    $image = "https://image.tmdb.org/t/p/w200$imagePath";

    if ($err) {
    echo "cURL Error #:" . $err;
    } else {
    return $image;
    }
}