<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="icon" type="image/png" href="<?php echo image_path("favicon.ico"); ?>"/>
        <?php if (has_slot("page_title")) { ?>
            <title>Follow gt | <?php include_slot("page_title") ?></title>
        <?php } else { ?>
            <title>Follow gt</title>
        <?php } ?>
        <?php include_stylesheets() ?>
        <?php include_javascripts() ?>
    </head>
    <body class="fixed-sidebar md-skin">
        <div id="wrapper">
            <nav class="navbar-default navbar-static-side" role="navigation">
                <div class="sidebar-collapse">
                    <div class="logo-element">
                        <span style="color:white">M</span><sup style="color:#F2971D">s</sup>
                    </div>
                    <ul class="nav" id="side-menu">
                        <li class="nav-header">
                            <div class="dropdown profile-element">
                                <span>
                                    <img alt="image" class="img-circle" width="50" src="<?php echo image_path("contact_no_image.png"); ?>" />
                                </span>
                                <a data-toggle="dropdown" class="dropdown-toggle" href="#">
                                    <span class="clear"><span class="block m-t-xs"> <strong class="font-bold"><?php echo $sf_user->getGuardUser()->getUsername(); ?></strong></span>
                                        <span class="text-muted text-xs block">
                                            <?php
                                            $index = 0;
                                            foreach ($sf_user->getGuardUser()->getGroups() as $group) {
                                                echo $group
                                                ?>
                                                <b class="caret" <?php echo $index !== 0 ? 'style="visibility: hidden;"' : '' ?>></b>
                                                <br>
                                                <?php
                                                $index++;
                                            }
                                            ?>
                                        </span>
                                    </span>
                                </a>
                                <ul class="dropdown-menu animated fadeInRight m-t-xs">
                                    <li><a href="<?php echo url_for("sf_guard_signout") ?>">Déconnexion</a></li>
                                </ul>
                            </div>
                        </li>
                        <?php include(sfConfig::get('sf_app_template_dir') . '/menus/menu' . $sf_user->getGuardUser()->getId() . '.php') ?>
                    </ul>
                </div>
            </nav>
            <div id="page-wrapper" class="gray-bg">
                <div class="row border-bottom">
                    <nav class="navbar navbar-static-top" role="navigation" style="margin-bottom: 0">
                        <div class="navbar-header">
                            <a class="navbar-minimalize minimalize-styl-2 btn btn-primary"><i class="fa fa-bars"></i></a>
                        </div>
                        <ul class="nav navbar-top-links navbar-right">
                            <li>
                                <span class="m-r-sm text-muted welcome-message">Follow GT | Logiciel de pilotage des flux industriels</span>
                            </li>
                            <li>
                                <a href="<?php echo url_for("sf_guard_signout") ?>">
                                    <i class="fa fa-sign-out"></i>Déconnexion
                                </a>
                            </li>
                        </ul>
                    </nav>
                </div>
                <div class="row wrapper border-bottom white-bg page-heading">
                    <div class="col-sm-6">
                        <?php if (has_slot("page_title")) { ?>
                            <h2><span id="lytPageTtle"><?php include_slot("page_title") ?></span></h2>
                        <?php } else { ?>
                            <h2>Page</h2>
                        <?php } ?>
                        <div id="lytHrchy"> <?php include_slot("page_hierarchy") ?> </div>
                    </div>
                </div>
                <?php echo $sf_content ?>
                <div class="footer">
                    <div class="pull-right">
                        <strong>www.mobileit.fr</strong>
                    </div>
                    <div>
                        <strong>Copyright</strong> MobileIT &copy; 2017
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>