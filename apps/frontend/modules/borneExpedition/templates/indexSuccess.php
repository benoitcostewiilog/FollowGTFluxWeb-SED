<?php
//Slot du titre de la page
slot('page_title', sprintf("Borne Expédition"));
?>
<div class="wrapper wrapper-content">
    <div id="tpltEdtHrchy" class="hidden">
        <ol class="breadcrumb">
            <li>
                <a href="#"><?php echo __('Borne'); ?></a>
            </li>
            <li>
                <a onclick="goBack();"><?php echo __('Expédition'); ?></a>
            </li>
            <li class="active">
                <strong><?php echo __('Créer une expédition'); ?></strong>
            </li>
        </ol>
    </div>
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5><?php echo __('Formulaire de création d\'une expédition'); ?></h5>
                </div>
                <div class="ibox-content">
                    <form method="POST" action="<?php echo url_for(array('sf_route' => 'borne-expedition-create')) ?>" id="formNew" class="form-horizontal">
                        <?php include_partial('form', array( 'fournisseurs' => $fournisseurs, 'transporteurs' => $transporteurs,'chauffeurs'=>$chauffeurs, 'natures' => $natures)) ?>
                         <div class="form-group">
                            <div class="col-sm-4 col-sm-offset-2">
                                <button class="btn btn-white" onclick="reset();" type="button"><?php echo __('Annuler'); ?></button>
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
<div class="modal inmodal fade" id="addTrspt" tabindex="-1" role="dialog"  aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only"><?php echo __('Fermer'); ?></span></button>
                <h4 class="modal-title"><?php echo __('Ajouter un transporteur'); ?></h4>
            </div>
            <div class="modal-body">
                <form method="POST" action="<?php echo url_for(array('sf_route' => 'referentiels-transporteur-create')) ?>" id="formNewT" class="form-horizontal">
                    <div class="form-group">
                        <label class="col-sm-2 control-label">
                            <span class="form-mandatory">* </span>
                            <?php echo __('Libelle') ?>
                        </label>
                        <div class="col-sm-10">
                            <input type="text" id="MlibTrspt" name="libelle" class="form-control"/>
                        </div>
                    </div> 
                </form> 
            </div>
            <div class="modal-footer">
                <button id="cancelButton" type="button" class="btn btn-white" data-dismiss="modal"><?php echo __('Annuler'); ?></button>
                <button id="deleteButton" type="button" class="btn btn-primary" onclick="createTrspt()" ><?php echo __('Ajouter'); ?></button>
            </div>
        </div>
    </div>
</div>
<div class="modal inmodal fade" id="addChauff" tabindex="-1" role="dialog"  aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only"><?php echo __('Fermer'); ?></span></button>
                <h4 class="modal-title"><?php echo __('Ajouter un chauffeur'); ?></h4>
            </div>
            <div class="modal-body">
                <form method="POST" action="<?php echo url_for(array('sf_route' => 'referentiels-chauffeur-create')) ?>" id="formNewC" class="form-horizontal">
                    <div class="form-group">
                        <label class="col-sm-2 control-label">
                            <span class="form-mandatory">* </span>
                            <?php echo __('Nom') ?>
                        </label>
                        <div class="col-sm-10">
                            <input type="text" id="nom" name="nom" class="form-control" />
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label">
                            <span class="form-mandatory">* </span>
                            <?php echo __('Prénom') ?>
                        </label>
                        <div class="col-sm-10">
                            <input type="text" id="prenom" name="prenom" class="form-control" />
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label">
                            <?php echo __('N° doc ID') ?>
                        </label>
                        <div class="col-sm-10">
                            <input type="text" id="docId" name="docId" class="form-control" />
                        </div>
                    </div>
                    <input type="hidden" id="hidTrspt" name="transporteur"/>    
                </form> 
            </div>
            <div class="modal-footer">
                <button id="cancelButton" type="button" class="btn btn-white" data-dismiss="modal"><?php echo __('Annuler'); ?></button>
                <button id="deleteButton" type="button" class="btn btn-primary" onclick="createChauffeur()" ><?php echo __('Ajouter'); ?></button>
            </div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function () {
        
        $('#lytHrchy').html($('#tpltEdtHrchy').html());
        
        var config = {
            disable_search_threshold: 10,
            no_results_text: 'Aucun résultat!',
            allow_single_deselect: false,
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

        $('#formNew').ajaxForm({
            beforeSubmit: controleValeur,
            success: function (res) {
                if (res === '1') {
                    swal("Expédition enregistrée!", "", "success");
                    reset();
                } else {
                }
            }});

        $('#transporteur').on('change', function (evt, params) {
            if (params.selected !== undefined) {
                updateChauffeurSelect(params.selected);
            }
        });

        $('#hidTrspt').val($('#transporteur').val());
        updateChauffeurSelect($('#transporteur').val());
        
        $('#addTrspt').on('shown.bs.modal', function () {
            $('#MlibTrspt').focus();
        });
        
        $('#addChauff').on('shown.bs.modal', function () {
            $('#nom').focus();
        });
            
    });

    function updateChauffeurSelect(idSelect) {
        $('#chauffeur').find('option').attr('disabled', '');
        $('#chauffeur').find('option').removeAttr('selected');
        $('#chauffeur').find('option[idTransporteur="' + idSelect + '"]').removeAttr('disabled');
        $('#chauffeur').find('option[idTransporteur="' + idSelect + '"]').first().prop('selected', true);
        $('#chauffeur').trigger('chosen:updated');
        $('#hidTrspt').val(idSelect);
    }
    
    function controleValeur() {
        var erreur = false;
        removeAllSet("#chauffeur");
        removeAllSet("#transporteur");
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

        return !erreur;
    }

    function reset() {
        $(':input','#formNew')
            .not(':button, :submit, :reset, :hidden')
            .val('')
            .removeAttr('checked')
            .removeAttr('selected');
    }
    
    function showTrsptModal(){
        $('#addTrspt').modal('show'); 
    }
    
    function showDriverModal(){
        $('#addChauff').modal('show');
    }
    
    function createTrspt(){
        
        var transporteur = $('#MlibTrspt').val();
        var erreur = false;
        removeAllSet("#MlibTrspt");
        if ($("#MlibTrspt").val() === "") {
            erreur = true;
            setHasError("#MlibTrspt");
        }
        if(erreur === false){
            $('#formNewT').ajaxSubmit({
                success: function (res) {
                    if (res !== '') {
                       $('#hidTrspt').val(res);
                       $('#transporteur').append('<option value="'+ res +'">'+ $("#MlibTrspt").val()+'</option>');
                       $('#transporteur').val(res).trigger('chosen:updated');
                       $('#addTrspt').modal('hide');
                       showDriverModal();               
                    } else {
                        swal("Erreur", "", "error");
                    }
                }
            }); 
        } 
    }
    
    function createChauffeur(){
        
        var erreur = false;
        removeAllSet("#nom");
        removeAllSet("#prenom");

        if ($("#nom").val() === "") {
            erreur = true;
            setHasError("#nom");
        }
        if ($("#prenom").val() === "") {
            erreur = true;
            setHasError("#prenom");
        }
        
        if(erreur === false){
            
            $('#formNewC').ajaxSubmit({
          
                success: function (res) {
                    if (res !== '') {
                       swal("Chauffeur enregistré !", "", "success");
                       
                       $('#addChauff').modal('hide');
                       $('#chauffeur').append('<option disabled value="'+ res +'" idTransporteur="'+ $('#transporteur').val() +'" >'+ $("#nom").val()+' '+ $("#prenom").val() +'</option>');
                       updateChauffeurSelect($('#transporteur').val());
                       $('#chauffeur').val(res).trigger('chosen:updated');
                      
                    } else {
                        swal("Erreur", "", "error");
                     
                    }
                }
            }); 
        }
    }    
</script>