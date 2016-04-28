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

<form method="POST" action="NuevaActividad">

	<table border="1">
		<tr>
			<th>Selección</th>
			<th>Día:</th>
			<th>Hora Inicio:</th>
			<th>Hora Finalizacion:</th>
			<th>Aula:</th>
		</tr>
		<?php foreach($this->Dias as $dia){?>
		<tr>
			<td><input type="checkbox" name="dia<?=$dia['Id']?>"  /></td>
			
			<td><label for="<?=$dia['Id']?>"><?=$dia['Dia']?></label></td>
			<td><input type="time" name="horaInicio<?=$dia['Id']?>"></td>
			<td><input type="time" name="horaFinal<?=$dia['Id']?>"></td>
		
			<td>
				<select name="selAula<?=$dia['Id']?>" id="Aula">
				<?php foreach($this->Aulas as $Aul){?>
                        <option value="<?=$Aul['aul_idaul']?>"><?=$Aul['aul_descr']?></option>
                <?php } ?>
				</select>
			</td>	
		</tr>
         <?php } ?>


	</table>
	

    <p>
		<button type="button" class="left" value="Volver" name="addArt" onclick=" location.href='NuevaActividad' ">Volver</button>
		<button type="submit" class="left" value="Aceptar" name="Guardar">Aceptar</button>
    </p>
	
	
</form>
</article>
</body>
</html>												