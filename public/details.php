<?php 
include_once '../src/goodboycinema_helper.php';
include_once '../views/header.php';
global $conn;

$id = $_GET['id'];

$stmt = $conn->prepare("SELECT * FROM movies WHERE tmdb_id = :tmdb_id");
$stmt->bindValue(":tmdb_id", $id);
$stmt->execute();
$results = $stmt->fetch(PDO::FETCH_ASSOC);


?>

<main>



</main>

<?php include_once '../views/footer.php'; ?>
