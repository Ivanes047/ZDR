<?php
    session_start();//Начало сессии
    $host='localhost';
    $port = '5433';
    $db = 'zdr_base';
    $username = 'Ivanes047';
    $password = '123456';
        
    $dbconn = pg_connect("host=$host port=$port dbname=$db user=$username password=$password") or die('Не удалось соединиться: ' . pg_last_error());

    if($_SERVER['REQUEST_METHOD'] == 'POST') {
        if(isset($_POST['email']) && isset($_POST['password'])) { //Условие, был ли запущен POST запрос из формы регистрации
            $email = $_POST['email'];
            $password = $_POST['password'];
        
            $password = md5($password."dsf32dsaf12s");//Кодировка пароля
            
            $query = "SELECT * FROM users WHERE ( email = '$email' OR username = '$email' ) AND password = '$password'";
            $data = pg_query($dbconn,$query);
            $user = pg_fetch_array($data);
            if (!$user) {
                echo'<div class="danger" onclick="this.remove()"><p>Неправильный логин или пароль, попробуйте еще раз</p><i class="uil uil-times"></i></div>';
            } else {
                $_SESSION['emailS'] = $user['email'];
                $_SESSION['idS'] = $user['id'];
            }

            
            if(isset($_SESSION['emailS'])){
                header('location: personal.php');
            }
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
    <title>ЖДР - Регистрация</title>
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
            <div class="container form__container">
                <form action="" class="form form__log-reg form__log" method="POST">
                    <h2>Вход</h2>
                    <p class="form__transition">У вас еще нет аккаунта? <a href="register.php">Зарегистрируйтесь</a></p>
                    <div class="form__bg">
                        <label for>Логин/Электронная почта</label>
                        <input type="text" name="email" id="email" class="form__input">
                    </div>
                    <div class="form__bg">
                        <label for=>Пароль</label>
                        <input type="password" name="password" id="password" class="form__input">
                    </div>
                    <div>
                        <input type="submit" value="Войти" onclick="" class="form__button">
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