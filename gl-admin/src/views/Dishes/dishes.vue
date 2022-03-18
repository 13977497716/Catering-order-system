<template>
  <div id="c1">
    <!-- 标题 -->
    <div class="biaoti"></div>
    <!-- 搜索TOP -->
    <div class="sousuo">
      <el-input
        placeholder="请输入菜品"
        v-model="ss"
        class="input-with-select"
        style="width: 80%"
      >
        <el-button
          slot="append"
          icon="el-icon-search"
          @click="sslist()"
        ></el-button>
      </el-input>
      <button class="btn_add el-icon-plus" @click="addshow = true">增加</button>
    </div>
    <!-- 插入框 -->
    <div class="add" v-show="addshow">
      <i class="el-icon-circle-close" @click="addshow = false"></i>
      <h3>插入菜品</h3>
      <div class="add_biao">
        <p>
          <label>菜品：</label
          ><el-input
            placeholder="请输入菜品"
            size="mini"
            v-model="addlist.cai_name"
            style="width: 180px"
          ></el-input>
        </p>
        <p>
          <label>菜系：</label>
          <el-select
            v-model="value"
            placeholder="请选择菜系"
            size="mini"
            style="width: 180px"
          >
            <el-option
              v-for="item in xialalist"
              :key="item.xi_name"
              :label="item.xi_name"
              :value="item.xi_name"
            >
            </el-option>
          </el-select>
        </p>
        <p>
          <label>价格：</label
          ><el-input
            placeholder="请输入价格"
            size="mini"
            v-model="addlist.jiage"
            style="width: 180px"
          ></el-input>
        </p>
        <span class="add_span"><img :src="topimg" alt="" /></span>
        <span class="add_btn">
          <el-button
            @click="$refs.addfile.click()"
            type="success"
            icon="el-icon-plus"
            circle
          ></el-button>
          <input
            type="file"
            ref="addfile"
            name=""
            id="pin_addimg"
            @change="addimgsr()"
        /></span>
        <div class="add_charu">
          <el-button type="info" style="width: 200px" @click="cai_add()"
            >插入</el-button
          >
        </div>
      </div>
    </div>

    <!-- 修改框 -->
    <div class="add" v-show="uppshow">
      <i class="el-icon-circle-close" @click="uppshow = false"></i>
      <h3>修改信息</h3>
      <div class="add_biao">
        <p>
          <label>编号：</label
          ><el-input
            placeholder="请输入编号"
            size="mini"
            v-model="upplist.cai_id"
            style="width: 180px"
          ></el-input>
        </p>
        <p>
          <label>菜品：</label
          ><el-input
            placeholder="请输入菜品"
            size="mini"
            v-model="upplist.cai_name"
            style="width: 180px"
          ></el-input>
        </p>
        <p>
          <label>菜系：</label
          ><el-select
            v-model="upplist.cai_xi"
            placeholder="请选择菜系"
            size="mini"
            style="width: 180px"
          >
            <el-option
              v-for="item in xialalist"
              :key="item.xi_name"
              :label="item.xi_name"
              :value="item.xi_name"
            >
            </el-option>
          </el-select>
        </p>
        <p>
          <label>价格：</label
          ><el-input
            placeholder="请输入价格"
            size="mini"
            v-model="upplist.jiage"
            style="width: 180px"
          ></el-input>
        </p>
        <span class="upp_span"><img :src="upplist.cai_img" alt="" /></span>
        <span class="upp_btn">
          <el-button
            @click="$refs.file.click()"
            type="success"
            icon="el-icon-plus"
            circle
          ></el-button
          ><input
            ref="file"
            type="file"
            name=""
            id="pin_uppimg"
            @change="uppimgsr()"
        /></span>
        <div class="add_charu">
          <el-button type="info" style="width: 200px" @click="cai_up()"
            >确定修改</el-button
          >
        </div>
      </div>
    </div>

    <div class="table">
      <!-- //:header-cell-style表头th的style元素 -->
      <el-table
        stripe
        :data="list"
        :header-cell-style="{
          textAlign: 'center',
          color: '#fff',
          background: '#0083ee',
        }"
        :cell-style="{ textAlign: 'center' }"
        style="width: 100%"
      >
        <el-table-column prop="id" sortable label="菜品编号" width="180">
        </el-table-column>

        <el-table-column prop="cai_name" label="奶茶名称" width="180">
        </el-table-column>

        <el-table-column prop="cai_xi" label="系列"> </el-table-column>

        <el-table-column prop="jiage" label="价格"> </el-table-column>

        <el-table-column label="操作" width="230">
          <template slot-scope="scope">
            <div class="btn">
              <el-button
                type="primary"
                size="small"
                @click="
                  cai_upon(
                    scope.row.id,
                    scope.row.cai_name,
                    scope.row.cai_xi,
                    scope.row.jiage,
                    scope.row.cai_img
                  )
                "
                >修改</el-button
              >

              <el-button
                type="danger"
                @click="cai_del(scope.row.id)"
                size="small"
                >删除</el-button
              >
            </div>
          </template>
        </el-table-column>
      </el-table>
    </div>

    <div class="fenye">
      <el-pagination
        background
        layout="prev, pager, next"
        @current-change="fenye_list"
        :pager-count="5"
        :current-page="dqpage"
        :page-size="pagesize"
        :total="total"
      >
        <!-- total总数量，page-size每页显示的数量，yema获得改变时的页码号 -->
      </el-pagination>
    </div>
  </div>
</template>

<script>
import axios from "axios";
export default {
  data() {
    return {
      id: window.sessionStorage.getItem('token') || '', //获取用户唯一token
      //增加菜品内容
      addlist: {
        cai_name: "",
        cai_xi: "",
        jiage: "",
      },
      addshow: false, //跳出增加板块
      //修改
      uppshow: false,
      upplist: {
        id: "",
        cai_id: "",
        cai_name: "",
        cai_xi: "",
        jiage: "",
        cai_img: "",
      },
      //搜索
      ss: "",
      list: [], //数据数组
      //分页信息
      total: 0, //总数
      pagesize: 5, //每页显示的条数(可修改)
      dqpage: 1, //当前页

      //下拉
      value: "",
      xialalist: [],
      //上传文件图片本地地址
      topimg: "/img/nc/nc_back.jpg",
      screenWidth: "",
      screenHeight: "",
    };
  },

  watch: {
    ss() {
      if (this.ss == "") {
        this.cai_list();
      }
    },
    pagesize() {
      this.fenye_list(this.dqpage);
    },
  },

  mounted() {
    this.screen();
  },
  created() {
    this.cai_list();
    this.xl_list();
  },

  methods: {
    //弹框
    tishi() {
      this.$message({
        showClose: true,
        message: "请输入你要添加的商品内容哦",
        type: "error",
      });
    },

    //弹框2
    addopen() {
      this.$alert("你已添加一个菜品", "操作成功", {
        confirmButtonText: "了解",
        callback: (action) => {
          this.$message({
            type: "info",
            message: `action: ${action}`,
          });
        },
      });
    },

    //弹框3
    uppopen() {
      this.$alert("修改菜品成功", "操作成功", {
        confirmButtonText: "了解",
        callback: (action) => {
          this.$message({
            type: "info",
            message: `action: ${action}`,
          });
        },
      });
    },
    del_open() {
      this.$notify({
        title: "成功",
        message: "已删除菜品",
        type: "success",
        offset: 120,
      });
    },

    //查询弹窗
    select_open() {
      this.$message({
        showClose: true,
        message: "请输入你要查询的菜品",
        type: "warning",
      });
    },

    //下拉
    xl_list() {
      let params = new URLSearchParams();
      params.append("xi_key", 6);
      axios.post(this.$urls + "/cai_xi.php", params).then((res) => {
        console.log(res);
        this.xialalist = res.data;
      });
    },

    //点击分页后返回（e页码）重新渲染数据(主数据渲染)
    fenye_list(e) {
      this.dqpage = e;
      let params = new URLSearchParams();
      params.append("key", 1);
      axios.post(this.$urls + "/cai_pin.php", params).then((res) => {
        console.log(res);
        let datas = [];
        datas = res.data;
        this.total = datas.length; //返回总数量
        this.list = datas.slice((e - 1) * this.pagesize, e * this.pagesize);
      });
    },

    //初步渲染数据(进入页码用只用一次)
    cai_list() {
      let params = new URLSearchParams();
      params.append("key", 1);
      axios.post(this.$urls + "/cai_pin.php", params).then((res) => {
        console.log(res);
        let datas = [];
        datas = res.data;
        this.total = datas.length;
        this.list = datas.slice(0, this.pagesize);
      });
    },

    //删除
    cai_del(idsr) {
      let param = new URLSearchParams();
      param.append("key", 2);
      param.append("id", idsr);
      axios.post(this.$urls + "/cai_pin.php", param).then((res) => {
        console.log(res);
        this.del_open();

        this.fenye_list(this.dqpage);
      });
    },
    //插入
    cai_add() {
      let param = new URLSearchParams();
      param.append("key", 4);
      param.append("cai_name", this.addlist.cai_name);
      param.append("cai_xi", this.value);
      param.append("jiage", this.addlist.jiage);
      param.append("cai_img", this.topimg);
      axios.post(this.$urls + "/cai_pin.php", param).then((res) => {
        console.log(res);
        this.addopen();
        this.fenye_list(this.dqpage);
      });
    },

    cai_upon(id, name, namexi, jiage, img) {
      //点击修改获取原有的信息
      this.uppshow = true;
      this.upplist.id = id;
      this.upplist.cai_id = id;
      this.upplist.cai_name = name;
      this.upplist.cai_xi = namexi;
      this.upplist.jiage = jiage;
      this.upplist.cai_img = img;
    },

    cai_up() {
      //修改数据
      let param = new URLSearchParams();
      param.append("key", 3);
      param.append("id", this.upplist.id);
      param.append("idsr", this.upplist.cai_id);
      param.append("cai_name", this.upplist.cai_name);
      param.append("cai_xi", this.upplist.cai_xi);
      param.append("jiage", this.upplist.jiage);
      param.append("cai_img", this.upplist.cai_img);
      axios.post(this.$urls + "/cai_pin.php", param).then((res) => {
        console.log(res);
        this.uppopen();

        this.fenye_list(this.dqpage);
        this.uppshow = false;
      });
    },
    //搜索后的结果
    sslist() {
      if (this.ss == "") {
        this.select_open();
        return;
      } else {
        let params = new URLSearchParams();
        params.append("key", 5); //搜索
        params.append("cai_name", this.ss);
        axios.post(this.$urls + "/cai_pin.php", params).then((res) => {
          console.log(res);

          let datas = res.data.length;
          this.list = res.data;
          this.total = datas;
        });
      }
    },

    //插入上传图片文件
    addimgsr() {
      let file = document.querySelector("#pin_addimg").value + "";
      let n = file.lastIndexOf("\\");
      let v = file.lastIndexOf(".");
      let sum = file.substr(n + 1, v);
      let loin = "/img/nc/" + "";
      this.topimg = loin + sum;
    },

    //修改图片文件名
    uppimgsr() {
      let file = document.querySelector("#pin_uppimg").value + "";
      let n = file.lastIndexOf("\\");
      let v = file.lastIndexOf(".");
      let sum = file.substr(n + 1, v);
      let loin = "/img/nc/" + "";
      this.upplist.cai_img = loin + sum;
    },

    screen() {
      this.screenWidth = document.body.clientWidth;
      this.screenHeight = document.body.clientHeight;
      if (this.screenHeight < 600) {
        this.pagesize = 5;
      }
      if (this.screenHeight > 700) {
        this.pagesize = 7;
      }
      console.log("宽", this.screenWidth, "高", this.screenHeight);
      window.onresize = () => {
        return (() => {
          this.screenWidth = document.body.clientWidth;
          this.screenHeight = document.body.clientHeight;
          if (this.screenHeight < 600) {
            this.pagesize = 5;
          }
          if (this.screenHeight > 700) {
            this.pagesize = 7;
          }
          console.log("宽", this.screenWidth, "高", this.screenHeight);
        })();
      };
    },
  },
};
</script>


<style scoped>
@import "/css/caipin.css";
/* 引入菜品css */
</style>