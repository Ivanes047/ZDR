<?php

    session_start();
    $host='localhost';
    $port = '5433';
    $db = 'zdr_base';
    $username = 'Ivanes047';
    $password = '123456';  
        
    $dbconn = pg_connect("host=$host port=$port dbname=$db user=$username password=$password") or die('Не удалось соединиться: ' . pg_last_error());

    if($_SERVER['REQUEST_METHOD'] == 'POST'){
        if(isset($_POST['title']) && isset($_POST['description']) && isset($_POST['text'])) {

            $title = $_POST['title'];
            $description = $_POST['description'];
            $text = $_POST['text'];
            $city = $_POST['city'];
            

        }
    }

    $now = date("Y-m-d H:i:s");

    $img_name = 'article_files/img_' . time() . stristr($_FILES['filename']['name'], '.');

            if (move_uploaded_file($_FILES['filename']['tmp_name'], __DIR__.'/../' . $img_name  )) {
                $query_article ="INSERT INTO article (title, description, text, picture, date, id_city) VALUES ('$title', '$description', '$text', '$img_name', '$now', '$city')";
                $result_article = pg_query($dbconn, $query_article);
                echo "Uploaded";
            } else {
            echo "File not uploaded";
            }

        header('location: ../blog.php');
?>