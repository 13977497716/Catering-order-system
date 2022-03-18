<?php 
 header('Content-Type:application/json');  
 header("Access-Control-Allow-Origin:*");
 header("Access-Control-Allow-Headers:*");
 header("Access-Control-Allow-Methods:GET, POST, OPTIONS, DELETE");

      $username=$_POST['username'];
      $password=$_POST['password'];
      $datas=array('msg'=>'ok');
  
     //1.取得数据库连接
     $link=mysqli_connect('localhost','root','root');
     //2.判断数据库是否连接成功
     if(!$link){
         exit("数据库连接失败");//exit退出
     }
     //3.设置字符集
     mysqli_set_charset($link,'utf8');
     //4.选择数据库
     mysqli_select_db($link,'dg');
     //5.发送sql语句
      $sql="select * from user ";
      $obj=mysqli_query($link,$sql);
    
      

    while (  $nr=mysqli_fetch_assoc($obj)) {
      if($username==$nr["username"] && $password==$nr["password"]){
        $datas['code'] =200; //200登录成功，403登录失败
        $datas['xian'] = $nr['xian'];  //用户权限判断，1是管理员，0是普通用户
        $datas['id']=$nr['id'];
        $datas['username']=$nr['username'];
        $datas['token']=$nr['token'];
        break;
      }else{
       $datas['code']= 403;
        
      }
    }
   
  echo json_encode($datas);
  //.关闭数据库
mysqli_close($link);

  
?>