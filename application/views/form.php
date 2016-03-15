<?php
/*---------------------------------

---- Margus David
---- created: 02.02.2014
---- oDesk job - KungFuData-Mobile-Site
---- file: mobile.php - main mobile page

---------------------------------*/

?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<HTML>
<HEAD>
	<TITLE> {app_title} </TITLE>
	<meta charset = "UTF-8">
	<meta http-equiv = "X-UA-Compatible" content = "IE=edge,chrome=1">
	<meta name = "viewport" content= "width=device-width, initial-scale=1, maximum-scale=1">
	
	<!-- load lib -->
	<script type = "text/javascript" src = "{base_url}assets/lib/jquery/jquery.min.js"></script>
	<script type = "text/javascript" src = "{base_url}assets/lib/kendoui/kendo.all.min.js"></script>
	<link rel = "stylesheet" type = "text/css" media = "screen" href = "{base_url}assets/lib/bootstrap/css/bootstrap.min.css"/>
	<link rel = "stylesheet" type = "text/css" media = "screen" href = "{base_url}assets/lib/bootstrap/css/bootstrap-theme.min.css"/>
	<script type = "text/javascript" src = "{base_url}assets/lib/bootstrap/js/bootstrap.min.js"></script>
	
	<link rel = "stylesheet" type = "text/css" media = "screen" href = "{base_url}assets/css/index.css"/>

</HEAD>

<!--  -->
<script> 
	var baseURL = "{base_url}"; 
	var ajaxURL = baseURL + "index.php/bs_api"; 
	var questionIDs = new Array;	
</script>
<BODY>

<div id = "page-home" data-role = "view" data-title = "{app_title}" data-model = "bsModel" data-show = "bsModel.initHome">
	<h2>{app_subject}</h2>
	<h4>{app_version}</h4>
</div>

<div id = "page-start" data-role = "view" data-title = "{app_title}" data-model = "bsModel" data-show = "bsModel.initStart">
	<h3>Encuentra tu ONG ideal</h3>
	<input type = "button" class = "btn btn-default" id = "start-app" value = "Empezar ahora"/>
</div>

<div id = "page-gender" data-role = "view" data-title = "{app_title}" data-model = "bsModel" data-show = "bsModel.initGender">
	<h3>Por favor dinos tu género</h3>
	<ul class = "gender-group">
		<li><input type = "radio" id = "gender-male" name = "gender" value = "male"/><label for = "gender-male">Chico</label></li>
		<li><input type = "radio" id = "gender-female" name = "gender" value = "female"/><label for = "gender-female">Chica</label></li>
	</ul>
	<input type = "button" id = "go-next" value = "Próximo" class = "btn btn-default"/>
</div>

<div id = "page-first-description" data-role = "view" data-title = "{app_title}" data-model = "bsModel" data-show = "bsModel.initFristDes">
	<p>A continuación se describe brevemente la forma de ser de algunas personas, y le vamos a pedir que indique en qué medida se parece usted a cada una de ellas. Por favor, siga el siguiente procedimiento: <b>en primer lugar es importante que lea todas las descripciones antes de colocar ninguna puntuación</b>, a continuación puntúe con un 6 <u>las dos</u> descripciones que más se parecen a usted y con un 1 <u>las dos</u> que menos se parecen a usted, finalmente puntúe entre 2 y 5 el resto de las descripciones.</p>	
	<input type = "button" id = "go-next" value = "Próximo" class = "btn btn-default"/>
</div>

<div id = "page-first" data-role = "view" data-title = "{app_title}" data-model = "bsModel" data-show = "bsModel.initFirst">
	<label>Por favor, recuerda leer primero todas las descripciones antes de colocar ninguna puntuación</label>
	<table class = "table table-hover">
		<col width = "70%">
		<col width = "5%">
		<col width = "5%">
		<col width = "5%">
		<col width = "5%">
		<col width = "5%">
		<col width = "5%">
		<thead>
			<tr class = "active">
				<th>Pregunta</th>
				<th>Opuesto</th>
				<th>Nada</th>
				<th>Poco</th>
				<th>Algo</th>
				<th>Mucho</th>
				<th>Indéntico</th>
			</tr>
		</thead>
		<tbody>
			<?php
				$i = 1;
				foreach($questions as $k => $v){
					if($i > 4) break;
					
					echo "<tr>
						<td>".$v['question']."</td>";
						for($j = 1; $j < 7; $j++){
							echo "<td><input type = \"radio\" name = \"q".$i."\" value = \"".$j."\"/></td>";
						}
					echo "</tr>
						<script>
							questionIDs[\"q".$i."\"] = ".$k.";
						</script>
					";
					$i++;
				}
			?>
		</tbody>
	</table>
	<input type = "button" id = "go-next" value = "Próximo" class = "btn btn-default"/>
</div>

<div id = "page-second-description" data-role = "view" data-title = "{app_title}" data-model = "bsModel" data-show = "bsModel.initSecondDes">
	<p>Las siguientes frases se refieren a sus sentimientos y pensamientos en una variedad de situaciones. Para cada situación indique cómo le describe, eligiendo la puntuación de 1 a 7 <b>(1= totalmente en desacuerdo; 4 = neutral; y 7= totalmente de acuerdo)</b>. Conteste honestamente aquello con lo que más se identifique, ya que no hay respuestas correctas o incorrectas. No deje ninguna frase sin contestar. GRACIAS </p>
	<input type = "button" id = "go-next" value = "Próximo" class = "btn btn-default"/>
</div>

<div id = "page-second" data-role = "view" data-title = "{app_title}" data-model = "bsModel" data-show = "bsModel.initSecond">
	<label>Por favor, recuerda leer primero todas las descripciones antes de colocar ninguna puntuación</label>
	<table class = "table table-hover">
		<col width = "69.5%">
		<col width = "4.5%">
		<col width = "4.5%">
		<col width = "4.5%">
		<col width = "4.5%">
		<col width = "4.5%">
		<col width = "4.5%">
		<col width = "4.5%">
		<thead>
			<tr class = "active">
				<th>Pregunta</th>
				<th>field1</th>
				<th>field2</th>
				<th>field3</th>
				<th>field4</th>
				<th>field5</th>
				<th>field6</th>
				<th>field7</th>
			</tr>
		</thead>
		<tbody>
			<?php
				$i = 1;
				foreach($questions as $k => $v){
					if($i > 7) break;
					else if($i < 5){
						$i++;
						continue;
					}
					
					echo "<tr>
						<td>".$v['question']."</td>";
						for($j = 1; $j < 8; $j++){
							echo "<td><input type = \"radio\" name = \"q".$i."\" value = \"".$j."\"/></td>";
						}
					echo "</tr>
						<script>
							questionIDs[\"q".$i."\"] = ".$k.";
						</script>
					";

					$i++;
				}
			?>
		</tbody>
	</table>
	<input type = "button" id = "go-next" value = "Próximo" class = "btn btn-default"/>
</div>

<div id = "page-result" data-role = "view" data-title = "{app_title}" data-model = "bsModel" data-show = "bsModel.initResult">
	<h3>Te proponemos estas ONGs</h3>
	<div class = "result-section"></div>
	<h3>Si quieres colaborar, pincha en la que preﬁeras</h3>
	<input type = "button" id = "go-next" value = "Próximo" class = "btn btn-default"/>
</div>

<div id = "page-contact" data-role = "view" data-title = "{app_title}" data-model = "bsModel" data-show = "bsModel.initContact">
	<h3>¿Quieres colaborar? Déjanos tu email para que se pongan en contacto contigo</h3>
	<input type = "text" id = "email" placeholder = "Please enter email" class = "form-control"/>
	<h3>¿De qué tiempo a la semana dispondrías?</h3>
	<input type = "text" id = "hours" placeholder = "Horas" class = "form-control"/><label for = "hours">Horas</label>
	<input type = "button" id = "go-next" value = "Próximo" class = "btn btn-default"/>
</div>

<div id = "page-last" data-role = "view" data-title = "Aplicación BS" data-model = "bsModel" data-show = "bsModel.initLast">
	<h1>Comparte</h1>
	<input type = "button" id = "go-next" value = "Empezar de nuevo" class = "btn btn-default"/>
</div>

</BODY>
</HTML>

<!-- form init -->
<script type = "text/javascript" src = "{base_url}assets/js/global.js"></script>
<script type = "text/javascript" src = "{base_url}assets/js/calculator.js"></script>
<script type = "text/javascript" src = "{base_url}assets/js/index.js"></script>