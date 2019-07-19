<div class="ibox-content">
    <h2>Temps moyens de transfert nomade</h2>
    <div class="flot-chart">
        <div class="flot-chart-content" id="flot-bar-chart-delais-ns"></div>
    </div>
</div>
<script>
    $(document).ready(function () {
        var arrayNbColis = new Array();
<?php foreach ($delaisNomadeSupervision as $month => $value) { ?>
            tmpArray = new Array();
            tmpArray.push(<?php echo $month ?>);
            tmpArray.push(<?php echo $value['moyenne'] ?>);
            arrayNbColis.push(tmpArray);
<?php } ?>

        var ticks = [[1, "Janvier"], [2, "Février"], [3, "Mars"], [4, "Avril"], [5, "Mai"], [6, "Juin"], [7, "Juillet"], [8, "Aout"], [9, "Septembre"], [10, "Octobre"], [11, "Novembre"], [12, "Décembre"]];
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
            colors: ["#1ab394"],
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
                content: "%y seconde(s)"
            }
        };
        var barData = {
            label: "bar",
            data: arrayNbColis
        };
        $.plot($("#flot-bar-chart-delais-ns"), [barData], barOptions);
    });

</script>
