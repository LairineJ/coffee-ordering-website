<?php
include "../assets/connection.php";

$val= $_GET["value"];
$val_M = mysqli_real_escape_string($conn, $val);

       $sql = "select s_categ_name, m_categ_name from sub_categ where m_categ_name ='$val_M'";
            $result= mysqli_query($conn, $sql);
            if (mysqli_num_rows($result)>0){
              echo "<select name='ProductCateg'>";

              while($row= mysqli_fetch_assoc($result)) {
                echo "<option>".$row["s_categ_name"]."</option>";
              }
              echo "</select>";
            }
      ?>