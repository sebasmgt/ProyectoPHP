
<!DOCTYPE html>
<html>

	<head>
	
		<link rel="stylesheet" href="html/css/style.css" />
		<link href="html/css/ui-lightness/jquery-ui.css" rel="stylesheet" media="screen">
		<script type="text/javascript" src="html/js/jquery.min.js"></script>
		<script type="text/javascript" src="html/js/jquery-ui.custom.min.js"></script>
		

		<style type="text/css">
		body
		{
			font-size:0.9em;
		}
		
		.dialogSencillo
		{
			width:300px;
		}
		
		.wraper{
			margin:0 auto;
			width:400px;
			height:auto;

			/*Borde redondeado*/
			border:1px solid #000;
			border-radius: .8em;
			-moz-border-radius: .8em;
			-webkit-border-radius: .8em;
			-o-border-radius: .8em;
		}

		.informacion
		{
			text-align:center;
		}

		</style>

		<script type="text/javascript">
		$(document).ready(function(){
			$('.dialogSencillo').button();
			$('.dialogo').dialog({
				autoOpen: false,
				modal: true,
				width: 350,
				height: 200,
				buttons: {
					Editar: function() {
						 var idAct = $(this).data("idAct");
						 window.location.href="ModificarActividad-" + idAct;
						 $(this).dialog("close");
					},
					Eliminar: function() {
						 var idAct = $(this).data("idAct");
						 window.location.href="EliminarActividad-" + idAct;
						 $(this).dialog("close");
					},
					Cerrar: function() {
						$(this).dialog( "close" );
					}
					
				}
			});
			
			// Mostrar Diálogo Sencillo
			$('.dialogSencillo').click(function(){
					var Act = $(this).attr("id");
					$('.dialogo').data("idAct", Act) ;;
					$('.dialogo').dialog('open');
			});
			
		});
		</script>
		
	</head>
 
	<body>

	<div class="dialogo" title="Opciones Actividad" style="display:none;">
	<p>Eliga una Opción a realizar:</p>
	</div>
	
	
		<h1>Calendario</h1>
		
		<form method="POST" action="Calendario">
				
			  <label for="anio">Año:</label>
			   <select name="anio"  id="anio">
			   <? foreach ($this->Anios As $An){	
						if($this->Anio == $An){ ?>
							<option value="<?=$An?>" selected ><?=$An?></option>	
						<?} else {?>
							<option value="<?=$An?>" ><?=$An?></option>	
				<? }} ?>
				</select> 
				
			    <select name="mes" id="mes">
				<? foreach ($this->Meses As $Mes){	
						if($this->Mes == $Mes['Id']){ ?>
							<option value="<?=$Mes['Id']?>" selected ><?=$Mes['Mes']?></option>	
						<?} else {?>
							<option value="<?=$Mes['Id']?>" ><?=$Mes['Mes']?></option>		
				<? }} ?>				
				</select> 
			
			<input type="submit" name="Ir"  Value = "Ir" />
			
			<br><br>
				
		</form>
	
		<table  id="calendar">
		
		<thead>

			<tr>
				
				<th>Lunes</th>
				<th>Martes</th>   
				<th>Miércoles</th>   
				<th>Jueves</th>   
				<th>Viernes</th>   
				<th>Sábado</th>   
				<th>Domingo</th>   

			</tr>

		</thead>

		<tbody>

			<? foreach ($this->Calendario as $days){ ?>

				<tr bgcolor="silver">

					<?for ($i=1;$i<=7;$i++) { ?>
						<td>
							<?=isset($days[$i]) ? $days[$i] : '';?>
							<? if(isset($days[$i])) {
									$FechaCal = $this->Anio.'-'.$this->Mes.'-'.$days[$i];
										$f1 = explode('-',date('Y-m-d',strtotime($FechaCal)));
										//var_dump($f1);
										foreach ($this->Fechas as $Fecha){
											$f2 = explode("-",date("Y-m-d",strtotime($Fecha['FechaActividad'])));
											//var_dump($f2);
											$dif = GregorianToJd($f1[1],$f1[2],$f1[0]) - GregorianToJd($f2[1],$f2[2],$f2[0]);
											//var_dump($dif);
											if($dif == 0) {
												?>
												<br><br>
												<input  class="dialogSencillo" type="button" name="Actividad" value="<?=$Fecha['TituloActividad'] .' - '. $Fecha['HoraInicio'].' a '.$Fecha['HoraFinalizacion'] ?>" id ="<?=$Fecha['idActividad']?>" />
												
						<?}}}?> 
						
						</td>

					<? } ?>

				</tr>

			<? } ?>

		</tbody>

		</table>
		<br><br>		
		<div ><a href="NuevaActividad">Agregar Nueva Actividad</a></div>
		<br><br>		
		<div ><a href="Facturacion">Facturar</a></div>
		<br><br>		
		<div ><a href="TraerFacturas">Mostrar Facturas</a></div>
	</body>

</html>
