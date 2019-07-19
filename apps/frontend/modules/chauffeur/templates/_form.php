<div class="form-group">
    <label class="col-sm-2 control-label">
        <span class="form-mandatory">* </span>
        <?php echo __('Nom') ?>
    </label>
    <div class="col-sm-10">
        <input type="text" id="nom" name="nom" class="form-control" value="<?php echo(isset($ref_chauffeur) ? $ref_chauffeur->getNom() : '') ?>"/>
    </div>
</div>
<div class="form-group">
    <label class="col-sm-2 control-label">
        <span class="form-mandatory">* </span>
        <?php echo __('Prénom') ?>
    </label>
    <div class="col-sm-10">
        <input type="text" id="prenom" name="prenom" class="form-control" value="<?php echo(isset($ref_chauffeur) ? $ref_chauffeur->getPrenom() : '') ?>"/>
    </div>
</div>
<div class="form-group">
    <label class="col-sm-2 control-label">
        <?php echo __('N° document ID') ?>
    </label>
    <div class="col-sm-10">
        <input type="text" id="docId" name="docId" class="form-control" value="<?php echo(isset($ref_chauffeur) ? $ref_chauffeur->getNumDocId() : '') ?>"/>
    </div>
</div>
<div class="form-group">
    <label class="col-sm-2 control-label">
        <span class="form-mandatory">* </span>
        <?php echo __('Transporteur') ?>
    </label>
    <div class="col-sm-10">
        <select id="transporteur" name="transporteur" class="form-control chosen-select" data-placeholder="Choisir une valeur">
            <?php foreach ($transporteurs as $transporteur) { ?>
                <option <?php echo ( isset($ref_chauffeur) && $transporteur->getIdTransporteur() == $ref_chauffeur->getIdTransporteur() ? 'selected' : '') ?> value="<?php echo $transporteur->getIdTransporteur(); ?>"><?php echo $transporteur->getLibelle() ?></option>
            <?php } ?>
        </select>
    </div>
</div>


<script>
    $(document).ready(function () {
        var config = {
            disable_search_threshold: 10, //on cache le champs de recherche si il y a moins de 10 elements
            no_results_text: 'Aucun résultat!',
            allow_single_deselect: false
        };
        $('.chosen-select').chosen(config);
        $(".chosen-container").css("width", "100%");
        $('#formEdit,#formNew').ajaxForm({
            beforeSubmit: controleValeur,
            success: function (res) {
                if (res === '1') {
                    goBack();
                    reloadList();
                } else {
                    setHasError("#nom");
                    setHasError("#prenom");
                    setHasError("#transporteur");
                }
            }});

    });

    function controleValeur() {
        var erreur = false;
        removeAllSet("#nom");
        removeAllSet("#prenom");
        removeAllSet("#transporteur");

        if ($("#nom").val() === "") {
            erreur = true;
            setHasError("#nom");
        }
        if ($("#prenom").val() === "") {
            erreur = true;
            setHasError("#prenom");
        }
        if ($("#transporteur").val() === "") {
            erreur = true;
            setHasError("#transporteur");
        }

        return !erreur;
    }
</script>