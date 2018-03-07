<?php
/*
Plugin Name: Exclusivo entrada complemento
Plugin URI: https://github.com/sasousuke/exclusivo-entrada-plugin
Description: Plugin de Wordpress para añadir una frase o palabra ante cada título de entrada a mostrar
Version: 1.0.0
Author: Ernesto Tur Laurencio
Author URI: https://twitter.com/sasousuke
*/
add_filter( 'the_title', 'exclusivo_entrada_plugin_cambiar_titulo', 10, 2 );
function exclusivo_entrada_plugin_cambiar_titulo( $title, $id ) {
  $frase = '[Exclusiva] ';
  $title = $frase . $title;
  return $title;
}
?>
