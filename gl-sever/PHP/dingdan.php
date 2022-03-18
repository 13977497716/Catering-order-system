<?php 

header('Content-Type:application/json');  
header("Access-Control-Allow-Origin:*");
header("Access-Control-Allow-Headers:*");
header("Access-Control-Allow-Methods:GET, POST, OPTIONS, DELETE");
$link=mysqli_connect('localhost','root','root');
if(!$link){
    exit('连接数据库失败');
}
mysqli_set_charset($link,'utf8');

mysqli_select_db($link,'dg');

$datas=[];
$key=$_GET['dd_key'];

switch ($key) {
    case 1:  //渲染列表
         $sql="select * from dd ";
        $obj=mysqli_query($link,$sql);
        
        while ($nr=mysqli_fetch_assoc($obj)) {
            $list=[];
            $list['id']=$nr['id'];
            $list['date']=$nr['date'];
            $list['sum']=$nr['sum'];
            $list['code']=$nr['code'];
            array_push($datas,$list);
            # code...
        }
        echo json_encode($datas);
        # code...
        break;
    
        case 2:   //插入订单
            $id=$_GET['idname'];
            $date=$_GET['date'];
            $sum=$_GET['sum'];
            $sql="insert INTO dd VALUES('".$id."','".$date."','".$sum."','1')";
           mysqli_query($link,$sql);
           exit("插入成功");
            # code...
            break;
        case 3:   //修改订单code
            $id=$_GET['idname'];
            $num=$_GET['num'];
            $sql="update dd SET code='".$num."' where id='".$id."'";
            mysqli_query($link,$sql);
            exit("修改取消订单成功");
            # code...
            break; 
        case 4: //删除
            $date=$_GET['date'];
            $sql="delete FROM dd WHERE date='".$date."'"; 
            mysqli_query($link,$sql); 
            exit("删除订单成功");
            break;
        case 5://分页查询
            $limt=$_GET['limt'];   //页码
            $pagesize=$_GET['pagesize'];

            $offset=$pagesize*($limt - 1);
            $sql="select * from dd  order by id desc limit ". $offset.",".$pagesize." ";
            $obj=mysqli_query($link,$sql);
            while ($nr=mysqli_fetch_assoc($obj)) {
                $list=[];
                $list['id']=$nr['id'];
                $list['date']=$nr['date'];
                $list['sum']=$nr['sum'];
                $list['code']=$nr['code'];
                array_push($datas,$list);  //array_push数组添加函数选择  1.数组后 2.添加要的元素
            }
            echo json_encode($datas);
            break; 
        case 6://查询时间
            $sql="select distinct date from dd" ;
            $obj=mysqli_query($link,$sql);
           
            while ( $nr=mysqli_fetch_assoc($obj)) { 
               array_push($datas,$nr['date']);
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