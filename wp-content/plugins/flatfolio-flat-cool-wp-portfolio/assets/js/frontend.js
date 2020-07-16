/* 
File: assets/js/frontend.js
Description: JS Script for Frontend
Plugin: FlatFolio
Author: Alessio Marzo
*/

jQuery(function($){
$(window).load(function(){ 


	//Filtering
	$('.og-filter button').click(function(){
		
		var cat = $(this).attr('id');
		
		$('.og-filter button').removeClass('filter-selected');
		$(this).addClass('filter-selected');
		
		$('.og-grid li').each(function(){
			
			if( $(this).hasClass(cat) || cat == 'viewall' ) {
			
				$(this).show(300);	
			
			}else{
				
				$(this).hide(300);
								
			}
			
		});		
		
		
	});
			
	

});
});
