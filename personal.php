<?php
    session_start();

    if (!isset($_SESSION['idS'])) {
        header('location: login.php');
    }

    $host='localhost';
    $port = '5433';
    $db = 'zdr_base';
    $username = 'Ivanes047';
    $password = '123456';  
        
    $dbconn = pg_connect("host=$host port=$port dbname=$db user=$username password=$password") or die('Не удалось соединиться: ' . pg_last_error());

    $user_id = $_SESSION['idS'];
    $query = 'SELECT * FROM users WHERE id = ' . $user_id;
    $result = pg_query($dbconn, $query) or die('Ошибка запроса: ' . pg_last_error());
    $user = pg_fetch_array($result, null, PGSQL_ASSOC);

    if($_SERVER['REQUEST_METHOD'] == 'POST'){
        if(isset($_POST['login']) && isset($_POST['email']) && isset($_POST['phone'])){//Условие, был ли запущен POST запрос из формы регистрации
        
            $login = $_POST['login'];
            $email = $_POST['email'];
            $phone = $_POST['phone'];
            $query_update ="UPDATE users SET username = '$login', email = '$email', tel = '$phone' WHERE id = " . $user_id;
            $result_update = pg_query($dbconn, $query_update) or die('Ошибка запроса: ' . pg_last_error());

            header('location: personal.php');

        }
    }

    /* Все варианты сортировки */
    $sort_list = array(
        'full_name_asc'   => 'full_name ASC',
        'full_name_desc'  => 'full_name DESC',
        'passport_asc'  => 'passport_id ASC',
        'passport_desc' => 'passport_id DESC',
        'gender_asc'   => 'gender ASC',
        'gender_desc'  => 'gender DESC'  
    );
    
    /* Проверка GET-переменной */
    $sort = @$_GET['sort'];
    if (array_key_exists($sort, $sort_list)) {
        $sort_sql = $sort_list[$sort];
    } else {
        $sort_sql = reset($sort_list);
    }
    
    /* Запрос в БД */
    $query_pass = "SELECT * FROM passenger WHERE id_user = " . $user_id . " ORDER BY {$sort_sql }";
    $result_pass = pg_query($dbconn, $query_pass) or die('Ошибка запроса: ' . pg_last_error());
    
    /* Функция вывода ссылок */
    function sort_link_th($title, $a, $b) {
        $sort = @$_GET['sort'];
    
        if ($sort == $a) {
            return '<a class="table__sort" href="?sort=' . $b . '">' . $title . ' <i>▲</i></a>';
        } elseif ($sort == $b) {
            return '<a class="table__sort" href="?sort=' . $a . '">' . $title . ' <i>▼</i></a>';  
        } else {
            return '<a class="table__sort" href="?sort=' . $a . '">' . $title . '</a>';  
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
    <title>ЖДР - Главная</title>
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
                        <?php if($_SESSION['idS'] == 7){
                            echo '<li><a  href="admin/admin.php">Админ панель</a></li>';
                        }
                        ?>
                        <li>
                            <?php
                                if(isset($_SESSION['idS'])){
                                    echo '<a  href="personal.php" class="active-nav"><i class="uil uil-user"></i></a>';
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
                <div class="container">
                    <div class="main__content">
                        <div class="header__personal">
                            <h5><?php echo $user["username"] ?></h5>
                            <div class="personal__nav">
                                <div id="my_data" class="active">
                                    Мои данные
                                </div>
                                <?php if($_SESSION['idS'] != 7){?>
                                <div id="my_pass">
                                    Мои пассажиры
                                </div>
                                <div id="my_review">
                                    Мои отзывы
                                </div>
                                <div id="my_ticket">
                                    Мои билеты
                                </div>
                                <?php } else {?>
                                    <div id="my_article">
                                        Статьи
                                    </div>
                                <?php } ?>
                            </div>

                        </div>
                        <div class="personal__data">
                            <form action="" id="personal__data" class="menu show-menu" method="POST">
                                <div class="form__personal">
                                    <label for>Логин</label>
                                    <input type="text" name="login" id="login" class="form__input" value=<?php echo $user["username"] ?>>
                                </div>
                                <div class="form__personal">
                                    <label for=>Электронная почта</label>
                                    <input type="email" name="email" id="email" class="form__input" value=<?php echo $user["email"] ?>>
                                </div>
                                <div class="form__personal">
                                    <label for=>Номер телефона</label>
                                    <input type="text" name="phone" id="text" class="form__input" value=<?php echo $user["tel"] ?>>
                                </div>
                                <div>
                                    <input type="submit" value="Редактировать" class="form__button">
                                </div>
                            </form>
                            <?php if($_SESSION['idS'] != 7) {?>
                                <div id="personal__pass" class="menu">
                                    <?php
                                        if ($line = pg_fetch_array($result_pass, null, PGSQL_ASSOC)) {
                                            echo "<table class='pass__table'>\n";
                                            echo "<tr>\n<th>" . sort_link_th('ФИО', 'full_name_asc', 'full_name_desc') . "</th>\n<th>" . sort_link_th('Паспортные данные', 'passport_asc', 'passport_desc') . "</th>\n<th>" . sort_link_th('Пол', 'gender_asc', 'gender_desc') . "</th>\n<tr>\n";
                                            echo "\t<tr>\n";
                            
                                                echo "\t\t<td>". $line['full_name'] ."</td>\n";
                                                echo "\t\t<td>". $line['passport_id'] ."</td>\n";
                                                echo "\t\t<td>". $line['gender'] ."</td>\n";
                                                echo "\t\t<td><i onclick = 'window.location = `new_pass.php?id=" . $line["id"] . "`' class='uil uil-wrench icon__pass'></i></td>\n";
                                                echo "\t\t<td><i onclick = 'window.location = `delete.php?id=" . $line["id"] . "`' class='uil uil-trash-alt icon__pass'></i></td>\n";

                                            echo "</tr>\n";
                                            while ($line = pg_fetch_array($result_pass, null, PGSQL_ASSOC)) {
                                                echo "\t<tr>\n";
                            
                                                    echo "\t\t<td>". $line['full_name'] ."</td>\n";
                                                    echo "\t\t<td>". $line['passport_id'] ."</td>\n";
                                                    echo "\t\t<td>". $line['gender'] ."</td>\n";
                                                    echo "\t\t<td><i onclick = 'window.location = `new_pass.php?id=" . $line["id"] . "`' class='uil uil-wrench icon__pass'></i></td>\n";
                                                    echo "\t\t<td><i onclick = 'window.location = `delete.php?id=" . $line["id"] . "&table=pass`' class='uil uil-trash-alt icon__pass'></i></td>\n";

                                                echo "</tr>\n";;
                                            }
                                            echo "</table>\n";
                                        }
                                    ?>
                                    <input type="button" value="Добавить пассажира" onclick="window.location='new_pass.php?id=0'" class="form__button">
                                </div>
                                
                                <div id="personal__review" class="menu">

                                </div>
                                <div id="personal__ticket" class="menu">

                                </div>
                            <?php } else {?>
                                <form id="personal__article" class="menu" method="POST" action="php/file.php" enctype='multipart/form-data'>
                                    <h4>Создать статью</h4>
                                    <div class="form__personal">
                                        <label for>Название статьи:</label>
                                        <input type="text" id="title" name="title"  class="form__input" required>
                                    </div>
                                    <div class="form__personal">
                                        <label for>Описание статьи (не более 200 символов):</label>
                                        <textarea id="description" name="description"  class="form__input" maxlength="200" required></textarea>
                                    </div>
                                    <div class="form__personal">
                                        <label for>Текст:</label>
                                        <textarea id="description" name="text"  class="form__input" required></textarea>
                                    </div>
                                    <div class="form__personal">
                                        <?php
                                            $query = "SELECT * FROM city";
                                            $result = pg_query($dbconn, $query) or die('Ошибка запроса: ' . pg_last_error());
                                            echo "<select name = 'city' class= 'select'>";
                                            while ($city = pg_fetch_array($result)) {
                                                echo "<option value = '" . $city['id'] . "' >" . $city['name'] . " </option>";
                                            }           
                                            echo "</select>";
                                        ?>
                                    </div>
                                    <div class="form__personal">
                                        <label for="file-upload" class="custom-file-upload">
                                            Добавить изображение
                                        </label>
                                        <input type='file' name='filename' id='file-upload'>
                                    </div>
                                    <div>
                                        <input type="submit" value="Добавить статью" class="form__button">
                                    </div>
                                </form>
                            <?php }?>
                        </div>
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
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>
    <script src="js/main.js"></script>
</body>
</html>