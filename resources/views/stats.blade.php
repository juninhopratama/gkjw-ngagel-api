<html lang="en">
  <head>
    <title>Keterisian Ibadah {{$next}}</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
  </head>
  <body>

    <div class="container p-5 align-items-center justify-content-center">
        <h5>Keterisian Kuota Kursi Ibadah Minggu, {{$next}}</h5>

        <div id="piechart" style="width: 900px; height: 500px;"></div>
    </div>
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript">
        google.charts.load('current', {'packages':['corechart']});
        google.charts.setOnLoadCallback(drawChart);

        function drawChart() {

        var data = google.visualization.arrayToDataTable([
            ['Category', 'Quantity'],
            ['Kuota', {{ $quota }}],
            ['Terdaftar', {{ $registered }}]
        ]);

          var options = {
            title: 'Keterisian Kuota',
            is3D: false,
          };

          var chart = new google.visualization.PieChart(document.getElementById('piechart'));

          chart.draw(data, options);
        }
      </script>
</body>
</html>