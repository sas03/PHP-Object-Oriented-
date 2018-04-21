<?php
/**
 * Created by PhpStorm.
 * User: sumo stephane
 * Date: 17/02/2018
 * Time: 15:03
 */
?>

<?php
class header
{
    public function display($title, $session, $content="")
    {
        $log;
        if(isset($session['connected']) && $session['connected']=="true")
        {
             $log= "<li class=\"nav-item dropdown\">
                        <a class=\"nav-link dropdown-toggle\" href=\"#\" id=\"navbarDropdown2\" role=\"button\" data-toggle=\"dropdown\" aria-haspopup=\"true\" aria-expanded=\"false\" style=\"color:#ce813d\">
                            {$session['pseudo']}
                        </a>
                        <div class=\"dropdown-menu\" aria-labelledby=\"navbarDropdown2\">
                            <a class=\"dropdown-item\" href=\"account.php\">Account</a>
                            <form action=\"index.php\" method=\"post\" enctype=\"application/x-www-form-urlencoded\">
                                <button class=\"dropdown-item\" type=\"submit\" name=\"logout\">Sign out </button>
                            </form>
                        </div>
                    </li>";
        }
        else
        {
            $log= "<li class=\"nav-item\">
                        <a class=\"nav-link\" href=\"connexion.php\" style=\"color:#ce813d\">
                            Sign in
                        </a>
                    </li>";
        }
           
        echo "<!DOCTYPE html>
            <html lang=\"fr | en\">
                <head>
                    <meta charset=\"utf-8\">
                    <meta name=\"viewport\" content=\"width=device-width, initial-scale=1, shrink-to-fit=no\">
                    <meta name=\"description\" content=\"{$content}\" />
                    <link href=\"https://fonts.googleapis.com/icon?family=Material+Icons\"
      rel=\"stylesheet\">
                    <link rel=\"shortcut icon\" type=\"image/png\" href=\"/icon.ico\" />
                    <link rel=\"stylesheet\" href=\"https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.3/css/bootstrap.min.css\" integrity=\"sha384-Zug+QiDoJOrZ5t4lssLdxGhVrurbmBWopoEl+M6BdEfwnCJZtKxi1KgxUyJq13dy\" crossorigin=\"anonymous\">
                    <script src=\"https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js\"></script>
                    <title>{$title}</title>
                </head>
                <body>
                    <nav class=\"navbar navbar-expand-lg\" style=\"z-index:100;position:fixed;width:100%;background-color:#242831;\">
                        <a class=\"navbar-brand\" href=\"index.php\" style=\"color:#ce813d\">
                            <img src=\"img/logo.png\" width=\"70\" height=\"40\" class=\"d-inline-block align-top\" alt=\"\" style=\"margin-top:-10px;margin-right:10px;\">
                            Planned Odyssey
                        </a>
                        <button class=\"navbar-toggler\" type=\"button\" data-toggle=\"collapse\" data-target=\"#navbarSupportedContent\" aria-controls=\"navbarSupportedContent\" aria-expanded=\"false\" aria-label=\"Toggle navigation\">
                            <span class=\"navbar-toggler-icon\"></span>
                        </button>
                        
                        <div class=\"collapse navbar-collapse\" id=\"navbarSupportedContent\">
                            <ul class=\"navbar-nav mr-auto\">
                            </ul>
                            <ul class=\"navbar-nav\" style=\"margin-right:6%;\">
                               <form class=\"form-inline my-2 my-lg-0\" method=\"get\" action=\"search.php\">
                                    <input class=\"form-control mr-sm-2\" type=\"search\" name=\"key\" placeholder=\"Search\" aria-label=\"Search\" style=\"width:400px;\" />
                                    <button class=\"btn my-2 my-sm-0\" type=\"submit\" style=\"color:#ce813d;background-color:#242831;\"><i class=\"material-icons\">search</i></button>
                                </form>
                                {$log}
                            </ul>
                        </div>
                    </nav>
                    <br/><br/>";
    }
}
//<meta name="description" content="Portfolio de KOMBA BETAMBO Gaston Pierre. Etudaint en école d'ingénieur informatique"/>
?>