<?php
/**
 * Created by PhpStorm.
 * User: sumo stephane
 * Date: 17/01/2018
 * Time: 15:03
 */
?>

<?php
session_start();
require_once("database.inc.php");
require_once("form.inc.php");
require_once("header.inc.php");
require_once("footer.inc.php");

if(isset($_SESSION['connected']) && $_SESSION['connected'] == "true") { echo"<script> document.location.href=\"index.php\"</script>"; }
$header = new header();
$form = new form();
$footer = new footer();
$database = new database();
$content = "Sign in to the forum";
$header->display("Sign in to the forum", $_SESSION, $content);
?>

<style>
    .sweet-shield{
        display: none;
    }
</style>

<?php
    $form->header("connexion.php", "connexionform");
         $form->divheader("form-group");
            $form->input("pseudo", "Pseudo or mail", "text", "pseudo", "Pseudo or mail");
        $form->divfooter();
         $form->divheader("form-group");
            $form->input("password", "Password", "password", "password", "Password");
        $form->divfooter();
        echo "<div class=\"sweet-shield\"><input type=\"text\" name=\"sweet-shield-input\" autocomplete=\"off\"/></div>";
        echo "<button class=\"btn\" id=\"submit\" style=\"background-color:#242831;color:#ce813d;border:solid 1px #ce813d;\">Submit</button>";
    $form->footer();
echo "<br/><p><a href=\"inscription.php\" class=\"ml-3\" style=\"color:black;\"><u>No account? Sign up now.</u></a></p>";
if(isset($_POST['pseudo']) && isset($_POST['password']))
{
    if(isset($_POST['sweet-shield-input']) && $_POST['sweet-shield-input'] != "") { sleep(5); echo"<script> document.location.href=\"connexion.php\"</script>"; exit(); }
    
    $pseudo = $database->format($_POST['pseudo']);
    $result = $database->select("SELECT pseudo, mail, password FROM user WHERE pseudo={$pseudo} OR mail={$pseudo}");
    
    if($result[0] !=0)
    {
        if(password_verify($_POST['password'], $result[1]->password))
        {
            $_SESSION['connected'] = "true";
            $_SESSION['pseudo'] = $result[1]->pseudo;
            echo"<script> document.location.href=\"index.php\"</script>";
        }
        else
        {
            echo "fail";
            /*echo "<script>
                document.querySelector('body').innerHTML += '<div class=\"alert alert-danger alert-dismissible fade show mt-2 mb-2\" role=\"alert\">'+
                            '<strong> Invalid login or password'+
                            '<button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-label=\"Close\">'+
                                '<span aria-hidden=\"true\">&times;</span>'+
                            '</button>'+
                        '</div>';
            </script>";*/
        }
    }
    else 
    { 
        echo "<script>
                document.querySelector('body').innerHTML += '<div class=\"alert alert-danger alert-dismissible fade show mt-2 mb-2\" role=\"alert\">'+
                            '<strong> Invalid login or password'+
                            '<button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-label=\"Close\">'+
                                '<span aria-hidden=\"true\">&times;</span>'+
                            '</button>'+
                        '</div>';
            </script>";
    }
}
$footer->display();
?>


