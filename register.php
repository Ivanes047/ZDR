<?php
    session_start();//Начало сессии
    $host='localhost';
        $port = '5433';
        $db = 'zdr_base';
        $username = 'Ivanes047';
        $password = '123456';
        
        
        $dbconn = pg_connect("host=$host port=$port dbname=$db user=$username password=$password") or die('Не удалось соединиться: ' . pg_last_error());

    if(isset($_SESSION['$emailS'])){
		header('location: personal.php');	
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
    <title>ЖДР - Регистрация</title>
</head>
<?php
	if($_SERVER['REQUEST_METHOD'] == 'POST'){
        if(isset($_POST['email']) && isset($_POST['login']) && isset($_POST['password'])){//Условие, был ли запущен POST запрос из формы регистрации
        
            $login = $_POST['login'];
            $email = $_POST['email'];
            $tel = $_POST['tel'];
            $password = $_POST['password'];
            $password2 = $_POST['password2'];

            if($password === $password2) {
                $query_login = "SELECT COUNT(*) FROM users WHERE username='".$login . "'";
                $result_login = pg_query($dbconn, $query_login);
                $login_kol = pg_fetch_array($result_login);
                if (!$login_kol[0]) {
                    $query_email = "SELECT COUNT(*) FROM users WHERE email='" . $email . "'";
                    $result_email = pg_query($dbconn, $query_email);
                    $email_kol = pg_fetch_array($result_email);
                    if (!$email_kol[0]) {
                        $password = md5($password."dsf32dsaf12s");//Кодировка пароля
                        $query ="INSERT INTO users (username, email, tel, password) VALUES ('$login', '$email', '$tel', '$password')";
                        //QUERY запрос на добавление пользователя в БД
                        $result = pg_query($dbconn, $query);
                    } else {
                        echo'<div class="danger" onclick="this.remove()"><p>На один адрес электронной почты, можно создать только один аккаунт</p><i class="uil uil-times"></i></div>';
                    }
                } else {
                    echo'<div class="danger" onclick="this.remove()"><p>Данный логин уже занят</p><i class="uil uil-times"></i></div>';
                }
            } else {
                echo'<div class="danger" onclick="this.remove()"><p>Пароли не совпадают</p><i class="uil uil-times"></i></div>';
            }
		}
	}
?>
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
            <div class="container form__container">
                <form action="" class="form form__log-reg form__reg" method="POST">
                    <h2>Регистрация</h2>
                    <p class="form__transition">Есть аккаунт? <a href="login.php">Войти</a></p>
                    <div class="form__bg">
                        <label for>Логин:</label>
                        <input type="text" id="login" name="login" required  class="form__input">
                    </div>
                    <div class="form__bg">
                        <label for>Электронная почта:</label>
                        <input type="email" id="email" name="email" required  class="form__input">
                    </div>
                    <div class="form__bg">
                        <label for>Номер телефона:</label>
                        <input type="tel" id="tel" name="tel" required  class="form__input">
                    </div>
                    <div class="form__bg">
                        <label for>Пароль:</label>
                        <input type="password" id="password" name="password"  class="form__input" minlength="6" required>
                    </div>
                    <div class="form__bg">
                        <label for>Повторите пароль:</label>
                        <input type="password" id="password2" name="password2"  class="form__input" required>
                    </div>
                    <div class="rbut">
                        <input type="submit" value="Зарегистрироваться" class="form__button">
                    </div>
                </form>
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