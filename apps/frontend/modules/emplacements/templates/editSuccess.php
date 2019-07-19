
<div class="wrapper wrapper-content animated fadeInRight">
    <div id="tpltEdtHrchy" class="hidden">
        <ol class="breadcrumb">
            <li>
                <a href="#"><?php echo __('Paramétrage'); ?></a>
            </li>
            <li>
                <a onclick="goBack();"><?php echo __('Emplacement'); ?></a>
            </li>
            <li class="active">
                <strong><?php echo __('Modifier un emplacement'); ?></strong>
            </li>
        </ol>
    </div>
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5><?php echo __('Formulaire de modification d\'un emplacement'); ?></h5>
                </div>
                <div class="ibox-content">
                    <form method="POST" action="<?php echo url_for(array('sf_route' => 'referentiels-emplacement-update')) ?>" id="formEdit" class="form-horizontal">
                        <input type="hidden" name="idEmplacement" value="<?php echo $ref_emplacement->getCodeEmplacement() ?>"/> 
                       <?php include_partial('form', array('ref_emplacement' => $ref_emplacement)) ?>
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