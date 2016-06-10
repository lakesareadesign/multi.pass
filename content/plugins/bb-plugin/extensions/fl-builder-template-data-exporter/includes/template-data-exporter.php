<div class="wrap fl-builder-template-data-exporter">
	<h1>Template Data Exporter</h1>
	<p>This tool exports a special data file that can be used by developers to include templates within their themes and plugins.</p>
	<p>If you need to export templates for import into another site, please use the exporter at <a href="<?php echo admin_url( '/export.php' ); ?>">Tools > Export</a>.</p>
	<form method="POST">
		
		<div class="fl-builder-template-data-section fl-builder-template-data-layouts">
			
			<h2>Layouts</h2>
			
			<?php if ( 0 === count( $layouts ) ) : ?>
			<p>No Layouts Found</p>
			<?php else : ?>
			<p><label><input type="checkbox" name="fl-builder-template-data-exporter-all" value="1" /> Select All</label></p>
			<?php endif; ?>
			
			<?php foreach ( $layouts as $layout ) : ?>
			<p><label><input type="checkbox" class="fl-builder-template-data-checkbox" name="fl-builder-export-layout[]" value="<?php echo $layout['id'] ?>" /> <?php echo $layout['name'] ?></label></p>
			<?php endforeach; ?>
			
		</div>
		
		<div class="fl-builder-template-data-section fl-builder-template-data-rows">
			
			<h2>Rows</h2>
			
			<?php if ( 0 === count( $rows ) ) : ?>
			<p>No Rows Found</p>
			<?php else : ?>
			<p><label><input type="checkbox" name="fl-builder-template-data-exporter-all" value="1" /> Select All</label></p>
			<?php endif; ?>
			
			<?php foreach ( $rows as $row ) : ?>
			<p><label><input type="checkbox" class="fl-builder-template-data-checkbox" name="fl-builder-export-row[]" value="<?php echo $row['id'] ?>" /> <?php echo $row['name'] ?></label></p>
			<?php endforeach; ?>
			
		</div>
		
		<div class="fl-builder-template-data-section fl-builder-template-data-modules">
			
			<h2>Modules</h2>
			
			<?php if ( 0 === count( $modules ) ) : ?>
			<p>No Modules Found</p>
			<?php else : ?>
			<p><label><input type="checkbox" name="fl-builder-template-data-exporter-all" value="1" /> Select All</label></p>
			<?php endif; ?>
			
			<?php foreach ( $modules as $module ) : ?>
			<p><label><input type="checkbox" class="fl-builder-template-data-checkbox" name="fl-builder-export-module[]" value="<?php echo $module['id'] ?>" /> <?php echo $module['name'] ?></label></p>
			<?php endforeach; ?>
			
		</div>

		<p class="submit">
			<input type="submit" name="update" class="button-primary" value="Export Template Data" />
			<?php wp_nonce_field( 'fl-builder-template-data-exporter', 'fl-builder-template-data-exporter-nonce' ); ?>
		</p>
	</form>
</div>