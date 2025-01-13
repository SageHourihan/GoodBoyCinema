<?php 

if($_SERVER['REQUEST_METHOD'] === 'POST'){
    $id = isset($_POST['id']) ? trim($_POST['id']) : null;
    $function = isset($_POST['function']) ? $_POST['function'] : '';

    // calling the function
    if(!empty($function) && function_exists($function)){
        $output = getMovieDetails($id);
        echo $output;
    }else{
        echo 'error';
    }
}

function getMovieDetails($id){
    // TODO: get movie desc from tmdb and actors
    // return "movie id {$id}";

    $curl = curl_init();

    curl_setopt_array($curl, [
    CURLOPT_URL => "https://api.themoviedb.org/3/movie/526007?language=en-US",
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_ENCODING => "",
    CURLOPT_MAXREDIRS => 10,
    CURLOPT_TIMEOUT => 30,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => "GET",
    CURLOPT_HTTPHEADER => [
        "Authorization: Bearer eyJhbGciOiJIUzI1NiJ9.eyJhdWQiOiIwYmY0N2Y3NmFjM2U0NjFkMGJkZDNkNmQwZTRhYmJjMSIsIm5iZiI6MTY1MzM1MTY5My45NTI5OTk4LCJzdWIiOiI2MjhjMjUwZDZjODQ5MjcxODdhZGIzYTAiLCJzY29wZXMiOlsiYXBpX3JlYWQiXSwidmVyc2lvbiI6MX0.ykHUrFI7vdvSsy1qjseLXZgLRy2Rn4HRxS2yTf2gVLs",
        "accept: application/json"
    ],
    ]);

    $response = curl_exec($curl);
    $err = curl_error($curl);

    curl_close($curl);

    return $response;

}