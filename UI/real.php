<?php include 'header.php'; ?>
        <div id="mainContent">
          <div style="width:100%;">
        		<canvas id="canvas"></canvas>
        	</div>
        	<br>
        	<br>

        </div>

        <script>

        var MONTHS = ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"];

          var data = [];

          // Data API url with default values.
          var url = "https://classroom-air-quality-system.eu-gb.mybluemix.net/api/data?hour=0.333333&resolution=1";
          getData(url); // Gets Data and create chart for the first view
          window.setInterval("getData(url)",10*1000);   // Calls getData function to update data every 10 seconds

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
