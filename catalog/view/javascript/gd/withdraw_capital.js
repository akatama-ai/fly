$(function(){
	$('.frm_capital').on('submit', function() {
		var self = $(this);
		var value = self.serialize();
        alertify.confirm('<p class="text-center" style="font-size:25px;color: black;text-transform: ;height: 20px">Are you sure ?</p>', function(e) {
            if (e) {
                window.funLazyLoad.start();				
                 $.ajax({
	                 type: "POST",
	                 url: 'confirm-sm-withdrawl-capital',
	                 data: value,
	                 success: function(response) {
	                 	response = $.parseJSON(response);
	                     if(_.has(response, 'input') && response['input'] === -1){
	                     	alertify.set('notifier','delay', 100000000);
	                     	alertify.set('notifier','position', 'top-right'); 
	                     	alertify.error('Please try again !!!');
	                     	window.funLazyLoad.reset();
	                     	return false;
	                     }
	                    
	                     if(_.has(response, 'error_value') && response['error_value'] === -1){
	                     	alertify.set('notifier','delay', 100000000); 
	                     	alertify.set('notifier','position', 'top-right');
	                     	alertify.error('Please try again !!!');
	                     	window.funLazyLoad.reset();
	                     	 return false;
	                     	}
	                    if(_.has(response, 'error_value') && response['error_value'] === 1){
							var xhtml = '<p class="text-center" style="font-size:25px;color: black;text-transform: ;height: 20px">Withdrawal Success!</p>';
	                         alertify.alert(xhtml, function() {
	                             location.reload(true);
	                         });
						} 

	                 }
	             });
            } else {
                return false;
            }
        });

        return false;
    });
})