<?php
//Slot du titre de la page
slot('page_title', sprintf("Bienvenue " . $sf_user->getGuardUser()->getUsername()));
?>
<style>
    tbody{
        max-height: 250px;
        overflow-x: scroll;
         overflow-y: scroll;
    }
</style>
<div id="list-ajax-div">
    <div id="tpltLstHrchy" class="hidden">
        <ol class="breadcrumb">
            <li>
                <strong><a href="#"><?php echo __('Accueil'); ?></a></strong>
            </li>
        </ol>
    </div>
    <div class="wrapper wrapper-content">
        <div class="row">
            <?php
            $i=0;
            foreach ($widgets as $widget) {
             
                if($i%2==0){
                    echo ' </div> <div class="row">';
                }
                   $i++;
                switch ($widget) {
                    case "Arrivages (UM)":
            ?>
                        <div class="col-md-6">
                            <div class="ibox float-e-margins" id="volumetrie-arrivage">
                                <?php include_partial('volumetrieArrivageJour', array('nbArrivage' => $nbColisArrivageParMois, 'nbReceptionne' => $nbColisArrivageReceptionnerParMois, 'annee' => $annee, 'mois' => $mois,'jour'=>$jour)); ?>
                            </div>
                        </div>
            <?php
                        break;
                    case "Réceptions (UM)":
            ?>
                        <div class="col-md-6">
                            <div class="ibox float-e-margins" id="reception">
                                <?php include_partial('nbColisParJour', array('nbColisParMois' => $nbColisReceptionParMois, 'titre' => 'Arrivages', 'id' => 'reception', 'annee' => $annee, 'mois' => $mois, 'jour'=>$jour)); ?>
                            </div>
                            
                        </div>
            <?php
                        break;
                    case "Unités de tracking en retard":
            ?>
                        <div class="col-md-6">
                            <div class="ibox float-e-margins">
                                <?php include_partial('produitRetard', array("produitEnRetard" => $produitEnRetard)); ?>
                            </div>
                        </div>
            <?php
                        break;
                    case "Processus de réception":
            ?>
                        <div class="col-md-6">
                            <div class="ibox float-e-margins">
                                <?php include_partial('schemaReceptionParJour', array('nbArrivage' => $nbArrivage, 'nbArrivageEnAttente' => $nbArrivageEnAttente,'arrivageEnRetard'=>$arrivageEnRetard, 'nbReceptionNonAchemine' => $nbReceptionNonAchemine, 'receptionEnRetard' => $receptionEnRetard,'deposeEnRetard'=>$deposeEnRetard, 'annee' => $annee, 'mois' => $mois, 'jour'=>$jour)); ?>
                            </div>
                        </div>
            <?php
                        break;
                    case "Acheminement":
            ?>
                        <div class="col-md-6">
                            <div class="ibox float-e-margins">
                                <?php include_partial('schemaReceptionParJour', array('nbArrivage' => $nbArrivage, 'nbArrivageEnAttente' => $nbArrivageEnAttente,'arrivageEnRetard'=>$arrivageEnRetard, 'nbReceptionNonAchemine' => $nbReceptionNonAchemine, 'receptionEnRetard' => $receptionEnRetard,'deposeEnRetard'=>$deposeEnRetard, 'annee' => $annee, 'mois' => $mois, 'jour'=>$jour)); ?>
                            </div>
                        </div>
            <?php
                        break;
                    case "Arrivages en retard":
            ?>
                        <div class="col-md-6">
                            <div class="ibox float-e-margins">
                                <?php include_partial('arrivageRetard', array('arrivageEnRetard' => $arrivageEnRetard)); ?>
                            </div>
                        </div>  
            <?php
                        break;
                    case "Réception en retard":
            ?>
                        <div class="col-md-6">
                            <div class="ibox float-e-margins">
                                <?php include_partial('receptionRetard', array('receptionEnRetard' => $receptionEnRetard)); ?>
                            </div>
                        </div>  
            <?php
                        break;
                    case "Dépose en retard":
            ?>
                        <div class="col-md-6">
                            <div class="ibox float-e-margins">
                                <?php include_partial('deposeRetard', array('deposeEnRetard' => deposeEnRetard)); ?>
                            </div>
                        </div>  
            <?php
                        break;
                }
            }
            ?>

        </div>
        <div class="row">
        </div>
    </div>
</div>
<script>
    $(document).ready(function () {
        //Maj des slots du layout
        $('#lytHrchy').html($('#tpltLstHrchy').html());
        $("#ajax-div").hide();
        //Style des boutons
        $('.favButton').hover(function () {$(this).addClass('fc-state-hover');}, function () {$(this).removeClass('fc-state-hover');});
        $('.favButton').mousedown(function () {$(this).addClass('fc-state-down');});
    });
</script>