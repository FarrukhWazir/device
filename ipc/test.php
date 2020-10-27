<?php
//if($_POST)
{
	print_r($_FILES); 
}
?>
<form class="form-inline" id='fileUploadForm' method='POST' name='fileUploadForm' action="" enctype="multipart/form-data">
	<div class="form-group">
		<label for="email">Select Firmware:</label>
		<input type="file" class="form-control"  name='file' id='file' required>
	</div>
	<button type="submit" id='btnSubmit' class="btn btn-default">Upload</button>
</form> 