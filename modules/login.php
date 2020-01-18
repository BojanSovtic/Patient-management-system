<?php

if (empty($_POST)) {
    $message = '';
} else {

    if (isset($_POST['username'])) {
        $username = htmlspecialchars(trim($_POST['username']));
    }

    if (isset($_POST['password'])) {
        $password = htmlspecialchars(trim($_POST['password']));
    }

    require 'core/db.php';

    try {
        $db = new db();

        $query = $db->query('SELECT user_id, username, password, name, users.role_id FROM users
        INNER JOIN roles ON users.role_id = roles.role_id WHERE username = ?', $username)->fetchAll();

        if (sizeof($query) > 0) {
            $result = $query[0];

            if (password_verify($password, $result['password'])) {
                session_regenerate_id();
                $_SESSION['role'] = $result['role_id'];
                $_SESSION['name'] = $username;
                $_SESSION['id'] = $result['user_id'];
                /*
                $cookie_name = "user";
                $cookie_value = $username;
                setcookie($cookie_name, $cookie_value, time() + (86400 * 30), "/");*/
                header('Location: index.php?modul=home');
            } else {
                $message = 'Pogrešna šifra!';
            }
        } else {
            $message = 'Pogrešno uneti podaci!';
        }

    } catch (Exception $ex) {
        echo $ex->getMessage();
    }
}

?>

<form id="loginForma" method="post">
            <div class="container">
                <div class="form-row col-md-6 form-centrirano">
                    <label for="username">Korisničko ime: </label>
                    <input type="text" id="username" name="username" class="form-control" value="<?php echo $_POST['username'] ?? '' ?> " required><br>
                    <label for="password">Šifra: </label>
                    <input type="password" id="password" name="password" class="form-control" required>

                    <input type="submit" class="btn btn-primary" value="Pošalji">
                    <?php echo $message . ''; ?>

            </div>
        </div>
 </form>
