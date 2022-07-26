<?php
include 'conn.php';  //Database Info
$conn = mysqli_connect($serverName,$userName,$userPassword,$dbName);
include 'function.php'; //Status Converter
include 'MapController.php'; //SQL arrayToDataTable

?>
<html>
    <head>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="source\css\bootstrap.css">
    <link rel="stylesheet" href="custom\main.css">
    <meta charset="utf-8">
    <title>True6:GeoDataMap</title>

    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript">
      google.charts.load('current', {
        'packages':['geochart'],
      });
      google.charts.setOnLoadCallback(drawRegionsMap);

      function drawRegionsMap() {
        var data = google.visualization.arrayToDataTable([
          ['Provinces', 'Status'],
          <?php echo $data2map; 
          //send data to gv.
          
          ?>
        ]);

        var options = {
            region: 'TH',
            resolution: 'provinces',
            //displayMode: 'markers',
            colorAxis: {minValue: 0, maxValue: 2,colors: ['#00FF48', '#F5C800', '#FA0135']},
            backgroundColor: '#00b3ff',
            datalessRegionColor: '#cfd7ff',
           
            keepAspectRatio: true,
            legend : 'none',
            tooltip: {isHtml: true}

            
        };

        var chart = new google.visualization.GeoChart(document.getElementById('monitor_div'));

        chart.draw(data, options);
      }
    </script>


    </head>
    <body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark shadow-sm" >
<div class="container-fluid">
 <a class="navbar-brand" href="dashboard.php"><img src="https://scontent.fbkk2-7.fna.fbcdn.net/v/t1.6435-9/155458399_2339511476193377_4484185785174429904_n.jpg?_nc_cat=106&ccb=1-7&_nc_sid=174925&_nc_eui2=AeFv9IBK-nPVi8pO6MUckRi9-MOwkUsa_R_4w7CRSxr9H4zwhIZfzev9Kuy7AQ-WwJA1ua_vrNRQux27TZuybTUS&_nc_ohc=cIlgpuYjtbUAX8sws6x&tn=CvU-KLrvjUdQLld2&_nc_ht=scontent.fbkk2-7.fna&oh=00_AT-ceH3a6PfiNt3J8dJA-0yV9N6ZjOS3n9H-fky0otLoZA&oe=62ED6EBB" class="d-inline-block align-top" width="30" height="30" alt=""> Ture6: User SidE</a>
 <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
   <span class="navbar-toggler-icon"></span>
 </button>
 <div class="collapse navbar-collapse" id="navbarSupportedContent">
   <ul class="navbar-nav me-auto mb-2 mb-lg-0">
     <li class="nav-item">
       <a class="nav-link active" aria-current="page" href="dashboard.php">GeoDataMap</a>
     </li>
     <li class="nav-item disabled">
       <a class="nav-link disabled" aria-current="page" href="">Version : <?php echo $c_version;?></a>
     </li>
   </ul>
 </div>
</div>
</nav>
    <div class="container">
     <div class="row">
      <div class="col-12">
        <div class="jumbotron mt-3">
  <h2 class="display-5">True6:GeoDataMap</h2>
  <hr class="my-1" style="max-width:100%" >
  <p class="lead">Siwadol's Project INTERN:2</p>
</div>
      </div>

      <div class="col-lg-12">
      <?php
      if (isset($_GET["result"]) == 1) {
      $result = $_GET["result"];
    }else {
      $result = NULL;
    }
      if ($result == "fail") {
        echo '
        <div class="alert alert-success alert-dismissible fade show" role="alert" id="success-alert">
        <strong>Error!</strong> Somethnig went worng.'.'
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        ';
      }elseif ($result == "done") {
        echo '
        <div class="alert alert-success alert-dismissible fade show" role="alert" id="success-alert">
        <strong>Success!</strong> New Ticket have been created. | ID:'.$_GET["newid"].'
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        ';
      }
      elseif ($result == "unknown") {
        echo '
        <div class="alert alert-warning w-100 shadow-sm alert-dismissible fade show" role="alert">
        ออกจากระบบอัตโนมัติเนื่องจากไม่มีการเคลื่อนไหวนานกว่า 15 นาที
        </div>
        ';
      }
      ?>
    </div>
     </div>
    <?php
    
    ?>
    
    <div class="row d-grid gap-3">
    <div class="col-lg-12 mb-12">
      <div class="card shadow-sm w-100">
    <div class="card-body monitor_div" id="monitor_div" class="map">
    </div>
    <div class="card-footer">Green = Normal | Yellow = NSA | Red = SA</div>
  </div>
    </div>

    <div class="col-lg-12 mb-12">
      <div class="card shadow-sm w-100" id="kokodayo" name="kokodayo">
      <div class="card-header">All Open Ticket</div>
    <div class="card-body">
    <div class="table-responsive">
      <table class="table text-dark table-hover table-striped mx-auto w-100 text-center align-middle">
                   <tr>
                   <td>Site</td>
                   <td>Ticket no.</td>
                   <td>Province</td>
                   <td class="fix-textFUll-column">Date</td>
                   <td>Time</td>
                   <td>Duration</td>
                   <td>Detail</td>
                   <td>Status</td>
                 </tr>
                 <?php
                   $result = $conn->query("SELECT TicketNo FROM trueCATV ORDER BY TicketNo");
                   $row_cnt = $result->num_rows;

                   //echo $row_cnt;


                  if (isset($_GET["page"]) AND !empty($_GET["page"])) {
                    $page_default = intval($_GET["page"]);
                  }else {
                    $page_default = 1;
                  }
            
                 $no_of_records_per_page = 8;
                 $offset = ($page_default-1) * $no_of_records_per_page;
                 $total_pages = ceil($row_cnt / $no_of_records_per_page);
                 
                 $sql_all = "SELECT * FROM trueCATV ORDER BY time DESC, date LIMIT $offset, $no_of_records_per_page";
                 $query = mysqli_query($conn,$sql_all) or die("error");
                 $result_all = mysqli_query($conn, $sql_all);
                       while($row_gen = mysqli_fetch_array($result_all)) {
                       echo '<tr>';
                       echo '<td>'.$row_gen["site"]."</td>";
                       echo '<td>'.$row_gen["TicketNo"]."</td>";
                       echo '<td>'.$row_gen["province"]."</td>";
                       echo '<td class="fix-textFUll-column">'.$row_gen["date"]."</td>";
                       echo '<td>'.$row_gen["time"]."</td>";
                       echo '<td>'.$row_gen["duration"]."</td>";
                       echo '<td>'.$row_gen["detail"]."</td>";
                       echo '<td>'.checkStatus($row_gen["status"])."</td>";               
                       echo "</tr>"."\n";
                       };
                       ?>
      </table>
      </div>
      <div class="mt-3 w-100">
      <hr class="mt-4">
      <div class="btn-toolbar w-100" style="justify-content: center; display: flex;" role="toolbar" aria-label="Toolbar with button groups">
        <div class="btn-group my-2 shadow-sm" role="group" aria-label="First group">
         <a class="btn btn-dark" href="?page=1#kokodayo">หน้าแรก</a>


         <a class="btn btn-dark <?php if($page_default <= 1){ echo 'disabled'; } ?>"
             href="<?php if($page_default <= 1){ echo ''; } else { echo "?page=".($page_default - 1); } ?>#kokodayo">หน้าที่แล้ว</a>
         </a>
         <?php if ($page_default - 3 > 0) {
           $numtoback = $page_default - 3;
           echo '<a class="btn btn-dark" href="?page='.$numtoback.'#kokodayo">';
           echo $page_default - 3;
           echo "</a>";}
           if ($page_default - 2 > 0) {
             $numtoback = $page_default - 2;
             echo '<a class="btn btn-dark" href="?page='.$numtoback.'#kokodayo">';
             echo $page_default - 2;
             echo "</a>";}
             if ($page_default - 1 > 0) {
               $numtoback = $page_default - 1;
               echo '<a class="btn btn-dark" href="?page='.$numtoback.'#kokodayo">';
               echo $page_default - 1;
               echo "</a>";}
          ?>
         <button class="btn btn-dark mx-2"><?php  echo "$page_default";?></button>

         <?php if ($page_default + 1 <= $total_pages) {
           $numtoback = $page_default + 1;
           echo '<a class="btn btn-dark" href="?page='.$numtoback.'#kokodayo">';
           echo $page_default + 1;
           echo "</a>";}
           if ($page_default + 2 <= $total_pages) {
             $numtoback = $page_default + 2;
             echo '<a class="btn btn-dark" href="?page='.$numtoback.'#kokodayo">';
             echo $page_default + 2;
             echo "</a>";}
             if ($page_default + 3 <= $total_pages) {
               $numtoback = $page_default + 3;
               echo '<a class="btn btn-dark" href="?page='.$numtoback.'#kokodayo">';
               echo $page_default + 3;
               echo "</a>";}
          ?>

         <a class="btn btn-dark <?php if($page_default >= $total_pages){ echo 'disabled'; } ?>"
              href="<?php if($page_default >= $total_pages){ echo '#'; } else { echo "?page=".($page_default + 1); } ?>#kokodayo">หน้าถัดไป
         </a>
         <a class="btn btn-dark <?php if ($page_default == $total_pages) {echo "disabled";} ?>" href="?page=<?php echo $total_pages; ?>#kokodayo">หน้าสุดท้าย</a>
    </div>
      </div>
    </div>
    </div>
  </div>
    </div>

    <div class="col-lg-12 mb-3">
      <div class="card shadow-sm w-100">
      <div class="card-header">Open New Ticket</div>
    <div class="card-body">
    <form class="" id="newwish_form" action="newticket.php" method="post" onsubmit="return checkForm(this);">
      <div class="mb-3">
      <label for="Name" class="form-label">Site<span class="text-danger">*</span></label>
      <input type="text" class="form-control" id="site" name="site" aria-describedby="nameHelp" maxlength="512" autocomplete="new-name" required>
      </div>
      <div class="mb-3">
      <label for="Name" class="form-label">Province<span class="text-danger">*</span></label>
      <select name="province" id="province" class="form-control form-select" required="true">
      <option value="" selected>เลือก...</option>
      <?php
      $sql_allProvince = "SELECT * FROM provinces ORDER BY id ASC";
      $result_allProvince = mysqli_query($conn, $sql_allProvince);
      while($rowProvince = mysqli_fetch_array($result_allProvince)) {
      echo '<option value="'.$rowProvince["name_en"].'">'.$rowProvince["name_th"].'</option>';
      };
             ?>
    </select>
      </div>
      <div class="mb-3">
      <label for="tag" class="form-label">Date<span class="text-danger">*</span></label>
      <input type="date" class="form-control" id="date" name="date" aria-describedby="tagHelp" autocomplete="new-tag" required>
      </div>
      <div class="mb-3">
      <label for="tag" class="form-label">Time<span class="text-danger">*</span></label>
      <input type="time" class="form-control" id="time" name="time" aria-describedby="tagHelp" autocomplete="new-tag" required>
      </div>
      <div class="mb-3">
      <label for="duration" class="form-label">Duration<span class="text-danger">*</span></label>
      <input type="text" class="form-control" id="duration" name="duration" aria-describedby="nameHelp" maxlength="512" autocomplete="new-name" required>
      </div>
      <div class="mb-3">
      <label for="duration" class="form-label">Status<span class="text-danger">*</span></label>
      <select name="status" id="status" class="form-control form-select" required="true">
      <option value="" selected>เลือก...</option>
      <option value="0" disabled>Normal : ปกติ</option>
      <option value="1">NSA : ผิดปกติ แต่ไม่ส่งผลกระทบกับ Service</option>
      <option value="2">SA : ผิดปกติ และส่งผลกระทบกับ Service</option>
      </select>
      </div>
      <label for="Name" class="form-label">Detail<span class="text-danger">*</label>
      <div class="input-group mb-3">
  <textarea class="form-control" rows="4" cols="50" maxlength="500" name="detail" id="detail" aria-label="With textarea" required autocomplete="new-wish"></textarea>
  </div>
  <div id="tagHelp" class="form-text my-2">Ticket ID is Auto Generate.</div>
        <input type="submit" class="btn btn-lg w-100 btn_newWish text-white" id="btnSubmit" value="Open New Ticket" name="submit_button">
      </form>
    </div>
    </div>
    </div>
  



    <script type="text/javascript" src="source\js\bootstrap.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <script>
      function checkForm(form) // Submit button clicked
{
  //
  // check form input values
  //

  form.submit_button.disabled = true;
  form.submit_button.value = "Please wait... Opening New Ticket...";
  return true;
}
    </script>
<script type="text/javascript">

$(document).ready(function () {
 
window.setTimeout(function() {
    $(".alert").fadeTo(1000, 0).slideUp(1000, function(){
        $(this).remove(); 
    });
}, 6900);
 
});
</script>
    </body>
</html>