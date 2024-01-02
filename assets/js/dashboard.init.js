function getChartColorsArray(e) {
  if (null !== document.getElementById(e)) {
    var r = document.getElementById(e).getAttribute("data-colors");
    return (r = JSON.parse(r)).map(function (e) {
      var r = e.replace(" ", "");
      if (-1 == r.indexOf("--")) return r;
      var t = getComputedStyle(document.documentElement).getPropertyValue(r);
      return t || void 0;
    });
  }
}
var barchartColors = getChartColorsArray("mini-1"),
  sparklineoptions1 = {
    series: [{ data: [12, 14, 2, 47, 42, 15, 47, 75, 65, 19, 14] }],
    chart: { type: "area", width: 110, height: 35, sparkline: { enabled: !0 } },
    fill: { type: "gradient", gradient: { shadeIntensity: 1, inverseColors: !1, opacityFrom: 0.45, opacityTo: 0.05, stops: [20, 100, 100, 100] } },
    stroke: { curve: "smooth", width: 2 },
    colors: barchartColors,
    tooltip: {
      fixed: { enabled: !1 },
      x: { show: !1 },
      y: {
        title: {
          formatter: function (e) {
            return "";
          },
        },
      },
      marker: { show: !1 },
    },
  };
