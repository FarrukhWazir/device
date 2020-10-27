<div class='row'>
	<div class='col-md-12'>
		<form class="form-inline" id='fileUploadForm' name='fileUploadForm' action="/action_page.php" enctype="multipart/form-data">
			<div class="form-group">
				<label for="email">Select Firmware:</label>
				<input type="file" class="form-control"  name='file' id='file' accept=".dav" required>
			</div>
            <div class="form-group">
				<button type="submit" id='btnSubmit' class="btn btn-default">Upload</button>
            </div>
            <div class="row">
            	<div class="col-sm-12" align="left">
					<div class="alert alert-primary"><span id="result" style="margin: 10px"></span></div>
				</div>
			</div>
		</form>
	</div>
</div>
<script>
$(document).ready(function () {
	$('#result').html('');
    $("#btnSubmit").click(function (event) 
	{
        //stop submit the form, we will post it manually.
        event.preventDefault();
        // Get form
		//alert($('#file').val());
		if($('#file').val() !='')
		{
			var form = $('#fileUploadForm')[0];
			// Create an FormData object
			var data = new FormData(form);
			// If you want to add an extra field for the FormData
			//data.append("CustomField", "This is some extra data, testing");
			// disabled the submit button
			$("#btnSubmit").prop("disabled", true);
			$("#result").html('<span style="text-align: center;display: block;"><img src="https://i.pinimg.com/originals/25/ef/28/25ef280441ad6d3a5ccf89960b4e95eb.gif" /></span>');
			$.ajax({
				type: "POST",
				enctype: 'multipart/form-data',
				url: "upgrade_firmware.php",
				data: data,
				processData: false,
				contentType: false,
				cache: false,
			   // timeout: 600000,
				success: function (data) {

					$("#result").html(data);
					console.log("SUCCESS : ", data);
					$("#btnSubmit").prop("disabled", false);

				},
				error: function (e) {

					$("#result").html(e.responseText);
					console.log("ERROR : ", e);
					$("#btnSubmit").prop("disabled", false);

				}
			});
		}
		else
		{
			 $("#result").html('please select firmware!.');
		}

    });

});
</script>