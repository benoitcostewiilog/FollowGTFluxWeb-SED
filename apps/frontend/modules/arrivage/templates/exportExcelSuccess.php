<?php echo include_http_metas() ?>
<style>
    table, tr, td, th {
        border-width:1px;
        border-style:solid;
        border-color:silver;
        /*border:1px solid black;*/
        border-collapse:collapse;
        text-align:center;
        vertical-align:middle;
        margin-left: 0px;
        margin-right: auto;

    }

    td{
        padding-left:5px;
        pading-right:5px;
        font-size:9pt;
    }

    tr.entete{
        /*background-color: #312E32;*/
        background-color:#4D4D4D;/*4A4A4A;474747;*/
        color: #FFFFFF;
        font-weight: bold;
        text-align: center;
        padding: 2px;
        width:auto;
        font-size:9pt;
    }


    #logo {
        width:125px;
    }

    #printer {
        width:45px;
        height:45px;
        opacity:0.5;
        position:fixed;
        top:50px;
        right:50px;
        text-indent:-9999px;
        cursor:pointer;
    }

    body {
        font-family: sans-serif;
        font-size: 11pt;
    }

    #back {
        width:45px;
        height:45px;
        opacity:0.5;
        position:fixed;
        top:100px;
        right:50px;
        text-indent:-9999px;
        cursor:pointer;
    }

    h1{
        padding-left:10;
        padding-left:10;
    }

    .foot {
        width:100%;
        background:white;
        position:absolute;
        bottom:0;
        text-align:center;
        font-family: sans-serif;
    }

    //permet de formater un nombre pour qu'il s'affiche en text
    .text{
        mso-number-format:"\@";/*force text*/
    }
</style>

<table style="margin-left:-100px;width:950px;">
    <td style="width:180px;"></td>
    <td><h1  style="font-size:13pt;">Historique des arrivages</h1></td>
</table>
<br/>
<table style="margin-left:-100px;width:950px;"  id="tableau">
    <thead  style="font-size:9pt;">
        <tr class="entete">
            <th style="width:180px;">Date du jour</th>
        </tr>
    </thead>
    <tbody  style="font-size:9pt;">
        <tr>
            <td style="width:150px;padding:10px 0px 10px 0px"><?php echo $date ?></td>
        </tr>
    </tbody>
</table>
<br/>


<table style="margin-left:-100px;width:950px;" >
    <thead>
        <tr class="entete">
           <th><?php echo __('N° d\'arrivage'); ?></th>
            <th><?php echo __('Transporteur'); ?></th>
            <th><?php echo __('N° tracking transporteur'); ?></th>
            <th><?php echo __('N° commande / BL'); ?></th>
            <th><?php echo __('Fournisseur'); ?></th>
              <th><?php echo __('Destinataire'); ?></th>
            <th><?php echo __('Nb UM'); ?></th>
            <th><?php echo __('Statut'); ?></th>
              <th><?php echo __('Urgent'); ?></th>
            <th><?php echo __('Date'); ?></th>
              <th><?php echo __('Utilisateur'); ?></th>
        </tr>
    </thead>

    <tbody>
        <?php foreach ($arrivages as $arrivage): ?>
            <tr>
                <?php
                $numArrivage = '';
                if ($arrivage->getWrkArrivageProduit()->getFirst()) {
                    $refProduit = $arrivage->getWrkArrivageProduit()->getFirst()->getRefProduit();
                }
                $numArrivage = substr($refProduit, 1, 12);
                ?>
                 <td class="click"><?php echo $numArrivage ?></td>
                <td class="click"><?php echo ($arrivage->getRefTransporteur() ? $arrivage->getRefTransporteur()->getLibelle() : $arrivage->getIdTransporteur()) ?></td>
                <td class="click"><?php echo ($arrivage->getTrackingFour() ? $arrivage->getTrackingFour() : '') ?></td>
                <td class="click"><?php echo $arrivage->getCommandeAchat() ?></td>
                <td class="click"><?php echo ($arrivage->getRefFournisseur() ? $arrivage->getRefFournisseur()->getLibelle() : '') ?></td>
                <td class="click"><?php echo ($arrivage->getRefContactPFF() ? ($arrivage->getRefContactPFF()->getNom()." ".$arrivage->getRefContactPFF()->getPrenom()) : '') ?></td>
                
                <td class="click"><?php echo $arrivage->getNbColis() ?></td>
                <td class="click" title="<?php echo $arrivage->getCommentaire() ?>"><?php echo $arrivage->getStatut() ?></td>
                 <td class="click" ><?php echo $arrivage->getUrgent()?"OUI":"NON" ?></td>
                <td class="click"><?php echo date('d/m/Y H:i:s', strtotime($arrivage->getCreatedAt())) ?></td>
                  <td class="click"><?php echo ($arrivage->getIdUser()&&isset($users[$arrivage->getIdUser()]) ? $users[$arrivage->getIdUser()] : "") ?></td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>
<br/>

<div class="foot" style="font-size:9pt;"><!--style="width:500px; margin-left:auto; margin-right:auto;"-->
    <span >© <?php echo date('Y') ?> - GTracking® | Logiciel de pilotage et gestion de marchandise</span>
</div>
</body>