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
            <th rowspan="2"><?php echo __('Numéro d’Arrivage'); ?></th>
            <th colspan="5"><?php echo __('Prise'); ?></th>
            <th colspan="5"><?php echo __('Dépose'); ?></th>
            <th colspan="2"><?php echo __('Délais'); ?></th>
        </tr>
        <tr class="entete">
            <th><?php echo __('Date/Heure'); ?></th>
            <th><?php echo __('Emplacement'); ?></th>
            <th><?php echo __('Commentaire'); ?></th>
            <th><?php echo __('Groupe'); ?></th>
            <th><?php echo __('Utilisateur'); ?></th>

            <th><?php echo __('Date/Heure'); ?></th>
            <th><?php echo __('Emplacement'); ?></th>
            <th><?php echo __('Commentaire'); ?></th>
            <th><?php echo __('Groupe'); ?></th>
            <th><?php echo __('Utilisateur'); ?></th>

            <th><?php echo __('Sans horaire d\'ouverture'); ?></th>
            <th><?php echo __('Avec horaire d\'ouverture'); ?></th>
        </tr>
    </thead>

    <tbody>
        <?php foreach ($mouvements as $mouvement): ?>
            <tr>

                <td style="mso-number-format:\@;" class="text"><?php echo $mouvement['ref_produit'] ?></td>

                <?php if (isset($mouvement['date_prise'])) { ?>
                    <td style="border-left: 2px solid black;"><?php echo date('d/m/Y H:i:s', strtotime($mouvement['date_prise'])) ?></td>
                    <td><?php echo (isset($emplacements[$mouvement['code_emplacement']]) ? $emplacements[$mouvement['code_emplacement']] : $mouvement['code_emplacement']) ?></td>
                    <td><?php echo ($mouvement['commentaire'] != "") ? $mouvement['commentaire'] : 'N/C' ?></td>
                    <td><?php echo $mouvement['groupe'] ?></td>
                    <td><?php echo (isset($users[$mouvement['id_utilisateur']]) ? $users[$mouvement['id_utilisateur']] : $mouvement['id_utilisateur']) ?></td>
                <?php } else { ?>
                    <td style="border-left: 2px solid black;">X</td>
                    <td>X</td>
                    <td>X</td>
                    <td>X</td>
                    <td>X</td>
                <?php } ?>
                <?php if (isset($mouvement['ref_produit_depose'])) { ?>
                    <td style="border-left: 2px solid black;"><?php echo date('d/m/Y H:i:s', strtotime($mouvement['date_depose'])) ?></td>
                    <td ><?php echo (isset($emplacements[$mouvement['code_emplacement_depose']]) ? $emplacements[$mouvement['code_emplacement_depose']] : $mouvement['code_emplacement_depose']) ?></td>
                    <td><?php echo ($mouvement['commentaire_depose'] != "") ? $mouvement['commentaire_depose'] : 'N/C' ?></td>
                    <td><?php echo $mouvement['groupe_depose'] ?></td>
                    <td><?php echo (isset($users[$mouvement['id_utilisateur_depose']]) ? $users[$mouvement['id_utilisateur_depose']] : $mouvement['id_utilisateur_depose']) ?></td>

                    <td style="border-left: 2px solid black;"><?php echo isset($mouvement['delais_transport_time']) ? $mouvement['delais_transport_time'] : "X" ?></td>
                    <td><?php echo isset($mouvement['delais_transport_horaire']) ? $mouvement['delais_transport_horaire'] : "X" ?></td>
                <?php } else { ?>
                    <td style="border-left: 2px solid black;">X</td>
                    <td>X</td>
                    <td>X</td>
                    <td>X</td>
                    <td>X</td>
                    <td style="border-left: 2px solid black;">X</td>
                    <td>X</td>
                <?php } ?>

            </tr>
        <?php endforeach; ?>
    </tbody>
</table>
<br/>

<div class="foot" style="font-size:9pt;"><!--style="width:500px; margin-left:auto; margin-right:auto;"-->
    <span >© <?php echo date('Y') ?> - GTracking® | Logiciel de pilotage et gestion de marchandise</span>
</div>
</body>