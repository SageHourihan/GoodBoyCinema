<?php
include_once '/var/www/html/GoodBoyCinema/config/db.php';
require_once '../vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable('/var/www/html/GoodBoyCinema/config');
$dotenv->load();
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
        'Authorization: Bearer ' . $_ENV['TOKEN']
    ),
    ));

    $response = curl_exec($curl);

    curl_close($curl);
    
    $searchData = json_decode($response, true);

    global $conn;
    try{
        $stmt = $conn->prepare("UPDATE movies SET tmdb_id=:tmdb_id WHERE title = :title");
        $stmt->bindParam(":tmdb_id", $searchData['results'][0]['id']);
        $stmt->bindParam(":title", $movie);
        $stmt->execute();
    }catch(PDOException $e){
        error_log($e->getMessage());
    }

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
        "Authorization: Bearer " . $_ENV['TOKEN']
    ],
    ]);

    $response = curl_exec($curl);
    $err = curl_error($curl);

    curl_close($curl);


    $response = json_decode($response, true);
    $imagePath = $response['posters'][0]['file_path'];

    $image = "https://image.tmdb.org/t/p/w200$imagePath";

    global $conn;
    try{
        $stmt = $conn->prepare("UPDATE movies SET poster_url = :poster_url WHERE tmdb_id = :tmdb_id");
        $stmt->bindValue(":poster_url", $image);
        $stmt->bindValue(":tmdb_id", $id);
        $stmt->execute();
    }catch(PDOException $e){
        error_log($e->getMessage());
    }

    if ($err) {
    error_log ("cURL Error #:" . $err);
    } else {
    return $image;
    }
}

function getDogID($title){
    $curl = curl_init();

    curl_setopt_array($curl, array(
    CURLOPT_URL => 'https://www.doesthedogdie.com/dddsearch?q=' . urlencode($title),
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_ENCODING => '',
    CURLOPT_MAXREDIRS => 10,
    CURLOPT_TIMEOUT => 0,
    CURLOPT_FOLLOWLOCATION => true,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => 'GET',
    CURLOPT_HTTPHEADER => array(
        'Accept: application/json',
        'X-API-KEY: ' . $_ENV['DOG_TOKEN'],
    ),
    ));

    $response = curl_exec($curl);

    curl_close($curl);

    $response = json_decode($response,true);

    return $response['items'][0]['id'];
}

function dogStatus($id, $title){
    global $conn;
    $curl = curl_init();

    curl_setopt_array($curl, array(
        CURLOPT_URL => "https://www.doesthedogdie.com/media/$id",
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'GET',
        CURLOPT_HTTPHEADER => array(
          'Accept: application/json',
          'X-API-KEY: ' . $_ENV['DOG_TOKEN'],
        ),
      ));
      
      $response = curl_exec($curl);
      
      curl_close($curl);
      $response = json_decode($response, true);
      
      foreach ($response['topicItemStats'] as $stats) {
        if($stats['TopicId'] === 153){
            if($stats['yesSum'] > $stats['noSum']){
                try{
                    $stmt = $conn->prepare("UPDATE movies SET dog_status = :dog_status WHERE title = :title");
                    $stmt->bindValue(":dog_status", 'The dog dies.');
                    $stmt->bindValue(":title", $title);
                    $stmt->execute();
                }catch(PDOException $e){
                    error_log($e->getMessage());
                }
                return 'The dog dies.';
            }else{
                try{
                    $stmt = $conn->prepare("UPDATE movies SET dog_status = :dog_status WHERE title = :title");
                    $stmt->bindValue(":dog_status", 'The dog lives.');
                    $stmt->bindValue(":title", $title);
                    $stmt->execute();
                }catch(PDOException $e){
                    error_log($e->getMessage());
                }
                return 'The dog lives.';
            }
        }
      }
}