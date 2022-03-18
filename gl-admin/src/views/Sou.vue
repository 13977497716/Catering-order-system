<template>
  <div id="sou">
    <div class="kuai_1"></div>
    <div class="kuai_2"></div>

    <div class="img" ref="toux" @click="$refs.sou_user.style.top = '3%'">
      <img :src="Sou_list.userimg" alt="" />
      <div class="img_hei">修改信息</div>
    </div>
    <b>点击按钮进入管理系统</b>
    <span @click="nav_btn()" ref="cd">菜单</span>
    <button @click="tz()" class="tc_btn2">退出</button>

    <!-- 点击头像修改框 -->
    <div class="Sou_user" ref="sou_user">
      <i class="el-icon-close" @click="$refs.sou_user.style.top = '-100%'"></i>

      <div class="Sou_user_img" @click="$refs.user_upp.click()">
        <img :src="Sou_list.userimg" alt="" />
        <div class="Sou_user_img_hei">修改头像</div>
      </div>
      <input
        type="file"
        ref="user_upp"
        name=""
        id="Sou_file"
        @change="Sou_upp_img()"
      />

      <div class="inp">
        <p>
          <label>编号：</label
          ><el-input
            placeholder="请输入用户编号"
            size="large"
            v-model="Sou_list.userid"
            style="width: 70%"
          ></el-input>
        </p>
        <p>
          <label>账号：</label
          ><el-input
            placeholder="请输入用户账号"
            size="large"
            v-model="Sou_list.username"
            style="width: 70%"
          ></el-input>
        </p>
        <p>
          <label>密码：</label
          ><el-input
            placeholder="请输入用户密码"
            size="large"
            v-model="Sou_list.password"
            style="width: 70%"
          ></el-input>
        </p>
      </div>
      <button @click="Sou_user_upp()">确定修改</button>
    </div>

    <!-- 黑幕页 -->
    <div id="dl_ye" ref="nana"></div>
    <!-- 链接器手臂 -->
    <div class="shoubi" ref="shoubi">
      <div class="shoubi2">
        <p><img src="/img/lianjie.png" alt="" /></p>
        <p><img src="/img/lianjie.png" alt="" /></p>
        <p><img src="/img/lianjie.png" alt="" /></p>
        <p><img src="/img/lianjie.png" alt="" /></p>
      </div>
    </div>

    <div class="nav" ref="nav">
      <ul>
        <!-- /sou/:url/c1/:url 地址-->
        <li @click="ck(1)" :class="{ text_lan: li_show == '统计' }">
          <i class="el-icon-s-marketing"></i>统计
        </li>
        <li @click="ck(2)" :class="{ text_lan: li_show == '菜品' }">
          <i class="el-icon-notebook-1"></i>菜品
        </li>
        <li @click="ck(3)" :class="{ text_lan: li_show == '菜系' }">
          <i class="el-icon-notebook-2"></i>菜系
        </li>
        <li @click="ck(4)" :class="{ text_lan: li_show == '订单' }">
          订单管理
        </li>
        <li
          @click="ck(5)"
          :class="{ text_lan: li_show == '用户' }"
          v-if="Sou_list.xian !== 1 "
        >
          用户管理
        </li>
      </ul>

      <button @click="nav_btn()" class="btn_tc">退出系统设置</button>
    </div>

    <div class="nr" ref="nrnr">
      <router-view></router-view>
    </div>
  </div>
</template>

<script>
import axios from "axios";

export default {
  data() {
    return {
      sum: false, //导航栏的判断动画
      id: 1, //导航栏显示与隐藏
      url: "", //头像
      shu: "", //传过来的用户名字（判断）
      li_show: "", //li导航栏颜色判断

      Sou_list: {
        id: "",
        userid: "",
        username: "",
        password: "",
        userimg: "",
        xian: "",
      },
    };
  },

  mounted() {
    this.dh(); //动画函数
    this.chuan(); //获取路由传递函数
  },

  methods: {
    Sou_upp_open() {
      this.$notify({
        title: "成功",
        message: "修改用户账号信息成功",
        type: "success",
        offset: 120,
      });
    },

    dh() {
      setTimeout(function () {
        var kuai1 = document.querySelector(".kuai_1");
        var kuai2 = document.querySelector(".kuai_2");
        var imgsr = document.querySelector(".img");
        var span = document.querySelector("span");
        imgsr.style.top = "7%";
        kuai1.style.left = "-50%";
        kuai2.style.right = "-50%";
        span.style.bottom = "40%";
      }, 1000);
    },

    chuan() {
    //获得用户身份唯一token
    this.shu=window.sessionStorage.getItem('token')
    
      console.log(this.shu);
      axios({
        url: this.$urls + "/user.php",
        method: "get",
        params: {
          user_key: 6,
          token: this.shu,
        },
      }).then((res) => {
        console.log("数组有：", res.data);
        //渲染用户修改
        this.Sou_list.id = res.data.id;
        this.Sou_list.userid = res.data.id;
        this.Sou_list.username = res.data.username;
        this.Sou_list.password = res.data.password;
        this.Sou_list.xian = res.data.xian;
        let img = res.data.user_img;
        if (img == "") {
          alert("空");
          this.Sou_list.userimg = "/img/user/back.png";
        } else {
          this.Sou_list.userimg = img;
        }
      });
    },

    tz() {
      window.sessionStorage.removeItem("token");
      this.$router.push("/home");
      window.location.reload();
    },
    // 导航栏的显示和缩放
    nav_btn() {
      this.li_show = "";
      this.pd = false;
      this.sum = !this.sum;
      if (this.sum == true) {
        this.$refs.cd.style.opacity = "0.4";
        this.$refs.nav.style.right = "0";
        this.$refs.nana.style.transform = "translateX(0%)";
      } else {
        this.$refs.nav.style.right = "-50%";
        this.$refs.cd.style.opacity = "1";
        this.$refs.nana.style.transform = "translateX(-100%)";
        this.$refs.nrnr.style.transform = "translateX(-100%)"; //内容
        this.$refs.shoubi.style.right = "-40%"; //链接骨架
      }
    },

    //  跳转到各种导航路由组件
    ck(nube) {
      this.$refs.nrnr.style.transform = "translateX(0%)";
      this.$refs.shoubi.style.right = "7%";
      if (nube == 2) {
        this.li_show = "菜品";
        this.$router.push("/sou/dishes"); //跳转
        return;
      } else if (nube == 3) {
        this.li_show = "菜系";
        this.$router.push("/sou/dishesds" ); //跳转
        return;
      } else if (nube == 4) {
        this.li_show = "订单";
        this.$router.push("/sou/order" ); //跳转
        return;
      } else if (nube == 5) {
        this.li_show = "用户";
        this.$router.push("/sou/userAdmin" ); //跳转
        return;
      } else if (nube == 1) {
        this.li_show = "统计";
        this.$router.push("/sou/stat" ); //跳转
        return;
      }
    },
    //(2)修改插入的图片
    Sou_upp_img() {
      let file = document.querySelector("#Sou_file").value + "";
      let n = file.lastIndexOf("\\");
      let v = file.lastIndexOf(".");
      let sum = file.substr(n + 1, v);
      let loin = "/img/user/" + "";
      this.Sou_list.userimg = loin + sum;
      console.log("图片", this.Sou_list.userimg);
    },

    Sou_user_upp() {
      axios
        .get(this.$urls + "/user.php", {
          params: {
            user_key: 3,
            id: this.Sou_list.id,
            userid: this.Sou_list.userid,
            username: this.Sou_list.username,
            password: this.Sou_list.password,
            xian: this.Sou_list.xian,
            user_img: this.Sou_list.userimg,
          },
        })
        .then((res) => {
          console.log(res);
          this.Sou_upp_open();
        });
    },
  }, //methods
};
</script>


<style  scoped>
.btn_tc {
  border: none;
  width: 200px;
  height: 40px;
  border-radius: 20px;
  /* transform: translate(200px,500px); */
  background-color: rgb(0, 131, 238);
  color: #fff;
  position: absolute;
  bottom: 100px;
  left: 50%;
  transform: translateX(-20%);
}

.nr {
  position: absolute;
  left: 0;
  top: 0;
  transform: translateX(-100%);
  width: 80%;
  height: 100%;
  background: url(/img/nav2.png) no-repeat;
  background-size: 100% 100%;
  z-index: 999;
  transition: all 0.7s;
}

a,
p,
li {
  text-decoration: none;
}

.nav ul {
  list-style: none;
  position: absolute;
  left: 55%;
  bottom: 25%;
}

.nav ul li {
  margin: 20px auto;
  color: rgb(58, 58, 58);
  cursor: pointer;
  font-size: 25px;
  text-align: center;
  height: 40px;
  width: 114px;

  line-height: 40px;
  position: relative;
}

.nav ul li a {
  color: #000;
  font-size: 25px;
}

.nav ul li i {
  float: left;
  margin-top: 7px;
}

.nav ul li::before {
  content: "";
  display: inline-block;
  position: absolute;
  right: 0;
  width: 3px;
  height: 00px;
  background-color: rgb(23, 143, 241);
  transition: all 0.3s;
}

.nav ul li:hover::before {
  height: 40px;
}

.nav ul li:hover {
  color: rgb(15, 113, 240);
}
/* 黑幕页 */
#dl_ye {
  position: absolute;
  width: 100%;
  height: 100vh;
  background-color: black;
  transform: translateX(-100%);
  opacity: 0.5;
  transition: all 0.5s;
  top: 0;
}

.nav {
  width: 30%;
  height: 100%;
  z-index: 99;
  position: absolute;
  /* -50%  */
  right: -50%;
  top: 0;
  bottom: 0;
  transition: all 1s;
  background: url(/img/nav.png) no-repeat;
  background-size: cover;
  border: none;
}
#sou span {
  cursor: pointer;
  display: block;
  color: rgb(246, 246, 246);
  width: 50px;
  height: 50px;
  background: rgb(38, 139, 255);
  text-align: center;
  line-height: 50px;
  border-radius: 50%;
  border: 2px solid aliceblue;
  position: absolute;
  left: 50%;
  transform: translateX(-50%);
  bottom: -20%;
  z-index: 2;
  transition: all 1.5s ease 0.5s;
  opacity: 1;
}

b {
  font-size: 25px;
  color: #fff;
  position: absolute;
  top: 40%;
  left: 50%;
  transform: translateX(-50%);
  font-family: KaiTi;
}

.kuai_2 {
  position: absolute;
  width: 50%;
  height: 100%;
  background-color: rgb(255, 255, 255);
  top: 0;
  right: 0;
  z-index: 99;
  transition: all 2s;
}
.kuai_1 {
  position: absolute;
  width: 50%;
  height: 100%;
  background-color: rgb(255, 255, 255);
  top: 0;
  left: 0;
  z-index: 99;
  transition: all 2s;
}

#sou {
  width: 100%;
  height: 100vh;
  /* background: url(/img/bj1.jpg) no-repeat;
    background-size: 100% 100%; 
    background-attachment: fixed; */
}

.img {
  width: 150px;
  height: 150px;
  border-radius: 50%;
  position: absolute;
  top: -40%;
  left: 50%;
  transform: translateX(-50%);
  transition: all 1.5s ease 0.5s;
  border: 2px solid rgb(164, 164, 164);
}
.img img {
  width: 100%;
  border-radius: 50%;
}

.img .img_hei {
  position: absolute;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  border-radius: 50%;
  transition: all 0.4s;
  text-align: center;
  line-height: 150px;
  color: #fff;
  background-color: rgb(49, 49, 49);
  opacity: 0;
  cursor: pointer;
}

.img:hover .img_hei {
  opacity: 0.7;
}
.shoubi {
  width: 500px;
  height: 100%;

  position: absolute;
  right: -40%;
  top: 0;
  /* transition: all 0.8s ease 0.5s; */
  transition: all 1s;
}
/* 7% */
.shoubi img {
  width: 300px;
  height: 74px;
  margin: 40px 0;
}
.shoubi2 {
  margin-top: 100px;
}
.shoubi2 p:nth-child(1) {
  margin-left: 135px;
}
.shoubi2 p:nth-child(2) {
  margin-left: 95px;
}
.shoubi2 p:nth-child(3) {
  margin-left: 55px;
}

.tc_btn2 {
  background: none;
  border: none;
  color: #fff;
  width: 100px;
  height: 40px;
  border: 1px solid #fff;
  float: right;
  border-radius: 20px;
  margin-right: 10px;
  margin-top: 10px;
  transition: all 0.4s;
  cursor: pointer;
}
.tc_btn2:hover {
  box-shadow: -5px 5px 10px black;
  transform: scale(1.1);
  background: rgb(21, 134, 248);
}
.Sou_user {
  width: 400px;
  height: 400px;
  background-color: #fff;
  box-shadow: 0 0 15px black;
  position: absolute;
  z-index: 20;
  left: 50%;
  top: -100%;
  transform: translateX(-50%);
  transition: all 0.5s;
  padding: 20px;
  position: relative;
  text-align: center;
}

.Sou_user_img {
  width: 18%;
  height: 18%;
  border-radius: 50%;
  margin: 20px auto;
  overflow: hidden;
  position: relative;
}

.Sou_user_img > img {
  width: 100%;
  border-radius: 50%;
}
.Sou_user > i {
  float: right;
}
.inp {
  text-align: center;
}
.inp > p {
  margin-top: 20px;
}
.Sou_user > button {
  border: none;
  background-color: rgb(32, 130, 241);
  width: 85%;
  height: 40px;
  margin-top: 30px;
  color: #fff;
  transition: all 0.2s;
  cursor: pointer;
  /* box-shadow: 0px 0px 10px rgb(73, 73, 73); */
}

.Sou_user > button:hover {
  box-shadow: 0 0 10px rgb(65, 65, 65);
  transform: scale(1.05);
}

#Sou_file {
  display: none;
}

.Sou_user_img_hei {
  position: absolute;
  top: 0;
  left: 0;
  background-color: rgb(68, 68, 68);
  color: #fff;
  width: 100%;
  height: 100%;
  text-align: center;
  padding: 10px;
  opacity: 0;
  transition: all 0.3s;
  cursor: pointer;
}

.Sou_user_img:hover .Sou_user_img_hei {
  opacity: 0.7;
}
</style>