<?php
    session_start();
    $host='localhost';
    $port = '5433';
    $db = 'zdr_base';
    $username = 'Ivanes047';
    $password = '123456'; 

    $dbconn = pg_connect("host=$host port=$port dbname=$db user=$username password=$password") or die('Не удалось соединиться: ' . pg_last_error());

    if ($_SESSION['idS'] != 7) {
        header('location: /personal.php');
    }
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Иконки -->
    <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.0/css/line.css">
    <link rel="stylesheet" href="/css/style.css">
    <title>ЖДР - Поезд №747</title>
</head>
<body>
    <div class="nofooter">
        <header>
            <div class="container">
                <img src="/img/logo.svg" alt="" class="logo" onclick="window.location = 'index.php'">
                <div class="nav__list">
                    <ul>
                        <li>
                            <a  href="/personal.php">К сайту</a>
                        </li>
                    </ul>
                </div>
            </div>
        </header>
        <main class="container">
            <section class="schedule__section">
                <h2 style="text-align: center">Поезд №747</h2>
                <table class='pass__table'>
                    <tr>
                        <th>Станция</th>
                        <th>Время отправления (мск)</th>
                        <th>Время прибытия (мск)</th>
                    </tr>
                    <tr>
                        <td><input type="text" value="Оренбург"></td>
                        <td><input type="time" value="08:30"></td>
                        <td><input type="time" value="09:30"></td>
                        <td><i onclick = 'window.location = `new_pass.php?id=" . $line["id"] . "`' class='uil uil-wrench icon__pass'></i></td>
                        <td><i onclick = 'window.location = `delete.php?id=" . $line["id"] . "&table=train`' class='uil uil-trash-alt icon__pass'></i></td>
                    </tr>
                    <tr>
                        <td><input type="text" value="Оренбург"></td>
                        <td><input type="time" value="08:30"></td>
                        <td><input type="time" value="09:30"></td>
                        <td><i onclick = 'window.location = `new_pass.php?id=" . $line["id"] . "`' class='uil uil-wrench icon__pass'></i></td>
                        <td><i onclick = 'window.location = `delete.php?id=" . $line["id"] . "&table=train`' class='uil uil-trash-alt icon__pass'></i></td>
                    </tr>
                    <tr>
                        <td colspan="9" class="icon__pass" onclick = 'window.location = `add_train.php?`'>Добавить станцию</td>
                    </tr>
                </table>
            </section>
        </main>
    </div>
    <footer>
        <div class="container">
            <div class="copyright">
                <p>© ОАО «ЖДР», 2022</p>
            </div>
        </div>
    </footer>
    <script src="js/main.js"></script>
</body>
</html>