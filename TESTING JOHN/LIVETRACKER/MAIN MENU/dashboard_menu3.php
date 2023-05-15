<!DOCTYPE html>
<html>
    <head>
		<meta charset = "utf-8">
    	<meta name = "description" content = "meta description">
    	<meta name = "viewpport" content = "width=device-width, initial-scale = 1">
    	<title>Tracker Dashboard</title>
    	<script type = "text/javascript" src = "../../JS LIBS/THIRD PARTY/jquery-3.4.1.js"></script>
    	<script type = "text/javascript" src = "./JS_button_groups.js"></script>
		<link rel = "stylesheet" href = "../../css/LT_style.css">
		<link href='https://fonts.googleapis.com/css?family=Source+Sans+Pro' rel='stylesheet' type='text/css'>     
    <!--   <script src="https://cdn.fusioncharts.com/fusioncharts/latest/fusioncharts.js"></script> -->
    

    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.js"></script>
</script>
        <?php
            $qla_this = 0;
            $qla_this_time_last = 1;
            $qla_last = 2;
        
            $qlb_this = 0;
            $qlb_last = 1;
        
            $qlc_this = 0;
            $qlc_this_time_last = 1;
        ?>
        <?php $pp_exceptions = json_decode(file_get_contents(__DIR__.'\CACHED\pre_production_exceptions.json'),true); ?>
        <?php $p_exceptions = json_decode(file_get_contents(__DIR__.'\CACHED\production_exceptions.json'),true); ?>
        <?php $s_exceptions = json_decode(file_get_contents(__DIR__.'\CACHED\sales_exceptions.json'),true); ?>

        <?php $closed_orders_year_d = json_decode(file_get_contents(__DIR__.'\CACHED\closed_orders_year_data.json'),true); ?>
        <?php $closed_orders_month_d = json_decode(file_get_contents(__DIR__.'\CACHED\closed_orders_month_data.json'),true); ?>
        <?php $closed_orders_week_d = json_decode(file_get_contents(__DIR__.'\CACHED\closed_orders_week_data.json'),true); ?>

        <?php $closed_percentage_year_d = json_decode(file_get_contents(__DIR__.'\CACHED\closed_percentage_year_data.json'),true); ?>
        <?php $closed_percentage_month_d = json_decode(file_get_contents(__DIR__.'\CACHED\closed_percentage_month_data.json'),true); ?>
        <?php $closed_percentage_week_d = json_decode(file_get_contents(__DIR__.'\CACHED\closed_percentage_week_data.json'),true); ?>

        <?php $comp_po_year_d = json_decode(file_get_contents(__DIR__.'\CACHED\complete_process_orders_year_data.json'),true); ?>
        <?php $comp_po_month_d = json_decode(file_get_contents(__DIR__.'\CACHED\complete_process_orders_month_data.json'),true); ?>
        <?php $comp_po_week_d = json_decode(file_get_contents(__DIR__.'\CACHED\complete_process_orders_week_data.json'),true); ?>

        <?php $p_hours_year_d = json_decode(file_get_contents(__DIR__.'\CACHED\process_orders_hours_year_data.json'),true); ?>
        <?php $p_hours_month_d = json_decode(file_get_contents(__DIR__.'\CACHED\process_orders_hours_month_data.json'),true); ?>
        <?php $p_hours_week_d = json_decode(file_get_contents(__DIR__.'\CACHED\process_orders_hours_week_data.json'),true); ?>

        <?php $live_orders_hours = json_decode(file_get_contents(__DIR__.'\CACHED\live_orders_hours.json'),true); ?>
        <?php $live_orders_val = json_decode(file_get_contents(__DIR__.'\CACHED\live_orders_value.json'),true); ?>
        <?php $pre_prod_confirmed = json_decode(file_get_contents(__DIR__.'\CACHED\pre_production_confirmed.json'),true); ?>
        <?php $pre_prod_potential = json_decode(file_get_contents(__DIR__.'\CACHED\pre_production_potential.json'),true); ?>
        <?php $pre_prod_forecast = json_decode(file_get_contents(__DIR__.'\CACHED\pre_production_forecast.json'),true); ?>
        <?php $f_w_a = json_decode(file_get_contents(__DIR__.'\CACHED\process_orders_hours_week_data.json'),true); ?>
        <?php $five_week_average_prod = json_decode(file_get_contents(__DIR__.'\CACHED\process_orders_five_week.json'),true); ?>

        <?php $full_schedule_count = json_decode(file_get_contents(__DIR__.'\CACHED\full_schedule_count.json'),true); ?>
        <?php $last_updated = json_decode(file_get_contents(__DIR__.'\CACHED\data_last_updated.json'),true); ?>
    </head>




    <body>
        <div id = 'background'>
            <div style = "width:100%; height:100%;">
                <div class = 'background_mask' style = "width:100%; height:100%; box-shadow:0px 0px 0px 5px #454545 inset; float:left;">
					<div style = "height:45vh; width:95%; margin: 1.8vh 2.5% 2vh 2.5%">
						<div style = "display:inline-block; height:100%; width:27%; margin:0% 2% 0% 2%;background-color:#dcdcdc;border-radius:3vh;border:3px solid #39ac39; vertical-align:top; color:black;">
							<div style = "height:4.5vh; border-radius:2.5vh 2.5vh 0 0; font-size:1.6vh; background-color:#39ac39;color:white;">
								<h1>YEAR TO DATE</h1>
							</div>
							<div style = "height:19.5vh; margin-top:0px;">
								<div style = "width:100%; height:4vh; margin-bottom:1vh;">
									<canvas id="myChart1" style="width:100%; height:35vh"></canvas>
								</div>
							</div>
						</div><!--
					 --><div style = "display:inline-block; height:100%; width:28%; margin:0% 2% 0% 2%;background-color:#dcdcdc;border-radius:3vh;border:3px solid #39ac39; vertical-align:top; color:black;">
							<div style = "height:4.5vh; border-radius:2.5vh 2.5vh 0 0; font-size:1.6vh; background-color:#39ac39;color:white;">
								<h1>MONTH TO DATE</h1>
							</div>
							<div style = "height:19.5vh; margin-top:0px;">
								<div style = "width:100%; height:4vh; margin-bottom:1vh;">
									<canvas id="myChart2" style="width:100%; height:35vh"></canvas>
								</div>
							</div>
						</div><!--
					 --><div style = "display:inline-block; height:100%; width:27%; margin:0% 2% 0% 2%;background-color:#dcdcdc;border-radius:3vh;border:3px solid #39ac39; vertical-align:top; color:black;">
							<div style = "height:4.5vh; border-radius:2.5vh 2.5vh 0 0; font-size:1.6vh; background-color:#39ac39;color:white;">
								<h1>WEEK TO DATE</h1>
							</div>
							<div style = "height:38.5vh; margin-top:0px;">
								<div style = "width:100%; height:38vh; margin-bottom:1vh;">
									<canvas id="myChart3" style="width:100%; height:35vh"></canvas>
								</div>
							</div>

						</div>
					</div>
					<div style = "height:45vh; width:95%; margin: 2vh 2.5% 2vh 2.5%; color:black;">
						<div style = "display:inline-block; height:100%; width:27%; margin:0% 2% 0% 2%;background-color:#dcdcdc;border-radius:3vh;border:3px solid #ad06cf;";>
							<div style = "height:4.5vh; border-radius:2.5vh 2.5vh 0 0; font-size:1.6vh; background-color:#ad06cf;color:white;">
								<h1>YEAR TO DATE</h1>
							</div>
							<div style = "height:38.5vh; margin-top:0px;">
								<div style = "width:100%; height:38vh; margin-bottom:1vh;">
									<canvas id="myChart4" style="width:100%;height:35vh;"></canvas>
								</div>
							</div>

						</div><!--
					--><div style = "display:inline-block;  height:100%; width:28%; margin:0% 2% 0% 2.5%;background-color:#dcdcdc;border-radius:3vh;border:3px solid #ad06cf;";>
							<div style = "height:4.5vh; border-radius:2.5vh 2.5vh 0 0; font-size:1.6vh; background-color:#ad06cf;color:white;">
								<h1>MONTH TO DATE</h1>
							</div>
							<div style = "height:19.5vh; margin-top:0px;">
								<div style = "width:100%; height:4vh; margin-bottom:1vh;">
									<canvas id="myChart5" style="width:100%; height:35vh"></canvas>
								</div>
							</div>
						</div><!--
					--><div style = "display:inline-block;  height:100%; width:27%; margin:0% 2% 0% 2%;background-color:#dcdcdc;border-radius:3vh;border:3px solid #ad06cf;";>
							<div style = "height:4.5vh; border-radius:2.5vh 2.5vh 0 0; font-size:1.6vh; background-color:#ad06cf;color:white;">
								<h1>WEEK TO DATE</h1>
							</div>
							<div style = "height:19.5vh; margin-top:0px;">
								<div style = "width:100%; height:4vh; margin-bottom:1vh;">
									<canvas id="myChart6" style="width:100%; height:35vh"></canvas>
								</div>
							</div>
						</div>
					</div>
				</div>	
			</div>

						<div style = "width:30%; height:100%; margin:0 0.75% 0 1.5%; float:left;">
                            <!-- <img style = "height:85%; position:relative; top:7.5%; width:100%;" src = "../../RESOURCES/KENTS_TRANS.png"> -->
						</div>		
					</div>
				</div>
			</div>
		</div>


<script>

   getData();
   async function getData() 
   {
    const response = await fetch("\CACHED\\closed_orders_year_data.json");
    const data = await response.json();
    console.log(data);

      length = data.length;
      console.log(length);
      labels = [];
      values = [];

      for (i = 0; i < length; i++) 
      {
         labels.push(i);
         values.push(data[i]["Sales Orders"]);
      }



     new Chart(document.getElementById("myChart1"), 
      {
         type: 'bar',
         data: 
         {
            labels: labels,
            datasets: 
            [
               {
                  label: "Sales Orders",
                  backgroundColor: ["#3a90cd",
                     "#8e5ea2",
                     "#3bba9f",
                     "#e8c3b9",
                     "#c45850",
                     "#CD9C5C",
                     "#40E0D0"],
                  data: values
               }
            ]
         },
         options: 
         {
            legend: { display: false },
            title: {
               display: true,
               text: 'Closed Sales Orders Year'
            }
         }


     }

     )




    const response2 = await fetch("\CACHED\\closed_orders_month_data.json");
    const data2 = await response2.json();
    console.log(data2);


      length2 = data2.length;
      console.log(length2);
      labels2 = [];
      values2 = [];

      for (i2 = 0; i2 < length2; i2++) 
      {
         labels2.push(i2);
         values2.push(data2[i2]["Sales Orders"]);

//document.getElementById("demo").innerHTML = document.getElementById("demo").innerHTML + i2 + "Sales Orders: " + 
//data2[i2]["Sales Order"] + "<BR/>";

	console.log("Sales Order: " + data2[i2]["Sales Orders"]);

      }



      new Chart(document.getElementById("myChart2"), 
      {
         type: 'line',
         data: 
         {
            labels: labels2,
            datasets: 
            [
               {
                  label: "Sales Orders",
                  backgroundColor: ["#3a90cd",
                     "#8e5ea2",
                     "#3bba9f",
                     "#e8c3b9",
                     "#c45850",
                     "#CD9C5C",
                     "#40E0D0"],
                  data: values2
               }
            ]
         },
         options: 
         {
            legend: { display: false },
            title: {
               display: true,
               text: 'Closed Sales Orders Month'
            }
         }


     }

     )



    const response3 = await fetch("\CACHED\\closed_orders_week_data.json");
    const data3 = await response3.json();
    console.log(data3);


      length3 = data3.length;
      console.log(length3);
      labels3 = [];
      values3 = [];

      for (i3 = 0; i3 < length3; i3++) 
      {
         labels3.push(i3);
         values3.push(data3[i3]["Sales Orders"]);

//document.getElementById("demo").innerHTML = document.getElementById("demo").innerHTML + i2 + "Sales Orders: " + 
//data2[i2]["Sales Order"] + "<BR/>";

	console.log("Sales Order: " + data3[i3]["Sales Orders"]);

      }



      new Chart(document.getElementById("myChart3"), 
      {
         type: 'radar',
         data: 
         {
            labels: labels3,
            datasets: 
            [
               {
                  label: "Sales Orders",
                  backgroundColor: ["#3a90cd",
                     "#8e5ea2",
                     "#3bba9f",
                     "#e8c3b9",
                     "#c45850",
                     "#CD9C5C",
                     "#40E0D0"],
                  data: values3
               }
            ]
         },
         options: 
         {
            legend: { display: false },
            title: {
               display: true,
               text: 'Closed Sales Orders Week'
            }
         }


     }

     )





    const response4 = await fetch("\CACHED\\complete_process_orders_year_data.json");
    const data4 = await response4.json();
    console.log(data4);

      length4 = data4.length;
      console.log(length4);
      labels4 = [];
      values4 = [];

         labels4.push("Difference Mat");
         labels4.push("Difference Lab");
         values4.push(data4[0]["3"]);
         values4.push(data4[0]["4"]);

//document.getElementById("demo").innerHTML = document.getElementById("demo").innerHTML + " Mat Efficiency: " + 
//data4["Mat Efficiency"] + " Lab Efficiency: " + data4["Lab Efficiency"] + "<BR/>";

	console.log("Lab Efficiency: " + data4[0]["3"] + " Mat Efficiency: " + data4[0]["4"]);
	console.log(labels4[0] + values4[0]);
	console.log(labels4[1] + values4[1]);
console.log(values4);



      new Chart(document.getElementById("myChart4"), 
      {
         type: 'doughnut',
         data: 
         {
            labels: labels4,
            datasets: 
            [
               {
                  label: "Efficency",
                  backgroundColor: ["#3a90cd",
                     "#8e5ea2",
                     "#3bba9f",
                     "#e8c3b9",
                     "#c45850",
                     "#CD9C5C",
                     "#40E0D0"],
                  data: values4
               }
            ]
         },
         options: 
         {
            legend: { display: true },
            title: {
               display: true,
               text: 'Complete Process Orders Year'
            }
         }


     }

     )


    const response5 = await fetch("\CACHED\\complete_process_orders_month_data.json");
    const data5 = await response5.json();
    console.log(data5);


      length5 = data5.length;
      console.log(length5);
      labels5 = [];
      values5 = [];



         labels5.push("Difference Mat");
         labels5.push("Difference Lab");
         values5.push(data5[0]["3"]);
         values5.push(data5[0]["4"]);

//document.getElementById("demo").innerHTML = document.getElementById("demo").innerHTML + " Mat Efficiency: " + 
//data4["Mat Efficiency"] + " Lab Efficiency: " + data4["Lab Efficiency"] + "<BR/>";

	console.log("Lab Efficiency: " + data5[0]["3"] + " Mat Efficiency: " + data5[0]["4"]);
	console.log(labels5[0] + values5[0]);
	console.log(labels5[1] + values5[1]);
	console.log(values5);







      new Chart(document.getElementById("myChart5"), 
      {
         type: 'bar',
         data: 
         {
            labels: labels5,
            datasets: 
            [
               {
                  label: "Process Orders",
                  backgroundColor: ["#3a90cd",
                     "#8e5ea2",
                     "#3bba9f",
                     "#e8c3b9",
                     "#c45850",
                     "#CD9C5C",
                     "#40E0D0"],
                  data: values5
               }
            ]
         },
         options: 
         {
            legend: { display: false },
            title: {
               display: true,
               text: 'Complete Process Orders Month'
            }
         }


     }

     )







    const response6 = await fetch("\CACHED\\complete_process_orders_week_data.json");
    const data6 = await response6.json();
    console.log(data6);


      length6 = data6.length;
      console.log(length6);
      labels6 = [];
      values6 = [];

      for (i6 = 0; i6 < length6; i6++) 
      {


         labels6.push("Difference Mat");
         labels6.push("Difference Lab");
         values6.push(data6[0]["3"]);
         values6.push(data6[0]["4"]);

//document.getElementById("demo").innerHTML = document.getElementById("demo").innerHTML + " Mat Efficiency: " + 
//data4["Mat Efficiency"] + " Lab Efficiency: " + data4["Lab Efficiency"] + "<BR/>";

	console.log("Lab Efficiency: " + data6[0]["3"] + " Mat Efficiency: " + data6[0]["4"]);
	console.log(labels6[0] + values6[0]);
	console.log(labels6[1] + values6[1]);
	console.log(values6);


      }



      new Chart(document.getElementById("myChart6"), 
      {
         type: 'bar',
         data: 
         {
            labels: labels6,
            datasets: 
            [
               {
                  label: "Process Orders",
                  backgroundColor: ["#3a90cd",
                     "#8e5ea2",
                     "#3bba9f",
                     "#e8c3b9",
                     "#c45850",
                     "#CD9C5C",
                     "#40E0D0"],
                  data: values6
               }
            ]
         },
         options: 
         {
            legend: { display: false },
            title: {
               display: true,
               text: 'Complete Process Orders Week'
            }
         }


     }

     )







}







</script>

	</body>
</html>