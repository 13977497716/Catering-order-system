<?php 
 header('Content-Type:application/json');  
 header("Access-Control-Allow-Origin:*");
 header("Access-Control-Allow-Headers:*");
 header("Access-Control-Allow-Methods:GET, POST, OPTIONS, DELETE");

 
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
$key=$_GET['key'];//进行操作的数
switch ($key) {
    case 1:
        $sql="select cai_xi,count(*) as sum from cp group by cai_xi";
        $obj=mysqli_query($link,$sql);
        while ($nr=mysqli_fetch_assoc($obj)) {
            $list=[];
            $list['value']=$nr['sum'];
            $list['name']=$nr['cai_xi'];
            array_push($datas,$list);  //array_push数组添加函数选择  1.数组后 2.添加要的元素
        }
        echo json_encode($datas);
        break;
        case 2:
            $sql="select date,count(*) as sum from dd group by date";
            $obj=mysqli_query($link,$sql);
            while ($nr=mysqli_fetch_assoc($obj)) {
                $list=[];
        
                $list['time']=$nr['date'];
                $list['sum']=$nr['sum'];
                array_push($datas,$list);  //array_push数组添加函数选择  1.数组后 2.添加要的元素
               
            }
            echo json_encode($datas);
            break;
         case 3:
            $sql="select xian,count(*) as sum from user	group by xian;";
            $obj=mysqli_query($link,$sql);
            while ($nr=mysqli_fetch_assoc($obj)) {
                $list=[];
              if($nr['xian']=="0"){
                $list['name']='员工';
              }else{
                $list['name']='管理员';
              }
               
                $list['value']=$nr['sum'];
                array_push($datas,$list);  //array_push数组添加函数选择  1.数组后 2.添加要的元素
               
            }
            echo json_encode($datas);
    default:
        # code...
        break;
}
//.关闭数据库
mysqli_close($link);

?>