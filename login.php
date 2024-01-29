<?php
/** @var $db */
require_once 'includes/database.php';
// required when working with sessions
if (!isset($_SESSION)) {
    session_start();
}
// Is user logged in?
if(isset($_SESSION['user']))  {
    header('Location: index.php');
    exit();
}

if (isset($_POST['submit'])) {
    // Get form data
    $email = mysqli_real_escape_string($db, $_POST['email']);
    $password = mysqli_real_escape_string($db, $_POST['password']);

    // Server-side validation
    $errors = [];
    if ($email == "") {
        $errors['email'] = "Email cannot be empty";
    }
    if ($password == "") {
        $errors['password'] = "Password cannot be empty";
    }

    // If data valid
    if(empty($errors)) {
        // SELECT the user from the database, based on the email address.
        // check if the user exists
        $query = "SELECT * FROM user WHERE email = '$email'";
        $result = mysqli_query($db, $query);
        if ($result !== false && mysqli_num_rows($result) > 0) {
            // Get user data from result
            $user = mysqli_fetch_assoc($result);
            $firstName = $user['first_name'];
            $lastName = $user['last_name'];
            $passwordHash = $user['password'];

            // Check if the provided password matches the stored password in the database
            if (password_verify($_POST['password'], $passwordHash)) {
                // Store the user in the session
                $_SESSION['user'] = [
                    'name' => $user['first_name'],
                    'email' => $user['last_name'],
                    'id' => $user['user_id']
                ];
                // Redirect to secure page
                header('Location: index.php');
                exit();
            } else {
                $errors['loginFailed'] = "Incorrect login credentials";
            }
        } else {
            $errorMessage = "Error: " . mysqli_error($db) . " with query: " . $query;
            $errors['loginFailed'] = "Incorrect login credentials";
        }
    }
    mysqli_close($db);
}
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>login</title>
    <link rel="stylesheet" href="styles/style.css">
</head>
<body>
<header>
    <?php
    require_once 'includes/nav.php';
    ?>
</header>
<main>
    <form id="emailPasswordForm" action="" method="post">
        <label for="email">Email:</label>
        <input type="email" id="email" name="email">
        <p><?= $errors['email'] ?? '' ?></p>

        <label for="password">Password:</label>
        <input type="password" id="password" name="password">
        <p><?= $errors['password'] ?? '' ?></p>

        <?php if(isset($errors['loginFailed'])) { ?>
                <?=$errors['loginFailed']?>
        <?php } ?>

        <input type="submit" name="submit" value="submit">
    </form>
</main>
</body>
</html>
