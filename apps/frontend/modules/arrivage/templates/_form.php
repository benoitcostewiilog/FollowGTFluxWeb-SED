<div class="form-group" style="display: none;">
    <label class="col-sm-2 control-label">
        <?php echo __('N° d\'arrivage') ?>
    </label>
    <div class="col-sm-10">
        <div class="input-group">
            <input id="numArrivage" name="numArrivage" class="form-control" readonly="" value="<?php echo (isset($arrivage) ? $arrivage->getNumArrivage() : '') ?>"/>
            <span class="input-group-btn">
                <button type="button" class="btn btn-primary" onclick="showEditNumArrivage()">
                    <i class="fa fa-edit"></i>
                </button>
            </span>
        </div>
    </div>
</div>
<div id="editNumArrivage" style="display: none;">
    <hr>
    <div class="form-group">
        <label class="col-sm-2 control-label">
            <?php echo __('Date/Heure') ?>
        </label>
        <div class="col-sm-10">
            <input name="dateArrivage" autocomplete="off" type="date" class="form-control dateHeure" id="numArrivageDate"> </div>
    </div>
    <div class="form-group">
        <label class="col-sm-2 control-label">
            <?php echo __('N° d\'arrivage généré') ?>
        </label>
        <div class="col-sm-10">
            <input id="numArrivageGenerated"class="form-control i-checks" readonly=""> </div>
    </div>
    <hr>
</div>
<div class="form-group">
    <label class="col-sm-2 control-label">
        <span class="form-mandatory">* </span>
        <?php echo __('Fournisseur') ?>
    </label>
    <div class="col-sm-10">
        <select id="fournisseur" name="fournisseur" class="form-control chosen-select" data-placeholder="Choisir une valeur">
            <?php foreach ($fournisseurs as $fournisseur) { ?>
                <option <?php echo (isset($arrivage) && $fournisseur->getIdFournisseur() == $arrivage->getIdFournisseur() ? 'selected' : '') ?> value="<?php echo $fournisseur->getIdFournisseur(); ?>"><?php echo $fournisseur->getLibelle() ?></option>
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
<div class="form-group">
    <label class="col-sm-2 control-label">
        <?php echo __('Chauffeur') ?>
    </label>
    <div class="col-sm-10">
        <select id="chauffeur" name="chauffeur" class="form-control chosen-select" data-placeholder="Choisir une valeur">
               <option id="chauffeur-empty-option"></option>
            <?php foreach ($chauffeurs as $chauffeur) { ?>
                <option <?php echo ( isset($arrivage) && $chauffeur->getIdTransporteur() === $arrivage->getIdTransporteur() ? '' : 'disabled') ?> <?php echo ( isset($arrivage) && $chauffeur->getIdChauffeur() == $arrivage->getIdChauffeur() ? 'selected' : '') ?> value="<?php echo $chauffeur->getIdChauffeur(); ?>" idTransporteur="<?php echo $chauffeur->getIdTransporteur(); ?>"><?php echo $chauffeur ?></option>
            <?php } ?>
        </select>
    </div>
</div>

<div class="form-group" style="display: none;">
    <label class="col-sm-2 control-label">
        <?php echo __('Immatriculation') ?>
    </label>
    <div class="col-sm-10">
        <input id="immatriculation" name="immatriculation" class="form-control" value="<?php echo (isset($arrivage) ? $arrivage->getImmatriculation() : '') ?>"/>
    </div>
</div>
 <hr>
  <div class="form-group">
    <label class="col-sm-2 control-label">
        <?php echo __('N° tracking transporteur') ?>
    </label>
    <div class="col-sm-10">
        <input id="tracking_four" name="tracking_four" class="form-control" value="<?php echo (isset($arrivage) ? $arrivage->getTrackingFour() : '') ?>"/>
    </div>
</div>
    <div class="form-group">
    <label class="col-sm-2 control-label">
        <?php echo __('N° commande / BL') ?>
    </label>
    <div class="col-sm-10">
        <input id="commande_achat" name="commande_achat" class="form-control" value="<?php echo (isset($arrivage) ? $arrivage->getCommandeAchat() : '') ?>"/>
    </div>
</div>
 <div class="form-group">
    <label class="col-sm-2 control-label">
        <?php echo __('Destinataire') ?>
    </label>
    <div class="col-sm-10">
        <select id="contact_pff" class="chosen-select" name="contact_pff">
            <option value="-1" <?php echo (!isset($arrivage) ? 'selected' : '') ?>>N/C</option>
            <?php foreach ($interlocuteurs as $interlocuteur) { ?>

                <option <?php echo ( isset($arrivage) && $interlocuteur->getId() == $arrivage->getIdContactPFF() ? 'selected' : '') ?> value="<?php echo $interlocuteur->getId(); ?>" idTransporteur="<?php echo $interlocuteur->getId(); ?>"><?php echo $interlocuteur ?></option>
            <?php } ?>
        </select>
    </div>
</div>
  <hr>
<?php if (isset($arrivage)) { ?>
    <div class="form-group">
        <label class="col-sm-2 control-label">
            <?php echo __('Nombre d\'UM') ?>
        </label>
        <div class=" col-sm-10">
            <div class="input-group">
                <input readonly="" id="colis" name="colis" class="form-control" value="<?php echo (isset($arrivage) ? $arrivage->getNbColis() : '') ?>"/>
                <span class="input-group-btn">
                    <button type="button" class="btn btn-primary" onclick="showNbUMAdd();">
                        <i class="fa fa-plus"></i>
                    </button>
                </span>
            </div>
        </div>
    </div>
<?php } ?>
<div id="addUM" style="<?php echo (isset($arrivage) ? 'display: none' : ''); ?>">
    <hr>
    <div class="form-group">
        <label class="col-sm-2 control-label">
            <?php echo __('Nombre d\'UM à ajouter') ?>
        </label>
        <div class="col-sm-10">
            <div class="row" id="umcolis">
                <div class="col-lg-4">
                    <label class="col-sm-3 control-label">Standard</label>
                    <div class="col-sm-8">
                        <div class="input-group">
                            <input id="umStandard" class="form-control spineEdit" name="umStandard">
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <label class="col-sm-3 control-label">Congelée/Mat. Dgx</label>
                    <div class="col-sm-8">
                        <div class="input-group">
                            <input id="umCongelee" class="form-control spineEdit" name="umCongelee"> 
                        </div>
                    </div>
                </div>
                <div class="col-lg-4" style="display: none;">
                    <label class="col-sm-3 control-label">Urgent</label>
                    <div class="col-sm-8">
                        <div class="input-group">
                            <input id="umUrgent" class="form-control spineEdit" name="umUrgent">
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-2 control-label">
            <?php echo __('Imprimer UM ?') ?>
        </label>
        <div class="col-sm-10">
            <input type="checkbox" class="form-control i-checks" name="autoPrint"> </div>
    </div>
    <div class="form-group">
        <label class="col-sm-2 control-label">
            <?php echo __('Imprimer arrivage ?') ?>
        </label>
        <div class="col-sm-10">
            <input id="printNumArrivage" type="checkbox" class="form-control i-checks" name="printNumArrivage"> </div>
    </div>
    <hr>
</div>

<div class="form-group">
    <label class="col-sm-2 control-label">
        <span class="form-mandatory">* </span>
        <?php echo __('Statut') ?>
    </label>
    <div class="col-sm-10">
        <select id="statut" name="statut" class="form-control chosen-select" data-placeholder="Choisir une valeur">
            <?php
            $statuts = array('conforme', 'réserve');
            foreach ($statuts as $statut) {
                ?>
                <option <?php echo ( isset($arrivage) && $statut == $arrivage->getStatut() ? 'selected' : '') ?> value="<?php echo $statut; ?>"><?php echo $statut ?></option>
            <?php } ?>
        </select>
    </div>
</div>
<div id="form-group-commentaire" class="form-group" style="<?php echo ( isset($arrivage) && $arrivage->getStatut() === 'réserve' ? '' : 'display: none;') ?>">
    <label class="col-sm-2 control-label">
        <?php echo __('Commentaire') ?>
    </label>
    <div class="col-sm-10">
        <textarea id="commentaire" name="commentaire" class="form-control"><?php echo (isset($arrivage) ? $arrivage->getCommentaire() : '') ?></textarea>
    </div>
</div>
  
  <hr>
    <div class="form-group" style="<?php echo ( isset($arrivage) && $arrivage->getUrgent() && $sf_user->hasCredential('arrivage-urgence-ecriture') ? '' : 'display: none;') ?>">
                        <label class="col-sm-2 control-label">
                            <?php echo __('Fourchette date de livraison') ?>
                        </label>
                        <div class="col-sm-10">
                            <input <?php echo $editUrgence?"":"disabled=''"?> type="text" id="date_livraison_debut" name="date_livraison_debut" class="form-control dateHeure"  value="<?php echo isset($arrivage) && $arrivage->getDateLivraisonDebut()? DateTime::createFromFormat('Y-m-d H:i:s', $arrivage->getDateLivraisonDebut())->format('d/m/Y H:i:s'):''; ?>" />
                            <input <?php echo $editUrgence?"":"disabled=''"?>  type="text" id="date_livraison_fin" name="date_livraison_fin" class="form-control dateHeure" value="<?php echo isset($arrivage) && $arrivage->getDateLivraisonFin()?DateTime::createFromFormat('Y-m-d H:i:s', $arrivage->getDateLivraisonFin())->format('d/m/Y H:i:s'):''; ?>" />
                        </div>
                    </div>
                    <div class="form-group" style="<?php echo ( isset($arrivage) && $arrivage->getUrgent() && $sf_user->hasCredential('arrivage-urgence-ecriture') ? '' : 'display: none;') ?>">
                        <label class="col-sm-2 control-label">
                            <?php echo __('Contact PFF') ?>
                        </label>
                        <div class="col-sm-10">
                            <select <?php echo $editUrgence?"":"disabled=''"?>  id="contact_pff" class="chosen-select" name="contact_pff">
                                <option value="-1" <?php echo ( !isset($arrivage) ? 'selected' : '') ?>>N/C</option>
                                  <?php foreach ($interlocuteurs as $interlocuteur) { ?>
                                
                    <option <?php echo ( isset($arrivage) && $interlocuteur->getId() == $arrivage->getIdInterlocuteur() ? 'selected' : '') ?> value="<?php echo $interlocuteur->getId(); ?>" idTransporteur="<?php echo $interlocuteur->getId(); ?>"><?php echo $interlocuteur ?></option>
                <?php } ?>
                            </select>
                        </div>
                    </div>
 
<script>
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
        
           /* $(".spineEdit").on("change",function(){
                var nbColis=0;
        if ($("#umStandard").val() !== "") {
            var nb = parseInt($("#umStandard").val());
            if (isNaN(nb)) {
               
            }else{
             nbColis=nbColis+nb;   
            }
        }
        if ($("#umCongelee").val() !== "") {
            var nb = parseInt($("#umCongelee").val());
            if (isNaN(nb)) {
               
            }else{
             nbColis=nbColis+nb;  
            }
        }
        if ($("#umUrgent").val() !== "") {
            var nb = parseInt($("#umUrgent").val());
            if (isNaN(nb)) {
               
            }else{
            nbColis=nbColis+nb;  
            }
        }
        if(nbColis<=1){
            $('#printNumArrivage').iCheck('uncheck');
        }else{
            $('#printNumArrivage').iCheck('check');
        }
        });*/

        $('.i-checks').iCheck({
            checkboxClass: 'icheckbox_flat-blue'
        });

        $('#formEdit,#formNew').ajaxForm({
            beforeSubmit: controleValeur,
            success: function (res) {
                if (res >0 || res==-5|| (typeof res =='string' &&res.indexOf("C")>=0 )) {
                 window.location.href = "<?php echo url_for('arrivage') ?>";
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
            useCurrent: true,
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
        $("#numArrivageDate").on("dp.change", function (e) {
            removeAllSet("#numArrivageGenerated");
            removeAllSet("#numArrivageDate");
            url = '<?php echo url_for('arrivages-check-num-arrivage') ?>';
            data = {date: $("#numArrivageDate").val()};
            $.post(url, data, function (json) {
                var res = JSON.parse(json);
                $('#numArrivageGenerated').val(res.numArrivage);
                if (!res.unique) {
                    setHasError("#numArrivageGenerated");
                    setHasError("#numArrivageDate");
                }
            });
        });
        
        
        <?php if (!isset($arrivage)) { ?>
         $("#umStandard").val(1)
        <?php } ?>
    });

    function updateChauffeurSelect(idSelect) {
         $('#chauffeur').find('option').attr('disabled', '');
        $('#chauffeur').find('option').removeAttr('selected');
        $('#chauffeur').find('option[idTransporteur="' + idSelect + '"]').removeAttr('disabled');
        $('#chauffeur').find('option[idTransporteur="' + idSelect + '"]').first().prop('selected', true);
        $("#chauffeur-empty-option").removeAttr('disabled');
          $("#chauffeur-empty-option").prop('selected', true);
        $('#chauffeur').trigger('chosen:updated');
        $('#hidTrspt').val(idSelect);

    }
    function controleValeur() {
        var erreur = false;
        removeAllSet("#fournisseur");
        removeAllSet("#chauffeur");
        removeAllSet("#transporteur");
        removeAllSet("#immatriculation");
        
          removeAllSet("#umcolis");
              
//        removeAllSet("#palette");

        if ($("#fournisseur").val() === "") {
            erreur = true;
            setHasError("#fournisseur");
        }

   

        if ($("#transporteur").val() === "") {
            erreur = true;
            setHasError("#transporteur");
        }
        
        var nbColis=0;
        if ($("#umStandard").val() !== "") {
            var nb = parseInt($("#umStandard").val());
            if (isNaN(nb)) {
               
            }else{
             nbColis=nbColis+nb;   
            }
        }
        if ($("#umCongelee").val() !== "") {
            var nb = parseInt($("#umCongelee").val());
            if (isNaN(nb)) {
               
            }else{
             nbColis=nbColis+nb;  
            }
        }
        if ($("#umUrgent").val() !== "") {
            var nb = parseInt($("#umUrgent").val());
            if (isNaN(nb)) {
               
            }else{
            nbColis=nbColis+nb;  
            }
        }
        
           if ($("#colis").val() !== "") {
            var nb = parseInt($("#colis").val());
            if (isNaN(nb)) {
               
            }else{
            nbColis=nbColis+nb;  
            }
        }
        
        if(nbColis<=0){
             erreur = true;
            setHasError("#umcolis");
        }

     
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
    
    function showEditNumArrivage(){
         $('#editNumArrivage').show();
     }
        
</script>