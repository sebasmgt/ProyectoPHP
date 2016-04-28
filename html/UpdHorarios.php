<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<title>Horarios</title>

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

<form method="POST" action="ModificarActividad">

	<table >
		<tr>
			<th>Selección</th>
			<th>Día:</th>
			<th>Hora Inicio:</th>
			<th>Hora Finalizacion:</th>
			<th>Aula:</th>
		</tr>
		

			<?foreach($this->Dias as $dia){	
					$idDia = $dia['Id'];
					
					if(isset($this->Horarios[$idDia]['acd_diaac']))
						$DiaAct = $this->Horarios[$idDia]['acd_diaac'];
					else 
						$DiaAct = null;
					?>
						<td>
							<? if($DiaAct == $dia['Id']) { ?> 
								<input type="checkbox" name="dia<?=$dia['Id']?>" checked />
							<?} else {?>
								<input type="checkbox" name="dia<?=$dia['Id']?>" />
							<? }?>						
						</td>	
						
						<td><label for="<?=$dia['Id']?>"><?=$dia['Dia']?></label></td>
						
						<td>	
							<? if($DiaAct == $dia['Id']) { ?> 
								<input type="time" name="horaInicio<?=$dia['Id']?>" value ="<?=$this->Horarios[$idDia]['acd_horai']?>" />
							<?} else {?>
								<input type="time" name="horaInicio<?=$dia['Id']?>"  />
							<? }?>			
						</td>
						
						<td>	
							<? if($DiaAct == $dia['Id']) { ?> 
								<input type="time" name="horaFinal<?=$dia['Id']?>" value ="<?=$this->Horarios[$idDia]['acd_horaf']?>" />
							<?} else {?>
								<input type="time" name="horaFinal<?=$dia['Id']?>" />
							<? }?>			
						</td>
						
						<td>
							<select name="selAula<?=$dia['Id']?>" id="Aula">
							<? foreach($this->Aulas as $Aul){
									if($DiaAct == $dia['Id'] && $Aul['aul_idaul'] == $this->Horarios[$idDia]['acd_idaul']) { ?>
											<option value="<?=$Aul['aul_idaul']?>" selected><?=$Aul['aul_descr']?></option>
							<? } else { ?>
											<option value="<?=$Aul['aul_idaul']?>"><?=$Aul['aul_descr']?></option>
							<? } }?>
							</select>
						</td>	
						
						
						
						</tr>	
						
			 <? }  ?>
			 



		
	</table>
	

    <p>		
		<button type="button" class="left" value="Volver" name="addArt" onclick=" location.href='ModificarActividad-<?=$this->IdActividad?>' ">Volver</button>
		<button type="submit" class="left" value="Aceptar" name="Guardar">Aceptar</button>
    </p>
	
	
</form>
</article>
</body>
</html>												