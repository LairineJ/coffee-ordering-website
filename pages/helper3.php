<?php
include "../assets/connection.php";
$pdID = $row['prod_id'];

$asd = "SELECT s_categ_name, m_categ_name FROM sub_categ WHERE m_categ_name = '$selectedValue'";
$sbCateg = "SELECT prod_categ FROM products WHERE prod_id = '$pdID'";
$eme = mysqli_query($conn, $sbCateg);
$owshi = mysqli_fetch_assoc($eme);

$prodCateg = $owshi['prod_categ'];

$resu = mysqli_query($conn, $asd);

if (mysqli_num_rows($resu) > 0) {


    while ($rowy = mysqli_fetch_assoc($resu)) {
        $selected = ($prodCateg == $rowy["s_categ_name"]) ? 'selected' : '';
        echo '<option value="' . $rowy["s_categ_name"] . '" ' . $selected . '>' . $rowy["s_categ_name"] . '</option>';
    }

}
?>