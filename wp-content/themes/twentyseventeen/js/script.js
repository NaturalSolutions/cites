/*jQuery.post(
    ajaxurl,
    {
        'action': 'taxons_search',
        'search': 'coucou'
    },
    function(response){
            console.log(response);
        }
);*/



var $ = jQuery.noConflict();

$( document ).ready(function() {
		
		$('#searchBtn').click(function() {

		var keyword = $('#searchVal').val();
			$.post(
				ajaxurl,
				{
					'action': 'taxons_search',
					'search': keyword
				},
				function(response){
					//$('.somewhere').html(response);
					console.log('** repose ***');
					console.log(response);
				}
			);
		});
	











	
		
});