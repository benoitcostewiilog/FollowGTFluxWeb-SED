<div class="ibox-content">
    <div class="row">
        <div class="<?php echo isset($labels) ? 'col-xs-6' : 'col-xs-12' ?> ">
            <h2><?php echo $titre ?></h2>
        </div>
        <?php if (isset($labels)) { ?>
            <div class="col-xs-3">
                <span class="label label-success" style="background-color: #dc030c;">  </span> &nbsp; <?php echo $labels[0]; ?>
                &nbsp;
            </div>
            <div class="col-xs-3">
                <span class="label label-info" style="background-color: #013972;">  </span> &nbsp; <?php echo $labels[1]; ?>
                &nbsp;
            </div>


        <?php } ?>
    </div>


    <div class="flot-chart">
        <div class="flot-chart-content" id="flot-bar-chart-<?php echo $id ?>"></div>
    </div>
    <br>
    <div class="text-center">
        <h3>
            <a id="precedent-<?php echo $id ?>">
                <i class="fa fa-arrow-circle-left fa-lg" style="color:#013972;"></i>
            </a>
            <?php echo $mois ?>/<?php echo $annee ?>
            <a id="suivant-<?php echo $id ?>">
                <i class="fa fa-arrow-circle-right fa-lg" style="color:#013972;"></i>
            </a>
            <!--            <br> <br>
                         <a id="print-<?php echo $id ?>">
                            <i class="fa fa-print fa-lg" style="color:#013972;"></i>
                        </a>-->
        </h3>
    </div>
</div>
<script>

    $(document).ready(function () {
        var arrayNbColisSeries2 = new Array();
        var arrayNbColis = new Array();
        var ticks = new Array();
        var i = 1;
<?php foreach ($nbColisParMois as $month => $value) { ?>
            tmpArray = new Array();
            tmpArray.push(<?php echo $value['ordre'] ?>);
            tmpArray.push(<?php echo $value['nbColis'] ?>);
            arrayNbColis.push(tmpArray);

            tmpArray = new Array();
            tmpArray.push(<?php echo $value['ordre'] ?>);
            tmpArray.push('<?php echo $value['name'] ?>');
            ticks.push(tmpArray);
    <?php
}
if (isset($nbColisSeries2)) {
    foreach ($nbColisSeries2 as $month => $value) {
        ?>
                tmpArray = new Array();
                tmpArray.push(<?php echo $value['ordre'] ?>);
                tmpArray.push(<?php echo $value['nbColis'] ?>);
                arrayNbColisSeries2.push(tmpArray);
    <?php }
    ?>

            var barData = [{color: ["#dc030c"], label: "<?php echo (isset($labels) ? $labels[0] : "") ?>", data: arrayNbColis},
                {label: "<?php echo (isset($labels) ? $labels[1] : "") ?>", data: arrayNbColisSeries2}
            ];
<?php } else { ?>
            var barData = [{
                    label: "bar",
                    data: arrayNbColis
                }];
<?php }
?>

        var barOptions = {
            series: {
                bars: {
                    show: true,
                    barWidth: 0.6,
                    fill: true,
                    fillColor: {
                        colors: [{
                                opacity: 0.8
                            }, {
                                opacity: 0.8
                            }]
                    }
                }
            },
            xaxis: {
                tickDecimals: 0,
                ticks: ticks
            },
            colors: ["#013972"],
            grid: {
                color: "#999999",
                hoverable: true,
                clickable: true,
                tickColor: "#D4D4D4",
                borderWidth: 0
            },
            legend: {
                show: false
            },
            tooltip: true,
            tooltipOpts: {
                content: "%y UM"
            }
        };
        var somePlot = $.plot($("#flot-bar-chart-<?php echo $id ?>"), barData, barOptions);
        $('#precedent-<?php echo $id ?>').click(function () {
            $.ajax({
                url: '<?php echo url_for('acceuil-reload-stats') ?>?type=<?php echo $id ?>&annee=<?php echo $annee ?>&mois=<?php echo $mois - 1 ?>',
                                success: function (data) {
                                    $('#<?php echo $id ?>').empty();
                                    $('#<?php echo $id ?>').append(data);
                                }
                            });
                        });

                        $('#suivant-<?php echo $id ?>').click(function () {
                            $.ajax({
                                url: '<?php echo url_for('acceuil-reload-stats') ?>?type=<?php echo $id ?>&annee=<?php echo $annee ?>&mois=<?php echo $mois + 1 ?>',
                                                success: function (data) {
                                                    $('#<?php echo $id ?>').empty();
                                                    $('#<?php echo $id ?>').append(data);
                                                }
                                            });
                                        });


                                        //test impression export
//        $('#print-<?php echo $id ?>').click(function () {
//            var container = $('#flot-bar-chart-<?php echo $id ?>');
//            var printWindow = window.open('', 'PrintMap');
//            //Create a new HTML document.
//            printWindow.document.write('<html><head><title>DIV Contents</title>');
//            printWindow.document.write('</head><body>');
//            printWindow.document.write("<link href=\"/css/style.css\" media=\"all\" type=\"text/css\" rel=\"stylesheet\">");
//            printWindow.document.write("<link href=\"/css/bootstrap.min.css\" media=\"all\" type=\"text/css\" rel=\"stylesheet\">");
//             var canvas = somePlot.getCanvas();
//        var img = canvas.toDataURL("image/png");
//        printWindow.document.write('<img src="'+img+'"/>');
//    printWindow.document.write($(container).html());
//            printWindow.document.write('</body></html>');
//            printWindow.document.close();
//            printWindow.print();
//            printWindow.close();
//
//        });
                                    });

</script>
