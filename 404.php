<?php
/**
 * The template for displaying 404 pages (Not Found)
 */
?>
<?php Theme_Utilities::get_template_parts( array( 'parts/shared/html-header', 'parts/shared/header' ) ); ?>

<div class="message-wrapper">
	<h2>404 - Not Found</h2>
	<p>You've stumbled across a page that does not exist or has never existed.  <a href="/">Click here</a> to return home.</p>
</div>

<?php Theme_Utilities::get_template_parts( array( 'parts/shared/footer','parts/shared/html-footer' ) ); ?>