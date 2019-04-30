jQuery(document).ready(function() {
   jQuery('#wc-customizer').submit(function() { 
      jQuery(this).ajaxSubmit({
         success: function(resp){
			   notify.create("Your settings were successfully updated");
            setTimeout(function(){
               window.location.reload(true);
            }, 3000 );
         }
      }); 
      return false; 
   });
   jQuery('.rp-reset-options').click(function(){
		if( confirm('Are you sure?') === true ) {
			jQuery.post(ajaxurl, {'action':'reset_options'},function(){
				notify.create("Your settings were successfully reset");
            setTimeout(function(){
               window.location.reload(true);
            }, 3000 );
			});
		}
   });
});