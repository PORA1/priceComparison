<?php
include "connection.php";
include('cekvendor.php');
$errors = array();

// extracts id vendor via user session and assigns it to vendor id for commodity table
$store_usr = $_SESSION['username'];
$pick_from = mysqli_query($connection, "SELECT idvendor FROM vendor WHERE username = '$store_usr';");
while ($row = $pick_from -> fetch_assoc())
{
    $store = $row['idvendor'];
}

if(isset($_POST['upload1commodity']))
{
    $commodityname  = mysqli_real_escape_string($connection, $_POST['commodityname']);  
    $commodityprice = mysqli_real_escape_string($connection, $_POST['commodityprice']);
    $vendorid = $store;
    $commodityimage = mysqli_real_escape_string($connection, $_FILES['commodityimage']['name']);

//deals with image storage to databse
    $commodityimageName = $_FILES['commodityimage']['name'];
    $commodityimageTmpName = $_FILES['commodityimage']['tmp_name'];
    $commodityimageSize = $_FILES['commodityimage']['size'];
    $commodityimageError = $_FILES['commodityimage']['error'];
    $commodityimageType = $_FILES['commodityimage']['type'];

    $commodityimageExt = explode('.',$commodityimageName );
    $commodityimageActualExt = strtolower(end($commodityimageExt));
    $allowed =array('jpg','jpeg','png');


    if(in_array($commodityimageActualExt,$allowed)) {
        if($commodityimageError === 0)
        {
            if ($commodityimageSize < 1000000){
                $commodityimageNameNew = uniqid('',true). ".".$commodityimageActualExt;
                $fileDestination = "assets/img/commodityimages/".$commodityimageNameNew;
                move_uploaded_file($commodityimageTmpName, $fileDestination);
            }else {echo 'Your file is too big';}

        }
        else{echo'Their was an error uploading your file';}
    }
    else{echo 'You cannot upload files of this type';}
//error handlers for the upload form 
    if(empty($commodityname)){
        array_push($errors, "Commodity name is required");
    }
    if(empty($commodityprice)){
        array_push($errors, "Commodity Price is required");
    }
    if(empty($commodityimage)){
        array_push($errors, "Commodity image is required");
    }

    if(count($errors) == 0){
        // $check = mysqli_real_escape_string($connection,"SELECT * FROM commodity_table WHERE idvendor=$vendorid,commodityname='$commodityname',commodityprice='$commodityprice',commodityimage='$commodityimage'");
        // $query = mysqli_query($check);
        // if(mysqli_num_rows($query) > 0 ){
        //  echo "This Commodity already exists";
        //  echo mysqli_error($connection);
        // }

        $insert_commodity = mysqli_query($connection, "INSERT INTO commodity_table (commodityname,commodityprice,commodityimage,idvendor) VALUES ('$commodityname','$commodityprice','$commodityimageNameNew','$vendorid')");
        echo mysqli_error($connection);

        if($insert_commodity == 1)
        {
            header("Location: upload.php");
        }
    }
}
?>