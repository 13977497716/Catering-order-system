<?php 
header('Content-Type:application/json');  
header("Access-Control-Allow-Origin:*");
header("Access-Control-Allow-Headers:*");
header("Access-Control-Allow-Methods:GET, POST, OPTIONS, DELETE");

//获得连接用户密码账号
$link=mysqli_connect('localhost','root','root');
if(!$link){
    exit("数据库连接失败");
}
//设置中文字符集
mysqli_set_charset($link,'utf8');
//选择数据库
mysqli_select_db($link,'dg');

$datas=[];//返回数据的数组
$key=$_POST['xi_key'];//选择进行的操作数

switch ($key) {
    case 1:   //查询
        $sql="select* from cx";
        $obj=mysqli_query($link,$sql);
        while ($nr=mysqli_fetch_assoc($obj)) {
            $list=[]; //创建map数组
            $list['id']=$nr['id'];
            $list['xi_name']=$nr['xi_name'];
            array_push($datas,$list);
        }
        echo json_encode($datas);
    case 2://删除
        $name=$_POST['xi_name'];
        $sql="delete from cx where xi_name='".$name."'";
        mysqli_query($link,$sql);
       
        break;
    case 3:  //修改
        $up_name=$_POST['xi_name'];
        $up_namesr=$_POST['xi_namesr'];

        $sql="update cx set cx.xi_name='".$up_namesr."' where cx.xi_name='". $up_name."'"; 

        $obj=mysqli_query($link,$sql);  
        break; 
    case 4:  //插入
        $name=$_POST['xi_name'];
        $sql="insert into cx(xi_name)values('".$name."')";
        mysqli_query($link,$sql);
        exit("插入成功");
        break;

    case 5:       //搜索
        $name=$_POST['xi_name'];
        $sql="select * from cx where xi_name like '%".$name."%'";
        $obj=mysqli_query($link,$sql);
        while ($nr=mysqli_fetch_assoc($obj)) {
           $list=[];
           $list['id']=$nr['id'];
           $list['xi_name']=$nr['xi_name'];
           array_push($datas,$list);
        }
        echo json_encode($datas);
        break;
        case 6:
            $sql="select xi_name from cx";
            $obj=mysqli_query($link,$sql);
            while ($nr=mysqli_fetch_assoc($obj)) {
                $list=[];
                $list['id']=$nr['id'];
                $list['xi_name']=$nr['xi_name'];
                array_push($datas,$list);
            }
            echo json_encode($datas);
            break;    
    default:
        # code...
        break;
}
//.关闭数据库
mysqli_close($link);

?>