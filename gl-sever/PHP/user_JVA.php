<?php
function getToken() {
      //简单生成token
      $token="";
      $pattern = '1234567890abcdefghijklmnopqrstuvwxyz 
      ABCDEFGHIJKLOMNOPQRSTUVWXYZ';
      for($i=0;$i<12;$i++){ 
       $name = $pattern{mt_rand(0,35)}; //生成php随机数 
       $token=$token.$name;
      } 
      return $token;
}
?>