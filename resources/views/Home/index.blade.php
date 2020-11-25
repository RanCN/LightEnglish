<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <!-- <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.0/dist/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous"> -->
    <link rel="stylesheet" href="/home/css/bootstrap.min.css">

    <title>Hello, world!</title>

    <style>
        a {
            text-decoration: underline;
        }

        textarea {
            width: 100%;
            height: 100%;
            border: none;
            resize: none;
            cursor: pointer;
            font-size: 20px;
            padding: 10px;
        }

        .left-height {
            min-height: 870px;
        }
        .h-1 {
            height: 280px;
        }
        .showdow {
            box-shadow: 0 1px 6px #ccc;
        }
        .trans-btn {
            display: inline-block;
            width: 106px;
            height: 32px;
           
            line-height: 32px;
            text-align: center;
            font-weight: 400;
            
            font-size: 14px;
            text-decoration: none!important;
            border-radius: 5px;
        }
        
        .btn1 {
            background-color: #4395ff;
            color: #fff;
        }

        .btn2 {
            border: 1px solid #4395ff;
            color: #4395ff;
        }

        .btn1:hover{
            /* opacity: 0.8; */
            background-color: #1985FB;
            color: #fff;
        }
        .btn2:hover{
            border: 1px solid #BD2D30;
            color: #BD2D30;
        }
        .color1 {
            color: #1985FB;
        }
        .color-3 {
            color: #333;
        }
        .color-gray {
            color: #787977;
        }
        .font-14 {
            font-size: 14px;
        }
        .trans-text {
            font-size: 20px;
            padding: 10px;
        }
        .a-text{
            text-decoration: none;
            color: #333
        }
    </style>
  </head>
  <body>
    <div class="container mt-5 mb-5" id="app">
        <div class="row">
            <div class="col-md-6 border left-height showdow pb-4">
                <h2 class="mt-2 color-3" v-text="now_date"></h2>
                <div class="color-gray font-14">总数：<span v-text="listCount"></span>   编辑</div>
                <hr/>
                <div v-for="(item, index) in list" v-on:click="del(item.id,index)">
                    <a href="javascript:;" class="a-text" v-text="item.word"></a>
                </div>
            </div>
            <div class="col-md-6 pl-4">
                <div>
                    <a href="#" class="trans-btn mr-1 btn1" v-on:click="trans()">翻&nbsp;&nbsp;&nbsp;&nbsp;译</a>
                    <a href="#" class="trans-btn btn2" v-on:click="record()">记&nbsp;&nbsp;&nbsp;&nbsp;录</a>
                </div>
                <div class="border mt-4 showdow">
                <div class="">
                    <textarea rows="8" placeholder="输入文本" v-model="query"></textarea>
                </div>
                </div>
                <div class="h-1 border mt-4 showdow trans-text" v-text='dst'>
                </div>
            </div>
        </div>
        
    </div>

    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.0/dist/js/bootstrap.min.js" integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous"></script>
    <!-- vue -->
    <script src="https://unpkg.com/vue/dist/vue.js"></script>
    <script src="https://unpkg.com/axios/dist/axios.min.js"></script>
    
    <!-- 百度api -->
    <script src="http://apps.bdimg.com/libs/jquery/1.9.1/jquery.min.js"></script>
    <script src="/home/js/md5.js"></script>

    <script>
        new Vue({
            el: '#app',
            data: {
                message: 'Hello Vue.js!',
                dst:'',
                query: '',
                now_date: '',
                list:[]
            },
            created() {
                // console.log('hello111')
                let that = this
                let date = new Date();
                let now = date.getFullYear() + "年" + (date.getMonth()+1) + "月" + date.getDate() + "日";
                that.now_date = now

                $.ajax({
                    url: 'http://www.light.test/index.php/api/words/list',
                    type: 'get',
                    success: function(res) {
                        res = JSON.parse(res)
                        console.log(res,'res')
                        that.list = res.data
                    }
                })
            },
            computed: {
                listCount: function() {
                    return this.list.length
                }
            },
            methods: {
                trans: function() {
                    var that = this
                    var appid = '20201125000625145';
                    var key = 'C95MEKZU7wNYxAu18ZWY';
                    var salt = (new Date).getTime();
                    var query = that.query;
                    var from = 'en';
                    var to = 'zh';
                    var str1 = appid + query + salt +key;
                    var sign = MD5(str1);

                    console.log("query",that.query)
                    $.ajax({
                        url: 'http://api.fanyi.baidu.com/api/trans/vip/translate',
                        type: 'get',
                        dataType: 'jsonp',
                        data: {
                            q: that.query,
                            appid: appid,
                            salt: salt,
                            from: from,
                            to: to,
                            sign: sign
                        },
                        success: function (data) {
                            console.log(data);
                            that.dst = data.trans_result[0].dst
                        } 
                    });
                },
                record: function() {
                    let that = this
                    console.log(this.query)
                    $.ajax({
                        url: 'http://www.light.test/index.php/api/words/record',
                        type: 'get',
                        data: {
                            val: that.query
                        },  
                        success: function(res) {
                            res = JSON.parse(res)
                            console.log(res)
                            if(res.code == 400) {
                                alert(res.msg)
                            }
                            if(res.code == 200) {
                                that.list.push(res.data)
                                console.log(that.list)
                            }
                        }
                    })
                },
                del: function(id, index) {
                    let that = this
                    console.log(id,'id')
                    if(confirm('确定要删除吗？')==true) {
                        $.ajax({
                            url: 'http://www.light.test/index.php/api/words/del',
                            type: 'get',
                            data: {
                                id: id
                            },
                            success: function(res) {
                                res = JSON.parse(res)
                                console.log(index,'index')
                                console.log(res)
                                that.list.splice(index,1)
                            }
                        })
                        return true
                    } else {
                        return false
                    }
                }
            }
        })
</script>
  </body>
</html>