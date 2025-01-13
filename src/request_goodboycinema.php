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
    return "Movie id is $id";
}