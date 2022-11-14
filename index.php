<?php
session_start();
require_once 'includes/db_connect.php';
    // file uploads start
    if (isset($_FILES['attachments'])) {
        $msg = "";
        $targetFile = "uploads/" . basename($_FILES['attachments']['name'][0]);
        if (file_exists($targetFile))
        $msg = array("status" => 0, "msg" => "File already exists!");
        else if  (move_uploaded_file($_FILES['attachments']['tmp_name'][0], $targetFile)){
        // $fileName = $_FILES['attachments']['tmp_name'][0];
        $fileName = basename($_FILES['attachments']['name'][0]);
        $exp = explode('.',$fileName);
        $fontName = $exp[0];
        // insert start 
        $sql = "INSERT INTO file_upload (font_name,file_name, upload_time)VALUES('$fontName','".$fileName."','".date("Y-m-d H:i:s")."')";
        //echo $sql;
        mysqli_query($db,$sql);
        // insert end
        $msg = array("status" => 1, "msg" => "File Has Been Uploaded", "path" => $targetFile);
        exit(json_encode($msg));
        }
    }
    // file upload end

    //delete font start
    if(isset($_GET['id'])){
        $id=$_GET['id'];
        $sql_delete = "DELETE FROM file_upload WHERE id='$id'";
        // echo $sql_delete;
        $delete_query =mysqli_query($db,$sql_delete);
        header("Location: index.php");
    }
    //delete font end 

    //delete font  group start
    if(isset($_GET['name'])){
        $name=$_GET['name'];
        $sql_delete = "DELETE FROM font_group WHERE name='$name'";
        // echo $sql_delete;
        $delete_query =mysqli_query($db,$sql_delete);
        header("Location: index.php");
    }
    //delete font group end 

    //edit font  group start
    if(isset($_GET['edit_group'])){
        $id=$_GET['id'];
        $name=$_POST['name_group'];
        $sql_update = "UPDATE `font_group` SET `name`='$name' WHERE id='$id'";
        //echo $sql_update;
        $update_query =mysqli_query($db,$sql_update);
        header("Location: index.php");
    }
    //edit font groiup end 

// font group insertation start
if(isset($_POST['create']))
{
    $name = $_POST['name'];
    $count = count($name);
    if($count<2){
        $_SESSION['status'] = "You have to select at least 2 fonts";
        header("Location: index.php");
        exit(0);
    }
    // print_r($name);
    $font = $_POST['font'];

    foreach($name as $index => $names)
    {
        $s_name = $names;
        $s_font = $font[$index];
        $query = "INSERT INTO font_group (name,font) VALUES ('$s_name','$s_font')";
        //echo $query;
        $query_run = mysqli_query($db, $query);
    }

    if($query_run)
    {
        $_SESSION['status'] = "Multiple Data Inserted Successfully";
        header("Location: index.php");
        exit(0);
    }
    else
    {
        $_SESSION['status'] = "Data Not Inserted";
        header("Location: index.php");
        exit(0);
    }
}

// font group insertation end
?>
    
<style>
    <?php include 'css/style.css';?>
</style>

<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    
  <title>Zepto Assignment</title>
  </head>
  <body>
    <div class="container">
        <div class="row">
            <div class="card text-dark bg-light mb-3" style="max-width: 100%;">
            <div class="card-header" align='center'>Zepto Assignment <br>
            Name: Nazrul Islam Safa <br>
            Cell: 01680128089 <br>
            Email: nazrul.safa@gmail.com
        </div>
            <div class="card-body" >
                <h5 class="card-title" align='center'>Assignment</h5>
	</head>
	<body>
		<center>
			<div id="dropZone">
				<h1>Drag & Drop Files...</h1>
				<input type="file" id="fileupload" name="attachments[]" multiple>
			</div>
			<h1 id="error"></h1><br><br>
			<h1 id="progress"></h1><br><br>
			<div id="files"></div>
		</center>
<br>
<div class="card text-dark bg-light" style="max-width: 100%;">
    <div class="card-header text-left"><h5 class="card-title">Our Fonts</h5></div>
    <div class="card-body">

<table class="table table-bordered "> 
    <tr class="bg-light">
        <th scope="col" class="col-5 text-center">Font Name</th>
        <th scope="col" class="col-5 text-center">Preview</th>
        <th scope="col" class="col-2 text-center">Action</th>
    </tr>
    <tbody>
        <?php
            $sqlp = "SELECT * FROM `file_upload` ORDER BY font_name ASC";
           // echo $sqlp;
            $sqlrunp= mysqli_query($db, $sqlp);
            while($array=mysqli_fetch_array($sqlrunp)){
                ?>
                <tr>
                    <td class="text-center"> <?= $array['font_name']; ?></td>
                    <td class="text-center"> 
                    <?
                    if($array['file_name']){
                        ?>
                        <a href="./uploads/<?= $array['file_name'];?>" target="_blank">Example Style</a>
                        <?
                    }
                    ?></td>
                    <td class="text-center">
                        <a href="./index.php?id=<?=$array['id']?>" style="color:red" name='delete'>Delete</a>
                    </td>
                </tr>

              <?php
               }
               ?>

            </tbody>
        </table>
</div></div>

<div class="card text-dark bg-light" style="max-width: 100%;">
    <div class="card-header text-left"><h5 class="card-title">Create Font Groups</h5> 
    <small>You have to select at least 2 fonts</small>
</div>
    <div class="card-body">       
                <?php 
                    if(isset($_SESSION['status']))
                    {
                        ?>
                            <div class="alert alert-warning alert-dismissible fade show" role="alert">
                            <?php echo $_SESSION['status']; ?>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        <?php
                        unset($_SESSION['status']);
                    }
                ?>
 
            <form action="index.php" method="POST"> 
                <div class="main-form mt-3 border-bottom">
                    <div class="row">
                        <div class="col-md-4">
                            <div>
                                <input type="text" name="name[]" class="form-control" required placeholder="Enter Name">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div>
                                <?php  
                                $sqlpp = "SELECT DISTINCT font_name from `file_upload`  ORDER BY font_name ASC";
                                // echo $sqlpp;
                                $sqlrunpp= mysqli_query($db, $sqlpp);
                                ?>
                                <select data-skip-name="true" name="font[]" class="form-control">
                                <option value="">--Select a font--</option>
                                <?php while($typel= mysqli_fetch_array($sqlrunpp))
                                {?>
                               <option value="<?php echo $typel["font_name"];?>"><?php echo $typel["font_name"]?></option>
                                <?php 
                                 }
                                 ?>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="paste-new-forms"></div>
                <button type="submit" name="create" class="btn btn-success float-end">Create</button>
                <a href="javascript:void(0)" class="add-more-form float-left btn btn-primary">ADD ROW</a>
            </form>
        </div>
        </div>
        </div>
        </div>


   <?php
        if(isset($_GET['edit'])){
            $id = $_GET['id'];
            $sql_edit = "SELECT * FROM `font_group` WHERE id='$id'";
            // echo $sqlp1;
            $sqlrunp_edit= mysqli_query($db, $sql_edit);
            $assoc_edit = mysqli_fetch_assoc($sqlrunp_edit);
           ?>
            <div class="card text-dark bg-light" style="max-width: 100%;">
                <div class="card-header text-left"><h5 class="card-title">Edit Font Groups Name</h5> 
                </div>
                <div class="card-body">
                    <tbody>
                    <form action='index.php?id=<?=$id ?>&edit_group' method='POST'>
                        <div class="form-group col-md-6">
                            <label>Font Name</label>
                            <input type="text" name ="name_group" class="form-control" value=<?php echo $assoc_edit['name']?>>
                        </div>
                        <br>
                        <button type="submit" class="btn btn-primary">Submit</button>
                        </form>
                    </tbody>
                </div>
            </div>
           <?php
        }
   ?>


    <div class="card text-dark bg-light" style="max-width: 100%;">
        <div class="card-header text-left"><h5 class="card-title">Our Font Groups</h5> 
            <small>List of all avilable font groups</small>
        </div>
        <div class="card-body">
        <table class="table table-bordered "> 
            <tr class="bg-light">
                <th scope="col" class="col-4 text-center">Name</th>
                <th scope="col" class="col-4 text-center">Fonts</th>
                <th scope="col" class="col-2 text-center">Count</th>
                <th scope="col" class="col-2 text-center">Action</th>
            </tr>
            <tbody>
                <?php
                    $sqlp = "SELECT * FROM `font_group` GROUP by name ORDER BY name ASC";
                   // echo $sqlp;
                    $sqlrunp= mysqli_query($db, $sqlp);
                    while($array=mysqli_fetch_array($sqlrunp)){
                        ?>
                        <tr>
                            <td class="text-center"> <?= $array['name']; ?></td>
                            <td class="text-center"> 
                            <?php
                                $sqlp1 = "SELECT font FROM `font_group` WHERE name='$array[name]' ORDER BY name ASC";
                                // echo $sqlp1;
                                 $sqlrunp1= mysqli_query($db, $sqlp1);
                                 foreach( $sqlrunp1 as $data ) 
                                 {
                                  echo $var =  $data['font'].", ";
                                  }
                            ?>
                            </td>
                            <td class="text-center">
                                 <?php
                                      $sqlp2 = "SELECT COUNT(font) as total FROM `font_group` WHERE name='$array[name]' ORDER BY name ASC";
                                      //echo $sqlp2;
                                      $sqlrunp2= mysqli_query($db, $sqlp2);
                                      $assoc = mysqli_fetch_array( $sqlrunp2);
                                      echo $assoc['total'];
                                 ?>
                            </td>
                            <td class="text-center">
                                <a href="./index.php?id=<?=$array['id']?>&edit" name='edit'>Edit</a> ||
                                <a href="./index.php?id=<?=$array['id']?>&name=<?=$array['name']?>&delete" style="color:red" name='delete_group'>Delete</a>
                            </td>
                        </tr>
                    <?php
                    }
                    ?>
            </tbody>
            <br><br>
        </table>
        </div>
    </div>
    <div class="card text-dark bg-light" style="max-width: 100%;">
        <div class="card-header text-left"><h5 class="card-title"></h5> 
        </div>
    </div>

               </div>
            </div>
        </div>
    </div>

    <script src="http://code.jquery.com/jquery-3.2.1.min.js" integrity="sha256-hwg4gsxgFZhOsEEamdOYGBf13FyQuiTwlAQgxVSNgt4=" crossorigin="anonymous"></script>
    <script src="js/vendor/jquery.ui.widget.js" type="text/javascript"></script>
    <script src="js/jquery.iframe-transport.js" type="text/javascript"></script>
    <script src="js/jquery.fileupload.js" type="text/javascript"></script>

<!-- file upload data insert start js -->
 <script type="text/javascript">
            $(function () {
               var files = $("#files");

               $("#fileupload").fileupload({
                   url: 'index.php',
                   dropZone: '#dropZone',
                   dataType: 'json',
                   autoUpload: false
               }).on('fileuploadadd', function (e, data) {
                   var fileTypeAllowed = /.\.(ttf)$/i;
                   var fileName = data.originalFiles[0]['name'];

                   if (!fileTypeAllowed.test(fileName))
                        $("#error").html('Only ttf are allowed!');
                   else {
                       $("#error").html("");
                       data.submit();
                   }
               }).on('fileuploaddone', function(e, data) {
                    var status = data.jqXHR.responseJSON.status;
                    var msg = data.jqXHR.responseJSON.msg;

                    if (status == 1) {
                        var path = data.jqXHR.responseJSON.path;
                        $("#files").fadeIn().append('<p><img style="width: 100px; height: 100px;" src="'+path+'" /></p>');
                    } else
                        $("#error").html(msg);
               }).on('fileuploadprogressall', function(e,data) {
                    var progress = parseInt(data.loaded / data.total * 100, 10);
                    $("#progress").html("Completed: " + progress + "%");
               });
            });
        </script>
<!-- file  upload insert data end -->



<!-- multiple data insert start js -->
  <script>
        $(document).ready(function () {
            $(document).on('click', '.remove-btn', function () {
                $(this).closest('.main-form').remove();
            });
            
            $(document).on('click', '.add-more-form', function () {
                $('.paste-new-forms').append('<div class="main-form mt-3 border-bottom">\
                        <div class="row">\
                            <div class="col-md-4">\
                                <div class="form-group">\
                                    <input type="text" name="name[]" class="form-control" required placeholder="Enter Name">\
                                </div>\
                            </div>\
                            <div class="col-md-4">\
                                <div class="form-group">\
                                <?php  
                                $sqlpp = "SELECT DISTINCT font_name from `file_upload`  ORDER BY font_name ASC";
                                // echo $sqlpp;
                                $sqlrunpp= mysqli_query($db, $sqlpp);
                                ?>
                                <select data-skip-name="true" name="font[]" class="form-control">\
                                <option value="">Select a font</option>\
                                <?php while($typel= mysqli_fetch_array($sqlrunpp))
                                {?>
                                <option value="<?php echo $typel["font_name"];?>"><?php echo $typel["font_name"]?></option>\
                                <?php }?>
                        </select>\
                                </div>\
                            </div>\
                            <div class="col-md-4">\
                                <div class="form-group">\
                                    <button type="button" class="remove-btn btn btn-danger">Remove</button>\
                                </div>\
                            </div>\
                        </div>\
                        </div>');
            });

        });
    </script>
<!-- multiple data insewrt end -->

    <!-- Option 1: Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>

    <!-- Option 2: Separate Popper and Bootstrap JS -->
    <!--
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>
    -->
  </body>
</html>