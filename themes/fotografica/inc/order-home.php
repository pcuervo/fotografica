<?php
	$direccion_mexico  = get_option('direccion_mexico');
	$telefono_mexico   = get_option('telefono_mexico');
	$direccion_morelia = get_option('direccion_morelia');
	$telefono_morelia  = get_option('telefono_morelia');
	$fax_mexico        = get_option('fax_mexico');
?>

	<div class="wrap editar-contacto-container">


		<div id="icon-generic" class="icon32"><br></div>
		<h2>Orden en el home</h2>
		<div id="settings-contacto-message" class="updated settings-error">
			<p><strong>Exito!</strong> Se guardaron los cambios.</p>
		</div>
		<div id="informacion-contacto">
			<div id="contacto-mexico">
				<label for="direccion-mexico">Dirección México:</label>
				<textarea id="direccion-mexico" name="direccion-mexico" class="widefat"><?php echo $direccion_mexico ?></textarea>
				<!-- <input type="text" id="direccion-mexico" name="direccion-mexico" class="widefat" value=""></input> -->

				<label for="telefono-mexico">Teléfono México:</label>
				<input type="text" id="telefono-mexico" name="telefono-mexico" class="widefat"
					value="<?php echo $telefono_mexico ?>"></input><br />

				<label for="fax-mexico">Fax México:</label>
				<input type="text" id="fax-mexico" name="fax-mexico" class="widefat"
					value="<?php echo $fax_mexico ?>"></input><br />
			</div>

			<br /><h3>Información de Contacto Morelia</h3>
			<label for="direccion-morelia">Dirección Morelia:</label>
			<textarea id="direccion-morelia" name="direccion-morelia" class="widefat"><?php echo $direccion_morelia ?></textarea>
			<!-- <input type="text" id="direccion-morelia" name="direccion-morelia" class="widefat" value=""></input> -->

			<label for="telefono-morelia">Teléfono Morelia:</label>
			<input type="text" id="telefono-morelia" name="telefono-morelia" class="widefat"
				value="<?php echo $telefono_morelia ?>"></input>

		</div><!-- end #informacion-contacto -->
		<input type="submit" name="submit-info-contacto" id="submit-info-contacto"
			class="button button-primary button-large" value="Guardar">
	</div><!-- end .editar-contacto-container -->