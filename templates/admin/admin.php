<div id="rp-admin">
	<h1>
		<span class="dashicons-before dashicons-feedback"></span>
		WC Customizer
	</h1>
	<form name="wc-customizer" id="wc-customizer" method="post" action="<?php echo admin_url('admin-ajax.php'); ?>">
		<?php wp_nonce_field( 'wc-customizer-s', 'rpnonce' ); ?>
		<input type="hidden" name="action" value="update_options">
		<label class="selectit">
			Replace the default Sale badge text
			<input type="text" name="wc-customizer-sale-text" value="<?php echo esc_attr( get_option( 'wc-customizer-sale-text', 'On Sale' ) ); ?>">
		</label>
		<div style="margin-top:15px">
			<button class="rp-btn">Save</button>
			<a class="rp-btn rp-btn-default rp-reset-options">Reset defaults</a>&nbsp;
		</div>
	</form>
	<p class="infotext" style="font-size:12px">If you like <strong>WC Customizer</strong> please leave us a <a href="#" target="_blank" class="wc-rating-link" data-rated="Thanks :)">★★★★★</a> rating. A huge thank you from me in advance!</p>
</div>