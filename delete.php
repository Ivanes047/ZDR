<?php 
      session_start();
      $host='localhost';
      $port = '5433';
      $db = 'zdr_base';
      $username = 'Ivanes047';
      $password = '123456'; 
  
      $dbconn = pg_connect("host=$host port=$port dbname=$db user=$username password=$password") or die('Не удалось соединиться: ' . pg_last_error());
  
      $id = $_GET['id'];
      if ($_GET['table'] == "pass") {
            $query_pass = "DELETE FROM passenger WHERE id =" . $id;
            $result_pass = pg_query($dbconn, $query_pass);
            header('location: personal.php');
      } else if ($_GET['table'] == "article") {
            $query_pass = "DELETE FROM article WHERE id =" . $id;
            $result_pass = pg_query($dbconn, $query_pass);
            header('location: blog.php');
      } else if ($_GET['table'] == "train") {
            $query_pass = "DELETE FROM article WHERE id =" . $id;
            $result_pass = pg_query($dbconn, $query_pass);
            header('location: admin.php');
      }

?>