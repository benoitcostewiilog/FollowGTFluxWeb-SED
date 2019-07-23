<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Follow gt | Login</title>

	<?php include_stylesheets() ?>

<style>
body{color:#1f1f1f!important;background:url(<?php echo image_path("bckgrnd_blur.png");?>)no-repeat center center fixed;-webkit-background-size:cover;-moz-background-size:cover;-o-background-size:cover;background-size:cover;}
#aeromobile-logo-login{width:350px;}
.form-control:focus{border-color:#F2971D!important;}
.middle-box{width:350px!important;}
</style>

</head>
<body>
    <div class="middle-box text-center loginscreen animated fadeInDown" style="padding-top: 190px;margin-left:200px;">
        <div>
            <div>
                <img id="aeromobile-logo-login" alt="image" src="<?php echo image_path("followgt.png"); ?>" />
            </div>
            <h3>Pilotage des flux industriels</h3>
            <p>Connectez-vous</p>
            <form class="m-t" role="form" action="<?php echo url_for('@sf_guard_signin') ?>" method="post">
                <div class="form-group">
                    <?php echo $form['username']; ?>
                </div>
                <div class="form-group">
                    <?php echo $form['password']; ?>
                </div>
                <button type="submit" class="btn btn-primary block full-width m-b"><?php echo __('Connexion') ?></button>
                <?php echo $form->renderHiddenFields(); ?>
            </form>
        </div>
    </div>

    <?php include_javascripts() ?>
    <script type="text/javascript">
        document.getElementById('signin_username').focus();
    </script>
</body>
</html>