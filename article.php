<?php
    session_start();
    $host='localhost';
    $port = '5433';
    $db = 'zdr_base';
    $username = 'Ivanes047';
    $password = '123456'; 

    $dbconn = pg_connect("host=$host port=$port dbname=$db user=$username password=$password") or die('Не удалось соединиться: ' . pg_last_error());

    $id_article = $_GET['id'];

    $query = "SELECT * FROM article WHERE id = $id_article";
    $result = pg_query($dbconn, $query) or die('Ошибка запроса: ' . pg_last_error());
    $line = pg_fetch_array($result, null, PGSQL_ASSOC);
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
    <title>ЖДР - <?php echo $line['title']?></title>
</head>
<body>
    <div class="nofooter">
        <header>
            <div class="container">
                <img src="img/logo.svg" alt="" class="logo" onclick="window.location = 'index.php'">
                <div class="nav__list">
                    <ul>
                        <li><a href="index.php">Главная</a></li>
                        <li><a href="blog.php" class="active-nav">Блог</a></li>
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
        <main class="container">
            <div class="article__one">
                <h2><?php echo $line['title']?></h2>
                <img src="<?php echo $line['picture']?>" alt="">
                <p><?php echo $line['text']?></p>
                <span><?php echo $line['date']?></span>
                <?php if ($_SESSION['idS'] == 7) {?><input type='button' class="form__button" value="Редактировать статью" onclick="window.location = 'edit_article.php?article=<?php echo $line['id']?>'"><?php }?>
                <a href="blog.php"><h5><i class="uil uil-arrow-circle-left"></i> К другим статьям</h5></a>
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
</body>
</html>