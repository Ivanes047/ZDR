<?php
    session_start();
    $host='localhost';
    $port = '5433';
    $db = 'zdr_base';
    $username = 'Ivanes047';
    $password = '123456';  
        
    $dbconn = pg_connect("host=$host port=$port dbname=$db user=$username password=$password") or die('Не удалось соединиться: ' . pg_last_error());

    $article_id = $_GET['article'];

    $query = 'SELECT * FROM article WHERE id = ' . $article_id;
    $result = pg_query($dbconn, $query) or die('Ошибка запроса: ' . pg_last_error());
    $article = pg_fetch_array($result, null, PGSQL_ASSOC);


    if($_SERVER['REQUEST_METHOD'] == 'POST') {
        if(isset($_POST['title']) && isset($_POST['description']) && isset($_POST['text'])) {

            $title = $_POST['title'];
            $description = $_POST['description'];
            $text = $_POST['text'];
            $city = $_POST['city'];
            
            $now = date("Y-m-d H:i:s");

            $img_name = 'article_files/img_' . $article_id . stristr($_FILES['filename']['name'], '.');


            if ($img_name == $article["picture"] || !$_FILES['filename']['name']) {
                $query_article ="UPDATE article SET title = '$title', description = '$description', text = '$text', id_city = '$city' WHERE id = " . $article_id;
            } else {
                if (move_uploaded_file($_FILES['filename']['tmp_name'], __DIR__.'/' . $img_name  )) {
                    unlink($article["picture"]);
                    $query_article ="UPDATE article SET title = '$title', description = '$description', text = '$text', id_city = '$city', picture = '$img_name' WHERE id = " . $article_id;
                    echo "Uploaded";
                } else {
                    echo "File not uploaded";
                }
            }
            $result_article = pg_query($dbconn, $query_article);


            header('location: ../blog.php');
            
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
                <div class="container">
                    <div class="main__content">
                        <div class="header__personal">
                            <h5><?php echo $article["title"] ?></h5>
                        </div>
                        <div class="personal__data">
                                <form id="personal__article" method="POST" enctype='multipart/form-data'>
                                    <h4>Редактировать статью</h4>
                                    <div class="form__personal">
                                        <label for>Название статьи:</label>
                                        <input type="text" id="title" name="title" value="<?php echo $article["title"] ?>" class="form__input" required>
                                    </div>
                                    <div class="form__personal">
                                        <label for>Описание статьи (не более 200 символов):</label>
                                        <textarea id="description" name="description" class="form__input" maxlength="200" required><?php echo $article["description"] ?></textarea>
                                    </div>
                                    <div class="form__personal">
                                        <label for>Текст:</label>
                                        <textarea id="description" name="text"  class="form__input" required><?php echo $article["text"] ?></textarea>
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
                                        <input type="submit" value="Внести изменения" class="form__button">
                                    </div>
                                </form>

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
</body>
</html>