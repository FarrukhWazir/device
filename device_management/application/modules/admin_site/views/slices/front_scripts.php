	<script>

		// function getApiResponse(api,label='API Response')
		// {
		// 	 $('#myModal').modal('show');
		// 	 $('.modal-title').text(label);
		// 	 $('#api-response').html('<span style="text-align: center;display: block;"><img src="https://i.pinimg.com/originals/25/ef/28/25ef280441ad6d3a5ccf89960b4e95eb.gif" /></span>');
		// 	 $.post(api).done(function(response){
		// 		$('#api-response').html(response); 
		// 	 });
		// }
		
		$('#select_camera').select2({
		  	placeholder: 'Select camera';
		});

		$('body').on('click','#camera_reboot', function(){

			var camera_id = $('#select_camera').val();
			$.ajax({
				url: "<?php echo SURL ?>qa_admin/get_timezone_new",
				type: "POST",
				data : {lead_id:lead_id,zipcode:zipcode},
				success:function(response){

					$('#time_zone'+lead_id).val(response);
				}
			});	

		});


	</script>