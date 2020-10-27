<?php ?>
<html lang="en">
  <head>
    <meta charset="UTF-8">
    <title>Dashboard</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link href="https://fonts.googleapis.com/css?family=Droid+Sans" rel="stylesheet">
    
    <style>
    * {
  padding: 0;
  margin: 0;
  -webkit-box-sizing: border-box;
  -moz-box-sizing: border-box;
  box-sizing: border-box;
  font-family: 'Droid Sans', sans-serif;
  outline: none;
}
::-webkit-scrollbar 
{
  background: transparent;
  width: 5px;
  height: 5px;
}
::-webkit-scrollbar-thumb 
{
  background-color: #888;
}
::-webkit-scrollbar-thumb:hover 
{
  background-color: rgba(0, 0, 0, 0.3);
}
body {background-color: #fff}
#contents {
  position: relative;
  transition: .3s;
  margin-left: 290px;
  background-color: #2a2b3d;
}
.margin {
  margin-left: 0 !important;
}
/* Start side navigation bar  */

.side-nav {
  float: left;
  height: 100%;
  width: 290px;
  background-color: #252636;
  color: #000;
  -webkit-transform: translateX(0);
  -moz-transform: translateX(0);
  transform: translateX(0);
  -webkit-transition: all .3s ease-in-out;
  -moz-transition: all .3s ease-in-out;
  transition: .3s;
  position: fixed;
  top: 0;
  left: 0;
  overflow: auto;
  z-index: 9999999
}
.side-nav .close-aside {
  position: absolute;
  top: 7px;
  right: 7px;
  cursor: pointer;
  color: #000;
}
.side-nav .heading {
  background-color: #252636;
  padding: 15px 15px 15px 30px;
  overflow: hidden;
  border-bottom: 1px solid #2a2b3c
}
.side-nav .heading > img {
  border-radius: 50%;
  float: left;
  width: 28%;
}
.side-nav .info {
  float: left;
  width: 69%;
  margin-left: 3%;
}
.side-nav .heading .info > h3 {margin: 0 0 5px}
.side-nav .heading .info > h3 > a {
  color: #000;
  font-weight: 100;
  margin-top: 4px;
  display: block;
  text-decoration: none;
  font-size: 18px;
}
.side-nav .heading .info > h3 > a:hover {
  color: #000;
}
.side-nav .heading .info > p {
  color: #000;
  font-size: 13px;
}
/* End heading */
/* Start search */
.side-nav .search {
  text-align: center;
  padding: 15px 30px;
  margin: 15px 0;
  position: relative;
}
.side-nav .search > input {
  width: 100%;
  background-color: transparent;
  border: none;
  border-bottom: 1px solid #23262d;
  padding: 7px 0 7px;
  color: #DDD
}
.side-nav .search > input ~ i {
  position: absolute;
  top: 22px;
  right: 40px;
  display: block;
  color: #2b2f3a;
  font-size: 19px;
}
/* End search */

.side-nav .categories > li {
  padding: 17px 40px 17px 30px;
  overflow: hidden;
  border-bottom: 1px solid rgba(255, 255, 255, 0.02);
  cursor: pointer;
}
.side-nav .categories > li > a {
  color: #000;
  text-decoration: none;
}
/* Start num: there are three options primary, danger and success like Bootstrap */
.side-nav .categories > li > a > .num {
  line-height: 0;
  border-radius: 3px;
  font-size: 14px;
  color: #000;
  padding: 0px 5px
}
.dang {background-color: #f35959}
.prim {background-color: #0275d8}
.succ {background-color: #5cb85c}
/* End num */
.side-nav .categories > li > a:hover {
  color: #000
}
.side-nav .categories > li > i {
  font-size: 18px;
  margin-right: 5px
}
.side-nav .categories > li > a:after {
  content: "\f053";
  font-family: fontAwesome;
  font-size: 11px;
  line-height: 1.8;
  float: right;
  color: #000;
  -webkit-transition: all .3s ease-in-out;
  -moz-transition: all .3s ease-in-out;
  transition: all .3s ease-in-out;
}
.side-nav .categories .opend > a:after {
  -webkit-transform: rotate(-90deg);
  -moz-transform: rotate(-90deg);
  transform: rotate(-90deg);
}
/* End categories */
/* Start dropdown menu */
.side-nav .categories .side-nav-dropdown {
  padding-top: 10px;
  padding-left: 30px;
  list-style: none;
  display: none;
}
.side-nav .categories .side-nav-dropdown > li > a {
  color: #000;
  text-decoration: none;
  padding: 7px 0;
  display: block;
}
.side-nav .categories p {
  margin-left: 30px;
  color: #535465;
  margin-top: 10px;
}

/* End dropdown menu */

.show-side-nav {
  -webkit-transform: translateX(-290px);
  -moz-transform: translateX(-290px);
  transform: translateX(-290px);
}


/* Start media query */
@media (max-width: 767px) {
  .side-nav .categories > li {
    padding-top: 12px;
    padding-bottom: 12px;
  }
  .side-nav .search {
    padding: 10px 0 10px 30px
  }
}

/* End side navigation bar  */
/* Start welcome */

.welcome {
  color: #000;
}
.welcome .content {
  background-color: #fff;
  padding: 15px;
  margin-top: 25px;
}
.welcome h2 {
  font-family: Calibri;
  font-weight: 100;
  margin-top: 0
}
.welcome p {
  color: #000;
}


/* Start statistics */
.statistics {
  margin-top: 25px;
  color: #000;
}
.statistics {
  margin-top: 25px;
  color: #000;
}
.statistics .box {
  background-color: #fff;
  padding: 15px;
  overflow: hidden;
  box-shadow: 0px 0px 5px 0px gray;
  margin-top: 10px;
  margin-bottom: 10px;
}
.statistics .box > i {
  float: left;
  color: #fff;
  border-radius: 50%;
  width: 60px;
  height: 60px;
  line-height: 60px;
  font-size: 22px;
}
.statistics .box .info {
  float: left;
  width: auto;
  margin-left: 10px;
}
.statistics .box .info h3 {
  margin: 5px 0 5px;
  display: inline-block;
}
.statistics .box .info p {color:#000}

/* End statistics */
/* Start charts */
.charts {
  margin-top: 25px;
  color: #000
}
.charts .chart-container {
  background-color: #fff;
  padding: 15px;
}
.charts .chart-container h3 {
  margin: 0 0 10px;
  font-size: 17px;
}

/* Start users */

.admins {
  margin-top: 25px;
}
.admins .box {

}
.admins .box > h3 {
  color: #ccc;
  font-family: Calibri;
  font-weight: 300;
  margin-top: 0;
}
.admins .box .admin {
  margin-bottom: 20px;
  overflow: hidden;
  background-color: #fff;
  padding: 10px;
}
.admins .box .admin .img {
  width: 20%;
  margin-right: 5%;
  float: left;
}
.admins .box .admin .img img {
  border-radius: 50%;
}
.admins .box .info {
  width: 75%;
  color: #000;
  float: left;
}
.admins .box .info h3 {font-size: 19px}
.admins .box .info p {color: #000}

/* End users */
/* Start statis */

.statis {
  color: #000;
  margin-top: 15px;
}
.statis .box {
  position: relative;
  padding: 15px;
  overflow: hidden;
  border-radius: 3px;
  margin-bottom: 25px;
}
.statis .box h3:after {
  content: "";
  height: 2px;
  width: 70%;
  margin: auto;
  background-color: rgba(255, 255, 255, 0.12);
  display: block;
  margin-top: 10px;
}
.statis .box i {
  position: absolute;
  height: 70px;
  width: 70px;
  font-size: 22px;
  padding: 15px;
  top: -25px;
  left: -25px;
  background-color: rgba(255, 255, 255, 0.15);
  line-height: 60px;
  text-align: right;
  border-radius: 50%;
}

/*chart*/
.chrt3 {
  padding-bottom: 50px;
}
.chrt3 .chart-container {
  height: 350px;
  padding: 15px;
  margin-top: 25px;
}
.chrt3 .box {
  padding: 15px;
}













.main-color {
  color: #ffc107
}
.warning {background-color: #f0ad4e}
.danger {background-color: #d9534f}
.success {background-color: #5cb85c}
.inf {background-color: #5bc0de}
/* Start bootstrap */
.navbar-right .dropdown-menu {
  right: auto !important;
  left: 0 !important;
}
.navbar-default {
  background-color: #6f6486 !important;
  border: none !important;
  border-radius: 0 !important;
  margin: 0 !important
}
.navbar-default .navbar-nav>li>a {
  color: #000 !important;
  line-height: 55px !important;
  padding: 0 10px !important;
}
.navbar-default .navbar-brand {color:#000 !important}
.navbar-default .navbar-nav>li>a:focus,
.navbar-default .navbar-nav>li>a:hover {color: #000 !important}

.navbar-default .navbar-nav>.open>a,
.navbar-default .navbar-nav>.open>a:focus,
.navbar-default .navbar-nav>.open>a:hover {background-color: transparent !important; color: #000 !important}

.navbar-default .navbar-brand {line-height: 55px !important; padding: 0 !important}
.navbar-default .navbar-brand:focus,
.navbar-default .navbar-brand:hover {color: #000 !important}
.navbar>.container .navbar-brand, .navbar>.container-fluid .navbar-brand {margin: 0 !important}
@media (max-width: 767px) {
  .navbar>.container-fluid .navbar-brand {
    margin-left: 15px !important;
  }
  .navbar-default .navbar-nav>li>a {
    padding-left: 0 !important;
  }
  .navbar-nav {
    margin: 0 !important;
  }
  .navbar-default .navbar-collapse,
  .navbar-default .navbar-form {
    border: none !important;
  }

}

.navbar-default .navbar-nav>li>a {
  float: left !important;
}
.navbar-default .navbar-nav>li>a>span:not(.caret) {
  background-color: #e74c3c !important;
  border-radius: 50% !important;
  height: 25px !important;
  width: 25px !important;
  padding: 2px !important;
  font-size: 11px !important;
  position: relative !important;
  top: -10px !important;
  right: 5px !important
}
.dropdown-menu>li>a {
  padding-top: 5px !important;
  padding-right: 5px !important;
}
.navbar-default .navbar-nav>li>a>i {
  font-size: 18px !important;
}




/* Start media query */

@media (max-width: 767px) {
  #contents {
    margin: 0 !important
  }
  .statistics .box {
    margin-bottom: 25px !important;
  }
  .navbar-default .navbar-nav .open .dropdown-menu>li>a {
    color: #000 !important
  }
  .navbar-default .navbar-nav .open .dropdown-menu>li>a:hover {
    color: #000 !important
  }
  .navbar-default .navbar-toggle{
    border:none !important;
    color: #000 !important;
    font-size: 18px !important;
  }
  .navbar-default .navbar-toggle:focus, .navbar-default .navbar-toggle:hover {background-color: transparent !important}
}
body
{
	color:#000 !important;
}
h1,h2,h3{
   background: -webkit-linear-gradient(#00BEEC,#00FAB2);
  -webkit-background-clip: text;
  -webkit-text-fill-color: transparent;
}
.modal-content {
	background-color: #fff;
}
</style>
</head>
<body>
    <section class="statistics" style="margin-top:0px">
        <div class="container-fluid">
          <div class="row">
            <div class="box">
                <i class="" style="width:180px; margin-top:10px"><img src="https://skais.com.my/wp-content/uploads/2020/01/logo-main-e1580188074192.png" /></i>
                <div class="info" style="float:right">
                  <h1>SKAIS Firmware</h1>
                </div>
              </div>
          </div>
        </div>
    </section>
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
    <section class="statistics">
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
    </section>
      <!-- Modal -->
    <div id="myModal" class="modal fade" role="dialog">
      <div class="modal-dialog modal-sm1">
    
        <!-- Modal content-->
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" style="color:red" data-dismiss="modal">&times;</button>
            <h3 class="modal-title">API RESPONSE</h3>
          </div>
          <div class="modal-body">
            <span id="api-response"></span>
          </div>
        </div>
        
      </div>
    </div>
      <script src='http://code.jquery.com/jquery-latest.js'></script>
      <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
     <script>
	 function getApiResponse(api,label='API Response')
	 {
		 $('#myModal').modal('show');
		 $('.modal-title').text(label);
		 $('#api-response').html('<span style="text-align: center;display: block;"><img src="https://i.pinimg.com/originals/25/ef/28/25ef280441ad6d3a5ccf89960b4e95eb.gif" /></span>');
		 $.post(api).done(function(response){
			$('#api-response').html(response); 
		 });
	 }
    </script>
	<script src='https://kit.fontawesome.com/a076d05399.js'></script>
      </body>
    </html>