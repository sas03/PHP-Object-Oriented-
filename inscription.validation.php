<?php
/**
 * Created by PhpStorm.
 * User: sumo stephane
 * Date: 17/02/2018
 * Time: 15:03
 */
?>

<?php
session_start();
require_once("database.inc.php");
if(isset($_POST['mail']) && isset($_POST['password']) && isset($_POST['confirm']) && isset($_POST['pseudo']) && isset($_POST['check']))
{
    if(isset($_POST['sweet-shield-input']) && $_POST['sweet-shield-input'] != "") { sleep(5); header("Location:nscription.php"); exit(); }
    $database = new database();
    
    $mail = $database->format($_POST['mail']);
    $password = $database->format($_POST['password']);
    $confirm = $database->format($_POST['confirm']);
    $pseudo= $database->format($_POST['pseudo']);
    $check = $database->format($_POST['check']);
    
    $user = $database->select("SELECT pseudo FROM user WHERE pseudo={$pseudo}");
    
    if($mail!="" && $password!="" && $confirm!="" && $password==$confirm && $pseudo!="" && $check!=false && strlen($password)>=8 && strlen($password)<=20 && strlen($pseudo)>=8 && strlen($pseudo)<=20 && $user[0] == 0 && preg_match("/^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?!.*\s).*$/", trim($_POST['password'])) && filter_var(trim($_POST['mail']), FILTER_VALIDATE_EMAIL) && preg_match("/^[a-zA-Z0-9._'-]*$/", trim($_POST['pseudo'])))
    {
        $date = date("m.d.y");
        $hash = password_hash($_POST['password'], PASSWORD_DEFAULT);
        $password = crypt($_POST['password'], $hash);
        $database->insert("INSERT INTO user VALUES({$pseudo}, {$mail}, '{$password}', '{$date}', 'user', 'default.png', '')");
        
        $_SESSION['connected'] = "true";
        $_SESSION['pseudo'] = $_POST['pseudo'];
        header("Location:index.php");
        exit();
    }
    else
    {
        header("Location:inscription.php");
    }
}
else
{
    header("Location:index.php");
}
?>