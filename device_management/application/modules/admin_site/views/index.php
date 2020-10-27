
<div class="welcome">
    <div class="container-fluid">
      <div class="row">
        <div class="col-md-12">
          <div class="content">
            <h2>Welcome to SKAIS Firmware Demo - HIKVISION: DS-2CD7146GO-IZS</h2>
            <p>This interface is only for demo purpose.</p>
          </div>
        </div>
      </div>
    </div>
</div>
<div class="container-fluid">
  <div class="row">
    <div class="col-md-6">
      <div class="box">
        <i class="far fa-lightbulb fa-fw bg-primary"></i>
        <div class="info">
          <h3><a href="javascript:;" onclick="getApiResponse('camera_status.php','Camera Status')">Camera Status</a></h3>
          <p>Get camera status.</p>
        </div>
      </div>
    </div>
    <div class="col-md-6">
      <div class="box">
        <i class="fa fa-desktop fa-fw bg-primary"></i>
        <div class="info">
          <h3><a href="javascript:;" onclick="getApiResponse('app_running_status.php','Camera App Runing Status')">Camera App Running Status</a></h3>
          <p>Get all running apps in camera status.</p>
        </div>
      </div>
    </div>
    <div class="col-md-6">
      <div class="box">
        <i class="fas fa-level-up-alt fa-fw bg-primary"></i>
        <div class="info">
          <h3><a href="javascript:;" onclick="getApiResponse('upgrade_firmware_popup.php','Upgrade Camera Firmware')">Upgrade Camera Firmware</a></h3> 
          <p>Update firmware to latest version of camera.</p>
        </div>
      </div>
    </div>
    <div class="col-md-6">
      <div class="box">
        <i class="fa fa-refresh fa-fw bg-primary"></i>
        <div class="info">
          <h3><a href="javascript:;" onclick="getApiResponse('camera_reboot.php','Reboot Camera')">Reboot Camera</a></h3>
          <p>Reboot the camera.</p>
        </div>
      </div>
    </div>
    <div class="col-md-6">
      <div class="box" style='opacity:0.5'>
        <i class="fa fa-certificate fa-fw bg-primary"></i>
        <div class="info">
          <h3><a href="javascript:;"  onclick="getApiResponse1('','Add SSL')">Add SSL</a></h3>
          <p>Add SSL certificate.</p>
        </div>
      </div>
    </div>
    <div class="col-md-6">
      <div class="box" style='opacity:0.5'>
        <i class="fa fa-certificate fa-fw bg-primary"></i>
        <div class="info">
          <h3><a href="javascript:;" onclick="getApiResponse1('','Remove SSL')">Remove SSL</a></h3>
          <p>Remove SSL certificate.</p>
        </div>
      </div>
    </div>
  </div>
</div>
<div id="myModal" class="modal fade" role="dialog">
  <div class="modal-dialog modal-sm1">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" style="color:red" data-dismiss="modal">&times;</button>
        <h3 class="modal-title">API RESPONSE</h3>
      </div>
      <di
      v class="modal-body">
        <span id="api-response"></span>
      </div>
    </div>
    
  </div>
</div>