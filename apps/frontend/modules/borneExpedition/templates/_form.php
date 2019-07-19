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
        <span class="form-mandatory">* </span>
        <?php echo __('Chauffeur') ?>
    </label>
    <div class="col-sm-10">
        <div class="input-group">
            <select id="chauffeur" name="chauffeur" class="form-control chosen-select" data-placeholder="Choisir une valeur">
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
<div class="form-group">
    <label class="col-sm-2 control-label">
        <?php echo __('Lettre voiture') ?>
    </label>
    <div class="col-sm-10">
        <input id="lVoiture" name="lVoiture" class="form-control" value="<?php echo (isset($arrivage) ? $arrivage->getLettreVoiture() : '') ?>"/>
    </div>
</div>
<div class="form-group">
    <label class="col-sm-2 control-label">
        <span class="form-mandatory">* </span>
        <?php echo __('Immatriculation') ?>
    </label>
    <div class="col-sm-10">
        <input id="immatriculation" name="immatriculation" class="form-control" value="<?php echo (isset($arrivage) ? $arrivage->getImmatriculation() : '') ?>"/>
    </div>
</div>
<div id="addUM">
    <div class="form-group">
        <label class="col-sm-2 control-label">
            <?php echo __('Nombre d\'UM') ?>
        </label>
        <div class="col-sm-10">   
            <div class="input-group">
                <input class="form-control spineEdit" name="umStandard">
            </div>
        </div>
    </div>
    <hr>
</div>
