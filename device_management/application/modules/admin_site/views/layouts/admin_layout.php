<?php ?>
<html lang="en">
  <head>
    <meta charset="UTF-8">
    <title>Dashboard</title>
    <?php if(!empty($admin_header_script)){ echo $admin_header_script; } ?> 
    
    
  </head>
  <body>

      <section class="statistics" style="margin-top:0px">
          <?php if(!empty($header)){ echo $header; } ?> 
      </section>
      
      <section class="statistics">

        <?php echo $content; ?>
          
      </section>

      <?php if(!empty($front_scripts)){ echo $front_scripts; } ?>
  </body>
</html>
