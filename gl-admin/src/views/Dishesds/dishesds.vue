<template>
  <div id="c2">
    <!-- 标题 -->
    <div class="biaoti2"></div>
    <!-- 搜索TOP -->
    <div class="sousuo">
      <el-input
        placeholder="请输入菜系名称"
        v-model="ss"
        class="input-with-select"
        style="width: 80%"
      >
        <el-button
          slot="append"
          icon="el-icon-search"
          @click="xi_sslist()"
        ></el-button>
      </el-input>
    </div>
    <!-- 插入框 -->
    <div class="add" v-show="addshow">
      <i class="el-icon-circle-close" @click="addshow = false"></i>
      <h3>插入新菜系</h3>
      <div class="add_biao">
        <p>
          <label>菜系名称：</label
          ><el-input
            placeholder="请输入要插入的菜系名"
            size="medium"
            v-model="add_xiname"
            style="width: 180px"
          ></el-input>
        </p>
        <div class="add_charu">
          <el-button type="info" style="width: 200px" @click="xi_add()"
            >插入</el-button
          >
        </div>
      </div>
    </div>

    <!-- 修改框 -->
    <div class="add" v-show="uppshow2">
      <i class="el-icon-circle-close" @click="uppshow2 = false"></i>
      <h3>修改信息</h3>
      <div class="add_biao">
        <p>
          <label>菜系名称：</label
          ><el-input
            placeholder="请输入修改后的菜系"
            size="medium"
            v-model="uplist.xi_namesr"
            style="width: 180px"
          ></el-input>
        </p>
        <div class="add_charu">
          <el-button type="info" style="width: 200px" @click="xi_up()"
            >确定修改</el-button
          >
        </div>
      </div>
    </div>

    <!-- 菜系列表信息 -->
    <div id="caixi_da">
      <transition-group
        name="animate__animated animate__bounce"
        appear
        enter-active-class="animate__backInLeft"
        leave-active-class="animate__bounceOut"
      >
        <!-- 行 -->
        <div class="kuai" v-for="(index, k) in list" :key="k">
          <h1>{{ index.xi_name }}</h1>
          <div class="btn_hang">
            <button class="btn2" @click="xi_upon(index.xi_name)">修改</button>
            <button class="btn2" @click="del(index.xi_name)">删除</button>
          </div>
        </div>
      </transition-group>
      <transition
        name="animate__animated animate__bounce"
        appear
        enter-active-class="animate__backInLeft"
        leave-active-class="animate__bounceOut"
      >
        <!-- 添加 -->
        <div class="kuai" v-show="addkuan" @click="addshow = true">
          <div class="jia el-icon-plus"></div>
        </div>
      </transition>
    </div>

    <h2 class="sstishi" v-show="tishi">没有搜索到这个内容......</h2>
  </div>
</template>

<script>
import axios from "axios";
import "animate.css";
export default {
  data() {
    return {
      id:  window.sessionStorage.getItem('token') || '', //从登录——导航栏 ——获取到了用户id
      list: [],
      //添加内容的固定框
      addkuan: true,
      //插入显示
      addshow: false,
      uppshow2: false,
      add_xiname: "",
      //修改
      uplist: {
        xi_name: "", //保存要修改的原名字
        xi_namesr: "",
      },
      //搜索
      ss: "",
      tishi: false,
    };
  },
  watch: {
    ss() {
      if (this.ss == "") return this.xi_list(), (this.addkuan = true);
    },
  },

  created() {
    this.xi_list();
  },

  methods: {
    upp_open() {
      this.$notify({
        title: "成功",
        message: "修改菜系名字",
        type: "success",
        offset: 120,
      });
    },

    add_open() {
      this.$notify({
        title: "成功",
        message: "插入新的菜系",
        type: "success",
        offset: 120,
      });
    },

    del_open() {
      this.$notify({
        title: "成功",
        message: "已删除菜系",
        type: "success",
        offset: 120,
      });
    },

    //渲染菜系表
    xi_list() {
      //转换传过去url数据为字符串
      let params = new URLSearchParams();
      params.append("xi_key", 1);
      axios.post(this.$urls + "/cai_xi.php", params).then((res) => {
        console.log(res);
        this.list = res.data;
      });
    },

    //插入
    xi_add() {
      let params = new URLSearchParams();
      params.append("xi_key", 4);
      params.append("xi_name", this.add_xiname);
      axios.post(this.$urls + "/cai_xi.php", params).then((res) => {
        console.log(res + "插入成功");
        this.xi_list();
      });
      this.add_open();
    },

    //修改获取默认信息
    xi_upon(name) {
      //获取修改前默认值方法
      this.uplist.xi_name = name; //获取修改前的名字
      this.uplist.xi_namesr = name;

      this.uppshow2 = true;
    },
    //修改方法
    xi_up() {
      let params = new URLSearchParams();
      params.append("xi_key", 3); //菜系选择
      params.append("key", 6); //菜品选择
      params.append("xi_name", this.uplist.xi_name); //判断是哪个名字要修改
      params.append("xi_namesr", this.uplist.xi_namesr);

      axios.post(this.$urls + "/cai_xi.php", params).then((res) => {
        console.log(res + "菜系修改成功");
      });

      axios.post(this.$urls + "/cai_pin.php", params).then((res) => {
        console.log(res + "菜品修改成功");
      });
      this.xi_list();
      this.uppshow2 = false;
      this.upp_open();
    },

    // 删除
    del(name) {
      let params = new URLSearchParams();
      params.append("xi_key", 2); //删除菜系
      params.append("key", 7); //删除菜品
      params.append("xi_name", name);

      axios.post(this.$urls + "/cai_xi.php", params).then((res) => {
        console.log(res);
      });

      axios.post(this.$urls + "/cai_pin.php", params).then((res) => {
        console.log(res + "菜品删除成功");
      });

      this.xi_list();
      this.del_open();
    },

    //搜索
    xi_sslist() {
      if (this.ss == "") return alert("请输入要搜索内容");

      let params = new URLSearchParams();
      params.append("xi_key", 5);
      params.append("xi_name", this.ss);
      axios.post(this.$urls + "/cai_xi.php", params).then((res) => {
        console.log(res);
        this.addkuan = false;
        this.list = res.data;
        if (this.list.length <= 0) {
          this.tishi = true;
        }
      });
    },
  }, //method结束
};
</script>


<style scoped>
@import "/css/caixi.css";
</style>