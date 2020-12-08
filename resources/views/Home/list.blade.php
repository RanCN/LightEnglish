<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="/home/css/bootstrap.min.css">
    <title>Light English</title>
    <style>
        .con-block{
            height: 150px;
        }
        .box-showdow {
            box-shadow: 0 5px 15px 0 rgba(0,0,0,0.08);
            border-radius: 5px;
        }
        .font-date {
            color: #373737;
            font-weight: 300;
            margin-bottom: 10px;
            font-size: 16px;
        }
        .left-box {
            background: #fafafa;
            height: 100%;
            width: 150px;
            float:left;
        }
        .right-box {
            height: 100%;
            float:left;
            padding-left: 20px;
            padding-top: 40px;
        }
        .text-desc{
            font-weight: 300;
            font-size: 14px;
            color: gray;
            padding: 5px 0;
        }
        .text-main{
            font-weight: 400;
            font-size: 18px;
            color: #333;
        }
        .box{
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
    <div class="container mt-5 mb-5" id="app">
        <div class="row">
            <div class="col-md-8 p-0">
                <div class="box" v-for="(item, index) in list" v-on:click="toUrl(item.time)">
                    <div class="font-date text-center"><span v-text="item.day"></span></div>
                    <div class="con-block box-showdow">
                        <div class="left-box"></div>
                        <div class="right-box">
                            <div class="text-desc">每日记录</div>
                            <div class="text-main">今日打卡记录单词<span v-text="item.count"></span>个</div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3 ml-4 pl-4 border">
                <!-- <h2>light english</h2> -->
            </div>
        </div>

    </div>

    <!-- vue -->
    <script src="https://unpkg.com/vue/dist/vue.js"></script>
    <script src="https://unpkg.com/axios/dist/axios.min.js"></script>

    <script src="http://apps.bdimg.com/libs/jquery/1.9.1/jquery.min.js"></script>

    <script>
        const apiUrl = 'http://le.mydy2020.com'
        // const apiUrl = 'http://www.le.test'

        new Vue({
            el: "#app",
            data: {
                message: 'Hello Vue.js!',
                dst:'',
                query: '',
                now_date: '',
                list:[]
            },
            created() {
                let that = this
                $.ajax({
                    url: apiUrl + '/index.php/api/days/list',
                    type: 'get',

                    success: function(res) {
                        res = JSON.parse(res)
                        console.log(res,'res')
                        that.list = res.data
                    }
                })
            },
            methods: {
                toUrl: function(time) {
                    // console.log(time)
                    window.location.href = apiUrl + "?time=" + time
                }
            }
        })
    </script>
</body>
</html>
