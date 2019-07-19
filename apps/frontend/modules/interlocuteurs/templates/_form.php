<div class="form-group">
    <label class="col-sm-2 control-label">
        <span class="form-mandatory">* </span>
        <?php echo __('Nom') ?>
    </label>
    <div class="col-sm-10">
        <input type="text" id="nom" name="nom" class="form-control" value="<?php echo(isset($interlocuteur) ? $interlocuteur->getNom() : '') ?>"/>
    </div>
</div>
<div class="form-group">
    <label class="col-sm-2 control-label">
        <?php echo __('Prénom') ?>
    </label>
    <div class="col-sm-10">
        <input type="text" id="prenom" name="prenom" class="form-control" value="<?php echo(isset($interlocuteur) ? $interlocuteur->getPrenom() : '') ?>"/>
    </div>
</div>
<div class="form-group">
    <label class="col-sm-2 control-label">
        <?php echo __('Mail') ?>
    </label>
    <div class="col-sm-10">
        <input type="text" id="mail" name="mail" class="form-control" value="<?php echo(isset($interlocuteur) ? $interlocuteur->getMail() : '') ?>"/>
    </div>
</div>
<div class="form-group">
    <label class="col-sm-2 control-label">
        <?php echo __('Emplacement') ?>
    </label>
    <div class="col-sm-10">
    <select id="emplacement" name="emplacement" class="form-control chosen-select" data-placeholder="Choisir une valeur">
                <?php 
                    if(isset($interlocuteur)){
                        $emplDépose = $interlocuteur->getRefEmplacement()->getCodeEmplacement();
                    }
                    foreach ($emplacements as $emplacement) { ?>
                        <option value="<?php echo $emplacement->getCodeEmplacement(); ?>"><?php echo $emplacement->getCodeEmplacement() ?></option>
                <?php } ?>
            </select>
    </div>
</div>

<script>
    $(document).ready(function () {
        $('#formEdit,#formNew').ajaxForm({
            beforeSubmit: controleValeur,
            success: function (res) {
                if (res !== '') {
                    goBack();
                    reloadList();
                } else {
                    setHasError("#nom");
                }
            }});
    });


    function controleValeur() {
        var erreur = false;
        removeAllSet("#nom");


        if ($("#nom").val() === "") {
            erreur = true;
            setHasError("#nom");
        }

        return !erreur;
    }
</script>