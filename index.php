<html>

<head>
	<title>Arduino.adxl335 chart</title>
	 <script src="../js/jquery.min.js"></script>
	<script src="../js/Chart.min.js"></script>
	<script src="../js/utils.js"></script>
	<script src="../js/chartjs-plugin-zoom.js"></script>
	<script src="../js/chartjs-plugin-streaming.js"></script>
	
	
    <!-- <script src="https://code.jquery.com/jquery-3.4.1.js"></script> -->
	<style>
	canvas{
		-moz-user-select: none;
		-webkit-user-select: none;
		-ms-user-select: none;
	}
	#reloj { width: 150px; height: 30px; padding: 5px 10px; border: 1px solid black; 
         font: bold 1.5em dotum, "lucida sans", arial; text-align: center;
         float: right; margin: 1em 3em 1em 1em; }
	</style>
	
</head>

<body>
	<div style="width:75%;">
		<canvas id="canvas"></canvas>
	</div>
		
    <div id="reloj">
   00 : 00 : 00
  </div>
	<script>
	  function getData(url) {
        obj = {id: [], datax: [], datay: [], dataz: []};
        var id = [], datax = [],datay = [],dataz = [];

        var jsonData = $.ajax({
          url: url,
          dataType: 'json',
          async: false
        }).done(function (results) {
          // Split timestamp and data into separate arrays
          results.forEach(function(packet) {
            id.push(packet.id);
            datax.push(packet.datox);
            datay.push(packet.datoy);
            dataz.push(packet.datoz);
            
          });
        });
        obj["id"] = id;
        obj["datax"] = datax;
        obj["datay"] = datay;
        obj["dataz"] = dataz;
        return obj;
      }

	     Chart.defaults.global.defaultFontSize = 18;
		 var datosadxl335 = getData('getvalores.php?q=y');
		 
		var config = {
		    labels : datosadxl335.id,
			datasets: [{
					label: 'datos x',
					backgroundColor: window.chartColors.red,
					borderColor: window.chartColors.red,
					data:datosadxl335.datax,
					fill: false,
				
				},
				{
					label: 'datos y',
					backgroundColor: window.chartColors.green,
					borderColor: window.chartColors.green,
					data:datosadxl335.datay,
					fill: false,
				
				},
				{
					label: 'datos z',
					backgroundColor: window.chartColors.blue,
					borderColor: window.chartColors.blue,
					data:datosadxl335.dataz,
					fill: false,
				}]
			};
			
      // Get the context of the canvas element we want to select
      var ctx = document.getElementById("canvas").getContext("2d");
      var adxl335Chart = new Chart(ctx, {
        type: 'line',
        data: config,
        animation:{
          animateScale: true
        },
			options: {
				responsive: true,
				title: {
					display: true,
					text: 'Arduino.adxl335'
				},
				tooltips: {
					mode: 'index',
					intersect: false,
				},
				hover: {
					mode: 'nearest',
					intersect: false
				},
				scales: {
					xAxes: [{					   
						display: true,
						scaleLabel: {
							display: true,
							labelString: 'id'
						},
						ticks: {
							reverse: true 
						}
					}],
					yAxes: [{
					     ticks: {
                        beginAtZero: false
                            },
						display: true,
						scaleLabel: {
							display: true,
							labelString: 'adxl335: X, Y, Z'
						}
					}]
				},
				pan: {
					enabled: false,
					mode: 'x',
					rangeMax: {
						x: 4000
					},
					rangeMin: {
						x: 0
					}
				},
				zoom: {
					enabled: false,
					mode: 'x',
					rangeMax: {
						x: 20000
					},
					rangeMin: {
						x: 10000
					}
				}
			}
		});

		
				
		function actual() {
         fecha2=new Date(); //Actualizar fecha.
         hora=fecha2.getHours(); //hora actual
         minuto=fecha2.getMinutes(); //minuto actual
         segundo=fecha2.getSeconds(); //segundo actual
         if (hora<10) { //dos cifras para la hora
            hora="0"+hora;
            }
         if (minuto<10) { //dos cifras para el minuto
            minuto="0"+minuto;
            }
         if (segundo<10) { //dos cifras para el segundo
            segundo="0"+segundo;
            }
         //ver en el recuadro del reloj:
         mireloj = hora+" : "+minuto+" : "+segundo;	
				 return mireloj; 
         }
         function actualizar() { //función del temporizador
          mihora=actual(); //recoger hora actual
           mireloj=document.getElementById("reloj"); //buscar elemento reloj
           mireloj.innerHTML=mihora; //incluir hora en elemento
         
	      }
	       setInterval(function(){

        var updatedatosadxl335 = getData('getvalores.php?q=y');
        adxl335Chart.data.labels = updatedatosadxl335.id;
        adxl335Chart.data.datasets[0].data = updatedatosadxl335.datax;
        adxl335Chart.data.datasets[1].data = updatedatosadxl335.datay;
        adxl335Chart.data.datasets[2].data = updatedatosadxl335.dataz;
        adxl335Chart.update();
        actualizar();
         }, 1000);
         
			  

	</script>
	
 </body>

</html>

