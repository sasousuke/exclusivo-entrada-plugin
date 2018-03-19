<?php
/*
Plugin Name: Exclusivo entrada plugin
Plugin URI: https://github.com/sasousuke/exclusivo-entrada-plugin
Description: Plugin de Wordpress para añadir una frase o palabra ante cada título de entrada a mostrar
Version: 1.0.2
Author: Ernesto Tur Laurencio
Author URI: https://twitter.com/sasousuke
License: GPLv3
*/

/*
  Función que realiza la modificación del título
*/
function exclusivo_entrada_plugin_cambiar_titulo( $title, $id ) {
    $categories = get_the_category($id);
    $check = false;
    foreach( $categories as $category )
	  if ($category->category_nicename == get_option('exclusivo_entrada_plugin_categoria_value'))
        $check = true;
    if ($check == true)
	  $title = get_option('exclusivo_entrada_plugin_value') . ' '. $title;
    return $title;
}

/*
  Se añade al evento the_title una llamada a la función definida
*/
add_filter( 'the_title', 'exclusivo_entrada_plugin_cambiar_titulo', 10, 2 );

/*
  Menú de opciones del plugin
*/
function exclusivo_entrada_plugin_menu (){
	add_menu_page('Ajustes del plugin Exclusivo Entrada Plugin', #Título de la página
				  'Exclusivo Entrada Plugin',                         #Título del menú
				  'administrator',                                    #Rol que puede acceder
				  'exclusivo-entrada-plugin-settings',                #Id de la página de opciones
				  'exclusivo_entrada_plugin_page_settings',           #Funcion que visualiza las configuraciones del plugin
				  'dashicons-admin-generic'                           #Icono del menú
				 );
}

/*
  Se añade al menú del panel de administración una entrada referente a las configuraciones
*/
add_action('admin_menu', 'exclusivo_entrada_plugin_menu');

/*
  Función que visualiza las configuraciones del plugin
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
			<table>
				<tr>
					<td>
					    <label>Palabra(s):&nbsp;</label>
					</td>
					<td>
			            <input 	type="text" 
					            name="exclusivo_entrada_plugin_value" 
					            id="exclusivo_entrada_plugin_value" 
					            value="<?php echo get_option('exclusivo_entrada_plugin_value'); ?>" />
					</td>
				</tr>
				<tr>
					<td>
					    <label>Categor&iacute;a:&nbsp;</label>
					</td>
					<td>
			           <select name="exclusivo_entrada_plugin_categoria_value" width="100%"> 
                             <option value=""><?php echo esc_attr_e( 'Seleccione una', 'textdomain' ); ?></option> 
<?php 
    $categories = get_categories(); 
    foreach ( $categories as $category ) {
     if ($category->category_nicename == get_option('exclusivo_entrada_plugin_categoria_value')){
         printf( '<option value="%1$s" selected="selected">%2$s (%3$s)</option>',
             esc_attr($category->category_nicename),
             esc_html($category->cat_name),
             esc_html($category->category_count)
         ); 
	 }
     else {
         printf( '<option value="%1$s">%2$s (%3$s) ></option>',
             esc_attr($category->category_nicename),
             esc_html($category->cat_name),
             esc_html($category->category_count)
         ); 
     }
    }
?>
                       </select>
					</td>
				</tr>
			</table>
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
	register_setting('exclusivo-entrada-plugin-settings-group',
					 'exclusivo_entrada_plugin_categoria_value',
					 'string');
}
add_action('admin_init','exclusivo_entrada_plugin_register_value_form_settings');
?>
