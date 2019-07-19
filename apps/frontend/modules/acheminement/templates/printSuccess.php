<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <link href="/css/bootstrap.css" media="all" type="text/css" rel="stylesheet">
        <script src="/js/jquery-2.1.1.js"></script>
        <script src="/js/plugins/barcode/jquery-barcode.min.js"></script>
        <style>
            table, tr, td, th{border-width:0.2mm;border-style:solid;border-color:black;border-collapse:collapse;text-align:center;vertical-align:middle;margin-left: 0px;margin-right: auto;}
            table{border-collapse:collapse;border-width:0px;}
            td{padding-left:5px;pading-right:5px;font-size:9pt;}
            tr.entete{background-color:#4D4D4D;color: #FFFFFF;font-weight: bold;text-align: center;padding: 2px;width:auto;font-size:9pt;border-width:1px;border-style:solid;border-color:silver;}
            .entete th,.entete td{border-width:1px;border-style:solid;border-color:silver;}
            #printer{width:45px;height:45px;opacity:0.5;position:fixed;top:50px;right:50px;text-indent:-9999px;cursor:pointer;}
            body{font-family: sans-serif;font-size: 11pt;}
            #back {width:45px;height:45px;opacity:0.5;position:fixed;top:100px;right:50px;text-indent:-9999px;cursor:pointer;}
            h1{padding-left:10;padding-left:10;}
            .saut{page-break-after : always;}
            .tr{height: 15mm;}
            @media print {
                #saut{page-break-after : always;}
                a[href]:after {content: " (" attr(href) ")";}
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
    <body id="content" style="width:210mm;height:280mm;">
        <div>
            <img id="printer" src="<?php echo image_path('printer.png') ?>" onclick="imprimer();">
            <img id="back" src="<?php echo image_path('retour.png') ?>" onclick="history.back();">
        </div>
          
<?php 
        $i = 1;
        $nbCol = count($listeColis);
        foreach ($listeColis as $colis ){ ?>    
        
            <p><h4 style="text-align: right;"><?php echo 'Colis N° '.$i.' / '.$nbCol ?></h4></p>
            <p><img style="float:left;width:30%;margin-left:74px;" src="<?php echo image_path("mobilestock_flat_white.png"); ?>" alt=""/></p>
            <div style="float: left;margin-left: 20mm;">
                <h2>ACHEMINEMENT N°<?php echo ' '.$acheminement->getNumAcheminement() ?></h2>
                <h3>COLIS N° <?php echo ' '.$colis->getTracking() ?></h3>
                <div id="bcTarget<?php echo $colis->getNumeroColis() ?>" style="margin-left: -5mm;"></div>
                <table class="" style="width: 190mm;">
                    <tr >
                        <th class="text-center">Date / heure demande</th>
                        <td><?php echo date('d/m/Y H:i:s', strtotime($colis->getCreatedAt())) ?></td>
                    </tr>
                    <tr >
                        <th class="text-center">Désignation</th>
                        <td><?php echo $colis->getdesignation() ?></td>
                    </tr>
                    <tr >
                        <th class="text-center">Emplacement de prise</th>
                        <td><?php echo $acheminement->getCodeEmplacementPrise() ?></td>
                    </tr>
                    <tr >
                        <th class="text-center">Nbr. colis total</th>
                        <td><?php echo $acheminement->getNbColis() ?></td>
                    </tr>
                    <tr >
                        <th class="text-center">Emplacement de dépose</th>
                        <td><?php echo $acheminement->getCodeEmplacementDepose() ?></td>
                    </tr>
                    <tr >
                        <th class="text-center">Destinataire</th>
                        <td><?php echo $acheminement->getDestinataire() ?></td>
                    </tr>
                    <tr >
                        <th class="text-center">Demandeur</th>
                        <td><?php echo $acheminement->getDemandeur() ?></td>
                    </tr>
                </table>
            </div>
            <script>
                $(document).ready(function () {
                    var codeBar = '<?php echo $colis->getTracking() ?>';
                    var output = 'bmp';
                    var barWidth = 2;
                    var barHeight = 40;
                    var fontSize = 5;
                    $("#bcTarget"+<?php echo $colis->getNumeroColis() ?>).barcode(codeBar, "code128", {barWidth: barWidth, barHeight: barHeight, fontSize: fontSize, output: output});
                });
            </script>   
            <br clear=all style='mso-special-character:line-break;page-break-before:always'>
        
<?php   $i++; 
        } ?>    
    </body>
</html>