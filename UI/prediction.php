<?php include 'header.php'; ?>
        <div id="mainContent">

<div class="row">
  <div class="col-md-6">
    <form>
      <div class="form-group">
        <label for="start">Day</label>
        <select id="day" class="form-control">
          <option selected="selected" value="1">Monday</option>
          <option value="2">Tuesday</option>
          <option value="3">Wednesday</option>
          <option value="4">Thursday</option>
          <option value="5">Friday</option>
          <option value="6">Saturday</option>
          <option value="7">Sunday</option>
        </select>
        <label for="start">Start Hour</label>
        <input type="number" class="form-control" id="start" min="0" max="23" value="9">
        <label for="end">End Hour</label>
        <input type="number" class="form-control" id="end" min="0" max="23" value="10">
        <input type="submit">
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

        var DAYS = ["Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday", "Sunday"];

          var data = [];

          // Get form data and call getData function on form submit without page refresh
          $( "form" ).submit(function( event ) {
            event.preventDefault();
            var url = "https://classroom-air-quality-system.eu-gb.mybluemix.net/api/prediction?day="+$('#day').val()+"&start_hour=";
            if ($('#start').val() < 10){
              url += "0";
            }
            url += $('#start').val()+"&end_hour=";
            if ($('#end').val() < 10){
              url += "0";
            }
            url += $('#end').val();
            getData(url);
          });


          // Gets data from specified URL
          function getData(url){
            // Uses proxy.php to overcome .htaccess issues
            $.getJSON('./proxy.php', { url: url }, function (data) {

              var labels = [];
              var dataset = [];

              // Iterate over data
              data.forEach(function(o){
                dataset.push(o['quality']);
                var d = new Date( 1000*(1526245200 + o['timestamp']));  // Create new Date Object by taking Monday, May 14, 2018 12:00:00 AM as a reference point
                // Fixing unknown bug
                if (d.getDay() - 1 < 0){
                  var day = DAYS[d.getDay() - 1 + 7];
                }else{
                  var day = DAYS[d.getDay() - 1];
                }
                // Date into a convention to show as label
                labels.push( day + ', ' + d.getHours() + ':' + ((d.getMinutes()<10?'0':'') + d.getMinutes()) + ':' + ((d.getSeconds()<10?'0':'') + d.getSeconds()));
              });

              // Specify configs of Chart.js object
              var config = {
                type: 'line',
                data: {
                  labels: labels,
                  datasets: [{
                    label: 'Quality',
                    fill: false,
                    backgroundColor: window.chartColors.green,
                    borderColor: window.chartColors.green,
                    data: dataset,
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
                      display: true,
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
