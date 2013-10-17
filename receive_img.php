<?php
$uploaddir = './uploads/';
$uploadfile = $uploaddir . uniqid();
//print_r($_POST);
//print_r($_FILES);

if ( move_uploaded_file( $_FILES['file']['tmp_name'], $uploadfile) ) {
echo $uploadfile;
}
?>
