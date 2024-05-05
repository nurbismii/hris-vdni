$(function() {
  'use strict';

  var options = {
    scales: {
      yAxes: [{
        ticks: {
          beginAtZero: true
        },
        gridLines: {
          color: "rgba(204, 204, 204,0.1)"
        }
      }],
      xAxes: [{
        gridLines: {
          color: "rgba(204, 204, 204,0.1)"
        }
      }]
    },
    legend: {
      display: false
    },
    elements: {
      point: {
        radius: 0
      }
    }
  };

  var doughnutPieDataLaporanWilayah = {
    datasets: [{
      data: jumlah_karyawan,
      backgroundColor: [
        'rgba(54, 162, 235, 0.5)',
        'rgba(255, 99, 132, 0.5)',
        'rgba(255, 206, 86, 0.5)',
        'rgba(153, 102, 255, 0.5)',
        'rgba(255, 159, 64, 0.5)',
        'rgba(54, 162, 235, 0.2)',
        'rgba(75, 192, 192, 0.2)',
        'rgba(255, 159, 64, 0.2)',
        'rgba(153, 102, 255, 0.2)',
        'rgba(255, 99, 132, 0.2)',
        'rgba(255, 206, 86, 0.2)',
      ],
      borderColor: [
        'rgba(54, 162, 235, 1)',
        'rgba(255,99,132,1)',
        'rgba(255, 206, 86, 1)',
        'rgba(153, 102, 255, 1)',
        'rgba(255, 159, 64, 1)',
        'rgba(54, 162, 235, 1)',
        'rgba(75, 192, 192, 1)',
        'rgba(255, 159, 64, 1)',
        'rgba(153, 102, 255, 1)',
        'rgba(255,99,132,1)',
        'rgba(255, 206, 86, 1)',
      ],
    }],

    // These labels appear in the legend and in the tooltips when hovering different arcs
    labels: nama_kelurahan
  };

  const polarAreaOptions = {
    options: {
      responsive: true,
      scales: {
        r: {
          pointLabels: {
            display: true,
            centerPointLabels: true,
            font: {
              size: 18
            }
          }
        }
      },
      plugins: {
        legend: {
          position: 'top',
        },
        title: {
          display: true,
          text: 'Chart.js Polar Area Chart With Centered Point Labels'
        }
      }
    },
  };

  if ($("#pieLaporanWilayah").length) {
    var pieChartCanvasLaporanWilayah = $("#pieLaporanWilayah").get(0).getContext("2d");
    var pieLaporanWilayah = new Chart(pieChartCanvasLaporanWilayah, {
      type: 'polarArea',
      data: doughnutPieDataLaporanWilayah,
      options: polarAreaOptions
    });
  }

});