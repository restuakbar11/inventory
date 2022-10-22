 <?php
$refgr_id = urldecode($_GET['rid']);
 ?>
 <!-- Multiple Axis -->
            <div class="row clearfix">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="card">
                        <div class="header">
                            <h2>DEVICE FLOT CHART</h2>
                            <!-- <ul class="header-dropdown m-r--5">
                                <li class="dropdown">
                                    <a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                                        <i class="material-icons">more_vert</i>
                                    </a>
                                    <ul class="dropdown-menu pull-right">
                                        <li><a href="javascript:void(0);">Action</a></li>
                                        <li><a href="javascript:void(0);">Another action</a></li>
                                        <li><a href="javascript:void(0);">Something else here</a></li>
                                    </ul>
                                </li>
                            </ul> -->
                        </div>
                        <div class="body">
                            <div id="multiple_axis_chart" class="flot-chart"></div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- #END# Multiple Axis -->
			 <!-- Flot Chart Plugins Js -->
    <script src="plugins/flot-charts/jquery.flot.js"></script>
    <script src="plugins/flot-charts/jquery.flot.resize.js"></script>
    <script src="plugins/flot-charts/jquery.flot.pie.js"></script>
    <script src="plugins/flot-charts/jquery.flot.categories.js"></script>
    <script src="plugins/flot-charts/jquery.flot.time.js"></script>
<script>
    $(function () {
refgr_id = "<?php echo $refgr_id; ?>";
//MULTIPLE AXIS ======================================================================================
    f_voltage();
    function f_voltage(){   
var v = [];
     //var voltage = [];
        kd_kulkas = refgr_id;
          $.ajax({
          type: "POST", 
          url: "functions/refrigerator/f_refrigerator.php", 
          data: "act=getVoltage&kode_kulkas="+kd_kulkas,

      dataType: 'json', 
          success: function(result) { 
             for (var i = 0; i < result.length; i++) {
            datetime = result[i].datetime;
            suhu = result[i].voltage;
            v[i] = [datetime,suhu];
        
         }
         var voltage = v;
        f_power(voltage);
          }  
    
        });
    } 

    function f_power(vol){
        var volt = vol;
        var p = [];
     //var voltage = [];
        kd_kulkas = refgr_id;
          $.ajax({
          type: "POST", 
          url: "functions/refrigerator/f_refrigerator.php", 
          data: "act=getPower&kode_kulkas="+kd_kulkas,
      dataType: 'json', 
          success: function(result) { 
             for (var i = 0; i < result.length; i++) {
            datetime = result[i].datetime;
            suhu = result[i].power;
            p[i] = [datetime,suhu];
        
         }
        var power = p;
        f_temperature(volt,power);
          }  
    
        });
    }

        function f_temperature(vol,pwr){
        var volt = vol;
        var pwer = pwr;
        var t = [];
        kd_kulkas = refgr_id;
          $.ajax({
          type: "POST", 
          url: "functions/refrigerator/f_refrigerator.php", 
          data: "act=getTemperature&kode_kulkas="+kd_kulkas,
      dataType: 'json', 
          success: function(result) { 
             for (var i = 0; i < result.length; i++) {
            datetime = result[i].datetime;
            suhu = result[i].temperature;
            t[i] = [datetime,suhu];
        
         }
        var temperature = t;
        flowchart(volt,pwer,temperature);
          }  
    
        });
    }

    function flowchart(vol,pwr,temp){
        voltage =  vol;
    power = pwr;
    temperature = temp;
        $.plot('#multiple_axis_chart', [
        { data: voltage, label: 'Voltage (V)', color: '#E91E63' },
    { data: power, label: 'Power (VA)', color: '#5AC225' },
        { data: temperature, label: 'Temperature (C)', yaxis: 2, color: '#000000' }
    ], {
        xaxes: [{ mode: 'time' }],
        yaxes: [{ min: 0 }, {
            alignTicksWithAxis: 1,
            position: 'right',
            tickFormatter: euroFormatter
        }],
        grid: {
            hoverable: true,
            autoHighlight: false,
            borderColor: '#f3f3f3',
            borderWidth: 1,
            tickColor: '#f3f3f3'
        },
        legend: { position: 'sw' }
    });
    }    
    

    function euroFormatter(v, axis) {
        return v.toFixed(axis.tickDecimals) + 'C';
    }


    //====================================================================================================
})

</script>