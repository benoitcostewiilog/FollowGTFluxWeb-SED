<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <link href="/css/bootstrap.css" media="all" type="text/css" rel="stylesheet">
        <script src="/js/jquery-2.1.1.js"></script>
        <script src="/js/plugins/barcode/jquery-barcode.js"></script>

        <style>
            table, tr, td, th {
                border-width:0.2mm;
                border-style:solid;
                border-color:black;
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
                a[href]:after {
                    content: " (" attr(href) ")";
                }
                body {-webkit-print-color-adjust: exact;}
            }
        </style>
        <script type="text/javascript">
            function imprimer() {
                document.getElementById('printer').style.display = 'none';
                document.getElementById('back').style.display = 'none';
                document.getElementById('content').style.border = '0px';
                history.back();
                window.print();
            }

        </script>
    </head>
    <body id="content" style="width:210mm;height:280mm; border:1px solid;">
        <div>
            <img id="printer" src="<?php echo image_path('printer.png') ?>" onclick="imprimer();">
            <img id="back" src="<?php echo image_path('retour.png') ?>" onclick="history.back();">

        </div>
        <table class="table-condensed" style="width:110mm;float: left;margin-top: 2mm;margin-left: 2mm;border:0px;">
            <tr style="border:0px;">
                <td style="border:0px;"><img style="width:100%;" id="logo"  src="<?php echo image_path("mobilestock_flat_white.png"); ?>"></td> <!--  style="width:20px; height:20px;" -->
            </tr>
        </table>
        <table class="table-condensed" style="width:80mm; height: 15mm; float: right; margin-top: 8mm;margin-bottom: 6mm; margin-right: 2mm;border:0px;">
            <tr style="border:0px;">
                <?php
// setlocale(LC_TIME, 'fr_FR');
// setlocale(LC_TIME, 'fr');
//setlocale(LC_TIME, 'fra_fra');
                setlocale(LC_TIME, 'fr_FR.UTF8');
                ?>
                <td class="" style="font-size: small;border:0px;"><b><?php echo strftime('%A %d %B %Y'); ?></b></td>
            </tr>
        </table>
        <table class="table-condensed" style="width:110mm;float: left; margin-top: 2mm;margin-left: 2mm;border:0px;">
            <tr style="border:0px;">
                <td style="border:0px;">
                    <div id="bcTarget" style="margin-left: 8mm;"></div>
                </td>
            </tr>
        </table>

        <div style="float: left;margin-top: 30mm;margin-left: 20mm;">
            <h2>Fiche chauffeur</h2>
            <table class="" style="width: 170mm;">
                <tr  style="height: 20mm;">
                    <th class="text-center" style="width: 170mm;font-size: medium">Identifiant</th>
                    <td style="width: 300px;font-size: medium;"><?php echo $ref_chauffeur->getIdChauffeur() ?></td>
                </tr>
                <tr style="height: 20mm;">
                    <th class="text-center" style="width: 170mm;font-size: medium">Nom</th>
                    <td style="width: 300px;font-size: medium"><?php echo $ref_chauffeur->getNom() ?></td>
                </tr>
                <tr style="height: 20mm;">
                    <th class="text-center" style="width: 170mm;font-size: medium">Prénom</th>
                    <td style="width: 300px;font-size: medium"><?php echo $ref_chauffeur->getPrenom() ?></td>
                </tr>
                <tr style="height: 20mm;">
                    <th class="text-center" style="width: 170mm;font-size: medium">N° document ID</th>
                    <td style="width: 170mm;font-size: medium"><?php echo $ref_chauffeur->getNumDocId() ?></td>
                </tr>
                <tr style="height: 20mm;">
                    <th class="text-center" style="width: 170mm;font-size: medium">Transporteur</th>
                    <td style="width: 170mm;font-size: medium"><?php echo $ref_chauffeur->getRefTransporteur()->getLibelle() ?></td>
                </tr>
            </table>
        </div>
        <div style="float: left;margin-top: 40mm;margin-left: 20mm;">
            <table style="width: 170mm;">
                <tr style="height: 20mm;">
                    <td class="" style="font-size: small"></td>
                </tr>
            </table> 
        </div>
        <div style="float: left;margin-left: 20mm;">
            <table style="width: 170mm;">
                <tr style="height: 20mm;border: 0px;">
                    <th class="text-center" style="width: 80mm; border-bottom: 0px;border-left: 0px;border-top: 0px;font-size: medium;">Signature</th>
                    <td style="width: 80mm;border: 0px;"></td>
                </tr>
            </table> 
        </div>
        <script>
            $(document).ready(function () {
                var codeBar = '<?php echo $ref_chauffeur->getIdChauffeur() ?>';
                var output = 'bmp';
                var barWidth = 5;
                var barHeight = 60;
                var fontSize = 13;
                $("#bcTarget").barcode(codeBar, "code128", {barWidth: barWidth, barHeight: barHeight, fontSize: fontSize, output: output});
            });
        </script>
    </body>
</html>