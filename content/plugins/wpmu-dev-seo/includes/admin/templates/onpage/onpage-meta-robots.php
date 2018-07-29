<?php
$items = empty( $items ) ? array() : $items;

if ( ! $items ) {
	return;
}
?>

<?php
$this->_render( 'toggle-group', array(
	'label'       => __( 'Indexing', 'wds' ),
	'description' => __( 'Choose whether you want your website to appear in search results.', 'wds' ),
	'separator'   => true,
	'items'       => $items,
) );
