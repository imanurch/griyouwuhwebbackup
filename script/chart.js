// GET DATA RIWAYAT ORGANIK PASSED BY PHP
var riwayatOrganik = JSON.parse(dataRiwayatOrganik);
const dataOrganikMap = new Map(Object.entries(riwayatOrganik));

const listOrganikMonth = [];
const listOrganikBobot = [];
dataOrganikMap.forEach((values, keys) => {
  listOrganikMonth.push(keys);
  listOrganikBobot.push(values);
});

// GET DATA RIWAYAT ANORGANIK PASSED BY PHP
var riwayatAnorganik = JSON.parse(dataRiwayatAnorganik);
const dataAnorganikMap = new Map(Object.entries(riwayatAnorganik));

const listAnorganikMonth = [];
const listAnorganikBobot = [];
dataAnorganikMap.forEach((values, keys) => {
  listAnorganikMonth.push(keys);
  listAnorganikBobot.push(values);
});

// CHART
if (window.outerWidth < 1200) {
  Chart.defaults.font.size = 14;
}
if (window.outerWidth >= 1200 && window.outerWidth < 1600) {
  Chart.defaults.font.size = 17;
}
if (window.outerWidth >= 1600 && window.outerWidth < 1800) {
  Chart.defaults.font.size = 20;
}
if (window.outerWidth >= 1800) {
  Chart.defaults.font.size = 24;
}

var islinechart = document.getElementById("lineChart");
lineChartColor = getChartColorsArray("lineChart");
islinechart.setAttribute("width", islinechart.parentElement.offsetWidth);
Chart.defaults.font.size = 16;
Chart.defaults.font.family = "Poppins";
Chart.defaults.color = "#25581d";
var lineChart = new Chart(islinechart, {
  type: "line",
  data: {
    labels: listOrganikMonth,
    datasets: [
      {
        label: "Sampah Organik",
        fill: true,
        lineTension: 0.5,
        backgroundColor: lineChartColor[2],
        borderColor: lineChartColor[3],
        borderCapStyle: "butt",
        borderDash: [],
        borderDashOffset: 0.0,
        borderJoinStyle: "miter",
        pointBorderColor: lineChartColor[3],
        pointBackgroundColor: "#363853",
        pointBorderWidth: 1,
        pointHoverRadius: 5,
        pointHoverBackgroundColor: lineChartColor[3],
        pointHoverBorderColor: "#eef0f2",
        pointHoverBorderWidth: 2,
        pointRadius: 1,
        pointHitRadius: 10,
        data: listOrganikBobot,
      },
      {
        label: "Sampah Anorganik",
        color: "#363853",
        fill: true,
        lineTension: 0.5,
        backgroundColor: lineChartColor[0],
        borderColor: lineChartColor[1],
        borderCapStyle: "butt",
        borderDash: [],
        borderDashOffset: 0.0,
        borderJoinStyle: "miter",
        pointBorderColor: lineChartColor[1],
        pointBackgroundColor: "#F86956",
        pointBorderWidth: 1,
        pointHoverRadius: 5,
        pointHoverBackgroundColor: lineChartColor[1],
        pointHoverBorderColor: "#fff",
        pointHoverBorderWidth: 2,
        pointRadius: 1,
        pointHitRadius: 10,
        data: listAnorganikBobot,
      },
    ],
  },
  options: {
    devicePixelRatio: 4,
    maintainAspectRatio: false,
  },
});

function responsiveFonts() {
  if (window.outerWidth < 1200) {
    Chart.defaults.font.size = 14;
  }
  if (window.outerWidth >= 1200 && window.outerWidth < 1600) {
    Chart.defaults.font.size = 17;
  }
  if (window.outerWidth >= 1600 && window.outerWidth < 1800) {
    Chart.defaults.font.size = 20;
  }
  if (window.outerWidth >= 1800) {
    Chart.defaults.font.size = 24;
  }
  lineChart.update();
}
