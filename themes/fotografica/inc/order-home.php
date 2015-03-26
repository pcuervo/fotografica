<?php
	$secciones = get_secciones_orden_home();
?>

	<!-- <div class="wrap editar-contacto-container"> -->
	<div class="">

		<h2>Orden en el home</h2>
		<p>INSERTA EXPLICACIÓN DE COMO FUNCIONA ESTA VAINA LOCA...</p>
		<label for="">Selecciona el orden de las secciones.</label>
		<form action="?page=ajustes-home-orden" class="[ j-orden-home ]" method="post">
		<?php foreach ($secciones as $key => $seccion) { ?>
			<fieldset>
				<label for="posicion_<?php echo $key+1 ?>">Posición <?php echo $key+1 ?></label>
				<select name="posicion_<?php echo $key+1 ?>">
					<?php foreach ($secciones as $seccion_option) { ?>
						<option value="<?php echo $seccion_option->seccion ?>" <?php echo ($key+1 == $seccion_option->posicion) ? 'selected="selected"' : '' ?>><?php echo $seccion_option->seccion ?></option>
					<?php } ?>
				</select>
			</fieldset>
		<?php } ?>
			<fieldset>
				<input type="submit" value="Guardar">
			</fieldset>
		</form>
		
	</div><!-- end .editar-contacto-container -->