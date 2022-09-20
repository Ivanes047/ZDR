<?php
    session_start();
    $host='localhost';
    $port = '5433';
    $db = 'zdr_base';
    $username = 'Ivanes047';
    $password = '123456'; 
    /* Все варианты сортировки */
    $sort_list = array(
        'date_desc'  => 'date DESC',
        'date_asc'   => 'date ASC',
        'title_asc'  => 'title ASC',
        'title_desc' => 'title DESC'   
    );
    
    /* Проверка GET-переменной */
    $sort = @$_GET['sort'];
    if (array_key_exists($sort, $sort_list)) {
        $sort_sql = $sort_list[$sort];
    } else {
        $sort_sql = reset($sort_list);
    }
    
    /* Запрос в БД */
    $dbconn = pg_connect("host=$host port=$port dbname=$db user=$username password=$password") or die('Не удалось соединиться: ' . pg_last_error());

    $count = 0;
    $where = "";
    $query_city = "SELECT * FROM city";
    $result_city_2 = pg_query($dbconn, $query_city);
    while ($city_17 = pg_fetch_array($result_city_2, null, PGSQL_ASSOC)) {
        if (@$_GET[$city_17['name']]) {
            if ($count == 0) {
                $where .= " WHERE id_city = " . $city_17['id'];
            } else {
                $where .= " OR id_city = " . $city_17['id'];
            }
            $count++;
        }
    }

    $query = "SELECT * FROM article" . $where . " ORDER BY {$sort_sql}";
    $result = pg_query($dbconn, $query) or die('Ошибка запроса: ' . pg_last_error());


    /* Функция вывода ссылок */
    function sort_link_bar($title, $a, $b) {
        $sort = @$_GET['sort'];
        $filtres = "";
        $query_city_1 = "SELECT * FROM city";
        $result_city_1 = pg_query($GLOBALS["dbconn"], $query_city_1);
        while ($city = pg_fetch_array($result_city_1, null, PGSQL_ASSOC)) {
            if (@$_GET[$city['name']]) {
                $filtres .= "&" . $city['name'] . "=on" ;
            }
        }
    
        if ($sort == $a) {
            return '<a class="active" href="?sort=' . $b . $filtres .'">' . $title . ' <i>↑</i></a>';
        } elseif ($sort == $b) {
            return '<a class="active" href="?sort=' . $a . $filtres . '">' . $title . ' <i>↓</i></a>';  
        } else {
            return '<a href="?sort=' . $a . $filtres .'">' . $title . '</a>';  
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
    <title>ЖДР - Блог</title>
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
            <aside class="sort">
                <form action=""></form>
                    <div class="sort-bar-title">Сортировать по:</div> 
                    <div class="sort-bar-list">
                        <?php echo sort_link_bar('Дате', 'date_asc', 'date_desc'); ?>
                        <?php echo sort_link_bar('Названию', 'title_asc', 'title_desc'); ?>
                    </div>
                </form>
            </aside>

            <div class="blog__content">
                <div class="blog__filtres">
                    <div class="title_filtres">Фильтры</div>
                    <form method="GET" id="form-filter">
                        <?php                  
                            $result_city = pg_query($dbconn, $query_city);
                            while ($city = pg_fetch_array($result_city, null, PGSQL_ASSOC)) {
                                if(@$_GET[$city['name']]) {
                                    $check = 'checked';
                                } else {
                                    $check = '';
                                }
                                echo "<label for='city_" . $city['id'] . "' class='label'><input type='checkbox' name='" . $city['name'] . "' " . $check . " id='city_" . $city['id'] . "' class='checkbox'><div>" . $city['name'] . "</div></label>";
                            }
                            echo "<input type='hidden' value=" . $sort . " name = 'sort'>";
                        ?>
                    </form>
                </div>

                <div class="list__article">
                    <?php 
                    $empty = 0;
                     while ($list = pg_fetch_array($result, null, PGSQL_ASSOC)) { $empty++; ?>
                                <div style="position: relative;">   
                                    <div class="card__blog" onclick="window.location = 'article.php?id=<?php echo $list['id']?>'">
                                        <img src="<?php echo $list['picture']?>" alt="" class="article__img">
                                        <h4><?php echo $list['title']?></h4>
                                        <p><?php echo $list['description']?></p>
                                        <span><?php echo $list['date']?></span>
                                    </div>  
                                    <?php 
                                    if (isset($_SESSION['idS'])) {if ($_SESSION['idS'] == 7) {
                                        echo "<i onclick = 'window.location = `delete.php?id=" . $list["id"] . "&table=article`' class='uil uil-trash-alt icon__article'></i>";
                                    }}?>
                                </div> 
                    <?php } if (!$empty) {echo "<p>К сожалению, таких статей у нас еще нет :(</p>";}?>
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
    <script>
        const form_filter = document.querySelector("#form-filter");
        document.querySelectorAll(".checkbox").forEach((el) => {
            el.addEventListener('click', () => {
                form_filter.submit();
            })
        })
    </script>
</body>
</html>