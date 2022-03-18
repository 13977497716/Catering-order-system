<template>
  <div id="c3">
    <header><span>Guanliyuan</span></header>
    <div class="user_kuai">
      <span
        ><h2>用户数量</h2>
        <p>{{ zhanshi.sum }}</p></span
      >
      <span
        ><h2>员工人数</h2>
        <p>{{ zhanshi.code_0 }}</p></span
      >
      <span
        ><h2>现管理员</h2>
        <p>{{ zhanshi.codename }}</p>
        <div class="codename">{{ zhanshi.codename }}</div></span
      >
      <span
        ><h2>管理员人数</h2>
        <p>{{ zhanshi.code_1 }}</p></span
      >
    </div>

    <!-- 插入框 -->
    <div class="add" v-show="addshow">
      <i class="el-icon-circle-close" @click="addshow = false"></i>
      <h3>插入新用户</h3>
      <div class="add_biao">
        <p>
          <label>账号：</label
          ><el-input
            placeholder="请输入账号"
            size="mini"
            v-model="addlist.username"
            style="width: 180px"
          ></el-input>
        </p>
        <p>
          <label>密码：</label
          ><el-input
            placeholder="请输入密码"
            size="mini"
            v-model="addlist.password"
            style="width: 180px"
          ></el-input>
        </p>
        <p>
          <label>权限：</label>
          <el-select
            v-model="addlist.value"
            placeholder="权限"
            size="mini"
            style="width: 180px"
          >
            <el-option
              v-for="item in user_xl"
              :key="item"
              :label="item"
              :value="item"
            >
            </el-option>
          </el-select>
        </p>

        <span class="add_span"><img :src="addlist.userimg" alt="" /></span>
        <span class="add_btn">
          <el-button
            @click="$refs.user_addimg.click()"
            type="success"
            icon="el-icon-plus"
            circle
          ></el-button>
          <input
            type="file"
            ref="user_addimg"
            name=""
            id="user_addimg"
            @change="addimgsr()"
          />
        </span>
        <div class="add_charu">
          <el-button type="info" style="width: 200px" @click="user_add()"
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
            placeholder="请输入用户编号"
            size="mini"
            v-model="upplist.userid"
            style="width: 180px"
          ></el-input>
        </p>
        <p>
          <label>账号：</label
          ><el-input
            placeholder="请输入用户账号"
            size="mini"
            v-model="upplist.username"
            style="width: 180px"
          ></el-input>
        </p>
        <p>
          <label>密码：</label
          ><el-input
            placeholder="请输入用户密码"
            size="mini"
            v-model="upplist.password"
            style="width: 180px"
          ></el-input>
        </p>
        <p>
          <label>权限：</label
          ><el-select
            v-model="upplist.value"
            placeholder="请选择用户权限"
            size="mini"
            style="width: 180px"
          >
            <el-option
              v-for="item in user_xlup"
              :key="item"
              :label="item"
              :value="item"
            >
            </el-option>
          </el-select>
        </p>

        <span class="upp_span"><img :src="upplist.userimg" alt="" /></span>
        <span class="upp_btn">
          <el-button
            @click="$refs.user_upp.click()"
            type="success"
            icon="el-icon-plus"
            circle
          ></el-button>
          <input
            type="file"
            ref="user_upp"
            name=""
            id="user_uppimg"
            @change="uppimgsr()"
          />
        </span>
        <div class="add_charu">
          <el-button type="info" style="width: 200px" @click="user_upp()"
            >确定修改</el-button
          >
        </div>
      </div>
    </div>

    <!-- 表格列表 -->
    <div class="container">
      <table>
        <thead>
          <tr>
            <th></th>
            <th>
              <div class="tx"></div>
              username
            </th>
            <th>
              <div class="mima"></div>
              password
            </th>
            <th>
              <div class="qx"></div>
              power
            </th>
            <th>
              <div class="cz"></div>
              操作
            </th>
          </tr>
        </thead>

        <tbody>
          <tr v-for="(item, index) in userlist" :key="index">
            <td><div class="xian" v-show="item.xian == 1"></div></td>
            <td>{{ item.username }}</td>
            <td>{{ item.password }}</td>
            <td>{{ item.xian == 1 ? "管理员" : "员工" }}</td>
            <td>
              <button
                @click="
                  user_uppon(
                    item.id,
                    item.username,
                    item.password,
                    item.xian,
                    item.user_img
                  )
                "
              >
                修改</button
              ><button @click="user_del(item.id)">删除</button>
            </td>
          </tr>
        </tbody>
      </table>
    </div>
    <!-- 分页 -->
    <div class="fenye fenye2" v-show="fyshow">
      <el-pagination
        background
        layout="prev, pager, next"
        @current-change="user_list_fy"
        
        :current-page="page"
        :page-size="pagesize"
        :total="toke"
      >
        <!-- total总数量，page-size每页显示的数量，yema获得改变时的页码号 -->
      </el-pagination>
    </div>

    <div class="add_btn2" @click="addshow = true">添加用户</div>
  </div>
</template>

<script>
import axios from "axios";

export default {
  data() {
    return {
      id: window.sessionStorage.getItem('token'), //从登录——导航栏 ——获取到了用户id
      //渲染用户列表
      userlist: [],
      //展示版
      zhanshi: {
        sum: "",
        code_0: "",
        code_1: "",
        codename: "",
      },
      //分页
      fyshow: false, //分页控件显示
      toke: 0, //1.总页数
      pagesize: 3, //2.条数
      page: 1, //3.当前页码
      //增加
      addshow: false,
      user_xl: ["员工", "管理员"],
      addlist: {
        username: "",
        password: "",
        value: "",
        userimg: "/img/user/back.png",
      },
      //修改
      uppshow: false,
      user_xlup: ["员工", "管理员"],
      upplist: {
        id: "",
        userid: "",
        username: "",
        password: "",
        value: "",
        userimg: "",
      },
      screenWidth: "",
      screenHeight: "",
    };
  },

  watch: {
    pagesize() {
      this.user_list_fy(this.page);
    },
  },
  mounted() {
    this.screen();
  },

  created() {
    this.user_list();
    this.user_list_fy(this.page);
  },

  methods: {
    //弹窗提示
    add_open() {
      this.$notify({
        title: "成功",
        message: "增加新用户账号成功",
        type: "success",
        offset: 120,
      });
    },

    del_open() {
      this.$notify({
        title: "成功",
        message: "已删除用户账号",
        type: "success",
        offset: 120,
      });
    },

    upp_open() {
      this.$notify({
        title: "成功",
        message: "修改用户账号信息成功",
        type: "success",
        offset: 120,
      });
    },

    user_list() {
      axios({
        url: this.$urls + "/user.php",
        method: "get",
        params: {
          user_key: 1,
        },
      }).then((res) => {
        console.log(res);
        var length = res.data.length;
        this.toke = length;
        //分页控件显示判断
        if (this.toke <= this.pagesize) {
          this.fyshow = false;
        } else {
          this.fyshow = true;
        }

        // ------下面是展示（不重要）---------
        //1.用户数量
        if (length < 10) {
          this.zhanshi.sum = "0" + length;
        } else {
          this.zhanshi.sum = length;
        }
        //2.员工人数
        var sumtie = 0;
        var sumtai = 0;
        for (let i = 0; i < length; i++) {
          if (res.data[i]["xian"] == 0) {
            sumtie = sumtie + 1;
            if (sumtie < 10) {
              this.zhanshi.code_0 = "0" + sumtie;
            } else {
              this.zhanshi.code_0 = sumtie;
            }
          } else {
            sumtai = sumtai + 1;
            if (sumtai < 10) {
              this.zhanshi.code_1 = "0" + sumtai;
            } else {
              this.zhanshi.code_1 = sumtai;
            }
          }
        }
        //3.当前管理员
    console.log(window.sessionStorage.getItem('username'))
        this.zhanshi.codename = window.sessionStorage.getItem('username');
      });
    },
    //  获取分页数据
    user_list_fy(e) {
      this.page = e;
      axios({
        url: this.$urls + "/user.php",
        method: "get",
        params: {
          user_key: 5,
          limt: this.page,
          pagesize: this.pagesize,
        },
      }).then((res) => {
        console.log(res);
        this.userlist = res.data;
        this.user_list();
      });
    },

    //增加
    //(1)插入上传图片文件
    addimgsr() {
      let file = document.querySelector("#user_addimg").value + "";
      let n = file.lastIndexOf("\\");
      let v = file.lastIndexOf(".");
      let sum = file.substr(n + 1, v);
      let loin = "/img/user/" + "";
      this.addlist.userimg = loin + sum;
    },
    user_add() {
      axios({
        url: this.$urls + "/user.php",
        method: "get",
        params: {
          user_key: 4,
          username: this.addlist.username,
          password: this.addlist.password,
          xian: this.addlist.value == "管理员" ? 1 : 0,
          user_img: this.addlist.userimg,
        },
      }).then((res) => {
        console.log(res);
        this.user_list_fy(this.page);
        this.user_list();
      });
      this.add_open();
    },

    //删除
    user_del(id) {
      axios({
        url: this.$urls + "/user.php",
        method: "get",
        params: {
          user_key: 2,
          id: id,
        },
      }).then((res) => {
        console.log(res);
        this.user_list_fy(this.page);
        this.user_list();
      });
      this.del_open();
    },
    //修改
    //(1)获取原有的修改数据
    user_uppon(id, username, password, xian, img) {
      this.uppshow = true;

      this.upplist.id = id;
      this.upplist.userid = id;
      this.upplist.username = username;
      this.upplist.password = password;
      this.upplist.value = xian == 1 ? "管理员" : "员工";
      this.upplist.userimg = img != "" ? img : "/img/user/back.png";
    },
    //(2)修改插入的图片
    uppimgsr() {
      let file = document.querySelector("#user_uppimg").value + "";
      let n = file.lastIndexOf("\\");
      let v = file.lastIndexOf(".");
      let sum = file.substr(n + 1, v);
      let loin = "/img/user/" + "";
      this.upplist.userimg = loin + sum;
    },
    //(3)修改内容
    user_upp() {
      axios({
        url: this.$urls + "/user.php",
        method: "get",
        params: {
          user_key: 3,
          id: this.upplist.id,
          userid: this.upplist.userid,
          username: this.upplist.username,
          password: this.upplist.password,
          xian: this.upplist.value == "管理员" ? 1 : 0,
          user_img: this.upplist.userimg,
        },
      }).then((res) => {
        console.log(res);
        this.user_list_fy(this.page);
        this.user_list();
      });
      this.upp_open();
    },
    screen() {
      this.screenWidth = document.body.clientWidth;
      this.screenHeight = document.body.clientHeight;
      if (this.screenHeight < 600) {
        this.pagesize = 3;
      }
      if (this.screenHeight > 700) {
        this.pagesize = 5;
      }
      console.log("宽", this.screenWidth, "高", this.screenHeight);
      window.onresize = () => {
        return (() => {
          this.screenWidth = document.body.clientWidth;
          this.screenHeight = document.body.clientHeight;
          if (this.screenHeight < 600) {
            this.pagesize = 3;
          }
          if (this.screenHeight > 700) {
            this.pagesize = 5;
          }
          console.log("宽", this.screenWidth, "高", this.screenHeight);
        })();
      };
    },
  },
};
</script>


<style  scoped src="../../../public/css/user.css">
@import "/css/user.css";
</style>