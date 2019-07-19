<div class="form-group">
    <label class="col-sm-2 control-label">
        <span class="form-mandatory">* </span>
        <?php echo __('Nombre de colis') ?>
    </label>
    <div class="col-sm-10">
        <div class="input-group">
            <input id="nbColis" class="form-control spineEdit" name="nbColis" value="<?php echo(isset($acheminement) ? $acheminement->getNbColis() : '') ?>">
        </div>
    </div>
</div>
<div class="form-group">
    <label class="col-sm-2 control-label">
        <span class="form-mandatory">* </span>
        <?php echo __('Emplacement de prise') ?>
    </label>
    <div class="col-sm-10">
        <select id="empPrise" name="empPrise" class="form-control chosen-select">
            <?php foreach ($emplacements as $emplacement) { ?>
                <option <?php echo (isset($acheminement) && $emplacement->getCodeEmplacement() == $acheminement->getCodeEmplacementPrise() ? "selected" : "") ?> value="<?php echo $emplacement->getCodeEmplacement() ?>"><?php echo $emplacement->getLibelle() ?></option>
            <?php } ?>
        </select>
    </div>
</div>
<div class="form-group">
    <label class="col-sm-2 control-label">
        <span class="form-mandatory">* </span>
        <?php echo __('Emplacement de dépose') ?>
    </label>
    <div class="col-sm-10">
        <select id="empDepose" name="empDepose" class="form-control chosen-select">
            <?php foreach ($emplacements as $emplacement) { ?>
                <option <?php echo (isset($acheminement) && $emplacement->getCodeEmplacement() == $acheminement->getCodeEmplacementDepose() ? "selected" : "") ?> value="<?php echo $emplacement->getCodeEmplacement() ?>"><?php echo $emplacement->getLibelle() ?></option>
            <?php } ?>
        </select>
    </div>
</div>
<div class="form-group">
    <label class="col-sm-2 control-label">
        <span class="form-mandatory">* </span>
        <?php echo __('Destinataire') ?>
    </label>
    <div class="col-sm-10">
        <input type="text" id="destinataire" name="destinataire" class="form-control" value="<?php echo(isset($acheminement) ? $acheminement->getDestinataire() : '') ?>"/>
    </div>
</div>
<div class="form-group">
    <label class="col-sm-2 control-label">
        <?php echo __('Demandeur') ?>
    </label>
    <div class="col-sm-10">
        <input type="text" id="demandeur" name="demandeur" class="form-control" value="<?php echo(isset($acheminement) ? $acheminement->getDemandeur() : '') ?>"/>
    </div>
</div>
<script>
    $(document).ready(function () {
        var config = {
            disable_search_threshold: 10,
            no_results_text: 'Aucun résultat!',
            allow_single_deselect: false,
            width: "100%"
        };
        $('.chosen-select').chosen(config);

        $('#formEdit,#formNew').ajaxForm({
            beforeSubmit: controleValeur,
            type: 'POST',
            success: function (res) {
                if (res !== '0') {
                    showForm('<?php echo url_for('acheminement-colis') ?>?idAch=' + res);
                } else {
                }
            }
        });
        
        $('.spineEdit').spinedit({
            minimum: 1,
            maximum: 100,
            step: 1,
            value: 0,
            numberOfDecimals: 0
        });
        
    });


    function controleValeur() {
        var erreur = false;
        removeAllSet("#empPrise");
        removeAllSet("#nbColis");
        removeAllSet("#empDepose");
        removeAllSet("#delais");
        removeAllSet("#utilisateur");

        if ($("#nbColis").val() === "") {
            erreur = true;
            setHasError("#nbColis");
        }
        if ($("#empPrise").val() === "") {
            erreur = true;
            setHasError("#empPrise");
        }
        if ($("#empDepose").val() === "") {
            erreur = true;
            setHasError("#empDepose");
        }
        if ($("#destinataire").val() === "") {
            erreur = true;
            setHasError("#destinataire");
        }

        return !erreur;
    }
</script>