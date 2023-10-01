<h1>Welcome, <?php echo $_settings->userdata('firstname')." ".$_settings->userdata('lastname') ?>!</h1>
<hr>
<div class="row">
  <div class="col-12 col-sm-4 col-md-4">
    <div class="info-box">
      <span class="info-box-icon bg-gradient-danger elevation-1"><i class="fas fa-users"></i></span>
      <div class="info-box-content">
        <span class="info-box-text">Control Teams</span>
        <span class="info-box-number text-right h5">
          <?php 
            $team = $conn->query("SELECT * FROM team_list where delete_flag = 0")->num_rows;
            echo format_num($team);
          ?>
          <?php ?>
        </span>
      </div>
      <!-- /.info-box-content -->
    </div>
    <!-- /.info-box -->
  </div>
  <!-- /.col -->
  <div class="col-12 col-sm-4 col-md-4">
    <div class="info-box">
      <span class="info-box-icon bg-gradient-secondary elevation-1"><i class="fas fa-Ambulance"></i></span>
      <div class="info-box-content">
        <span class="info-box-text">Pending Requests</span>
        <span class="info-box-number text-right h5">
          <?php 
            $request = $conn->query("SELECT id FROM request_list where `status` = 0")->num_rows;
            echo format_num($request);
          ?>
          <?php ?>
        </span>
      </div>
      <!-- /.info-box-content -->
    </div>
    <!-- /.info-box -->
  </div>
  <!-- /.col -->
  <div class="col-12 col-sm-4 col-md-4">
    <div class="info-box">
      <span class="info-box-icon bg-gradient-light elevation-1"><i class="fas fa-Ambulance"></i></span>
      <div class="info-box-content">
        <span class="info-box-text">Assigned Requests</span>
        <span class="info-box-number text-right h5">
          <?php 
            $request = $conn->query("SELECT id FROM request_list where `status` = 1")->num_rows;
            echo format_num($request);
          ?>
          <?php ?>
        </span>
      </div>
      <!-- /.info-box-content -->
    </div>
    <!-- /.info-box -->
  </div>
  <div class="col-12 col-sm-4 col-md-4">
    <div class="info-box">
      <span class="info-box-icon bg-gradient-info elevation-1"><i class="fas fa-Ambulance"></i></span>
      <div class="info-box-content">
        <span class="info-box-text">Team OTW Requests</span>
        <span class="info-box-number text-right h5">
          <?php 
            $request = $conn->query("SELECT id FROM request_list where `status` = 2")->num_rows;
            echo format_num($request);
          ?>
          <?php ?>
        </span>
      </div>
      <!-- /.info-box-content -->
    </div>
    <!-- /.info-box -->
  </div>
  <!-- /.col -->
  <div class="col-12 col-sm-4 col-md-4">
    <div class="info-box">
      <span class="info-box-icon bg-gradient-primary elevation-1"><i class="fas fa-Ambulance"></i></span>
      <div class="info-box-content">
        <span class="info-box-text">On-Progress Requests</span>
        <span class="info-box-number text-right h5">
          <?php 
            $request = $conn->query("SELECT id FROM request_list where `status` = 3")->num_rows;
            echo format_num($request);
          ?>
          <?php ?>
        </span>
      </div>
      <!-- /.info-box-content -->
    </div>
    <!-- /.info-box -->
  </div>
  <!-- /.col -->
  <div class="col-12 col-sm-4 col-md-4">
    <div class="info-box">
      <span class="info-box-icon bg-gradient-teal elevation-1"><i class="fas fa-Ambulance"></i></span>
      <div class="info-box-content">
        <span class="info-box-text">Completed Requests</span>
        <span class="info-box-number text-right h5">
          <?php 
            $request = $conn->query("SELECT id FROM request_list where `status` = 4")->num_rows;
            echo format_num($request);
          ?>
          <?php ?>
        </span>
      </div>
      <!-- /.info-box-content -->
    </div>
    <!-- /.info-box -->
  </div>
  <!-- /.col -->
</div>
<div class="container">
  <?php 
    $files = array();
      $fopen = scandir(base_app.'uploads/banner');
      foreach($fopen as $fname){
        if(in_array($fname,array('.','..')))
          continue;
        $files[]= validate_image('uploads/banner/'.$fname);
      }
  ?>
  <div id="tourCarousel"  class="carousel slide" data-ride="carousel" data-interval="3000">
      <div class="carousel-inner h-100">
          <?php foreach($files as $k => $img): ?>
          <div class="carousel-item  h-100 <?php echo $k == 0? 'active': '' ?>">
              <img class="d-block w-100  h-100" style="object-fit:contain" src="<?php echo $img ?>" alt="">
          </div>
          <?php endforeach; ?>
      </div>
      <a class="carousel-control-prev" href="#tourCarousel" role="button" data-slide="prev">
          <span class="carousel-control-prev-icon" aria-hidden="true"></span>
          <span class="sr-only">Previous</span>
      </a>
      <a class="carousel-control-next" href="#tourCarousel" role="button" data-slide="next">
          <span class="carousel-control-next-icon" aria-hidden="true"></span>
          <span class="sr-only">Next</span>
      </a>
  </div>
</div>
