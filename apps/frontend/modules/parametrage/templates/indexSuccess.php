<?php
//Slot du titre de la page
slot('page_title', sprintf("Paramétrage"));
?>

<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox-content">
                <div class="panel blank-panel">
                    <div class="panel-heading">
                        <div class="panel-options">
                            <ul class="nav nav-tabs">
                                <li class="active" onclick="$('#buttonGroup').fadeIn();"><a data-toggle="tab" href="#tabJours">Jours fériés</a></li>
                                <li onclick="$('#buttonGroup').fadeIn();"><a data-toggle="tab" href="#tabHoraire">Horaires</a></li>
                                <li onclick="$('#buttonGroup').fadeIn();"><a data-toggle="tab" href="#tabDelais">Délais</a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="panel-body">
                        <div class="tab-content">
                            <div id="tabJours" class="tab-pane active">
                                <?php include_partial("feries", array("feries" => $feries)) ?>
                            </div>
                            <div id="tabHoraire" class="tab-pane">
                                 <?php include_partial("horaires", array("horaires" => $horaires)) ?>
                            </div>
                            <div id="tabDelais" class="tab-pane">
                                 <?php include_partial("delais") ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
