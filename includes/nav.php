<?php
if(!isset($_SESSION)) {
    session_start();
}

if(isset($_SESSION['user'])) { ?>
    <nav>
        <a href="index.php">Home</a>
        <a href="adventureList.php">Adventures</a>
        <a href="adventureCreation.php">Create Adventure</a>
        <a href="reserveAdventure.php">Reserve Adventure</a>
        <a href="agenda.php">Agenda</a>
        <a href="logout.php">Logout</a>
    </nav>
<?php } else { ?>
    <nav>
        <a href="index.php">Home</a>
        <a href="adventureList.php">Adventures</a>
        <a href="login.php">Login</a>
        <a href="register.php">Register</a>
    </nav>
<?php } ?>