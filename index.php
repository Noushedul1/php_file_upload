<?php
include './confing.php';
include './database.php';
$db = new Database();
?>
<?php
$query = "SELECT * FROM upload";
$select_img = $db->select($query);
?>
<?php
// echo "<pre>";
// print_r($_FILES['file_upload']);
// echo "</pre>";
// echo $_FILES['file_upload']['name']."<br>";
// echo $_FILES['file_upload']['full_path']."<br>";
// echo $_FILES['file_upload']['tmp_name']."<br>";
// echo $_FILES['file_upload']['type']."<br>";
// echo $_FILES['file_upload']['size']."<br>";

if(isset($_POST['upload'])){
    $file_name = $_FILES['file_upload']['name'];
    $tmp_loc = $_FILES['file_upload']['tmp_name'];
    $file_type = $_FILES['file_upload']['type'];
    $file_size = $_FILES['file_upload']['size'];
    $upload_loc = "images/".$file_name;

    if(file_exists($upload_loc)){
        echo "File already exists";
    }else{
        if($file_size < 700000){
            if($file_type == 'image/jpeg') {
                if(move_uploaded_file($tmp_loc,$upload_loc)) {
                    echo 'file uploaded';
                    $query = "INSERT INTO upload(uploadimg) VALUES('$file_name')";
                    $insert_img = $db->imgInsert($query);
                }else{
                    echo "file not uploaded";
                }
            }else{
                echo 'file type not image/jpeg';
            }
        }else{
            echo "Your file size is greater than {$file_size}";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>php file upload</title>
    <style>
        .img_gallery{
            float: left;
        }
        img{
            width: 200px;
            height: 200px;
        }
    </style>
</head>
<body>
    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST" enctype="multipart/form-data">
        <input type="file" name="file_upload">
        <input type="submit" value="UPLOAD" name="upload">
    </form>
    <?php if($select_img) { ?>
        <?php while($img = $select_img->fetch_assoc()) { ?>
    <div>
        <?php 
           $img_data =  $img['uploadimg'];
         echo   "<div class='img_gallery'>
               <img src='images/$img_data'>
           </div>";
        ?>
    </div>
    <?php } ?>
    <?php } else { ?>
        <h1>
            Image is not found
        </h1>
    <?php } ?>
</body>
</html>