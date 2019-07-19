
<div class="wrapper wrapper-content animated fadeInRight">
    <div id="tpltEdtHrchy" class="hidden">
        <ol class="breadcrumb">
            <li>
                <a href="#"><?php echo __('Paramétrage'); ?></a>
            </li>
            <li>
                <a onclick="goBack();"><?php echo __('Chauffeur'); ?></a>
            </li>
            <li class="active">
                <strong><?php echo __('Créer un chauffeur'); ?></strong>
            </li>
        </ol>
    </div>
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5><?php echo __('Formulaire de création d\'un chauffeur'); ?></h5>
                </div>
                <div class="ibox-content">
                    <form method="POST" action="<?php echo url_for(array('sf_route' => 'referentiels-chauffeur-create')) ?>" id="formNew" class="form-horizontal">
                        <?php include_partial('form', array('transporteurs' => $transporteurs)) ?>
                        <div class="form-group">
                            <div class="col-sm-4 col-sm-offset-2">
                                <button class="btn btn-white" onclick="goBack();" type="button"><?php echo __('Annuler'); ?></button>
                                <button class="btn btn-primary" type="submit"><?php echo __('Enregistrer'); ?></button>
                            </div>
                            <span class="form-mandatory-end"><span class="form-mandatory">* </span><?php echo __('champs obligatoires') ?></span>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function () {
        //Maj des slots du layout
        $('#lytHrchy').html($('#tpltEdtHrchy').html());
    });
</script>