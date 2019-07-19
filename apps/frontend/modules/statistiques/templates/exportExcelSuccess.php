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
    <td><h1  style="font-size:13pt;">Statistiques globales</h1></td>
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
              <th><?php echo __('N° d\'arrivage'); ?></th>
                                    <th><?php echo __('Date arrivage'); ?></th>
                                    <th><?php echo __('Zone Attente'); ?></th>
                                    <th><?php echo __('Date dépose ZA'); ?></th>
                                    <th><?php echo __('Unités'); ?></th>
                                    <th><?php echo __('Réception'); ?></th>
                                    <th><?php echo __('zone Attente'); ?></th>
                                    <th><?php echo __('Date dépose ZA'); ?></th>
                                    <th><?php echo __('Date 1ere dépose'); ?></th>
                                    <th><?php echo __('Zone 1ere dépose'); ?></th>
                                    <th><?php echo __('Date dépose suivante'); ?></th>
                                    <th><?php echo __('Délais brute'); ?></th>
                                    <th><?php echo __('Délais'); ?></th>
                                    <th><?php echo __('retard'); ?></th>
        </tr>
    </thead>

    <tbody>
        <?php  $nbRes = count($resultats);
                                        for ($i = 0; $i < $nbRes; $i++) { ?>
            <tr>
                  <td class="click"><?php echo $resultats[$i]['num_arrivage'] ?></td>
                                        <td class="click"><?php echo $resultats[$i]['date_arrivage'] ?></td>
                                        <td class="click"><?php echo $resultats[$i]['zone_attente1'] ?></td>
                                        <td class="click"><?php echo $resultats[$i]['date_attente1'] ?></td>
                                        <td style="mso-number-format:\@;" class="text"><?php echo $resultats[$i]['unite_tracking'] ?></td>
                                        <td class="click"><?php echo $resultats[$i]['date_reception'] ?></td>
                                        <td class="click"><?php echo $resultats[$i]['zone_attente2'] ?></td>
                                        <td class="click"><?php echo $resultats[$i]['date_attente2'] ?></td>
                                        <td class="click"><?php echo $resultats[$i]['date_depose'] ?></td>
                                        <td class="click"><?php echo $resultats[$i]['zone_depose'] ?></td>
                                        <td class="click"><?php echo $resultats[$i]['date_depose_suivante'] ?></td>
                                        <td class="click"><?php echo $resultats[$i]['delai_brut'] ?></td>
                                        <td class="click"><?php echo $resultats[$i]['delai'] ?></td>
                                        <td class="click"><?php echo $resultats[$i]['retard'] ?></td>
                                        
     
            </tr>
                                        <?php } ?>
    </tbody>
</table>
<br/>

<div class="foot" style="font-size:9pt;"><!--style="width:500px; margin-left:auto; margin-right:auto;"-->
    <span >© <?php echo date('Y') ?> - GTracking® | Logiciel de pilotage et gestion de marchandise</span>
</div>
</body>