<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Follow gt | Login</title>

        <?php include_stylesheets() ?>

        <style>
            body{color:#1f1f1f!important;background:url(<?php echo image_path("bckgrnd_blur.jpg"); ?>)no-repeat center center fixed;-webkit-background-size:cover;-moz-background-size:cover;-o-background-size:cover;background-size:cover;}
            #aeromobile-logo-login{width:350px;}
            .form-control:focus{border-color:#F2971D!important;}
            .middle-box{width:350px!important;}
        </style>

    </head>
    <body>
        <div class="middle-box text-center loginscreen animated fadeInDown">
            <div>
                <div>
                    <img id="aeromobile-logo-login" alt="image" src="<?php echo image_path("followgt.png"); ?>" />
                </div>
                <h3>Pilotage des flux industriels</h3>
                <p>
                    Créer votre nouveau mot de passe pour acceder à l'application
                </p>
                <form class="m-t" role="form" action="index.html" onkeydown="if (event.keyCode == 13) {
                            validate();
                            return false;
                        }">
                    <div class="form-group">
                        <input id="password" type="password" class="form-control" placeholder="Mot de passe" required="">
                    </div>
                    <div class="form-group">
                        <input id="password-confirm" type="password" class="form-control" placeholder="Confirmation" required="">
                    </div>
                    <button type="button" onclick="validate()" class="btn btn-primary block full-width m-b">Valider</button>
                    <div id="errorMessage" style="font-weight: bold;font-size: large;"><?php echo $message ?></div>
                </form>
            </div>
        </div>

        <?php include_javascripts() ?>
        <script>
            function validate() {
                $("#errorMessage").css("visibility", "hidden");
                var password = $("#password").val();
                var passwordConfirm = $("#password-confirm").val();
                if (password != passwordConfirm) {
                    errorMessage("Les deux mots de passes ne correspondent pas");
                    return false;
                }

                var regexpMajuscule = /(?=.*[A-Z])/;
                var regexpMinusule = /(?=.*[A-Z])/;
                var regexpSpecialChar = /[^A-Za-z0-9]/;

                if (password.length < 10) {
                    errorMessage("Le mot de passe doit contenir au moins 10 caractères");
                    return false;
                } else if (!regexpMajuscule.test(password) || !regexpMinusule.test(password) || !regexpSpecialChar.test(password)) {
                    errorMessage("Le mot de passe doit contenir au moins une lettre, une majuscule et un caractère spécial");
                    return false;
                }

                $.post('<?php echo url_for('sf_guard_updatePassword') ?>', {password: password}, function (valid) {
                    if (valid) {
                        window.location = '<?php echo url_for('homepage') ?>';
                    } else {
                        errorMessage("Une erreur est survenue lors de la modification du mot de passe");
                    }
                });

            }
            ;

            function errorMessage(message) {
                $("#errorMessage").html(message);
                $("#errorMessage").css("visibility", "");
            }
        </script>
    </body>
</html>