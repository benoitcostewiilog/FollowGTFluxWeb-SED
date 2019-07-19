<div class="form-group">
    <label class="col-sm-2 control-label">
        <span class="form-mandatory">* </span>
        <?php echo __('Fournisseur') ?>
    </label>
    <div class="col-sm-10">
        <div class="input-group">
            <select id="fournisseur" name="fournisseur" class="form-control chosen-select" data-placeholder="Choisir une valeur">
                <?php foreach ($fournisseurs as $fournisseur) { ?>
                    <option <?php echo (isset($arrivage) && $fournisseur->getIdFournisseur() == $arrivage->getIdFournisseur() ? 'selected' : '') ?> value="<?php echo $fournisseur->getIdFournisseur(); ?>"><?php echo $fournisseur->getLibelle() ?></option>
                <?php } ?>
            </select>
            <span class="input-group-btn">
                <button type="button" class="btn btn-primary" onclick="showFrnModal()">
                    <i class="fa fa-plus"></i>
                </button>
            </span>
        </div>
    </div>
</div>
<div class="form-group">
    <label class="col-sm-2 control-label">
        <span class="form-mandatory">* </span>
        <?php echo __('Transporteur') ?>
    </label>
    <div class="col-sm-10">
        <div class="input-group">
            <select id="transporteur" name="transporteur" class="form-control chosen-select" data-placeholder="Choisir une valeur">
                <?php foreach ($transporteurs as $transporteur) { ?>
                    <option <?php echo ( isset($arrivage) && $transporteur->getIdTransporteur() == $arrivage->getIdTransporteur() ? 'selected' : '') ?> value="<?php echo $transporteur->getIdTransporteur(); ?>"><?php echo $transporteur->getLibelle() ?></option>
                <?php } ?>
            </select>
            <span class="input-group-btn">
                <button type="button" class="btn btn-primary" onclick="showTrsptModal()">
                    <i class="fa fa-plus"></i>
                </button>
            </span>
        </div>
    </div>
</div>
<div class="form-group">
    <label class="col-sm-2 control-label">
        <?php echo __('Chauffeur') ?>
    </label>
    <div class="col-sm-10">
        <div class="input-group">
            <select id="chauffeur" name="chauffeur" class="form-control chosen-select" data-placeholder="Choisir une valeur">
                <option id="chauffeur-empty-option"></option>
                <?php foreach ($chauffeurs as $chauffeur) { ?>
                    <option <?php echo ( isset($arrivage) && $chauffeur->getIdTransporteur() === $arrivage->getIdTransporteur() ? '' : 'disabled') ?> <?php echo ( isset($arrivage) && $chauffeur->getIdChauffeur() == $arrivage->getIdChauffeur() ? 'selected' : '') ?> value="<?php echo $chauffeur->getIdChauffeur(); ?>" idTransporteur="<?php echo $chauffeur->getIdTransporteur(); ?>"><?php echo $chauffeur ?></option>
                <?php } ?>
            </select>
            <span class="input-group-btn">
                <button type="button" class="btn btn-primary" onclick="showDriverModal()()">
                    <i class="fa fa-plus"></i>
                </button>
            </span>
        </div>
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
            <input type="checkbox" class="form-control i-checks" name="autoPrint" checked> </div>
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
<hr>


<div id="form-group-commentaire" class="form-group" style="<?php echo ( isset($arrivage) && $arrivage->getStatut() === 'réserve' ? '' : 'display: none;') ?>">
    <label class="col-sm-2 control-label">
        <?php echo __('Commentaire') ?>
    </label>
    <div class="col-sm-10">
        <textarea id="commentaire" name="commentaire" class="form-control"><?php echo (isset($arrivage) ? $arrivage->getCommentaire() : '') ?></textarea>
    </div>
</div>

