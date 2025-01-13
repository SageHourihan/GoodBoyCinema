<?php 
include_once '../src/goodboycinema_helper.php';
include_once '../views/header.php';

$id = $_GET['id'];

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
    "Authorization: Bearer " . $_ENV['TOKEN'],
    "accept: application/json"
],
]);

$response = curl_exec($curl);
$err = curl_error($curl);

curl_close($curl);

$response = json_decode($response, true);

?>

<main>

    <div class="details-container">
        
    </div>

</main>

<?php include_once '../views/footer.php'; ?>
