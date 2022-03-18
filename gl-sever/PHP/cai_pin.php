<?php  
 header('Content-Type:application/json');  
 header("Access-Control-Allow-Origin:*"); //允许所有地址跨域请求
 header("Access-Control-Allow-Headers:*");//允许所有请求头
 header("Access-Control-Allow-Methods:GET, POST, OPTIONS, DELETE");//允许所有请求的类型

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
$key=$_POST['key'];//进行操作的数


switch ($key) {
    case 1:
        $sql="select * from cp";
        $obj=mysqli_query($link,$sql);
        while ($nr=mysqli_fetch_assoc($obj)) {
            $list=[];
            $list['id']=$nr['id'];
            $list['cai_name']=$nr['cai_name'];
            $list['cai_xi']=$nr['cai_xi'];
            $list['jiage']=$nr['jiage'];
            $list['cai_img']=$nr['cai_img'];
            array_push($datas,$list);  //array_push数组添加函数选择  1.数组后 2.添加要的元素
        }
        echo json_encode($datas);
        break;
    case 2:        //删除
        $ide=$_POST['id'];
        $sql="delete from cp where id=".$ide."";
        $obj=mysqli_query($link,$sql);
       
          break;
    case 3:           //修改
        $id=$_POST['id'];//要修改的id
        $idsr=$_POST['idsr'];
        $name=$_POST['cai_name'];//菜品名称
        $namexi=$_POST['cai_xi'];//菜系
        $jiage=$_POST['jiage']; //价格
        $img=$_POST['cai_img'];//图片
        $sql="update cp SET id='".$idsr."',cai_name='".$name."',cai_xi='".$namexi."',jiage='".$jiage."',cai_img='".$img."' where id=".$id."";
        $obj=mysqli_query($link,$sql);
        break;

    case 4:  //插入菜品
         $name=$_POST['cai_name'];
         $xi=$_POST['cai_xi'];
         $jiage=$_POST['jiage'];
         $img=$_POST['cai_img'];
        $sql="insert into cp(cai_name,cai_xi,jiage,cai_img)values('".$name."','" .$xi."','".$jiage."','".$img."')";
        $obj=mysqli_query($link,$sql);
        break;

    case 5://搜索
       $name=$_POST['cai_name'];
       $sql="select * from cp where cai_name like '%".$name."%'"; 
       $obj=mysqli_query($link,$sql);
       while ($nr=mysqli_fetch_assoc($obj)) {
        $list=[];
        $list['id']=$nr['id'];
        $list['cai_name']=$nr['cai_name'];
        $list['cai_xi']=$nr['cai_xi'];
        $list['jiage']=$nr['jiage'];
        $list['cai_img']=$nr['cai_img'];
        array_push($datas,$list);  //array_push数组添加函数选择  1.数组后 2.添加要的元素
    }
    echo json_encode($datas);
         break; 
    case 6:  //修改多内容
        $up_name=$_POST['xi_name'];
        $up_namesr=$_POST['xi_namesr'];
        $sql="update cp set cp.cai_xi='".$up_namesr."' where cp.cai_xi='".$up_name."'";
        mysqli_query($link,$sql);
        break;
     case 7:  //删除多内容
         # code...
        $name=$_POST['xi_name'];
        $sql="delete from cp where cai_xi='".$name."'";
        mysqli_query($link,$sql);
         break;
     case 8://返回对应菜系的菜品
        $name=$_POST['cai_xi'];
        $sql="select * from cp where cai_xi='".$name."'"; 
        $obj=mysqli_query($link,$sql);
        while ($nr=mysqli_fetch_assoc($obj)) {
         $list=[];
         $list['id']=$nr['id'];
         $list['cai_name']=$nr['cai_name'];
         $list['cai_xi']=$nr['cai_xi'];
         $list['jiage']=$nr['jiage'];
         $list['cai_img']=$nr['cai_img'];
         $list['num']=$nr['num'];
         array_push($datas,$list);  //array_push数组添加函数选择  1.数组后 2.添加要的元素
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