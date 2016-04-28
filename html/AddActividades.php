<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>Agregar Nueva Actividad</title>

	<link rel="stylesheet" href="html/css/style2.css" type='text/css'  />
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.4.2/jquery.min.js" type="text/javascript" charset="utf-8"></script>
    <script src="js/jquery.uniform.min.js" type="text/javascript" charset="utf-8"></script>
    <script type="text/javascript" charset="utf-8">
      $(function(){
        $("input:checkbox, input:radio, input:file, select").uniform();
      });
    </script>
	
</head>
<body>

<article>

<form method="POST" action="NuevaActividad">

		<ul>
			<li>
				<label for="txtTitulo">Titulo Actividad:</label>
				<input type="text" name="txtTitulo" />
			</li>
			
			<li>
				<label for="selResponsable">Responsable:</label>
				<select name="selResponsable" id="car">
				<?php foreach($this->Responsables as $res){?>
                        <option value="<?=$res['res_idres']?>" selected><?=$res['res_nombr']?></option>
                <?php } ?>
				</select>			
			</li>
			
			<li>
				<label for="selTipAct">Tipo de Actividad:</label>
				<select name="selTipAct" id="car">
				<?php foreach($this->TipoActividades as $Tip){?>
                        <option value="<?=$Tip['tac_tipid']?>"><?=$Tip['tac_descr']?></option>
                <?php } ?>
				</select>	
			</li>
			
			<li>
				<label for="fechaIni">Fecha de Inicio:</label>
				<input type="date" name="fechaIni" id="car">
			</li>

			<li>
				<label for="fechaFin">Fecha de Finalización:</label>
				<input type="date" name="fechaFin" id="car">
			</li>
			
			<li>
				<label for="selRepeticiones">Repeticiones:</label>
				<select name="selRepeticiones" id="car">
				<?php foreach($this->Repeticiones as $rep){?>
                        <option value="<?=$rep['Id']?>"><?=$rep['Descripcion']?></option>
                <?php } ?>
				</select>
			</li>
			
			<li>
				<label for="txtTarifa">Tarifa por Clase:</label>
				<input type="text" name="txtTarifa" />
			</li>		
			
		    <li>
				<label for="chkFacturable">Facturable:</label>
				<input type="checkbox" name="chkFacturable" id="car">
			</li>
			

			
		</ul>


		<p>
			<button type="button" class="left" name="volver"  onclick="location.href='Calendario'">Volver</button>
			<button type="submit" class="left" value="Aceptar" name="sigAct">Siguiente</button>
		</p>
	
	
</form>
</article>
</body>
</html>												