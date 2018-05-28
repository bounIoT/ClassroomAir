<?php include 'header.php'; ?>
        <div id="mainContent">

<div class="row">
  <div class="col-md-6">
    <h5>Sensor Values Between Specific Dates </h5>
    <form id="range-specific">
      <div class="form-group">
        <label for="start">Start Date</label>
        <input type="datetime-local" class="form-control" id="start" value="2018-05-14T13:00">
        <label for="end">End Date</label>
        <input type="datetime-local" class="form-control" id="end" value="2018-05-14T13:01">
        <label for="resolution">Resolution</label><br>
        <input type="number" id="resolution_specific" >
        <input type="submit" class="pull-right">
      </div>
    </form>
  </div>

  <div class="col-md-6">
    <h5>Sensor Values For The Last _ Hours </h5>
    <form id="range-hour">
      <div class="form-group">
        <label for="hour">Last _ Hour</label><br>
        <input type="number" id="hour" min="1" max="24"><br>
        <label for="resolution">Resolution</label><br>
        <input type="number" id="resolution_hour" >
        <input type="submit" class="pull-right">
      </div>
    </form>
  </div>
</div>

          <div style="width:100%;">
		<canvas id="canvas"></canvas>
	</div>
	<br>
	<br>

        </div>

        <script>

        var MONTHS = ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"];

          var data = [];

          // Get form data and call getData function on form submit without page refresh
          $( "#range-specific" ).submit(function( event ) {
            event.preventDefault();
            var url = "https://classroom-air-quality-system.eu-gb.mybluemix.net/api/data?start_date="+$('#start').val()+"&end_date="+$('#end').val()+"&resolution="+$('#resolution_specific').val();
            getData(url);
          });

          // Get form data and call getData function on form submit without page refresh
          $( "#range-hour" ).submit(function( event ) {
            event.preventDefault();
            var url = "https://classroom-air-quality-system.eu-gb.mybluemix.net/api/data?hour="+$('#hour').val()+"&resolution="+$('#resolution_hour').val();
            getData(url);
          });

          // Gets data from specified URL
          function getData(url){
            // Uses proxy.php to overcome .htaccess issues
            $.getJSON('./proxy.php', { url: url }, function (data) {

              var labels = [];
              var dataset1 = [];
              var dataset2 = [];
              var dataset3 = [];

              // Iterate over data and construct datasets and labels
              data.forEach(function(o){
                dataset1.push(o['temp']);
                dataset2.push(o['hum']);
                dataset3.push(o['quality']);
                var d = new Date( 1000*(o['timestamp']));
                labels.push(d.getDate() + ' ' + MONTHS[d.getMonth()] + ', ' + d.getHours() + ':' + ((d.getMinutes()<10?'0':'') + d.getMinutes()) + ':' + ((d.getSeconds()<10?'0':'') + d.getSeconds()));
              });

              // Specify configs of Chart.js object
              var config = {
                type: 'line',
                data: {
                  labels: labels,
                  datasets: [{
                    label: 'Temperature',
                    backgroundColor: window.chartColors.red,
                    borderColor: window.chartColors.red,
                    data: dataset1,
                    fill: false,
                    yAxisID: 'temp',
                  }, {
                    label: 'Humidity',
                    fill: false,
                    backgroundColor: window.chartColors.blue,
                    borderColor: window.chartColors.blue,
                    data: dataset2,
                    yAxisID: 'hum',
                  }, {
                    label: 'Quality',
                    fill: false,
                    backgroundColor: window.chartColors.green,
                    borderColor: window.chartColors.green,
                    data: dataset3,
                    yAxisID: 'quality',
                  }]
                },
                options: {
                  responsive: true,
                  tooltips: {
                    mode: 'index',
                    intersect: false,
                  },
                  hover: {
                    mode: 'nearest',
                    intersect: true
                  },
                  scales: {
                    xAxes: [{
                      display: true,
                      scaleLabel: {
                        display: true,
                        labelString: 'Time'
                      }
                    }],
                    yAxes: [{
                      id: 'temp',
                      display: true,
                      scaleLabel: {
                        display: true,
                        labelString: 'Temperature Value'
                      }
                    },
                    {
                      id: 'hum',
                      display: true,
                      scaleLabel: {
                        display: true,
                        labelString: 'Humidity Value'
                      }
                    },
                    {
                      id: 'quality',
                      display: true,
                      position:'right',
                      scaleLabel: {
                        display: true,
                        labelString: 'Quality Value'
                      }
                    }]
                  }
                }
              };

              var ctx = document.getElementById('canvas').getContext('2d');
              // If any chart created before, destroy it before creating a new one.
              if (window.myLine) {
                window.myLine.destroy();
              }
              window.myLine = new Chart(ctx, config);   // Create Chart.js object with specified config

          });
          }


          </script>

<?php include 'footer.php'; ?>
