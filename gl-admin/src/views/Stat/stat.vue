<template>
  <div id="tongji">
    <div class="echs">
      <div class="echs_left">
        <div class="paid">
          <h2>订单数量</h2>
          <div class="tu xi"></div>
        </div>

        <div class="paid">
          <h2>菜系数量</h2>
          <div class="tu pie"></div>
        </div>
      </div>

      <div class="echs_right">
        <div class="paid">
          <h2>订单趋势</h2>
          <div class="tu zhe"></div>
        </div>
        <div class="paid">
          <h2>用户类别</h2>
          <div class="tu user"></div>
        </div>
      </div>
    </div>
  </div>
</template>
<script>
import * as echarts from "echarts";
import axios from "axios";
export default {
  data() {
    return {};
  },
  mounted() {
    this.zhu();
    this.bing();
    this.zhe();
    this.user();
  },

  methods: {
    zhu() {
      var zhuChart = echarts.init(document.querySelector(".xi"));
      zhuChart.showLoading(); //显示加载动画
      axios({
        url: this.$urls+"/tongji.php",
        method: "get",
        params: {
          key: 2,
        },
      }).then((res) => {
        console.log("柱形图", res);
        let time = [];
        let sum = [];
        res.data.forEach((a) => {
          time.push(a.time);
          sum.push(a.sum);
        });
        zhuChart.hideLoading(); //关闭加载动画
        // 绘制柱形图表
        zhuChart.setOption({
          color: ["#2c7ff0"],
          tooltip: {
            trigger: "axis",
          },
          xAxis: {
            data: time,
            offset: 8,
          },
          yAxis: {},
          legend: {},
          series: [
            {
              name: "销量",
              type: "bar",
              barWidth: 35, //柱图宽度
              data: sum,
              showBackground: true,
              backgroundStyle: {
                color: "#efefef",
                opacity: 0.5,
              },
            },
          ],
        });
      });
    },

    bing() {
      var pieChart = echarts.init(document.querySelector(".pie"));
      pieChart.showLoading();
      axios({
        url: this.$urls+"/tongji.php",
        method: "get",
        params: {
          key: 1,
        },
      }).then((res) => {
        console.log("饼状图", res);
        pieChart.hideLoading();

        pieChart.setOption({
          tooltip: {
            trigger: "item",
          },
          legend: {
            orient: "vertical",
            left: "left",
            textStyle: {
              //图例文字的样式
              color: "#000",
              fontSize: 10,
            },
          },
          series: [
            {
              roseType: "angle",
              name: "菜品",
              type: "pie",
              radius: "60%",
              center: ["60%", "50%"],
              data: res.data,
              emphasis: {
                itemStyle: {
                  shadowBlur: 10,
                  shadowOffsetX: 0,
                  shadowColor: "rgba(0, 0, 0, 0.5)",
                },
              },
            },
          ],
        });
      });
    },
    zhe() {
      var zheChart = echarts.init(document.querySelector(".zhe"));
      zheChart.showLoading();
      axios({
        url: this.$urls+"/tongji.php",
        method: "get",
        params: {
          key: 2,
        },
      }).then((res) => {
        console.log("折线图", res);
        let time = [];
        let sum = [];
        res.data.forEach((a) => {
          time.push(a.time);
          sum.push(a.sum);
        });
        zheChart.hideLoading();
        //绘制折线图
        zheChart.setOption({
          tooltip: {
            trigger: "axis",
          },
          legend: {
            data: ["成交"],
          },

          xAxis: {
            type: "category",
            boundaryGap: false,
            data: time,
          },
          yAxis: {
            type: "value",
          },
          series: [
            {
              name: "成交",
              type: "line",
              smooth: true,
              data: sum,
            },
          ],
        });
      });
    },

    user() {
      var userChart = echarts.init(document.querySelector(".user"));
      userChart.showLoading();
      axios({
        url: this.$urls+"/tongji.php",
        method: "get",
        params: {
          key: 3,
        },
      }).then((res) => {
        console.log("用户", res);
        userChart.hideLoading();

        userChart.setOption({
          tooltip: {
            trigger: "item",
          },
          legend: {
            orient: "vertical",
            left: "left",
            textStyle: {
              //图例文字的样式
              color: "#000",
              fontSize: 10,
            },
          },
          series: [
            {
              name: "类别数量",
              type: "pie",
              radius: "60%",
              center: ["60%", "50%"],
              data: res.data,
              emphasis: {
                itemStyle: {
                  shadowBlur: 10,
                  shadowOffsetX: 0,
                  shadowColor: "rgba(0, 0, 0, 0.5)",
                },
              },
            },
          ],
        });
      });
    },
  },
};
</script>

<style  scoped src="../../../public/css/tongji.css">
</style>


