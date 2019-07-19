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
    <td><h1  style="font-size:13pt;">Numéro d’Arrivage en retard</h1></td>
</table>
<br/>
<table style="margin-left:-100px;width:950px;"  id="tableau">
    <thead  style="font-size:9pt;">
        <tr class="entete">
            <th style="width:180px;">Date du jour</th>
            <th style="width:70px">Plage d'export</th>
        </tr>
    </thead>
    <tbody  style="font-size:9pt;">
        <tr>
            <td style="width:150px;padding:10px 0px 10px 0px"><?php echo $date ?></td>
            <td style="width:70px"><?php echo date('d/m/Y', strtotime($dateDebut)) . " au " . date('d/m/Y', strtotime($dateFin)) ?></td>
        </tr>
    </tbody>
</table>
<br/>
<table style="margin-left:-100px;width:950px;" >
    <thead>
        <tr class="entete">
            <th rowspan="2">Numéro d’Arrivage</th>
            <th rowspan="2">Date d'arrivage</th>
            <th rowspan="2">Date de réception</th>
            <th rowspan="2">Date de dépose</th>
            <th colspan="3">Réception->Dépose</th>
        </tr>
        <tr class="entete">
            <th>Delais brut (sans horaire d'ouverture)</th>
            <th>Delais (avec horaire d'ouverture)</th>
            <th>Retard (avec horaire d'ouverture)</th>
        </tr>
    </thead>
    <tbody>
        <?php
        foreach ($uniteTracking as $ut) {
            ?>
            <tr>
                <td style="mso-number-format:\@;" class="text"><?php echo $ut['unite'] . " " ?></td>
                <td> <?php echo $ut['date_arrivage'] ? date('d/m/Y H:i:s', strtotime($ut['date_arrivage'])) : '' ?></td>
                <td> <?php echo date('d/m/Y H:i:s', strtotime($ut['date_reception'])) ?></td>
                <td> <?php echo $ut['date_depose'] ? date('d/m/Y H:i:s', strtotime($ut['date_depose'])) : '' ?></td>
                <td> <?php echo $ut['time_delais_acheminement'] ?></td>
                <td> <?php echo $ut['time_delais_acheminement_horaire'] ?></td>
                <td> <?php echo $ut['date_depose'] ? $ut['time_retard_depose'] : $ut['time_retard_sans_depose'] ?></td>
            </tr>
            <?php
        }
        ?>
    </tbody>
</table>
<br/>

<div class="foot" style="font-size:9pt;"><!--style="width:500px; margin-left:auto; margin-right:auto;"-->
    <span >© <?php echo date('Y') ?> - GTracking® | Logiciel de pilotage et gestion de marchandise</span>
</div>
</body>