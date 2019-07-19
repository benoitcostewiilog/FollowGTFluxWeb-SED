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
    <td><h1  style="font-size:13pt;">Historique des réceptions</h1></td>
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
            <th><?php echo __('N° arrivage') ?></th>
            <th><?php echo __('N° reception') ?></th>
            <th><?php echo __('Date de création') ?></th>
            <th><?php echo __('Utilisateur'); ?></th>
        </tr>
    </thead>

    <tbody>
        <?php foreach ($assBR as $reception): ?>
            <tr>
                <td><?php echo $reception->getRefProduit() ?></td>
                <td style="mso-number-format:\@;" class="text"><?php echo $reception->getBrSap() ?></td>
                <td><?php echo date('d/m/Y H:i:s', strtotime($reception->getCreatedAt())) ?></td>
                <td><?php echo (isset($users[$reception->getIdUtilisateur()]) ? $users[$reception->getIdUtilisateur()] : $reception->getIdUtilisateur()) ?></td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>
<br/>

<div class="foot" style="font-size:9pt;">
    <span >© <?php echo date('Y') ?> - GTracking® | Logiciel de pilotage et gestion de marchandise</span>
</div>
</body>