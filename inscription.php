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
require_once("form.inc.php");
require_once("header.inc.php");
require_once("footer.inc.php");
if(isset($_SESSION['connected']) && $_SESSION['connected'] == "true") { echo"<script> document.location.href=\"index.php?page=1\"</script>"; }
$header = new header();
$form = new form();
$footer = new footer();
$database = new database();
$content = "Sign up on the forum";
$header->display("Sign up on the forum", $_SESSION, $content);
?>

<style>
    .sweet-shield{
        display: none;
    }
</style>

<?php
$users = $database->select("SELECT * FROM user");
$pseudos = array();
for($i = 1; $i < sizeof($users); $i++)
{
    $pseudos[]=$users[$i]->pseudo;
}

$implode_pseudos = implode(",", $pseudos);
    $form->header("inscription.validation.php", "inscription-form");
        $form->divheader("form-group");
            $form->input("mail", "Email", "email", "mail", "Email", null, null, "form-control", 'pattern="(^[a-z0-9._-]+)@([a-z0-9._-])+(\.)([a-z]{2,4})"');
        $form->divfooter();
        $form->divheader("form-row");
            $form->divheader("form-group col-md-6");
                $form->input("password", "Password", "password", "password", "Password", null, null, "form-control", 'aria-describedby="passwordHelpBlock" pattern="^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?!.*\s).*$"');
                echo "<small id=\"passwordHelpBlock\" class=\"form-text text-muted\">
                Your password must be 8-20 characters long, contain letters (uppercase and lowercase) and numbers, and must not contain spaces, special characters, or emoji.
                </small>";
            $form->divfooter();
            $form->divheader("form-group col-md-6");
                $form->input("confirm", "Confirm", "password", "confirm", "Confirm");
            $form->divfooter();
        $form->divfooter();
        $form->divheader("form-group");
            $form->input("pseudo", "Pseudo", "text", "pseudo", "Pseudo", null, null, "form-control", 'aria-describedby="pseudoHelpBlock"');
            echo "<small id=\"pseudoHelpBlock\" class=\"form-text text-muted\">
                    8-20 characters long, contain letters (uppercase and lowercase) and numbers, and must not contain spaces, special characters, or emoji.
                </small>";
        $form->divfooter();
        $form->divheader("form-group");
            $form->divheader("form-check");
                $form->checkbox("check", "I agree to the <a href='terms' style='color:black;'><u>terms of use</u></a>", "check");
            $form->divfooter();
        $form->divfooter();
        echo "<div class=\"sweet-shield\"><input type=\"text\" name=\"sweet-shield-input\" autocomplete=\"off\"/></div>";
$form->footer();
echo "<button class=\"btn ml-3\" id=\"continue\" style=\"background-color:#242831;color:#ce813d;border:solid 1px #ce813d;\">Continue</button>";
echo "<div class=\"col-xs-12\" id=\"error-display\" style=\"margin-top:50px;\"></div>";
?>
<script>
    function errorset(message)
    {
        return '<div class="alert alert-danger alert-dismissible fade show mt-2" role="alert">'+
                                        '<strong>'+message+
                                        '<button type="button" class="close" data-dismiss="alert" aria-label="Close">'+
                                            '<span aria-hidden="true">&times;</span>'+
                                        '</button>'+
                                '</div>';
    }
    
    document.querySelector('#continue').addEventListener('click', function () {
        
        var mail = document.querySelector('#mail').value;
        var password = document.querySelector('#password').value;
        var confirm = document.querySelector('#confirm').value;
        var pseudo = document.querySelector('#pseudo').value;
        var check = document.querySelector('#check').checked;
        var pseudos = '<?php echo $implode_pseudos; ?>';
        var explode_pseudos = pseudos.split(",");
        var hasUser = false;
        
        for(var i=0; i < explode_pseudos.length; i++)
        {
              if(pseudo==explode_pseudos[i]) { hasUser=true;}
        }
        
        if(mail!="" && password!="" && confirm!="" && pseudo!="" && pseudo.length <= 20 && pseudo.length >=8 && check!=false && password == confirm && /^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?!.*\s).*$/.test(password) && /(^[a-z0-9._-]+)@([a-z0-9._-])+(\.)([a-z]{2,4})/.test(mail) && /^[a-zA-Z0-9._'-]*$/.test(pseudo)  && password.length >= 8 && password.length <= 20 && !hasUser) 
        {
            document.querySelector('#inscription-form').submit();
         }
        else
        {
            var errorDiv = document.createElement('div');
            errorDiv.id = 'error';
            document.querySelector('#error-display').appendChild(errorDiv);
            
            if(hasUser) { errorDiv.innerHTML += errorset('This user name already exists.'); }
            if(mail=="" || !/(^[a-z0-9._-]+)@([a-z0-9._-])+(\.)([a-z]{2,4})/.test(mail)) { errorDiv.innerHTML += errorset('Please enter a valid mail.'); }
            if(pseudo=="" || pseudo.length < 8 || pseudo.length > 20 || !/^[a-zA-Z0-9._'-]*$/.test(pseudo)) { errorDiv.innerHTML += errorset('Please enter a valid pseudo.'); }
            if(password=="" || password.length < 8 || password.length > 20 || !/^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?!.*\s).*$/.test(password)) { errorDiv.innerHTML += errorset('Please enter a valid password.'); }
            if(confirm=="") { errorDiv.innerHTML += errorset('Please confirm your password'); }
            if(password!=confirm) { errorDiv.innerHTML += errorset('The passwords are not the same.'); }
            if(check==false) { errorDiv.innerHTML += errorset('Accept the terms of use to continue.'); }
        }
        
    });
    
</script>

<?php
$footer->display(); 
?> 

