

var querySpeedChart;
var drawConstellation = true;
var chartNotActivated = true;
$(document).ready(function () {
  var labelStrings = ['查询速度 (记录/秒 x10,000)', '客户端连接数', '写入速度 (记录/秒 x 100,000)', '客户端连接数'];
  var ctx1 = document.getElementById('chart-1');
  var ctx2 = document.getElementById('chart-2');
  querySpeedChart = new Chart(ctx1, {
    type: 'line',
    data: {
      datasets: [],
      labels: [1, 2, 3, 4, 5, 6, 7]
    },
    options: {
      responsive: true,
      scales: {
        yAxes: [{
          ticks: {
            min: 0,
            max: 2400
          },
          scaleLabel: {
            display: true,
            labelString: "Query Speed (Records/s x10,000)",
            fontSize: 15
          }
        }],
        xAxes: [{
          scaleLabel: {
            display: true,
            labelString: "Number of Client Connections",
            fontSize: 15
          }
        }]
      },
      animation: {
        duration: 1400
      },
      legend: {
        display: false
      },
      maintainAspectRatio: false
    }
  });
  writeSpeedChart = new Chart(ctx2, {
    type: 'line',
    data: {
      datasets: [],
      labels: [1, 2, 3, 4, 5, 6, 7]
    },
    options: {
      responsive: true,
      scales: {
        yAxes: [{
          ticks: {
            min: 0,
            max: 45
          },
          scaleLabel: {
            display: true,
            labelString: "Write Speed (Records/s x100,000)",
            fontSize: 15
          }
        }],
        xAxes: [{
          scaleLabel: {
            display: true,
            labelString: "Number of Client Connections",
            fontSize: 15
          }
        }]
      },
      animation: {
        duration: 1400
      },
      legend: {
        display: false
      },
      maintainAspectRatio: false
    }
  });

  if (siteLang == 'cn') {
    querySpeedChart.options.scales.yAxes[0].scaleLabel.labelString = labelStrings[0];
    querySpeedChart.options.scales.xAxes[0].scaleLabel.labelString = labelStrings[1];
    writeSpeedChart.options.scales.yAxes[0].scaleLabel.labelString = labelStrings[2];
    writeSpeedChart.options.scales.xAxes[0].scaleLabel.labelString = labelStrings[3];
  }

  activateScrollCheck();
  $(window).scroll(function () {
    // This is then function used to detect if the element is scrolled into view
    activateScrollCheck();
  });
});

function elementScrolled(elem) {
  var docViewTop = $(window).scrollTop() + window.innerHeight / 1.5;
  var bot = $(window).scrollTop();
  var elemTop = $(elem).offset().top;
  return elemTop <= $(window).scrollTop() + window.innerHeight / 2 && elemTop + $(elem).height() >= $(window).scrollTop();
}

function activateScrollCheck() {
  if (elementScrolled('#content-3') && chartNotActivated == true) {
    activateCharts();
    chartNotActivated = false;
  }
}

function generatedALegend(chart) {
  var text = [];
  text.push("<ul class='" + chart.id + "-legend chart-legend'>");

  for (var i = 0; i < chart.data.datasets.length; i++) {
    text.push("<li><div class='label-circle' style='background-color:" + chart.data.datasets[i].borderColor + "'></div><span>");

    if (chart.data.datasets[i].label) {
      text.push(chart.data.datasets[i].label);
    }

    text.push("</span></li>");
  }

  text.push("</ul>");
  return text.join("");
}

function activateCharts() {
  delayedPush(querySpeedChart, querySpeedDatasets, 0, 0, 5, $("#chart-1-legend-wrapper")); //querySpeedChart.generateLegend();

  delayedPush(writeSpeedChart, writeSpeedDatasets, 0, 0, 5, $("#chart-2-legend-wrapper"));
}

function delayedPush(chart, data, delay, iteration, endIteration, dom) {
  if (iteration > endIteration) {
    return;
  }

  chart.data.datasets.push(data[iteration]);
  chart.update();
  dom.html(generatedALegend(chart));
  setTimeout(function () {
    delayedPush(chart, data, delay, iteration + 1, endIteration, dom);
  }, delay);
}

var querySpeedDatasets = [{
  label: 'InfluxDB',
  data: [7.0589, 7.6530, 7.9680, 7.8500, 7.5235, 7.1687, 7.0138],
  borderColor: 'rgb(158,114,222)',
  backgroundColor: 'white',
  fill: false,
  pointRadius: 4,
  pointHoverRadius: 6,
  pointHoverBackgroundColor: 'white'
}, {
  label: 'OpenTSDB',
  data: [13.5436, 14.6488, 14.9329, 14.9808, 15.3441, 16.4561, 18.4580],
  borderColor: 'rgb(70,161,168)',
  backgroundColor: 'white',
  fill: false,
  pointRadius: 4,
  pointHoverRadius: 6,
  pointHoverBackgroundColor: 'white'
}, {
  label: 'Cassandra',
  data: [36.7788, 37.7244, 42.0378, 43.0227, 43.2190, 43.2179, 43.2162],
  borderColor: 'rgb(126,185,129)',
  backgroundColor: 'white',
  fill: false,
  pointRadius: 4,
  pointHoverRadius: 6,
  pointHoverBackgroundColor: 'white'
}, {
  label: 'MySQL',
  data: [72.1540, 74.2093, 72.7632, 72.7658, 74.9868, 75.5254, 74.9259],
  borderColor: 'rgb(242,165,65)',
  backgroundColor: 'white',
  fill: false,
  pointRadius: 4,
  pointHoverRadius: 6,
  pointHoverBackgroundColor: 'white'
}, {
  label: 'ClickHouse',
  data: [238.5712, 238.6898, 237.9902, 238.0021, 237.9399, 237.6074, 237.3440],
  borderColor: 'rgb(229,106,96)',
  backgroundColor: 'white',
  fill: false,
  pointRadius: 4,
  pointHoverRadius: 6,
  pointHoverBackgroundColor: 'white'
}, {
  label: 'TDengine',
  data: [1481.0521, 2019.0429, 2232.6609, 2058.3832, 2021.8376, 2031.7405, 2025.5069],
  borderColor: 'rgb(55,155,230)',
  backgroundColor: 'white',
  fill: false,
  pointRadius: 4,
  pointHoverRadius: 6,
  pointHoverBackgroundColor: 'white'
}];
var writeSpeedDatasets = [{
  label: 'InfluxDB',
  data: [1.08336, 1.37820, 1.54390, 1.57606, 1.55721, 1.42557, 1.45802],
  borderColor: 'rgb(158,114,222)',
  backgroundColor: 'white',
  fill: false,
  pointRadius: 4,
  pointHoverRadius: 6,
  pointHoverBackgroundColor: 'white'
}, {
  label: 'OpenTSDB',
  data: [0.21262, 0.20522],
  borderColor: 'rgb(70,161,168)',
  backgroundColor: 'white',
  fill: false,
  pointRadius: 4,
  pointHoverRadius: 6,
  pointHoverBackgroundColor: 'white'
}, {
  label: 'Cassandra',
  data: [0.04091, 0.25731, 0.35201, 0.40959, 0.44174, 0.45205, 0.46782],
  borderColor: 'rgb(126,185,129)',
  backgroundColor: 'white',
  fill: false,
  pointRadius: 4,
  pointHoverRadius: 6,
  pointHoverBackgroundColor: 'white'
}, {
  label: 'MySQL',
  data: [0.15701, 0.21020, 0.20571, 0.20349, 0.20082, 0.20138, 0.20064],
  borderColor: 'rgb(242,165,65)',
  backgroundColor: 'white',
  fill: false,
  pointRadius: 4,
  pointHoverRadius: 6,
  pointHoverBackgroundColor: 'white'
}, {
  label: 'ClickHouse',
  data: [11.95916, 16.77832, 18.15918, 19.47167, 19.01642, 17.64432, 18.43326],
  borderColor: 'rgb(229,106,96)',
  backgroundColor: 'white',
  fill: false,
  pointRadius: 4,
  pointHoverRadius: 6,
  pointHoverBackgroundColor: 'white'
}, {
  label: 'TDengine',
  data: [8.86653, 17.08037, 24.78045, 28.96079, 32.67590, 36.30836, 42.13323],
  borderColor: 'rgb(55,155,230)',
  backgroundColor: 'white',
  fill: false,
  pointRadius: 4,
  pointHoverRadius: 6,
  pointHoverBackgroundColor: 'white'
}];