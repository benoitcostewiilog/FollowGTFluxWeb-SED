<div class="ibox-content">
    <div class="row">
        <div class="col-xs-4">
            <h2><?php echo "Arrivages (UM)" ?></h2>
        </div>
        <div class="col-xs-3">
            <span class="label label-success" style="background-color: #99CCFF;">  </span> &nbsp; <?php echo "Nb arrivages"; ?>
            &nbsp;
        </div>
        <div class="col-xs-3">
            <span class="label label-info" style="background-color: #0000CC;">  </span> &nbsp; <?php echo "Taux de scan"; ?>
            &nbsp;
        </div>
        <div class="col-xs-2">
            <span class="label label-info" style="background-color: #00CC00;">  </span> &nbsp; <?php echo "Objectif"; ?>
            &nbsp;
        </div>

    </div>


    <div class="flot-chart">
        <div class="flot-chart-content" id="flot-volumetrie-arrivage"></div>
    </div>
    <br>
    <div class="text-center">
        <h3>
            <a id="precedent-volumetrie-arrivage">
                <i class="fa fa-arrow-circle-left fa-lg" style="color:#013972;"></i>
            </a>
            <?php echo $mois ?>/<?php echo $annee ?>
            <a id="suivant-volumetrie-arrivage">
                <i class="fa fa-arrow-circle-right fa-lg" style="color:#013972;"></i>
            </a>
        </h3>
    </div>
</div>
<script>

    $(document).ready(function () {

        var arrayNbColisSeries2 = new Array();
        var arrayNbColis = new Array();
        var ticks = new Array();
        var objectifs = new Array();
        var i = 1;
<?php foreach ($nbArrivage as $month => $value) { ?>
            tmpArray = new Array();
            tmpArray.push(<?php echo $value['ordre'] ?>);
            tmpArray.push(<?php echo $value['nbColis'] ?>);
            arrayNbColis.push(tmpArray);

            tmpArray = new Array();
            tmpArray.push(<?php echo $value['ordre'] ?>);
            tmpArray.push('<?php echo $value['name'] ?>');
            ticks.push(tmpArray);

            tmpArray = new Array();
            tmpArray.push(<?php echo $value['ordre'] ?>);
            tmpArray.push('<?php echo 90 ?>');
            objectifs.push(tmpArray);
    <?php
}
foreach ($nbReceptionne as $month => $value) {
    $percent = 100;
    if (isset($nbArrivage[$month])) {
        if ($nbArrivage[$month]['nbColis'] != 0) {
            $percent = $value['nbColis'] / $nbArrivage[$month]['nbColis'] * 100;
        }
    }
    ?>
            tmpArray = new Array();
            tmpArray.push(<?php echo $value['ordre'] ?>);
            tmpArray.push(<?php echo $percent ?>);
            arrayNbColisSeries2.push(tmpArray);
<?php }
?>

        var barData = [
            {color: ["#99CCFF"], label: "Arrivage", data: arrayNbColis, yaxis: 1, bars: {
                    show: true,
                    barWidth: 0.6,
                    fill: true,
                    align: "center",
                    fillColor: {
                        colors: [{
                                opacity: 0.9
                            }, {
                                opacity: 0.9
                            }]
                    }
                }},
            {color: ["#0000CC"], label: "Réceptionné", data: arrayNbColisSeries2, yaxis: 2,
                lines: {
                    lineWidth: 2,
                    show: true
                }, points: {
                    show: true
                }
            },
            {color: ["#00CC00"], label: "Objectif", data: objectifs, yaxis: 2,
                lines: {
                    lineWidth: 2,
                    show: true
                }
            }

        ];

        var barOptions = {
            xaxis: {
                tickDecimals: 0,
                ticks: ticks
            },
            yaxes: [{},
                {
                    position: "right",
                    min: 0,
                    max: 100,
                    ticks:[0,25,50,75,90,100],
                    //tickSize:10,
                    tickFormatter: function (v, axis) {
                        return v.toFixed(2) + "%";
                    }
                }
            ],
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
                content: "%y"
            }
        };
        var somePlot = $.plot($("#flot-volumetrie-arrivage"), barData, barOptions);

        $('#precedent-volumetrie-arrivage').click(function () {
            $.ajax({
                url: '<?php echo url_for('acceuil-reload-stats') ?>?type=volumetrie-arrivage&annee=<?php echo $annee ?>&mois=<?php echo $mois - 1 ?>',
                                success: function (data) {
                                    $('#volumetrie-arrivage').empty();
                                    $('#volumetrie-arrivage').append(data);
                                }
                            });
                        });

                        $('#suivant-volumetrie-arrivage').click(function () {
                            $.ajax({
                                url: '<?php echo url_for('acceuil-reload-stats') ?>?type=volumetrie-arrivage&annee=<?php echo $annee ?>&mois=<?php echo $mois + 1 ?>',
                                                success: function (data) {
                                                    $('#volumetrie-arrivage').empty();
                                                    $('#volumetrie-arrivage').append(data);
                                                }
                                            });
                                        });
                                    });
</script>