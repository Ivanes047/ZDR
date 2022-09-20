<?php
    session_start();
    $host='localhost';
    $port = '5433';
    $db = 'zdr_base';
    $username = 'Ivanes047';
    $password = '123456'; 

    $dbconn = pg_connect("host=$host port=$port dbname=$db user=$username password=$password") or die('Не удалось соединиться: ' . pg_last_error());
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
    <title>ЖДР - Главная</title>
</head>
<body>
    <div class="nofooter">
        <header>
            <div class="container">
                <img src="img/logo.svg" alt="" class="logo" onclick="window.location = 'index.php'">
                <div class="nav__list">
                    <ul>
                        <li><a href="index.php" class="active-nav">Главная</a></li>
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
        <main class="container">
            <section class="main__section">
                <div class="main__text">
                    <h1>Путешествуй</br>с комфортом</h1>
                    <h4>Ж/д билеты по доступным ценам</h4>
                </div>
                <div class="main__img">
                    <img src="img/main-pic.png" alt="">
                </div>
            </section>
            <button class="buy-button" onclick="window.location = 'personal.php'" id="buy-btn">
                Купить билет
            </button>
            <section class="cards__section">
                <h2>Популярные города</h2>
                <div class="cards">
                    <div class="card" onclick="window.location = 'blog.php?Москва=on'">
                        <h5>Москва</h5>
                        <img src="img/moscow.png" alt="">
                    </div>
                    <div class="card" onclick="window.location = 'blog.php?Санкт-Петербург=on'">
                        <h5>Санкт-Петербург</h5>
                        <img src="img/saint-petersburg.png" alt="">
                    </div>
                    <div class="card" onclick="window.location = 'blog.php?Казань=on'">
                        <h5>Казань</h5>
                        <img src="img/kazan.png" alt="">
                    </div>
                    <div class="card" onclick="window.location = 'blog.php?Сочи=on'">
                        <h5>Сочи</h5>
                        <img src="img/sochi.png" alt="">
                    </div>
                </div>
            </section>
            <section class="blog__section">
                <h2>Блог</h2>
                <div class="articles">
                    <div class="main__article">
                        <?php 
                            $query = "SELECT * FROM article ORDER BY date DESC LIMIT 1";
                            $result = pg_query($dbconn, $query) or die('Ошибка запроса: ' . pg_last_error());
                            $line = pg_fetch_array($result, null, PGSQL_ASSOC)
                        ?>
                        <div class="article" onclick="window.location = 'article.php?id=<?php echo $line['id']?>'">
                            <img src="<?php echo $line['picture']?>" alt="" class="article__img">
                            <h4><?php echo $line['title']?></h4>
                            <p><?php echo $line['description']?></p>
                            <span><?php echo $line['date']?></span>
                        </div>
                    </div>
                    <div class="sub__article">
                        <?php 
                            $query = "SELECT * FROM article ORDER BY date DESC LIMIT 2 OFFSET 1";
                            $result = pg_query($dbconn, $query) or die('Ошибка запроса: ' . pg_last_error());
                            while ($line = pg_fetch_array($result, null, PGSQL_ASSOC)) {
                        ?>
                        <div class="article" onclick="window.location = 'article.php?id=<?php echo $line['id']?>'">
                            <img src="<?php echo $line['picture']?>" alt="" class="article__img">
                            <h4><?php echo $line['title']?></h4>
                            <p><?php echo $line['description']?></p>
                            <span><?php echo $line['date']?></span>
                        </div>
                        <?php
                            } 
                        ?>
                        <!-- <div class="article">
                        <img src="img/about-zhdr.png" alt="" class="article__img">
                            <h5>Заголовок статьи</h5>
                            <p>Описание статьи. Lorem ipsum dolor sit amet consectetur adipisicing elit. Quam enim numquam magni, nam natus temporibus, architecto repellat, aliquam iure quaerat rem at consequuntur dolores! Vel ...</p>
                            <span>08.06.2022 01:51</span>
                        </div> -->
                        
                    </div>
                </div>
                <div class="arrow" onclick="window.location='blog.php'">
                            <i class="uil uil-arrow-right"></i> Смотреть больше
                        </div>
            </section>
            <section class="about">
                <h2>О ЖДР</h2>
                <div class="about__content">
                    <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Animi ad, iste est quas adipisci quibusdam repellendus ab quis? Velit magni necessitatibus, libero iusto totam facere incidunt. Atque molestiae voluptas eum.
                    Esse, molestiae vitae. Numquam modi expedita earum quaerat, accusamus tempora ab quod labore laudantium hic cupiditate sint, atque, nostrum quia ipsa excepturi? Consequatur, itaque eius vel iure assumenda quasi! Fugit.
                    Deserunt, nisi eaque error fuga rem repellendus odit eum porro facilis ipsa quis hic quas et perferendis voluptates sint illum tempore dolore, placeat autem provident unde sunt ipsum. Dolorem, rem!</p>
                    <img src="img/about-zhdr.png" alt="">
                </div>
            </section>
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