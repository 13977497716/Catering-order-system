<template>
  <div id="kou">
    <!-- 开场 -->
    <div class="kuai_1"></div>
    <div class="kuai_2"></div>
    <!-- top -->
    <div class="tou">
      <div class="dg_tx">
        <span class="img_kuai"><img :src="params.url" alt="" /></span>
        <span class="img_name">{{ params.name }}</span>
        <button class="tc_btn" @click="tz()">
          <i class="el-icon-switch-button"></i>退出
        </button>
      </div>
    </div>

    <!-- 菜单 -->
    <nav class="dg_nav">
      <div id="cai_dan" v-show="caishow == '点餐'">
        <!-- 1.导航块 -->
        <div class="dg_daoan">
          <ul>
            <li
              v-for="(item, index) in dglist"
              :key="index"
              @click="dgshow = item.xi_name"
              :class="{ lan: dgshow == item.xi_name }"
            >
              {{ item.xi_name }}
            </li>
          </ul>
        </div>
        <!-- 菜单内容块 -->
        <div class="dg_nr">
          <h3 v-show="dg_text" class="dg_text">此系列没有食品</h3>
          <span v-for="(item, index) in dgcplist" :key="index">
            <div class="nr_da">
              <img :src="item.cai_img != null ? item.cai_img : caiimg" alt="" />
              <div class="dg_hei"></div>
              <div class="dg_hei2">
                <p>{{ item.cai_name }}</p>
                <span>￥{{ item.jiage }}</span>
              </div>
              <div class="icon"></div>
              <i class="el-icon-plus" @click="add(item)"></i>
            </div>
          </span>
        </div>
      </div>

      <!-- 订单数据  -->
      <div id="dan_da" v-show="caishow == '订单'">
        <ul class="dan_ui">
          <!-- 每一单就循环一个内容 -->
          <li
            v-for="(item, index) in ddlist"
            :key="index"
            @dblclick="delshow = index + 1"
            :class="{ jb: item.code == 0 }"
          >
            <h3>订单</h3>
            <p>{{ item.id }}</p>
            <h1>A{{ ddlist.length - index }}</h1>
            <b>￥{{ item.sum }}</b>
            <div v-show="delshow == index + 1"></div>
            <button v-show="delshow == index + 1" @click="del_dd(item.id)">
              取消订单
            </button>
            <span v-show="item.code == 0">未付款</span>
          </li>
        </ul>
      </div>
    </nav>

    <!-- 购物车 -->

    <div id="gwc">
      <span class="gwc_img"><img :src="params.url" alt="" /></span>
      <h2>{{ params.name }}</h2>
      <div class="text_dc"></div>

      <!-- 购物车块 -->
      <div class="ding_da">
        <ul>
          <li v-for="(item, index) in gmlist" :key="index">
            <span>{{ item.cai_name }}</span>
            <span>￥{{ item.jiage }}</span
            ><span>
              <div class="ding_btn">
                <span @click="item.num--" class="num">-</span>
                <span ref="shunum">{{
                  item.num >= 1 ? item.num : del(index)
                }}</span>
                <span @click="item.num++" class="num">+</span>
              </div>
            </span>
          </li>
        </ul>
      </div>
      <!-- 清空和挂单块 -->
      <div class="gwc_btn">
        <div class="gwc_bnt2"><button @click="gmlist = []">清空</button></div>
      </div>
    </div>

    <!-- 支付 -->
    <div id="fukuan">
      <span style="font-size: 15px">应收:</span>
      <span>￥{{ zongshu() }}</span>
      <span><button @click="add_ddlist(zongshu())">收款</button></span>
    </div>

    <!-- 功能 -->
    <div class="dg_gn">
      <span
        @click="caishow = '点餐'"
        :class="{ lan: caishow == '点餐', bai: caishow == '点餐' }"
        >点餐<i class="el-icon-shopping-cart-1"></i
      ></span>
      <span
        @click="caishow = '订单'"
        :class="{ lan: caishow == '订单', bai: caishow == '订单' }"
        >订单<i class="el-icon-tickets ii"></i
      ></span>
    </div>

    <!-- 弹窗 -->
    <div class="alert" v-show="alertshow" @click="alertshow = false">
      <div class="alert2">
        <span>订单号：{{ dd_data.danhao }}</span
        ><span>金额：{{ dd_data.sum }}</span
        ><span>日期：{{ dd_data.date }}</span>
      </div>
    </div>
  </div>
</template>

<script>
import axios from "axios";
export default {
  data() {
    return {
      id:window.sessionStorage.getItem('token') || '',
      caiimg: "/img/nc/nc_back.jpg",
      params: {
        shu: "", //穿过的id
        url: "", //头像
        name: "", //名称
      },
      dglist: [],
      dgcplist: [],
      dgshow: "",
      dg_text: false, //菜系没有菜品时显示
      //存放菜品购物车内容数组
      gmlist: [],

      //判断切换订单或者菜单
      caishow: "点餐",
      //订单列表处理
      ddlist: [],
      //添加订单时的信息返回
      dd_data: {
        danhao: "",
        date: "",
        sum: "", //总价钱
      },
      alertshow: false,
      //取消订单
      delshow: false,
    };
  },
  watch: {
    dgshow() {
      console.log(this.dgshow);
      this.dg_cp();
    },
    //添加订单时弹窗时，弹窗自动关闭
  },

  created() {
    this.chuan();
    this.dh();
    this.dg_list();
    this.dd_list();
  },

  methods: {
    dh() {
      setTimeout(() => {
        var kuai1 = document.querySelector(".kuai_1");
        var kuai2 = document.querySelector(".kuai_2");
        kuai1.style.left = "-50%";
        kuai2.style.right = "-50%";
      }, 300);
    },

    chuan() {
      axios({
        url: this.$urls + "/user.php",
        method: "get",
        params: {
          user_key: 6,
          token: this.id,
        },
      }).then((res) => {
        let img = res.data.user_img;
        this.params.name = res.data.username;
        if (img == "") {
          console.log("空");
          this.params.url = "/img/nc/nc_back.jpg";
        } else {
          this.params.url = img;
        }
      });
    },

    tz() {
      window.sessionStorage.removeItem("token");
      this.$router.push("/home");
    
    },
    //菜系动态导航渲染
    dg_list() {
      let params = new URLSearchParams();
      params.append("xi_key", 1);
      axios.post(this.$urls + "/cai_xi.php", params).then((res) => {
        console.log(res);
        this.dglist = res.data;
        this.dgshow = res.data[0].xi_name; //渲染初步进入的第一个菜系和菜品
      });
    },

    //菜品动态渲染
    dg_cp() {
      let params = new URLSearchParams();
      params.append("key", 8);
      params.append("cai_xi", this.dgshow);
      axios.post(this.$urls + "/cai_pin.php", params).then((res) => {
        console.log(res.data);
        this.dgcplist = res.data;
        if (res.data.length <= 0) {
          this.dg_text = true;
        } else {
          this.dg_text = false;
        }
      });
    },

    // 存放菜品的订单
    add(data) {
      let datas = JSON.parse(JSON.stringify(data)); //把存过来的值进行json又转回js数组对象，与原数组形成不一样的空间栈（不会互相影响）

      if (this.gmlist.length <= 0) {
        this.gmlist.push(datas);
      } else {
        //for遍历数组判断有没有数等于，有的话就退出并返回参数X，循环结束没有退出并返回参数Y。
        for (let i = 0; i < this.gmlist.length; i++) {
          if (this.gmlist[i].cai_name == datas.cai_name) {
            console.log("gmlist的输是：", this.gmlist[i].cai_name);
            return this.gmlist[i].num++;
          }
        }
        return this.gmlist.push(datas);
      }
    },

    //删除菜品的订单
    del(e) {
      this.gmlist.splice(e, 1);
    },
    //总数
    zongshu() {
      let sum = 0;
      this.gmlist.forEach((a) => {
        sum += a.jiage * a.num;
      });
      this.sum = sum;
      return sum;
    },

    //时间优化显示处理
    compuent(a) {
      if (a < 10) {
        return "0" + a;
      }
      return a;
    },

    //添加订单
    add_ddlist(sum) {
      if (sum <= 0) {
        return alert("没有订单需要付款！");
      }

      //价格
      this.dd_data.sum = sum;
      let d = new Date();
      //  d.setDate(28) //设置日期测试
      //单号
      this.dd_data.danhao =
        d.getFullYear() +
        "n" +
        this.compuent(d.getMonth() + 1) +
        "y" +
        this.compuent(d.getDate()) +
        "r" +
        this.compuent(d.getHours()) +
        "s" +
        this.compuent(d.getMinutes()) +
        "f" +
        this.compuent(d.getSeconds()) +
        "";
      //下单日期
      this.dd_data.date =
        d.getFullYear() +
        "-" +
        this.compuent(d.getMonth() + 1) +
        "-" +
        this.compuent(d.getDate()) +
        "";

      console.log("单号:", this.dd_data.danhao);

      axios({
        url: this.$urls + "/dingdan.php",
        method: "get",
        params: {
          dd_key: 2,
          idname: this.dd_data.danhao,
          date: this.dd_data.date,
          sum: sum,
        },
      }).then((res) => {
        console.log("插入订单：", res);
        this.dd_list();
      });

      this.alertshow = true;
      this.gmlist = [];
    },

    //取单号处理
    dd_qudan(index) {
      let a = this.ddlist.length - index;
      // 添加数据
      window.localStorage.setItem("取单号", a);
      return a;
    },

    //订单渲染
    dd_list() {
      axios({
        url: this.$urls + "/dingdan.php",
        method: "get",
        params: {
          dd_key: 1,
        },
      }).then((res) => {
        console.log("内容是:", res);
        let datas = res.data;
        this.ddlist = datas.reverse();
      });
    },

    //取消订单
    del_dd(id) {
      this.delshow = false;

      axios({
        url: this.$urls + "/dingdan.php",
        method: "get",
        params: {
          dd_key: 3,
          idname: id,
          num: 0,
        },
      }).then((res) => {
        console.log(res);
        this.dd_list();
      });
    },
  }, //methods
};
</script>


 <style  scoped>
@import "/css/mante.css";
@import "/css/kou.css";

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

#kou {
  width: 100%;
  height: 100vh;
  background: url(/img/bj2.jpg) no-repeat;
  background-size: 100% 100%;
}
</style>