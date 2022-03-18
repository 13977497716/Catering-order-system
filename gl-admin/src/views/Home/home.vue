<template>
  <div id="da">
    <div id="zhu_ye">
      <p class="p1" ref="p1">订单管理系统</p>
      <p class="p2" ref="p2">———— 康康打造一个量身定制的专属饮食系统 ————</p>
      <button class="zhu_dl" @click="parentButtonClick" ref="btn">
        登录一下吧
      </button>
    </div>

    <denglu ref="Denglu"> </denglu>
  </div>
</template>

<script>
// JS代码

import denglu from "@/components/login_div";

export default {
  components: {
    denglu,
  },

  mounted() {
    this.dh();
  },

  methods: {
    parentButtonClick() {
    //给组件绑定名字操作组件里面的dom的方法函数或者变量
      this.$refs.Denglu.dlshow = true;
    },

  

    //网页动画和样式
    dh() {
       setTimeout(() => {
          var zhu_dl = document.querySelector(".zhu_dl");
        var p1 = document.querySelector(".p1");
        var p2 = document.querySelector(".p2");
        zhu_dl.style.bottom = "40%";
        p1.style.top = "30%";
        p2.style.left = "50%";
       }, 300);
       
  
    },
  },
};
</script>
  

<style scoped>
.da {
  width: 100%;
  height: 100vh;
}

.a {
  width: 100px;
  height: 40px;
  background-color: blue;
  position: absolute;
  left: 0px;
}

.zhu_dl {
  border: none;
  outline: none;
  background-color: rgb(11, 135, 224);
  width: 130px;
  height: 40px;
  border-radius: 20px;
  font-size: 13px;
  color: #fff;
  position: absolute;
  bottom: -20%;
  left: 50%;
  transform: translateX(-50%);
  transition: all 2s;
}

.zhu_dl:hover {
  background-color: rgb(166, 197, 241);
}
.p1,
.p2 {
  width: 700px;

  position: absolute;
  text-align: center;
  color: #fff;
  font-size: 40px;
  top: -300px;
  left: 50%;
  transform: translateX(-50%);
  transition: all 2s;
  font-family: KaiTi;
}

.p2 {
  top: 45%;
  left: -20%;
  font-size: 25px;
  transition: all 2s;
}

/* 黑幕页 */
#dl_ye {
  width: 100%;
  height: 100vh;
  position: absolute;
  right: 0;
  background-color: black;
  transform: translateX(-100%);
  opacity: 0.5;
  transition: all 0.8s;
}

/* 登录 */
.denglu {
  position: absolute;
  top: 50%;

  left: -400px;
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
</style>