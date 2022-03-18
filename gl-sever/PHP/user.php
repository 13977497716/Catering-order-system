<?php 
 header('Content-Type:application/json');  
 header("Access-Control-Allow-Origin:*");
 header("Access-Control-Allow-Headers:*");
 header("Access-Control-Allow-Methods:GET, POST, OPTIONS, DELETE");
 include 'user_JVA.php';
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


$datas=[];
 $key=$_GET['user_key'];//进行操作的数

switch ($key) {
   
    case 1:  //查询总数
        $sql="select * from user ";
        $obj=mysqli_query($link,$sql);
        while ($nr=mysqli_fetch_assoc($obj)) {
            $list=[];
            $list['id']=$nr['id'];
            $list['username']=$nr['username'];
            $list['password']=$nr['password'];
            $list['xian']=$nr['xian'];
            $list['user_img']=$nr['user_img'];
            array_push($datas,$list);  //array_push数组添加函数选择  1.数组后 2.添加要的元素
        }
        echo json_encode($datas);
        break;
     case 2:
        $id=$_GET['id'];
        $sql='delete from user where id='.$id.'';
        mysqli_query($link,$sql);
        exit('删除成功');
         break;
     case 3:
        $id=$_GET['id'];
        $userid=$_GET['userid'];
        $username=$_GET['username'];
        $password=$_GET['password'];
        $xian=$_GET['xian'];
        $img=$_GET['user_img'];
        $sql="update user set  id=".$userid.", username='".$username."',password='".$password."',xian='".$xian."',user_img='".$img."' where id=".$id."";
        mysqli_query($link,$sql);
        exit('修改成功');
        break;    
     case 4:
        $username=$_GET['username'];
        $password=$_GET['password'];
        $xian=$_GET['xian'];
        $img=$_GET['user_img'];
         $token=getToken();  
        $sql="insert into user (username,password,xian,user_img,token) VALUES ('".$username."','".$password."','".$xian."','".$img."','".$token."')";
        mysqli_query($link,$sql);
        exit('新增成功');
         # code...
         break;       
    case 5: //分页查询
            $limt=$_GET['limt'];
            $pagesize=$_GET['pagesize'];
            $offset=$pagesize*($limt - 1);
            $sql="select * from user limit ". $offset.",".$pagesize."";
            $obj=mysqli_query($link,$sql);
            while ($nr=mysqli_fetch_assoc($obj)) {
                $list=[];
                $list['id']=$nr['id'];
                $list['username']=$nr['username'];
                $list['password']=$nr['password'];
                $list['xian']=$nr['xian'];
                $list['user_img']=$nr['user_img'];
                array_push($datas,$list);  //array_push数组添加函数选择  1.数组后 2.添加要的元素
            }
            echo json_encode($datas);
            exit($count);
            break; 
     case 6:
        $token=$_GET['token'];
         $sql="select * from user where token='".$token."'";
         $obj=mysqli_query($link,$sql);
         $nr=mysqli_fetch_assoc($obj);
         $datas['username']=$nr['username'];
         $datas['user_img']=$nr['user_img'];
         $datas['password']=$nr['password'];
         $datas['id']=$nr['id'];
         $datas['xian']=$nr['xian'];
         echo json_encode($datas);
         break;       
    default:
        # code...
        break;
}

//.关闭数据库
mysqli_close($link);


?>