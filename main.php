<?php
/*
Plugin Name: Exclusivo entrada complemento
Plugin URI: https://github.com/sasousuke/exclusivo-entrada-plugin
Description: Plugin de Wordpress para añadir una frase o palabra ante cada título de entrada a mostrar
Version: 1.0.1
Author: Ernesto Tur Laurencio
Author URI: https://twitter.com/sasousuke
License: GPLv3
*/

/*
  Función que realiza la modificación del título
*/
function exclusivo_entrada_plugin_cambiar_titulo( $title, $id ) {
  $title = get_option('exclusivo_entrada_plugin_value') . ' '. $title;
  return $title;
}

/*
  Se añade al evento the_title una llamada a la función definida
*/
add_filter( 'the_title', 'exclusivo_entrada_plugin_cambiar_titulo', 10, 2 );

/*
  Menú de opciones del complemento
*/
function exclusivo_entrada_plugin_menu (){
	add_menu_page('Ajustes del complemento Exclusivo Entrada Plugin', #Título de la página
				  'Exclusivo Entrada Plugin',                         #Título del menú
				  'administrator',                                    #Rol que puede acceder
				  'exclusivo-entrada-plugin-settings',                #Id de la página de opciones
				  'exclusivo_entrada_plugin_page_settings',           #Funcion que visualiza las configuraciones del complemento
				  'dashicons-admin-generic'                           #Icono del menú
				 );
}

/*
  Se añade al menú del panel de administración una entrada referente a las configuraciones
*/
add_action('admin_menu', 'exclusivo_entrada_plugin_menu');

/*
  Funcion que visualiza las configuraciones del complemento
*/
function exclusivo_entrada_plugin_page_settings(){
?>
	<div class="wrap">
		<h2>Configuración</h2>
		<form method="POST" action="options.php">
			<?php 
				settings_fields('exclusivo-entrada-plugin-settings-group');
				do_settings_sections('exclusivo-entrada-plugin-settings-group'); 
			?>
			<label>Palabra(s):&nbsp;</label>
			<input 	type="text" 
					name="exclusivo_entrada_plugin_value" 
					id="exclusivo_entrada_plugin_value" 
					value="<?php echo get_option('exclusivo_entrada_plugin_value'); ?>" />
			<?php submit_button(); ?>
		</form>
	</div>
<?php
}

/*
* Función que registra las opciones del formulario en una lista blanca para que puedan ser guardadas
*/
function exclusivo_entrada_plugin_register_value_form_settings(){
	register_setting('exclusivo-entrada-plugin-settings-group',
					 'exclusivo_entrada_plugin_value',
					 'string');
}
add_action('admin_init','exclusivo_entrada_plugin_register_value_form_settings');
?>
