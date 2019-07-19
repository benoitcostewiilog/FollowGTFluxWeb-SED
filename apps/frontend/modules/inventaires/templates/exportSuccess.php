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
    table{
        border-collapse:collapse;
        border-width:0px;
    }
    td{
        padding-left:5px;
        pading-right:5px;
        font-size:9pt;
    }
    .bordure{
        border-width:1px;
        border-style:solid;
        border-color:silver;
    }
    tr.entete{
        background-color:#4D4D4D;
        color: #FFFFFF;
        font-weight: bold;
        text-align: center;
        padding: 2px;
        width:auto;
        font-size:9pt;
        border-width:1px;
        border-style:solid;
        border-color:silver;
    }
    .entete th,.entete td {
        border-width:1px;
        border-style:solid;
        border-color:silver;
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
        text-align:center;
        font-family: sans-serif;
    }
    .saut {
        page-break-after : always;
    }
    @media print {
        #saut{
            page-break-after : always;
        }
    }
</style>
<script type="text/javascript">

    function imprimer() {
        document.getElementById('printer').style.display = 'none';
        document.getElementById('back').style.display = 'none';
        history.back();
        window.print();
    }

    function checkPrint() {
        var print = <?php echo $print ?>;
        var tables = document.getElementsByTagName('table');
        if (print == '1') {
            for (var i = 0; i < tables.length; i++) {
                tables[i].style.width = "90%";
            }
            document.getElementsById('foot').style.display = "block";
        }
    }
</script>

<!-- Calcul du nombres d'elements -->
<?php
$nbElements=0;
foreach ($inventaires as $codeEmplacement => $emplacement) {
    foreach ($emplacement as $heure => $usersTab) {
        foreach ($usersTab as $userId => $produits) {
            $nbElements++;
        }
    }
}
$nbPages = ceil($nbElements / 20);
?>
<body onload="checkPrint()">
    <div>
<?php if ($print) {
    ?><img id="printer" src="<?php echo image_path('printer.png') ?>" onclick="imprimer();">
            <img id="back" src="<?php echo image_path('retour.png') ?>" onclick="history.back();"><?php }
?>
    </div>
    <table style="width:100%;margin-left:4px;">
        <tr>
            <td style="width:180px;"><img id="logo"  src="<?php  echo  image_path("mobilestock_flat_white.png")      ?>"></td> <!--  style="width:20px; height:20px;" -->
            <td><h1  style="font-size:13pt;">Historique des inventaires</h1></td>
        </tr>
    </table>
    <br/>
    <table style="width:100%;"  id="tableau">
        <thead  style="font-size:9pt;">
            <tr class="entete">
                <th style="width:180px;">Date du jour</th>
                <th>Filtres</th>
                <th style="width:70px">Page</th>
            </tr>
        </thead>
        <tbody  style="font-size:9pt;">
            <tr>
                <td style="width:150px;padding:10px 0px 10px 0px"><?php echo $date ?></td>
                <td>
                </td>
                <td style="width:70px">1 sur <?php echo $nbPages ?></td>
            </tr>
        </tbody>
    </table>
    <br/>

    <table style="width:100%;">
        <thead style="border-width:0px;" >
            <tr class="entete">
                <th><?php echo __('Emplacement'); ?></th>
                <th><?php echo __('Date'); ?></th>
                <th><?php echo __('Utilisateur'); ?></th>
                <th><?php echo __('Colis'); ?></th>
            </tr>
        </thead>
        <tbody>

<?php
$cpt = 0;
$cptNbPage = 1;
foreach ($inventaires as $codeEmplacement => $emplacement) {
    foreach ($emplacement as $heure => $usersTab) {
        foreach ($usersTab as $userId => $produits) {
            ?>

                        <?php
                        if ($cpt % 20 === 0 && $cpt != 0) {
                            $cptNbPage++;
                            ?>

                    </table><br/><br/><br/><br/>

                    <div class="foot"  style="font-size:9pt;">
                        <span >
                <?php
                if (!$print) {

                    echo ' - GTracking® | Logiciel de pilotage et gestion de marchandise ';
                }
                ?>
                        </span>
                    </div>
                    <div id="saut" style="display:block;page-break-after: always;">&nbsp;</div>

                    <table style="width:100%;margin-left:4px;">
                        <tr>
                            <td style="width:180px;"><img id="logo"  src="<?php echo  image_path("mobilestock_flat_white.png")      ?>"></td>
                            <td><h1  style="font-size:13pt;">Historique des inventaires</h1></td>
                        </tr>
                    </table>
                    <br/>
                    <table style="width:100%;"  id="tableau">
                        <thead  style="font-size:9pt;">
                            <tr class="entete">
                                <th style="width:180px;">Date du jour</th>
                                <th>Filtres</th>
                                <th style=";width:70px">Page</th>
                            </tr>
                        </thead>
                        <tbody  style="font-size:9pt;">
                            <tr>
                                <td style="width:150px;padding:10px 0px 10px 0px"><?php echo $date ?></td>
                                <td>
                                </td>
                                <td style="width:70px"><?php echo $cptNbPage . ' sur ' . $nbPages ?></td>
                            </tr>
                        </tbody>
                    </table>
                    <br/>

                    <table style="width:100%;">
                        <tr class="entete">
                            <th><?php echo __('Emplacement'); ?></th>
                            <th><?php echo __('Date'); ?></th>
                            <th><?php echo __('Utilisateur'); ?></th>
                            <th><?php echo __('Colis'); ?></th>
                        </tr>

                        <tr >
                            <td><?php echo $codeEmplacement ?></td>
                            <td><?php echo date('d/m/Y H:i:s', strtotime($heure)) ?></td>
                            <td><?php echo (isset($users[$userId]) ? $users[$userId] : $userId) ?></td>
                            <td ><?php echo count($produits) ?></td>

                        </tr>

            <?php } else { ?>
                        <tr >
                            <td><?php echo $codeEmplacement ?></td>
                            <td><?php echo date('d/m/Y H:i:s', strtotime($heure)) ?></td>
                            <td><?php echo (isset($users[$userId]) ? $users[$userId] : $userId) ?></td>
                            <td ><?php echo count($produits) ?></td>

                        </tr>
            <?php } ?>


            <?php
            $cpt++;
        }
    }
}
?>

    </table>
    <br/><br/>
    <div class="foot"  style="font-size:9pt;">
        <span>
<?php
if (!$print) {
    echo '©' . date('Y') . ' - GTracking® | Logiciel de pilotage et gestion de marchandise ';
}
?>
        </span>
    </div>
</body>