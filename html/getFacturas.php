
<!DOCTYPE html>
<html>

	<head>
	
		<link rel="stylesheet" href="html/css/style.css" />
		<link href="html/css/ui-lightness/jquery-ui.css" rel="stylesheet" media="screen">
		
		<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.4.2/jquery.min.js" type="text/javascript" charset="utf-8"></script>
		<script src="js/jquery.uniform.min.js" type="text/javascript" charset="utf-8"></script>
		<script type="text/javascript" charset="utf-8">
      $(function(){
        $("input:checkbox, input:radio, input:file, select").uniform();
      });
    </script>
				
	</head>
 
	<body>

		<h1>Facturación</h1>
		
		<form method="POST" action="TraerFacturas">
				
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
				
				<label for="Res">Responsable:</label>
				<select name="Res" id="car">
				<? foreach($this->Responsables as $res){
						if($this->Responsable == $res['res_idres']){ ?>
                        <option value="<?=$res['res_idres']?>" selected><?=$res['res_nombr']?></option>
                <? } else { ?>
						 <option value="<?=$res['res_idres']?>" ><?=$res['res_nombr']?></option>
				<?  } } ?>
				</select>			
			
			<input type="submit" name="Ir"  Value = "Ir" />
			
			<br><br>
				
		</form>
	
		<table  id="factura">
		
		<thead>

			<tr>
				<th>Numero de Factura</th>
				<th>Fecha de Generacion</th>   
				<th>Responsable</th>   
				<th>Documento</th> 
				<th>Monto Total</th>     
			</tr>

		</thead>

		<tbody>
		
		<? foreach ($this->Facturas as $Fac){ ?>
				<tr bgcolor="silver">

						<td>
								<?=$Fac['pag_numpa']?>
						</td>
						<td>
								<?=$Fac['pag_fegen']?>
						</td>
						<td>
								<?=$Fac['res_nombr']?>
						</td>
						<td>
								<?=$Fac['res_docum']?>
						</td>
						<td>
								<?=$Fac['pag_total']?>
						</td>

				</tr>
		<?}?>
		</tbody>

		</table>
	<p>
	<button type="button" class="left" name="volver"  onclick="location.href='Calendario'">Volver</button>
	</p>

		
	</body>

</html>
