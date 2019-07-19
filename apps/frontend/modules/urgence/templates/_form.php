<div class="form-group">
    <label class="col-sm-2 control-label">
        <span class="form-mandatory">* </span>
        <?php echo __('Fournisseur') ?>
    </label>
    <div class="col-sm-10">
        <select id="fournisseur" name="fournisseur" class="form-control chosen-select" data-placeholder="Choisir une valeur">
            <?php foreach ($fournisseurs as $fournisseur) { ?>
                <option <?php echo (isset($urgence) && $fournisseur->getIdFournisseur() == $urgence->getIdFournisseur() ? 'selected' : '') ?> value="<?php echo $fournisseur->getIdFournisseur(); ?>"><?php echo $fournisseur->getLibelle() ?></option>
            <?php } ?>
        </select>
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
                <option <?php echo ( isset($arrivage) && $transporteur->getIdTransporteur() == $arrivage->getIdTransporteur() ? 'selected' : '') ?> value="<?php echo $transporteur->getIdTransporteur(); ?>"><?php echo $transporteur->getLibelle() ?></option>
            <?php } ?>
        </select>
    </div>
</div>
<hr>
<div class="form-group">
    <label class="col-sm-2 control-label">
           <span class="form-mandatory">* </span>
        <?php echo __('N° tracking transporteur') ?>
    </label>
    <div class="col-sm-10">
        <input id="tracking_four" name="tracking_four" class="form-control" value="<?php echo (isset($urgence) ? $urgence->getTrackingFour() : '') ?>"/>
    </div>
</div>
<div class="form-group">
    <label class="col-sm-2 control-label">
           <span class="form-mandatory">* </span>
        <?php echo __('N° commande / BL') ?>
    </label>
    <div class="col-sm-10">
        <input id="commande_achat" name="commande_achat" class="form-control" value="<?php echo (isset($urgence) ? $urgence->getCommandeAchat() : '') ?>"/>
    </div>
</div>
<hr>

<div class="form-group">
    <label class="col-sm-2 control-label">
        <?php echo __('Fourchette date de livraison') ?>
    </label>
    <div class="col-sm-10">
        <input  type="text" id="date_livraison_debut" autocomplete="off" name="date_livraison_debut" class="form-control dateHeure date_livraison_debut"  value="<?php echo isset($urgence) && $urgence->getDateLivraisonDebut() ? DateTime::createFromFormat('Y-m-d H:i:s', $urgence->getDateLivraisonDebut())->format('d/m/Y H:i:s') : ''; ?>" />
        <input  type="text" id="date_livraison_fin" autocomplete="off" name="date_livraison_fin" class="form-control dateHeure date_livraison_fin" value="<?php echo isset($urgence) && $urgence->getDateLivraisonFin() ? DateTime::createFromFormat('Y-m-d H:i:s', $urgence->getDateLivraisonFin())->format('d/m/Y H:i:s') : ''; ?>" />
    </div>
</div>
<div class="form-group" style="">
    <label class="col-sm-2 control-label">
        <?php echo __('Contact PFF') ?>
    </label>
    <div class="col-sm-10">
        <select id="contact_pff" class="chosen-select form-control" name="contact_pff">
            <option value="-1">N/C</option>
            <?php foreach ($interlocuteurs as $interlocuteur) { ?>

                <option <?php echo ( isset($urgence) && $interlocuteur->getId() == $urgence->getIdInterlocuteur() ? 'selected' : '') ?> value="<?php echo $interlocuteur->getId(); ?>" idTransporteur="<?php echo $interlocuteur->getId(); ?>"><?php echo $interlocuteur ?></option>
            <?php } ?>
        </select>
    </div>
</div>

<script>
    
    var dateMax='<?php $date = date("Y-m-d H:i:s");
           $date = DateTime::createFromFormat('Y-m-d H:i:s',$date);
           $date->modify('+15 minutes');
           echo $date->format('d/m/Y H:i:s');
           ?>'
    $(document).ready(function () {
        var config = {
            disable_search_threshold: 10, //on cache le champs de recherche si il y a moins de 10 elements
            no_results_text: 'Aucun résultat!',
            allow_single_deselect: true,
            display_disabled_options: false
        };
        $('.chosen-select').chosen(config);
        $(".chosen-container").css("width", "100%");

        $('#statut').change(function () {
            if ($('#statut').val() === 'réserve') {
                $('#form-group-commentaire').show();
            } else {
                $('#form-group-commentaire').hide();
            }
        });

        $('.spineEdit').spinedit({
            minimum: 0,
            maximum: 100,
            step: 1,
            value: 0,
            numberOfDecimals: 0
        });

        $('.i-checks').iCheck({
            checkboxClass: 'icheckbox_flat-blue'
        });

        $('#formEdit,#formNew').ajaxForm({
            beforeSubmit: controleValeur,
            success: function (res) {
                if (res >=1) {
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


        $('.dateHeure').datetimepicker({
            format: 'DD/MM/YYYY HH:mm:ss',
            useCurrent: false,
            locale: moment.locale('fr'),
            icons: {
                time: 'fa fa-clock-o',
                date: 'fa fa-calendar',
                up: 'fa fa-chevron-up',
                down: 'fa fa-chevron-down',
                previous: 'fa fa-chevron-left',
                next: 'fa fa-chevron-right',
                today: 'fa fa-crosshairs',
                clear: 'fa fa-trash',
                close: 'fa fa-remove'
            }
        });
        
        $('#date_livraison_debut').data("DateTimePicker").minDate(dateMax);
           $('#date_livraison_fin').data("DateTimePicker").minDate(dateMax);
           
           $('#date_livraison_debut').data("DateTimePicker").clear();
           $('#date_livraison_fin').data("DateTimePicker").clear();
           
        $("#numUrgenceDate").on("dp.change", function (e) {
            removeAllSet("#numUrgenceGenerated");
            removeAllSet("#numUrgenceDate");
            url = '<?php echo url_for('urgences-check-num-urgence') ?>';
            data = {date: $("#numUrgenceDate").val()};
            $.post(url, data, function (json) {
                var res = JSON.parse(json);
                $('#numUrgenceGenerated').val(res.numUrgence);
                if (!res.unique) {
                    setHasError("#numUrgenceGenerated");
                    setHasError("#numUrgenceDate");
                }
            });
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
        removeAllSet("#fournisseur");
        removeAllSet("#tracking_four");
        removeAllSet("#transporteur");
        removeAllSet("#commande_achat");
//        removeAllSet("#palette");

        if ($("#fournisseur").val() === "") {
            erreur = true;
            setHasError("#fournisseur");
        }

        if ($("#transporteur").val() === "") {
            erreur = true;
            setHasError("#transporteur");
        }

        if ($("#tracking_four").val() === "") {
            erreur = true;
            setHasError("#tracking_four");
        }
  if ($("#commande_achat").val() === "") {
            erreur = true;
            setHasError("#commande_achat");
        }



//        if ($("#colis").val() !== "") {
//            if (isNaN(parseInt($("#colis").val()))) {
//                erreur = true;
//                setHasError("#colis");
//            }
//        }
//        if ($("#palette").val() !== "") {
//            if (isNaN(parseInt($("#palette").val()))) {
//                erreur = true;
//                setHasError("#palette");
//            }
//        }

        return !erreur;
    }

    function showNbUMAdd() {
        $('#addUM').show();
    }

    function showEditNumUrgence() {
        $('#editNumUrgence').show();
    }

</script>