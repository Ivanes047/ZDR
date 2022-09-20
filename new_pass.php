<?php
    session_start();
    $host='localhost';
    $port = '5433';
    $db = 'zdr_base';
    $username = 'Ivanes047';
    $password = '123456'; 
        
    $dbconn = pg_connect("host=$host port=$port dbname=$db user=$username password=$password") or die('Не удалось соединиться: ' . pg_last_error());

    if ($_GET['id']) {
        $id_pass = $_GET['id'];
        $last_query = 'SELECT * FROM passenger WHERE id = ' . $id_pass;
        $result_query = pg_query($dbconn, $last_query) or die('Ошибка запроса: ' . pg_last_error());
        $pass = pg_fetch_array($result_query, null, PGSQL_ASSOC);
    } else {
        $id_pass = 0;
    }
    

    if($_SERVER['REQUEST_METHOD'] == 'POST'){
        if(isset($_POST['full_name']) && isset($_POST['passport']) && isset($_POST['gender'])){//Условие, был ли запущен POST запрос из формы регистрации
        
            $full_name = $_POST['full_name'];
            $passport = $_POST['passport'];
            $gender = $_POST['gender'];
            $user_id = $_SESSION['idS'];
            if ($id_pass) {
                $query ="UPDATE passenger SET full_name = '$full_name', passport_id = '$passport', gender = '$gender' WHERE id = " . $id_pass;
            } else {
                $query ="INSERT INTO passenger (full_name, passport_id, gender, id_user) VALUES ('$full_name', '$passport', '$gender', '$user_id')";
            } 
            $result = pg_query($dbconn, $query);
            header('location: personal.php');
		}
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

    <link rel="stylesheet" href="css/style.css">
    <title>ЖДР - Добавить нового пассажира</title>
</head>
<body>
    <div class="nofooter">
        <header>
            <div class="container">
                <img src="img/logo.svg" alt="" class="logo" onclick="window.location = 'index.php'">
                <div class="nav__list">
                    <ul>
                        <li><a href="index.php">Главная</a></li>
                        <li><a href="blog.php">Блог</a></li>
                        <li><a href="tickets.php">Купить билет</a></li>
                        <li>
                            <?php
                                if(isset($_SESSION['idS'])){
                                    echo '<a  href="personal.php"><i class="uil uil-user"></i></a>';
                                }else{
                                    echo '<a href="login.php"><i class="uil uil-user"></i></a>';
                                }
                            ?>
                        </li>
                        <li><a href="cart.php"><i class="uil uil-shopping-cart"></i></a></li>
                        <?php
                            if(isset($_SESSION['idS'])){
                                echo '<li><a  href="php/exit.php"><i class="uil uil-signout"></i></a></li>';
                            }
                        ?>
                    </ul>
                </div>
            </div>
        </header>
        <main>
            <div class="">
                <div class="container">
                    <form action="" class="form form__new-pass" method="POST">
                        <h4>Данные пассажира</h4>
                        <div class="form__bg">
                            <label for>ФИО:</label>
                            <input type="text" id="full_name" name="full_name" value="<?php if ($id_pass) { echo $pass['full_name'];}?>" class="form__input" required>
                        </div>
                        <div class="form__bg">
                            <label for>Паспортные данные:</label>
                            <input type="text" id="passport" name="passport" value="<?php if ($id_pass) { echo $pass['passport_id'];}?>" class="form__input" required>
                        </div>
                        <div class="form__bg">
                            <p>Пол:</p>
                            <input type="radio" id="gender1" name="gender" value="Мужской" class="form__radio" checked> 
                            <label for="gender1">Мужской</label></br>
                            <input type="radio" id="gender2" name="gender" value="Женский" class="form__radio">
                            <label for="gender2">Женский</label>
                        </div>
                        <div>
                            <input type="submit" value="<?php if ($id_pass) { echo "Редактировать";} else {echo "Добавление пассажира";}?>" class="form__button">
                        </div>
                    </form>
                </div>
            </div>
        </main>
    </div>

    <footer>
        <div class="container">
            <div class="hotline">
                <div>
                    <h3>Горячая линия</h3>
                    <a href="tel:+79005550000">8(900)555-00-00</a>
                </div>
                <div>
                    <h3>Почта для обращений</h3>
                    <a href="mailto:ticket@zdr.ru">ticket@zdr.ru</a>
                </div>
            </div>

            <div class="footer__menu">
                <div>
                    <ul>
                        <li>Главная</li>
                        <li>Купить билет</li>
                        <li>Личный кабинет</li>
                        <li>Контакты</li>
                    </ul>
                </div>
                <div>
                    <ul>
                        <li>Vk</li>
                        <li>Youtube</li>
                        <li>Facebook</li>
                        <li>Росграмм</li>
                    </ul>
                </div>
                <div>
                    <ul>
                        <li>WhatsApp</li>
                        <li>Telegram</li>
                        <li>Viber</li>
                        <li>ICQ</li>
                    </ul>
                </div>
            </div>

            <div class="copyright">
                <p>© ОАО «ЖДР», 2022</p>
            </div>
        </div>
    </footer>
    <script src="js/main.js"></script>
</body>
</html>