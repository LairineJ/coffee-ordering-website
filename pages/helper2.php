<?php
include "../assets/connection.php";
$selectedValue = $_GET["selectedValue"];
$pdID = $_GET['pdID'];

$query = "SELECT * FROM sub_categ WHERE m_categ_name = '$selectedValue'";
$result = mysqli_query($conn, $query);
    while ($rowt = mysqli_fetch_array($result)) {
      $getCatID = "select prod_categ from products where prod_id= '$pdID'";
      $res = mysqli_query($conn, $getCatID);
      $owshi = mysqli_fetch_assoc($res);
      $pdCATEG= $owshi['prod_categ'];
      $sels = ($pdCATEG == $rowt["s_categ_name"]) ? 'selected' : '';
        echo '<option value="' . $rowt["s_categ_name"]. '" ' . $sels . '>' . $rowt["s_categ_name"] .'</option>';
    }
?>


