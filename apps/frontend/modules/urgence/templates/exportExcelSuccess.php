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
    <td><h1  style="font-size:13pt;">Historique des urgences</h1></td>
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
           <th><?php echo __('Création'); ?></th>
            <th><?php echo __('Fournisseur'); ?></th>
            <th><?php echo __('N° Tracking Fournisseur'); ?></th>

            <th><?php echo __('Transporteur'); ?></th>
            <th><?php echo __('Commande achat'); ?></th>
            <th><?php echo __('Fourchette date livraison'); ?></th>
            <th><?php echo __('Contact PFF'); ?></th>
             <th><?php echo __('Date arrivage'); ?></th>
        </tr>
    </thead>

    <tbody>
        <?php foreach ($urgences as $urgence): ?>
            <tr>
            
                <td class="click"><?php echo date('d/m/Y H:i:s', strtotime($urgence->getCreatedAt())) ?></td>
                <td class="click"><?php echo ($urgence->getRefFournisseur() ? $urgence->getRefFournisseur()->getLibelle() : '') ?></td>
<td class="click"><?php echo ($urgence->getTrackingFour()) ?></td>

                <td class="click"><?php echo ($urgence->getRefTransporteur() ? $urgence->getRefTransporteur()->getLibelle() : '') ?></td>
                <td class="click"><?php echo ($urgence->getCommandeAchat()) ?></td>
               <td class="click"><?php echo ($urgence->getDateLivraisonDebut()?date('d/m/Y H:i:s', strtotime($urgence->getDateLivraisonDebut())):"")." - ".($urgence->getDateLivraisonFin()?date('d/m/Y H:i:s', strtotime($urgence->getDateLivraisonFin())):"") ?></td>
              <td class="click"><?php echo ($urgence->getRefInterlocuteur() ? ($urgence->getRefInterlocuteur()->getNom()." ".$urgence->getRefInterlocuteur()->getPrenom()) : '') ?></td>
                <td class="click"><?php echo ($urgence->getWrkArrivage() && $urgence->getWrkArrivage()->getCreatedAt() ? date('d/m/Y H:i:s', strtotime($urgence->getWrkArrivage()->getCreatedAt())) : "") ?></td>
              
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>
<br/>

<div class="foot" style="font-size:9pt;"><!--style="width:500px; margin-left:auto; margin-right:auto;"-->
    <span >© <?php echo date('Y') ?> - GTracking® | Logiciel de pilotage et gestion de marchandise</span>
</div>
</body>