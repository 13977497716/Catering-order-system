<template>
  <div>
    <!-- 标题 -->
    <div class="biaoti3"></div>
    <div id="dd_da">
      <!-- //:header-cell-style表头th的style元素 -->
      <el-table
        stripe
        :data="ddlist"
        :header-cell-style="{
          textAlign: 'center',
          color: '#fff',
          background: '#0083ee',
        }"
        :cell-style="{ textAlign: 'center' }"
        style="width: 100%"
      >
        <el-table-column prop="id" sortable label="订单编号"> </el-table-column>

        <el-table-column prop="date" label="订单时间"> </el-table-column>

        <el-table-column prop="sum" label="总价"> </el-table-column>

        <el-table-column prop="code" label="是否付款">
          <template slot-scope="scope">
            <el-switch
              v-model="scope.row.code"
              inactive-text="未付款"
              active-text="已付款"
              active-color="#13ce66"
              inactive-color="#ff4949"
              active-value="1"
              inactive-value="0"
              @change="upp($event, scope.row.id)"
            >
            </el-switch>
          </template>
        </el-table-column>
      </el-table>
    </div>

    <div class="fenye">
      <el-pagination
        background
        layout="prev, pager, next"
        @current-change="dd_fenye_list"
        :current-page="page"
        :page-size="pagesize"
        :total="toke"
      >
        <!-- total总数量，page-size每页显示的数量，current当前页，yema获得改变时的页码号 -->
      </el-pagination>
    </div>

    <div class="dd_del">
      <div class="dd_select">
        <el-select
          style="width: 100%"
          class="input-select"
          v-model="xiala"
          placeholder="请选择要删除哪天订单"
        >
          <el-option
            v-for="item in xiala_list"
            :key="item"
            :label="item"
            :value="item"
          ></el-option>
        </el-select>
        {{ xiala }}
      </div>
      <div class="dd_btn" @click="dd_del()">删除</div>
    </div>
  </div>
</template>
<style scoped>
@import "/css/dingd.css";

.dd_select >>> .el-input > input {
  height: 70px;
}
</style>

  




<script>
import axios from "axios";
export default {
  data() {
    return {
      ddlist: [],
      fkshow: false,

      //分页
      fyshow: false, //分页控件显示
      toke: 0, //1.总页数
      pagesize: 6, //2.条数
      page: 1, //3.当前页码

      xiala_list: [],
      xiala: "",
      screenWidth: "",
      screenHeight: "",
    };
  },
  watch: {
    pagesize() {
      this.dd_fenye_list(this.page);
    },
  },

  mounted() {
    this.screen();
  },

  created() {
    this.dd_list(); //渲染订单数据
    this.dd_fenye_list(this.page); //首次分页1
    this.select_del(); //下拉数据
  },

  methods: {
    //默认渲染全部订单数据
    dd_list() {
      axios({
        url: this.$urls + "/dingdan.php",
        method: "get",
        params: {
          dd_key: 1,
        },
      }).then((res) => {
        let leng = res.data.length;
        this.toke = leng;
      });
    },

    //分页查询
    dd_fenye_list(e) {
      this.page = e;
      console.log(e);
      axios({
        url: this.$urls + "/dingdan.php",
        method: "get",
        params: {
          dd_key: 5,
          limt: this.page, //页码
          pagesize: this.pagesize,
        },
      }).then((res) => {
        console.log(res);
        let datas = res.data;
        this.ddlist = datas; //reverse数组颠倒函数
      });
    },

    //修改是否付款
    upp(show, data) {
      console.log(show, data);
      axios({
        url: this.$urls + "/dingdan.php",
        method: "get",
        params: {
          dd_key: 3,
          idname: data,
          num: show,
        },
      }).then((res) => {
        console.log("修改成功", show, res);
      });
    },

    //下拉选择渲染
    select_del() {
      axios({
        url: this.$urls + "/dingdan.php",
        method: "get",
        params: {
          dd_key: 6,
        },
      }).then((res) => {
        console.log("时间查询成功", res);
        this.xiala_list = res.data;
      });
    },

    //删除时间
    dd_del() {
      axios({
        url: this.$urls + "/dingdan.php",
        method: "get",
        params: {
          dd_key: 4,
          date: this.xiala,
        },
      }).then((res) => {
        console.log(res);
        this.dd_fenye_list(this.page);
      });
    },

    screen() {
      this.screenWidth = document.body.clientWidth;
      this.screenHeight = document.body.clientHeight;
      if (this.screenHeight < 600) {
        this.pagesize = 6;
      }
      if (this.screenHeight > 700) {
        this.pagesize = 8;
      }
      console.log("宽", this.screenWidth, "高", this.screenHeight);
      window.onresize = () => {
        return (() => {
          this.screenWidth = document.body.clientWidth;
          this.screenHeight = document.body.clientHeight;
          if (this.screenHeight < 600) {
            this.pagesize = 6;
          }
          if (this.screenHeight > 700) {
            this.pagesize = 8;
          }
          console.log("宽", this.screenWidth, "高", this.screenHeight);
        })();
      };
    },
  },
};
</script>