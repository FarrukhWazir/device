<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<!DOCTYPE html>
<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1">
<style>
* {box-sizing: border-box;}

body { 
  margin: 0;
  font-family: Arial, Helvetica, sans-serif;
}

.header {
    overflow: hidden;
    background-color: #e9e3ec;
    padding: 5px 10px;
}

.header a {
  float: left;
  color: black;
  text-align: center;
  padding: 12px;
  text-decoration: none;
  font-size: 18px; 
  line-height: 25px;
  border-radius: 4px;
}

.header a.logo {
  font-size: 25px;
  font-weight: bold;
}

.header a:hover {
  background-color: #ddd;
  color: black;
}

.header a.active {
  background-color: dodgerblue;
  color: white;
}

.header-right {
  float: right;
}

@media screen and (max-width: 500px) {
  .header a {
    float: none;
    display: block;
    text-align: left;
  }
  
  .header-right {
    float: none;
  }
}
</style>
<meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>

</head>
<body>

<div class="header">
  <a href="#default" class="logo"><i>Altitude Crude</i></a>
</div>
<div class="container">
  <h2 style="width:100%" >Altitude Staff Listing <p style="float:right;"><button class="btn btn-success" data-toggle="modal" data-target="#myModal" >Add Staff</button></p> </h2>
             
  <table class="table table-striped">
    <thead>
      <tr>
        <th>Name</th>
        <th>Designation</th>
        <th>Sort</th>
        <th>Edit</th>
        <th>Delete</th>
      </tr>
    </thead>
    <tbody id="tbody">
      <?php if( count($users_arr)){

        foreach ($users_arr as $key => $value) { ?> 
          
          <tr>
                <td><?=$value['name']?></td>
                <td><?=$value['designation']?></td>
                <td><?=$value['sort']?></td>
                <td><button class="btn btn-danger" id="edit_user" data-id="<?=$value['id']?>" >Edit</button></td>
                <td><button class="btn btn-danger" id="delete_user" data-id="<?=$value['id']?>" >Delete</button></td>
          </tr>
      <?php  
        }//end loo[]

      }else{ ?>

        <tr><td colspan="4">No Record Found</td></tr>
      <?php  
      }// end if else
      ?>
      
    </tbody>
  </table>
</div>


<div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Add Staff</h4>
        </div>
        <div class="modal-body">
          <form action="javascript:void(0)" id="add_staff_form">
            <div class="form-group">
              <label for="email">Name:</label>
              <input type="text" class="form-control"  placeholder="Enter Name" id="save_name" name="name">
            </div>
            <div class="form-group">
              <label for="email">Designation:</label>
              <input type="text" class="form-control"  placeholder="Enter Designation"  name="designation">
            </div>
            
          </form>
        </div>
        <div class="modal-footer">
          <button type="submit" style="float:right" id="add_staff_submit" class="btn btn-success">Save</button>
        </div>
      </div>
      
    </div>
</div>

<div class="modal fade" id="myModal_edit" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Edit Staff</h4>
        </div>
        <div class="modal-body">
          <form action="javascript:void(0)" id="edit_staff_form">
            <div class="form-group">
              <label for="email">Name:</label>
              <input type="text" class="form-control" id="name"  placeholder="Enter Name" name="name">
            </div>
            <div class="form-group">
              <label for="email">Designation:</label>
              <input type="text" class="form-control" id="designation"  placeholder="Enter Designation" name="designation">
            </div>
            <div class="form-group">
              <label for="email">Sort:</label>
              <input type="text" class="form-control" id="sort_input"  placeholder="Enter Sort" name="sort">
            </div>
            
          </form>
        </div>
        <div class="modal-footer">
          <button type="submit" style="float:right" id="edit_staff_submit" data-id="" class="btn btn-success">Update</button>
        </div>
      </div>
      
    </div>
</div>
</body>
</html>

<script type="text/javascript">

  $('body').on("click","#add_staff_submit", function(){

    var save_name = $('#save_name').val();
    if(save_name != '' ){
      var postData = $('#add_staff_form').serializeArray();
      $('#add_staff_form').trigger("reset");

      $.ajax({
        url : "<?php echo SURL;?>users/add_users",
        type: "POST",
        data : postData,
        success:function(data) 
        {
          
          get_users();
          $('#myModal').modal('hide');
        }
      });
    }else{
      alert("Please enter staff name");
    }

  });

  $('body').on("click","#delete_user", function(){

  	if(confirm("Are you sure?")){
	    var id = $(this).attr('data-id');
	    $.ajax({
	      url : "<?php echo SURL;?>users/delete_user/"+id,
	      type: "POST",
	      success:function(data) 
	      {
	        get_users();
	      }
	    });
	}

  });

  $('body').on("click","#edit_user", function(){

    var id = $(this).attr('data-id');
    $.ajax({
      url : "<?php echo SURL;?>users/get_user_by_id/"+id,
      type: "POST",
      success:function(data) 
      {
      	var data_arr = JSON.parse(data);
      	$('#name').val(data_arr.name);
      	$('#designation').val(data_arr.designation);
      	$('#sort_input').val(data_arr.sort);
      	$('#edit_staff_submit').attr('data-id',data_arr.id);
      	$('#myModal_edit').modal('show');

      }
    });

  });

  $('body').on("click","#edit_staff_submit", function(){

  	var id= $(this).attr('data-id');
    var postData = $('#edit_staff_form').serializeArray();
    $('#add_staff_form').trigger("reset");

    $.ajax({
      url : "<?php echo SURL;?>users/add_users/"+id,
      type: "POST",
      data : postData,
      success:function(data) 
      {
        
        get_users();
        $('#myModal_edit').modal('hide');
      }
    });

  });
  

  function get_users(){

    $.ajax({
      url : "<?php echo SURL;?>users/get_users",
      type: "POST",
      success:function(data) 
      {
         $('#tbody').html(data);
      }
    });


  }
</script>
