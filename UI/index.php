<?php include 'header.php'; ?>
        <div id="mainContent">
          <div class="row gap-20 masonry pos-r">
            <div class="masonry-sizer col-md-6"></div>
            <div class="masonry-item w-100">
              <div class="row gap-20">
                <div class="col-md-2">
                  <div class="layers bd bgc-white p-20">
                    <div class="layer w-100 mB-10">
                      <h6 class="lh-1">Temperature</h6></div>
                    <div class="layer w-100">
                      <div class="peers ai-sb fxw-nw">
                        <div class="peer"><span id="temp" class="d-ib lh-0 va-m fw-600 bdrs-10em pX-15 pY-15 bgc-green-50 c-green-500">NaN</span></div>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="col-md-2">
                  <div class="layers bd bgc-white p-20">
                    <div class="layer w-100 mB-10">
                      <h6 class="lh-1">Humidity</h6></div>
                    <div class="layer w-100">
                      <div class="peers ai-sb fxw-nw">
                        <div class="peer"><span id="hum" class="d-ib lh-0 va-m fw-600 bdrs-10em pX-15 pY-15 bgc-red-50 c-red-500">NaN</span></div>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="col-md-2">
                  <div class="layers bd bgc-white p-20">
                    <div class="layer w-100 mB-10">
                      <h6 class="lh-1">Quality</h6></div>
                    <div class="layer w-100">
                      <div class="peers ai-sb fxw-nw">
                        <div class="peer"><span id="quality" class="d-ib lh-0 va-m fw-600 bdrs-10em pX-15 pY-15 bgc-purple-50 c-purple-500">NaN</span></div>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="layers bd bgc-white p-20">
                    <div class="layer w-100 mB-10">
                      <h6 class="lh-1">Time</h6></div>
                    <div class="layer w-100">
                      <div class="peers ai-sb fxw-nw">
                        <div class="peer"><span id="timeago" class="d-ib lh-0 va-m fw-600 bdrs-10em pX-15 pY-15 bgc-blue-50 c-blue-500">NaN</span></div>
                        <div class="peer"><span id="time" class="d-ib lh-0 va-m fw-600 bdrs-10em pX-15 pY-15 bgc-gray-50 c-blue-100">NaN</span></div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>

        <script type="text/javascript">

          // Latest API Url
          var latest_url = 'https://classroom-air-quality-system.eu-gb.mybluemix.net/api/data/latest';

          getData();
          window.setInterval(getData,10*1000);  // Calls getData function to update data every 10 seconds

          function getData(){
            $('.va-m').html('Updating...');
            $.getJSON('./proxy.php', { url: latest_url }, function (data) {
              // var data = d;

              // Assign values from response json to variables. Example response:
              // {
              //    "_id":"b3d2731c4562041aa3be27e3fbcff3af",
              //    "_rev":"1-6b92b9f45bf4167c3af14d76de7c5705",
              //    "temp":25.299999,
              //    "hum":65.599998,
              //    "quality":399,
              //    "timestamp":1527354126
              // }
              var temp = data['temp'];
              var hum = data['hum'];
              var quality = data['quality'];
              var time = new Date(data['timestamp']*1000);  // Convert to Date Object. Multiplied by 1000 since API gives timestamp in sec.

              // Change views
              // toFixed is used to show only 2 decimal
              $('#temp').html(temp.toFixed(2) + ' &#8451;');
              $('#hum').html(hum.toFixed(2) + '%');
              $('#quality').html(quality.toFixed(2));
              $('#timeago').html(timeago().format(time));
              $('#time').html(time);

            })
            .fail(function( jqxhr, textStatus, error ) {
              var err = textStatus + ", " + error;
              console.log( "Request Failed: " + err );
            });
          }

          </script>
      <?php include 'footer.php'; ?>
