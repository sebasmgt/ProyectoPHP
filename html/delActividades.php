<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>Eliminar Actividad</title>

	
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

<form method="POST" action="EliminarActividad">

		<ul>
			<li>
				<label for="txtTitulo">Titulo Actividad:</label>
				<input type="text" name="txtTitulo" value="<?=$this->Actividad['act_descr']?>" />
				<input type="hidden" name="ID" value="<?=$this->Actividad['act_idact']?>" />

			</li>
			
			
			<li>
				<label for="selResponsable">Responsable:</label>
				<select name="selResponsable" id="car">					 			  
				<? foreach($this->Responsables as $res)
				{
						if($this->Actividad['act_respo'] == $res['res_idres'])
						{ ?>
							<option value="<?=$res['res_idres']?>" selected><?=$res['res_nombr']?></option>
                   <? } else 
				        { ?>
							<option value="<?=$res['res_idres']?>"><?=$res['res_nombr']?></option>
				   <? }
				}?>
				</select>				
			</li>
			
			<li>
				<label for="selTipAct">Tipo de Actividad:</label>
				<select name="selTipAct" id="car">
				<? foreach($this->TipoActividades as $Tip)
				{
						if($this->Actividad['act_tipoa'] == $Tip['tac_tipid'])
						{ ?>
							<option value="<?=$Tip['tac_tipid']?>" selected><?=$Tip['tac_descr']?></option>
                   <? } else 
				        { ?>
							<option value="<?=$Tip['tac_tipid']?>"><?=$Tip['tac_descr']?></option>
				   <? }
				}?>	
				</select>	
			</li>
			
			<li>
				<label for="fechaIni">Fecha de Inicio:</label>
				<input type="date" name="fechaIni" id="car" value="<?=$this->Actividad['act_feini']?>" />
			</li>

			<li>
				<label for="fechaFin">Fecha de Finalización:</label>
				<input type="date" name="fechaFin" id="car"  value="<?=$this->Actividad['act_fefin']?>" />
			</li>
			
			<li>
				<label for="selRepeticiones">Repeticiones:</label>
				<select name="selRepeticiones" id="car">
				<? foreach($this->Repeticiones as $rep)
				{
						if($this->Actividad['act_repet'] == $rep['Id'])
						{ ?>
							<option value="<?=$rep['Id']?>" selected><?=$rep['Descripcion']?></option>
                   <? } else 
				        { ?>
							<option value="<?=$rep['Id']?>"><?=$rep['Descripcion']?></option>
				   <? }
				}?>					
				</select>
			</li>
			<li>
				<label for="txtTarifa">Tarifa por Clase:</label>
				<input type="text" name="txtTarifa" value="<?=$this->Actividad['act_tarifa']?>" />
			</li>	
		    <li>
				<label for="chkFacturable">Facturable:</label>
				<? if($this->Actividad['act_fefin'] == 'S') {?>
						<input type="checkbox" name="chkFacturable" id="car" checked />
				<? } else { ?>
						<input type="checkbox" name="chkFacturable" id="car" checked />
				<? } ?>
			</li>
		</ul>


		<p>
			<button type="button" class="left" value="Volver" name="volver" onclick=" location.href='Calendario' ">Volver</button>
			<button type="submit" class="left" value="Aceptar" name="Eliminar">Eliminar</button>
		</p>
	
	
</form>
</article>
</body>
</html>												