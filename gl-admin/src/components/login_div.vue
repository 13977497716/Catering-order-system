<template>
  <div>
    <transition name="hei">
      <!-- 黑幕页 -->
      <div id="dl_ye" ref="nana" v-show="dlshow"></div>
    </transition>
    <!-- 登录 -->
    <transition name="mai">
      <div class="denglu" ref="nava" v-show="dlshow">
        <div class="left"></div>
        <div class="righ">
          <p class="text1">
            订单管理<span style="color: rgb(70, 113, 253)">系统</span>
          </p>
          <div class="dl_kuan">
            <form action="" method="post">
              <ul>
                <li  ref='user_name'>
                  <span></span>
                  <input
                    type="text"
                   
                    id="user"
                    placeholder="账号"
                    v-model="name"
                    @blur="border(1,'user_name')"
                    @focus="border(2,'user_name')"
                  />
                </li>
                <li ref='user_password'>
                  <span></span
                  ><input
                    type="password"
                    id="pasw"
                    placeholder="密码"
                    v-model="mima"
                     @blur="border(1,'user_password')"
                    @focus="border(2,'user_password')"
                  />
                </li>
              </ul>
              <button class="dl" type="button" @click="phpce()">登录</button>
              <p class="radio">
                <el-radio v-model="radio" label="1">订单系统</el-radio>
                <el-radio v-model="radio" label="2">后台系统</el-radio>
              </p>

              <p class="text3" @click="panent()">返回</p>
            </form>
          </div>
        </div>
      </div>
    </transition>
  </div>
</template>
<script>
import axios from "axios";
export default {
  data() {
    return {
      dlshow: false,
      name: "admin",
      mima: "123456789",
      imgid: 1,
      //判断单选选择
      radio: "1",
      disabled: false,
    };
  },
  methods: {
    // 焦点获得或失去变色
    border(n,refName){
      // 1获得焦点，2失去焦点,refName选择哪个dom
      if(n==1){
        this.$refs[refName].style.borderBottom= "1px solid rgb(175, 175, 175)";
      }else{
        this.$refs[refName].style.borderBottom= "1px solid rgb(44, 92, 248)";
      }
    },

    //权限选择弹窗提示
    code_open() {
      this.$notify({
        title: "权限不足",
        message: "你没有权力进入此功能",
        type: "error",
        offset: 120,
      });
    },

    //登录失败提示
    open() {
      this.$alert("账号货密码有误，请重新输入", "康康订单系统", {
        confirmButtonText: "确定",
        callback: (action) => {
          this.$message({
            type: "info",
            message: `action: ${action}`,
          });
        },
      });
    },

    phpce() {
      //发送 post 请求
      //转换成字符串格式
      let param = new URLSearchParams();
      param.append("username", this.name);
      param.append("password", this.mima);
      axios
        .post(this.$urls + "/pandun.php", param)
        .then((res) => {
          let code = res.data.code; //判断登录是否成功
          let xian = res.data.xian; //判断用户权限
          let username = res.data.username;
          if (code == 200) {
            console.log("登录信息", res);
            window.sessionStorage.setItem("username",username);
            window.sessionStorage.setItem("token", res.data.token); //放行路由守卫
            if (xian == 1) {
              // 如果是选择下单购物车
              if (this.radio == "1") {
                this.$router.push("/kou/" + username);
                return;
              } else {
                //否则跳转后台管理系统
                this.$router.push("/sou");
                return;
              }
            } else {
              if (this.radio == "1") {
                this.$router.push("/kou/" + username);
                return;
              } else {
                this.code_open();
                return;
              }
            }
          } else {
            this.open();
            this.mima = ""; //重置密码
          }
        })
        .catch((err) => {
          console.log("请检查网络或服务器是否正确连接", err);
          alert("请检查网络或服务器是否正确连接");
          return;
        });
    },

    panent() {
      this.dlshow = false;
      this.$router.push({
        path: "*",
        query: {
          id: 1234,
          name: "李俊康",
        },
      });
    },
  },
};
</script>

<style  scoped>
/* 黑幕页 */
#dl_ye {
  width: 100%;
  height: 100vh;
  position: absolute;
  right: 0;
  background-color: black;
  opacity: 0.5;
  transition: all 0.8s;
}

/* 登录 */
.denglu {
  position: absolute;
  top: 50%;
  left: 50%;
  transform: translate(-50%, -50%);
  width: 800px;
  height: 500px;
  background-color: burlywood;
  transition: all 2s;
}

.left {
  width: 470px;
  height: 100%;
  background-color: rgb(48, 48, 179);
  float: left;
  background: url(/img/123.png) no-repeat right;
  background-size: 100% 103%;
}

.righ {
  width: 330px;
  height: 100%;
  background-color: #292e41;
  float: left;
  padding: 0 40px;
  position: relative;
}
.righ .text1 {
  text-align: center;
  margin: 80px auto;
  color: rgb(202, 202, 202);
  font-size: 30px;
}

.text2 {
  text-align: center;
  color: rgb(160, 160, 160);
  font-size: 13px;
  cursor: pointer;
}

.text3 {
  text-align: center;
  position: absolute;
  bottom: 10px;
  color: rgb(161, 161, 161);
  right: 10px;
  cursor: pointer;
}

ul {
  list-style: none;
}
.dl_kuan ul li {
  width: 100%;
  height: 40px;
  margin: 20px auto;
  border-bottom: 1px solid rgb(175, 175, 175);
  color: rgb(49, 141, 226);
  transition: all 0.4s;
}
.dl_kuan ul li span {
  position: absolute;
  display: block;
  width: 20px;
  height: 20px;
  background-color: cyan;
  transform: translate(5px, 5px);
}

.dl_kuan ul li:nth-child(1) span {
  background: url(/img/zh.png) no-repeat;
  background-size: 15px 17px;
}
.dl_kuan ul li:nth-child(2) span {
  background: url(/img/mima.png) no-repeat;
  background-size: 15px 17px;
}
.dl_kuan ul li input {
  position: absolute;
  width: 60%;
  height: 30px;
  left: 90px;
  background: none;
  border: none;
  outline: none;
  color: rgb(209, 209, 209);
}
.dl {
  width: 100%;
  height: 40px;
  background-color: #373c52;
  border: none;
  color: rgb(230, 230, 230);
  margin: 10px auto;
  font-size: 18px;
  cursor: pointer;
  transition: all 0.4s;
}

.dl:hover {
  background-color: #676b7b;
}
.radio {
  text-align: center;
}

.hei-enter,
.hei-leave-to {
  transform: translateX(-100%);
}
.hei-leave,
.hei-enter-to {
  transform: translateX(0);
}

.mai-enter,
.mai-leave-to {
  transform: translate(-200%, -50%);
}
.mai-enter-to,
.mai-leave {
  transform: translate(-50%, -50%);
}
</style>