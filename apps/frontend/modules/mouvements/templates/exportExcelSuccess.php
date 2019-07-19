<?php echo include_http_metas() ?>
<style>
    table, tr, td, th {
        border-width:1px;
        border-style:solid;
        border-color:silver;
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
        background-color:#4D4D4D;
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
    .text{
        mso-number-format:"\@";
    }
</style>

<table style="margin-left:-100px;width:950px;">
    <td style="width:180px;"></td>
    <td><h1  style="font-size:13pt;">Historique des mouvements</h1></td>
</table>
<br/>
<table style="margin-left:-100px;width:950px;"  id="tableau">
    <thead  style="font-size:9pt;">
        <tr class="entete">
            <th style="width:180px;">Date du jour</th>
            <th>Filtres</th>
        </tr>
    </thead>
    <tbody  style="font-size:9pt;">
        <tr>
            <td style="width:150px;padding:10px 0px 10px 0px"><?php echo $date ?></td>
            <td>
            </td>
        </tr>
    </tbody>
</table>
<br/>


<table style="margin-left:-100px;width:950px;" >
    <thead>
        <tr class="entete">
            <th><?php echo __('Date/Heure'); ?></th>
      		<th><?php echo __('Numéro d’Arrivage'); ?></th>
      		<th><?php echo __('Action'); ?></th>
      		<th><?php echo __('Emplacement'); ?></th>
			 <th><?php echo __('Quantite'); ?></th>
      		<th><?php echo __('Commentaire'); ?></th>
      		<th><?php echo __('Groupe'); ?></th>
            <th><?php echo __('Utilisateur'); ?></th>
            <th><?php echo __('Arrivage'); ?></th>
              <th><?php echo __('BL'); ?></th>
        </tr>
    </thead>

    <tbody>
        <?php foreach ($mouvements as $mouvement): ?>
            <tr>
                <td><?php echo date('d/m/Y H:i:s', strtotime($mouvement->getHeurePrise())) ?></td>
            	<td style="mso-number-format:\@;" class="text"><?php echo $mouvement->getRefProduit() ?></td>
            	<td><?php echo $mouvement->getType() ?></td>
            	<td><?php echo ($mouvement->getRefEmplacement() ? $mouvement->getRefEmplacement()->getLibelle() : $mouvement->getCodeEmplacement()) ?></td>
					<td><?php echo ($mouvement->getQuantite() != "")? $mouvement->getQuantite() : 1 ?></td>
            	<td><?php echo ($mouvement->getCommentaire() != "")? $mouvement->getCommentaire() : 'N/C' ?></td>
            	<td><?php echo $mouvement->getGroupe() ?></td>
                <td><?php echo (isset($users[$mouvement->getIdUtilisateur()]) ? $users[$mouvement->getIdUtilisateur()] : $mouvement->getIdUtilisateur()) ?></td>
                <td><?php echo ($mouvement->getWrkArrivageProduit()) ? $mouvement->getWrkArrivageProduit()->getRefProduit() : 'Absent' ?></td>
                <td style="mso-number-format:\@;" class="text"><?php echo ($mouvement->getWrkArrivageProduit() && $mouvement->getWrkArrivageProduit()->getWrkArrivage()) ? $mouvement->getWrkArrivageProduit()->getWrkArrivage()->getCommandeAchat() : 'Absent' ?></td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>
<br/>

<div class="foot" style="font-size:9pt;"><!--style="width:500px; margin-left:auto; margin-right:auto;"-->
    <span >© <?php echo date('Y') ?> - GTracking® | Logiciel de pilotage et gestion de marchandise</span>
</div>
</body>