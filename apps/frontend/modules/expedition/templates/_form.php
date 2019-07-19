<!--<div class="form-group">
    <label class="col-sm-2 control-label">
        <span class="form-mandatory">* </span>
<?php echo __('Fournisseur') ?>
    </label>
    <div class="col-sm-10">
        <select id="fournisseur" name="fournisseur" class="form-control chosen-select" data-placeholder="Choisir une valeur">
<?php foreach ($fournisseurs as $fournisseur) { ?>
                                            <option <?php echo (isset($expedition) && $fournisseur->getIdFournisseur() == $expedition->getIdFournisseur() ? 'selected' : '') ?> value="<?php echo $fournisseur->getIdFournisseur(); ?>"><?php echo $fournisseur->getLibelle() ?></option>
<?php } ?>
        </select>
    </div>
</div>-->
<div class="form-group">
    <label class="col-sm-2 control-label">
        <span class="form-mandatory">* </span>
        <?php echo __('Transporteur') ?>
    </label>
    <div class="col-sm-10">
        <select id="transporteur" name="transporteur" class="form-control chosen-select" data-placeholder="Choisir une valeur">
            <?php foreach ($transporteurs as $transporteur) { ?>
                <option <?php echo ( isset($expedition) && $transporteur->getIdTransporteur() == $expedition->getIdTransporteur() ? 'selected' : '') ?> value="<?php echo $transporteur->getIdTransporteur(); ?>"><?php echo $transporteur->getLibelle() ?></option>
            <?php } ?>
        </select>
    </div>
</div>
<div class="form-group">
    <label class="col-sm-2 control-label">
        <span class="form-mandatory">* </span>
        <?php echo __('Chauffeur') ?>
    </label>
    <div class="col-sm-10">
        <select id="chauffeur" name="chauffeur" class="form-control chosen-select" data-placeholder="Choisir une valeur">
            <?php foreach ($chauffeurs as $chauffeur) { ?>
                <option <?php echo (isset($expedition) && $chauffeur->getIdTransporteur() === $expedition->getIdTransporteur() ? '' : 'disabled') ?> <?php echo ( isset($expedition) && $chauffeur->getIdChauffeur() == $expedition->getIdChauffeur() ? 'selected' : '') ?> value="<?php echo $chauffeur->getIdChauffeur(); ?>" idTransporteur="<?php echo $chauffeur->getIdTransporteur(); ?>"><?php echo $chauffeur ?></option>
            <?php } ?>
        </select>
    </div>
</div>
<div class="form-group">
    <label class="col-sm-2 control-label">
        <?php echo __('Lettre voiture') ?>
    </label>
    <div class="col-sm-10">
        <input id="lVoiture" name="lVoiture" class="form-control" value="<?php echo (isset($expedition) ? $expedition->getLettreVoiture() : '') ?>"/>
    </div>
</div>
<div class="form-group">
    <label class="col-sm-2 control-label">
        <span class="form-mandatory">* </span>
        <?php echo __('Immatriculation') ?>
    </label>
    <div class="col-sm-10">
        <input id="immatriculation" name="immatriculation" class="form-control" value="<?php echo (isset($expedition) ? $expedition->getImmatriculation() : '') ?>"/>
    </div>
</div>
<hr>
<div class="form-group">
    <label class="col-sm-2 control-label">
        <?php echo __('Nombre d\'UM') ?>
    </label>
    <div class="col-sm-10">
        <div class="input-group">
            <input id="colis" name="colis" class="form-control spineEdit" value="<?php echo (isset($expedition) ? $expedition->getNbColis() : '') ?>"/>
        </div>
    </div>
</div>
<div class="form-group">
    <label class="col-sm-2 control-label">
        <?php echo __('Imprimer le numéro d\'expedition ?') ?>
    </label>
    <div class="col-sm-10">
        <input type="checkbox" class="form-control i-checks" name="printNumExp"> </div>
</div>

<!--<div class="form-group">
    <label class="col-sm-2 control-label">
<?php echo __('Statut') ?>
    </label>
    <div class="col-sm-10">
        <select id="statut" name="statut" class="form-control chosen-select" data-placeholder="Choisir une valeur">
<?php
$statuts = array('conforme', 'reserve');
foreach ($statuts as $statut) {
    ?>
                                            <option <?php echo ( isset($expedition) && $statut == $expedition->getStatut() ? 'selected' : '') ?> value="<?php echo $statut; ?>"><?php echo $statut ?></option>
<?php } ?>
        </select>
    </div>
</div>-->

<script>
    $(document).ready(function () {
        var config = {
            disable_search_threshold: 10, //on cache le champs de recherche si il y a moins de 10 elements
            no_results_text: 'Aucun résultat!',
            allow_single_deselect: false,
            display_disabled_options: false
        };
        $('.chosen-select').chosen(config);
        $(".chosen-container").css("width", "100%");


        $('.spineEdit').spinedit({
            minimum: 0,
            maximum: 100,
            step: 1,
            numberOfDecimals: 0
        });

        $('.i-checks').iCheck({
            checkboxClass: 'icheckbox_flat-blue'
        });

        $('#formEdit,#formNew').ajaxForm({
            beforeSubmit: controleValeur,
            success: function (res) {
                if (res === '1') {
                    goBack();
                    reloadList();
                } else {
                }
            }});
        $('#transporteur').on('change', function (evt, params) {
            if (params.selected !== undefined) {
                updateChauffeurSelect(params.selected);
            }
        });
    });

    function updateChauffeurSelect(idSelect) {
        $('#chauffeur').find('option').attr('disabled', '');
        $('#chauffeur').find('option').removeAttr('selected');

        $('#chauffeur').find('option[idTransporteur="' + idSelect + '"]').removeAttr('disabled');
        $('#chauffeur').find('option[idTransporteur="' + idSelect + '"]').first().prop('selected', true);
        $('#chauffeur').trigger('chosen:updated');

    }
    function controleValeur() {
        var erreur = false;
        removeAllSet("#chauffeur");
        removeAllSet("#transporteur");
        removeAllSet("#colis");
        removeAllSet("#immatriculation");

        if ($("#chauffeur").val() === "" || $("#chauffeur").val() === null) {
            erreur = true;
            setHasError("#chauffeur");
        }
        if ($("#immatriculation").val() === "") {
            erreur = true;
            setHasError("#immatriculation");
        }

        if ($("#transporteur").val() === "") {
            erreur = true;
            setHasError("#transporteur");
        }

        if ($("#colis").val() !== "") {
            if (isNaN(parseInt($("#colis").val()))) {
                erreur = true;
                setHasError("#colis");
            }
        }

        return !erreur;
    }
</script>