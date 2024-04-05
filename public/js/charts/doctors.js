const chart = Highcharts.chart('container', {
    chart: {
        type: 'column'
    },
    title: {
        text: 'Gráfico de citas por Médico',
        align: 'left'
    },
    // subtitle: {
    //     text: 'Source: <a target="_blank" ' +
    //         'href="https://www.indexmundi.com/agriculture/?commodity=corn">indexmundi</a>',
    //     align: 'left'
    // },
    xAxis: {
        categories: [],
        crosshair: true,
        accessibility: {
            description: 'Mêdicos'
        }
    },
    yAxis: {
        min: 0,
        title: {
            text: 'Cantidad de Consultas'
        }
    },
    tooltip: {
        valueSuffix: ' (Consultas)'
    },
    plotOptions: {
        column: {
            pointPadding: 0.2,
            borderWidth: 0
        }
    },
    series: []
});

let $start, $end;

function fetchData() {
    const startDate = $start.val();
    const endDate = $end.val();
    const url = `/charts/doctors/column/data?start=${startDate}&end=${endDate}`;
    fetch(url)
        .then(response => response.json())
        .then(data => {
            chart.xAxis[0].setCategories(data.categories);

            if (chart.series.length > 0) {
                chart.series[0].remove()
                chart.series[1].remove()
            }
            chart.addSeries(data.series[0])//atendidas;
            chart.addSeries(data.series[1])//canceladas;
        })
}
$(function () {
    $start = $('#startDate');
    $end = $('#endDate');

    fetchData();

    $start.change(fetchData);
    $end.change(fetchData);
})