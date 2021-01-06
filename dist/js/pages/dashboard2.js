$(function () {

  var MedicalChartCanvas = $('#medicalchart').get(0).getContext('2d');
  var MedicalChartData = {
    labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
    datasets: [{
        label: 'UMUM',
        backgroundColor: 'rgba(220,53,69,0.9)',
        borderColor: 'rgba(220,53,69,1)',
        pointRadius: false,
        pointColor: '#3B8BBA',
        pointStrokeColor: 'rgba(220,53,69,1.5)',
        pointHighlightFill: '#FFFFFF',
        pointHighlightStroke: 'rgba(220,53,69,1.5)',
        data: [100, 75, 50, 75, 100, 90, 60, 90, 100, 80, 40, 80]
      },
      {
        label: 'BPJS',
        backgroundColor: 'rgba(40,167,69,0.9)',
        borderColor: 'rgba(40,167,69,1)',
        pointRadius: false,
        pointColor: '#C1C7D1',
        pointStrokeColor: 'rgba(40,167,69,1.5)',
        pointHighlightFill: '#FFFFFF',
        pointHighlightStroke: 'rgba(40,167,69,1.5)',
        data: [40, 20, 40, 50, 45, 30, 45, 50, 37, 25, 38, 50]
      },
      {
        label: 'AQUA',
        backgroundColor: 'rgba(0,123,255,0.9)',
        borderColor: 'rgba(0,123,255,1)',
        pointRadius: false,
        pointColor: '#C1C7D1',
        pointStrokeColor: 'rgba(0,123,255,1.5)',
        pointHighlightFill: '#FFFFFF',
        pointHighlightStroke: 'rgba(0,123,255,1.5)',
        data: [50, 19, 25, 20, 50, 23, 30, 24, 50, 20, 20, 20]
      },
    ]
  }

  var MedicalChartOptions = {
    responsive: true,
    maintainAspectRatio: false,
    datasetFill: false
  }

  var MedicalChart = new Chart(MedicalChartCanvas, {
    type: 'bar',
    data: MedicalChartData,
    options: MedicalChartOptions
  })

})