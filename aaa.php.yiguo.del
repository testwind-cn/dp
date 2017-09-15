<!DOCTYPE html>
<html>
    <head lang="en">
        <meta charset="UTF-8">
        <title></title>
        <meta name="viewport" content="width=device-width,minimum-scale=1.0,maximum-scale=1.0,user-scalable=no" />
        <meta http-equiv="Content-Type" content="text/html;charset=utf-8" />
        <meta http-equiv="Pragma" content="no-cache" />
        <link rel="Stylesheet" href="http://img02.yiguo.com/e/web/130101/css/mall.min.css?v20131120" />
        <style>
            body{
                padding: 0;
                margin: 0;
                }
        </style>


 
        
        
         <style type="text/css">
        #afui #afui_modal
        {
            color: black;
        }
        .ulselect li a[value]
        {
            font-weight: bolder;
            font-size: 20px;
        }
        .plist
        {
            position: relative;
            list-style-type: none;
            overflow: hidden;
            margin-left: auto;
            margin-right: auto;
            width: 300px;
            z-index: 0;
        }
        ul li
        {
            list-style-type: none;
        }
        .plist ul li
        {
            margin-top: 10px;
        }
        .plist ul li .product
        {
            background: none repeat scroll 0 0 #FFFFFF;
            border: 1px solid #D0D0D0;
            height: auto;
            padding: 4px;
            position: relative;
            width: 300px;
        }
        .p-img
        {
            position: relative;
            text-align: center;
            float: left;
        }
        .p-name
        {
            height: auto;
            padding-top: 10px;
            padding-bottom: 5px;
            text-overflow: ellipsis;
            font-size: 130%;
            clear: both;
            text-align: center;
        }
        
        .p-price
        {
            color: #CF5926;
            font: bold 16px Arial;
            font-size: 120%;
            height: 20px;
            text-align: center;
            margin-top: 40px;
        }
        a
        {
            border: 0 none;
            color: #575556;
            outline: medium none;
            text-decoration: none;
        }
        img
        {
            border: none;
        }
        .orderlist span
        {
            float: left;
            width: 33%;
            text-align: left;
            vertical-align: middle;
            height: 100%;
        }
        .orderlist .header
        {
            font-weight: bolder;
        }
        
        #ularead li
        {
            text-align: center;
            display: block;
            width: 10%;
            height: 10%;
            float: left;
            margin: 1%;
            border: 1px solid black;
        }
        .change
        {
            padding-left: 20px;
            background: url(../images/Location.png) no-repeat;
            background-position: left center;
        }
        #afui .button.next::after
        {
            height: 35px;
            width: 34px;
            top: 2px;
        }
        #afui .citybutton
        {
            margin:6px 0;
        }
        .c-btn-orange
        {
            width: 100%;
            display: block;
            text-align: center;
            color: #fff;
            height: 38px;
            line-height: 38px;
            font-size: 16px;
            border-radius: 4px;
            -webkit-border-radius: 4px;
            border: 1px #D13600 solid;
            background: -webkit-gradient(linear, center bottom, center top, from(#ff5500), to(#ff4300));
            width: 100%;
            margin-bottom: 5px;
            font-weight: bolder;
        }
        #order_logistics
        {
            padding:10px;
         }
         #order_logistics li
         {
             padding:5px;
             margin-left:30px;
        }
    </style>
    <script type="text/javascript">

        function beforeSubmit(data) {
            return true;
        }

        function afterAddressAuto(data) {

        }

        function listChange(e, selecttext, selectvalue) {
        }

        var startDate = new Date();
        window.onload = function () {
            var endDate = new Date();
            var ts = endDate - startDate;
            var imgs = document.getElementsByTagName("img");
            if (ts >= 5000) {
                for (var i = 0; i < imgs.length; i++) {
                    imgs[i].setAttribute("onclick", "this.setAttribute('src', this.getAttribute('value'));this.style.height='140px';this.style.width='140px'");
                    imgs[i].setAttribute("alt", "点击查看图片");
                    imgs[i].style.height = "140px";
                    imgs[i].style.width = "140px";

                }

            } else {
                for (var i = 0; i < imgs.length; i++) {
                    imgs[i].setAttribute("src", imgs[i].getAttribute("value"));
                }
            }
        };
    </script>
    <script type="text/javascript" src="http://img02.yiguo.com/e/web/130101/Scripts/jm/appframework.min.js"></script>
    <script type="text/javascript" src="http://img02.yiguo.com/e/web/130101/Scripts/jm/mall.min.js?v20131120"></script>
    <script type="text/javascript">
        function Getcity(bid) {
            if (bid >= 100000 && bid < 200000) { return 2; }
            if (bid >= 200000 && bid < 300000) { return 1; }
            if (bid >= 300000 && bid < 400000) { return 16; }
            if (bid >= 400000 && bid < 500000) { return 8; }
            if (bid >= 500000 && bid < 600000) { return 32; }
            if (bid >= 600000 && bid < 700000) { return 4; }
            if (bid >= 700000 && bid < 800000) { return 64; }
            if (bid >= 800000 && bid < 900000) { return 128; }
            if (bid >= 900000 && bid < 1000000) { return 256; }
            if (bid >= 1000000 && bid < 1100000) { return 512; }
            if (bid >= 1100000 && bid < 1200000) { return 1024; }
            return 0;
        }
        function Getcity_id(bid) {
            //            if (bid >= 100000 && bid < 200000) { return 100000; }
            //            if (bid >= 200000 && bid < 300000) { return 200000; }
            //            if (bid >= 300000 && bid < 400000) { return 300000; }
            //            if (bid >= 400000 && bid < 500000) { return 400000; }
            //            if (bid >= 500000 && bid < 600000) { return 500000; }
            //            if (bid >= 600000 && bid < 700000) { return 600000; }
            return bid - bid % 100000;
        }

        ///////////////////////////////////////////自定义SelectBox//////////////////////////
        var sobj = new Object;
        var obj;
        sobj.GoSelect = function (element, title, data, showSearch) {
            this.element = element;
            if (showSearch != undefined)
                this.ShowSearch = showSearch;
            var val = $(element).attr("value");

            var list = $("#afui_modal #slist");
            if (list == null || list == undefined || list.length == 0)
                list = $("#slist");
            if (showSearch)
                $(list).parent().find("#divSearch").show();
            else
                $(list).parent().find("#divSearch").hide();
            $("#stitle").text(title);
            $("#afui_modal  #stitle").text(title);

            $(data).each(function () {
                var v = this.value;
                var t = this.title;
                var r = this.remark;
                $(list).append("<li><a  href='javascript:sobj.SelectComplete(\"" + t + "\",\"" + v + "\",\"" + r + "\");'  value='" + v + "' remark='" + r + "'>" + t + "</a></li>");
            })
            LoadData(); //ios7滚动bug
        }
        sobj.SelectComplete = function (title, value, r) {
            $(this.element).text(title);
            $(this.element).attr("value", value);
            if (sobj.CallBack != null && sobj.CallBack != undefined) {
                sobj.CallBack(title, value, r);
                sobj.CallBack = null;
            }
            listChange($(this.element), title, value);
            $("#slist").empty();
            $.ui.hideModal();
        }

        $(document).ready(function () {
            $("ul li a[data]").click(function () {
                var data = eval($(this).attr("data"));
                var objli = $(this);
                if (data != null && data != undefined) {
                    sobj.CallBack = function (title, value, r) {
                        if (value == 0) {
                            $(this.element).removeAttr("value");
                            $(this.element).text("购买数量");
                        }
                        $.ui.updateBadge("#settle", $(".divc").find("a[value]").length, "tr");
                        $(".product").css("border-color", "#d0d0d0");
                        $(".divc").find("a").parent("li").parent("ul").css("background-color", "white");
                        $(".divc").find("a[value]").parent("li").parent("ul").css("background-color", "#cf5926");
                    }
                    sobj.GoSelect(this, $(this).attr("title"), data);
                }
            })
        })
        ///////////////////////////////////////////自定义SelectBox//////////////////////////
        $(document).ready(function () {
            $.ui.updateBadge("#settle", "0", "tr");
            LoadScroll();

            var bid = $("#hbid").val();
            var cityid = Getcity_id(bid);
            if (cityid != undefined && cityid > 0) {
                var cityname = $("#hCityName").val();
                var data = [{ value: cityid, title: cityname}]
                $("#s_city").attr("data", data);
                $("#s_city").click(function () {
                    sobj.GoSelect($("#s_city"), $("#s_city").attr("title"), data);
                    sobj.CallBack = function () {
                        $("#s_district").text("区县");
                        $("#s_district").removeAttr("value");
                        $("#s_building").text("办公楼");
                        $("#s_building").removeAttr("value");
                    }
                    $.ui.hideMask();
                    $.ui.showModal("#selectoptions");
                })
            } else {
                $("#s_city").click(function () {
                    var fid = $(this).attr("fid");
                    if (fid == null || fid == undefined)
                        fid = "";
                    $.ui.showMask('正在加载');
                    $.ajax({
                        url: "/ajax/GetBuilding.ashx?grade=1&date=" + new Date().getTime() + "&FilterID=" + fid,
                        success: function (data) {
                            var obj = eval(data);
                            var data = [];
                            $(obj).each(function (i) {
                                var o = { title: this.City, value: this.BID };
                                data.push(o);
                            });
                            sobj.GoSelect($("#s_city"), $("#s_city").attr("title"), data);
                            sobj.CallBack = function () {
                                $("#s_district").text("区县");
                                $("#s_district").removeAttr("value");
                                $("#s_building").text("办公楼");
                                $("#s_building").removeAttr("value");
                            }
                            $.ui.hideMask();
                            $.ui.showModal("#selectoptions");
                        },
                        error: function () {
                        }
                    });
                })
            }

            $("#s_district").click(function () {
                var id = $("#s_city").attr("value");
                if (id != undefined && id != "" && id != null) {
                    $.ui.showMask('正在加载');
                    $.ajax({
                        url: "/ajax/GetBuilding.ashx?grade=2&id=" + id + "&date=" + new Date().getTime(),
                        success: function (data) {
                            var obj = eval(data);
                            var data = []
                            $(obj).each(function () {
                                var o = { title: this.PY + " " + this.District, value: this.BID };
                                data.push(o);
                            })
                            sobj.GoSelect($("#s_district"), $("#s_district").attr("title"), data);
                            sobj.CallBack = function () {
                                $("#s_building").text("办公楼");
                                $("#s_building").removeAttr("value");
                            }
                            $.ui.hideMask();
                            $.ui.showModal("#selectoptions");
                        },
                        error: function () {
                        }
                    });
                } else {
                    alert("请先选择省市");
                    $("#stitle").text("请先选择省市");
                }
            });

            $("#s_building").click(function () {
                var id = $("#s_district").attr("value");
                if (id != undefined && id != "" && id != null) {
                    $.ui.showMask('正在加载');
                    $.ajax({
                        url: "/ajax/GetBuilding.ashx?grade=3&id=" + id + "&date=" + new Date().getTime(),
                        success: function (data) {
                            var obj = eval(data);
                            var data = [];
                            $(obj).each(function () {
                                var o = { title: this.PY + " " + this.BuildingName, value: this.BID, remark: this.Address };
                                data.push(o);
                            })
                            sobj.GoSelect($("#s_building"), $("#s_building").attr("title"), data, true);
                            sobj.CallBack = function (title, value, r) {
                                $(this.element).text(title + "[" + r + "]");
                            }
                            $.ui.hideMask();
                            $.ui.showModal("#selectoptions");
                        },
                        error: function () {
                        }
                    });
                } else {
                    alert("请先选择区县");
                    $("#stitle").text("请先选择区县");
                }
            });
            if ($("#s_home_city") != undefined) {
                $("#s_home_city").click(function () {
                    GetAddress("#s_home_city", 2, "");
                    $("#s_home_district").text("区县");
                    $("#s_home_district").removeAttr("value");
                    $("#s_home_region").text("区");
                    $("#s_home_region").removeAttr("value");
                })
                $("#s_home_district").click(function () {
                    var value = $("#s_home_city").attr("value");
                    if (value != null && value != "" && value != undefined) {
                        var city = $("#s_home_city").text();
                        if ("上海北京天津".indexOf(city) < 0) {
                            $("#s_home_region").parent().show();
                        }
                        else {
                            $("#s_home_region").parent().hide();
                        }
                        GetAddress("#s_home_district", 3, value);
                        $("#s_home_region").text("区");
                        $("#s_home_region").removeAttr("value");
                    } else {
                        alert("请先选择省市！");
                        $("#stitle").text("请先选择省市！");
                    }
                })
                $("#s_home_region").click(function () {
                    var value = $("#s_home_district").attr("value");
                    if (value != null && value != "" && value != undefined) {
                        GetAddress("#s_home_region", 4, value);
                    } else {
                        alert("请先选择区县！");
                        $("#stitle").text("请先选择区县！");
                    }
                })
            }

            $("#btnPay").click(function () {
                var v = $(this).attr("value");
                if (v != undefined && v != "") {
                    $.ui.showMask('正在跳转');
                    $.ajax({
                        url: "/ajax/OrderOp.ashx?op=topay&orderid=" + v + "&r=" + Math.random(),
                        success: function (data) {
                            var obj = eval(data)[0];
                            $.ui.hideMask();
                            if (obj != null && obj.Payed == 0) {
                                Alipay();
                            } else {
                                alert("没有待支付项！");
                            }
                        },
                        error: function (e) {
                            alert(e.responseText);
                        }
                    })
                }
            })
        })

        $(document).ready(function () {
            $("#btnQuery").click(function () {
                $.ajax({
                    url: "/ajax/bailouOperator.ashx?OP=Query&mobile=" + $("#txtmobile").val() + "&r=" + Math.random(),
                    success: function (msg) {
                        $("#lblqty").text(msg);
                    },
                    error: function () {
                    }
                })
                return false;
            })
        })

        function AddressAuto() {
            LoadProduct();
            if ($("#txtName").val() == "") {
                $.ui.showMask('正在加载');
                $.ajax({
                    url: "/ajax/bjjg100Operator.ashx?OP=QueryAddress&uid=" + $("#huid").val() + "&r=" + Math.random(),
                    success: function (data) {
                        if (data != "" && data != null) {
                            var obj = eval(data)[0];
                            var bid = $("#hbid").val();
                            if (obj != null && obj != undefined) {
                                var city1 = Getcity(bid);
                                var city2 = Getcity(obj.Bid);
                                $.ui.hideMask();
                                if ((bid != undefined && city1 == city2) || bid == 0) {
                                    $("#txtPhone").val(obj.Mobile);
                                    $("#txtName").val(obj.ConsigneeName);
                                    $("#s_city").text(obj.CName);
                                    $("#s_city").attr("value", obj.Cid);
                                    $("#s_district").text(obj.DName);
                                    $("#s_district").attr("value", obj.Did);
                                    $("#s_building").text(obj.BName);
                                    $("#s_building").attr("value", obj.Bid);
                                    $("#s_address").text(obj.Address);
                                    $("#s_address").attr("value", obj.Address);
                                    afterAddressAuto(obj);
                                }
                            }
                        }
                        $.ui.hideMask();
                    },
                    error: function () {
                    }
                })
            }
        }

        function LoadProduct() {
            $("#ulBuy").empty();
            var total = 0;
            $(".divc").each(function () {
                var qty = $(this).find("a").attr("value");
                var cname = $(this).parent(".product").find(".p-name").text();
                var price = $(this).parent(".product").find(".p-price").find("input").val();
                var spec = $(this).parent(".product").find(".p-price").text();

                if (qty != undefined && qty > 0 && cname != undefined && cname != "" && !isNaN(qty)) {
                    $("#ulBuy").append("<li><a href=\"#aftransitions\"><span style='float:left;width:60%;'>" + cname + "</span><span style='float:left'>" + spec + "</span><span style='float:right;color:red'>" + qty + "份</span><div style='clear:both;'></div></a></li>");
                    total += price * qty;
                }
            })

            if ($("#ulBuy").find("li").length == 0) {
                $("#ulBuy").append("<li><a href=\"#aftransitions\">请先选择要购买的商品</a></li>");
            }
            else
                $("#ulBuy").append("<li style='text-align:right;'>总金额：<span style='color:red;font-size:130%;' id='spantotal'>" + total + "</span></li>");
            HomeAddressAuto();
            GetFreight();
        }

        function AddressSelect() {
            $(".select").show();
            $(".binding").hide();
            $("#hbid").val("");
        }

        function LoadData() {
            if ($.os.ios == true)
                $("#modalContainer").height($("#afui_modal").height());
        }

        function UnLoadData(div) {
            $.ui.hideMask();
            $("#selectoptions").find("#slist").empty();
            $("#selectoptions").find("#stitle").text();
            $(div).find("#slist").empty();
            $(div).find("#stitle").text();
        }
        function load() {
            $($("ul[name='ulqty']")[0]).find("a").focus();
        }

        function GetAddress(element, grade, areaid) {
            var url = "/ajax/GetAddress.ashx?r=" + Math.random() + "&grade=" + grade;
            if (areaid != undefined && areaid != "")
                url += "&id=" + areaid;
            $.ui.showMask('正在加载');
            $.ajax({
                url: url,
                success: function (data) {
                    $.ui.hideMask();
                    if (data != "") {
                        var obj = eval(data);
                        var data = [];
                        var data1 = [];
                        $(obj).each(function () {
                            var o = { title: this.areaname, value: this.areaid, remark: '' };
                            if (this.areaname == '北京' || this.areaname == '上海' || this.areaname == '天津')
                                data1.push(o);
                            else
                                data.push(o);
                        })
                        var d = data1.reverse().concat(data);
                        if (grade == 3)
                            sobj.CallBack = function () { GetFreight(); };
                        sobj.GoSelect($(element), $(element).attr("title"), d);
                    }
                    $.ui.showModal("#selectoptions");
                },
                error: function () {
                }
            })
        }
        function HomeAddressAuto() {
            if ($("#txt_home_name").val() == "") {
                var userid = $("#huid").val();
                $.ui.showMask('正在加载');
                $.ajax({
                    url: "/ajax/OrderOp.ashx?op=getaddress&r=" + Math.random() + "&userid=" + userid,
                    success: function (data) {
                        $.ui.hideMask();
                        if (data != null && data != "") {
                            var obj = eval(data)[0];
                            if (obj != undefined && obj != null) {
                                $("#txt_home_name").val(obj.Consignee);
                                $("#txt_home_phone").val(obj.ConsigneeMobile);
                                $("#s_home_city").text(obj.ProvinceName);
                                $("#s_home_city").attr("value", obj.ProvinceId);
                                $("#s_home_district").text(obj.DistinctName);
                                $("#s_home_district").attr("value", obj.DistinctId);
                                if ("上海北京天津".indexOf(obj.ProvinceName) < 0) {
                                    $("#s_home_region").parent().show();
                                    $("#s_home_region").text(obj.RegionName);
                                    $("#s_home_region").attr("value", obj.RegionId);
                                }
                                else {
                                    $("#s_home_region").parent().hide();
                                    $("#s_home_region").text("区");
                                    $("#s_home_region").removeAttr("value");
                                }
                                $("#a_address").text(obj.Address);
                                $("#a_address").attr("value", obj.Address);
                                afterAddressAuto(obj);
                                GetFreight();
                            }
                        }
                    },
                    error: function () {
                    }
                })
            }
        }
        function loadorder() {
            var userid = $("#huid").val();
            var btype = $("#hbtype").val();
            var op = btype > 2000 ? "getorder" : "getbailouorder";
            $.ui.showMask('正在加载');
            $.ajax({
                url: "/ajax/OrderOp.ashx?r=" + Math.random() + "&op=" + op + "&userid=" + userid + "&btype=" + btype,
                success: function (data) {
                    $.ui.hideMask();
                    if (data != null) {
                        var objs = eval(data);
                        $("#orderlist .list").empty();
                        $("#orderlist .list").append("<li class='header'><span style='width:40%;'>订单流水号</span><span style='width:35%;'>金额</span><span style='width:25%;'>状态</span><div style='clear: both;'></div></li>");
                        $(objs).each(function () {
                            $("#orderlist .list").append("<li><a onclick=javascript:loadorderedetail('" + this.SerialNumber + "') href='#panelOrderDetails'><span style='width:40%;'>" + this.SerialNumber + "<br>" + this.DTime + "<br>" + this.Name + "</span><span style='width:35%;'><font style=' color:red'>金额：" + this.TotalPrice + "</font><br>运费：" + this.Freight + "</span><span style='width:25%;'><br>" + (this.Status == "待支付" ? "<font style='color:red; text-decoration:underline;'>" + this.Status + "</font>" : this.Status) + "</span><div style='clear: both;'></div></a></li>")
                        })
                    }
                },
                error: function () {
                }
            })
        }
        function unload() {
            $.ui.hideMask();
        }

        function GetFreight() {
            var areaid = $("#s_home_district").attr("value");
            var cityid = $("#s_home_city").attr("value");
            var commoditys = "";
            var total = 0;
            $(".divc").each(function () {
                var qty = $(this).find("a").attr("value");
                var cid = $(this).find(".divc-cid").val();
                if (qty != undefined && qty > 0 && cid != undefined && cid != "") {
                    commoditys += cid + "|" + qty + "|1,";
                }
            })
            var isfr = $("#hisfr").val();
            if (isfr == "0") {
                $("#homefreight").text("运费：0");
                return false;
            }
            var data = { areaid: areaid, cityid: cityid, commoditys: commoditys, isfr: isfr };
            if (areaid != undefined && cityid != undefined && commoditys != undefined && commoditys != "") {
                $("#homefreight").text("正在计算运费......");
                $.ajax({
                    url: "/ajax/AddOrder.ashx?op=fregiht&r=" + Math.random(),
                    data: data,
                    success: function (data) {
                        $("#homefreight").text("运费：" + data);
                    },
                    error: function () {
                    }
                })
            }
        }

        function addressunload(elementName) {
            var value = "";
            $(".areaAddress").each(function () {
                if (value == "")
                    value = $(this).val();
            });
            $.ui.hideModal();
            if (value != "") {
                $("#" + elementName).text(value);
                $("#" + elementName).attr("value", value);
            }
        }
        function loadorderedetail(sn) {
            $("#btnPay").hide();
            var userid = $("#huid").val();
            $.ui.showMask('正在加载');
            $.ajax({
                url: "/ajax/OrderOp.ashx?op=getorderdetails&r=" + Math.random() + "&userid=" + userid + "&sn=" + sn,
                success: function (data) {
                    $.ui.hideMask();
                    if (data != null && data != "") {
                        var obj = eval(data)[0];
                        if (obj != undefined) {
                            $("#order_logistics").empty();
                            $("#orderstatus").val(obj.OrderStateName);
                            if (obj.Payed == 1) {
                                $("#btnPay").hide();
                            } else {
                                $("#orderstatus").css('color', 'red');
                                $("#btnPay").text(obj.PayName + "支付");
                                $("#btnPay").show();
                            }
                            $("#btnPay").attr("value", obj.OrderId);
                            $("#txtSN").val(obj.SN);
                            $("#txtCName").val(obj.ConsigneeName);
                            $("#txtCMobile").val(obj.ConsigneeMobile);
                            $("#txtCAddress").val(obj.ConsigneeAddress);
                            $("#txtTotalPrice").val(obj.TotalPrice);
                            $("#txtFreight").val(obj.Freight);
                            $("#txtDTime").val(obj.DeliveryTime);
                            $("#txtCTime").val(obj.CreateTime);
                            $("#txtPayment").val(obj.PayName);
                            $("#panelOrderDetails .list").empty();
                            $(obj.Details).each(function () {
                                $("#panelOrderDetails .list").append("<li><span style='width:60%'>" + this.ProductName + "</span><span style='width:20%;'>" + this.Spec + "</span><span style='width:10%; text-align:right;'>" + this.Qty + "</span><div style='clear:both;'></div></li>");
                            })

                            var str = "";
                            for (var i = 0; i < obj.Track.length; i++) {
                                str += "<li>" + obj.Track[i].time + (obj.Track[i].time == "" ? "" : "<br/>") + obj.Track[i].info + "</li>";
                            }
                            $("#order_logistics").append(str);
                        }
                    }
                },
                error: function () {
                }
            })
        }

        function BindAddressBtn(elementName) {
            $("#paneladdress .button").attr("href", "javascript:addressunload('" + elementName + "');");
            var regionname = $("#s_home_region").attr("value") == null ? "" : $("#s_home_region").text();
            if (elementName == "s_address")
                $("#paneladdress h3").text($("#s_city").text() + $("#s_district").text() + $("#s_building").text());
            else
                $("#paneladdress h3").text($("#s_home_city").text() + $("#s_home_district").text() + regionname);
        }

        function Search(element) {
            $.ui.showMask("正在搜索");
            var value = $(element).parent().find("#txtKey").val();
            setTimeout(function () {
                $(element).parent().parent().find("#slist li").each(function () {
                    var text = $(this).find("a").text();
                    if (text != undefined && text != null && text.indexOf(value) < 0)
                        $(this).hide();
                    else
                        $(this).show();
                })
                $.ui.hideMask();
            }, 100);
        }

        function ClearProduct() {
            $(".divc").each(function () {
                if ($(this).find("a").attr("isfixed") == undefined) {
                    $(this).find("a").removeAttr("value");
                    $(this).find("a").text("购买数量");
                    $(this).find("a").parent("li").parent("ul").css("background-color", "white");
                }
            })
            $.ui.updateBadge("#settle", $(".divc").find("a[value]").length, "tr");
            $("#ulBuy").empty();
            $("#ulBuy").append("<li><a href=\"#aftransitions\">请先选择要购买的商品</a></li>");
        }
    </script>
    <script type="text/javascript">
        function ValidatePay(paytype, callback) {
            if (paytype != "" && paytype != undefined && paytype != null && paytype.toLowerCase() == "79D283C3-9539-48FA-BEE8-8B4D728FB5CF".toLowerCase()) {
                var userid = $("#huid").val();
                if (userid == "") {
                    alert("用户错误！");
                    return false;
                }
                $.ui.showMask("请稍等");
                $("#btnHomeSubmit,#btnSubmit").attr("disabled", "disabled");
                $.ajax({
                    url: "/ajax/user.ashx?t=iv&r=" + Math.random(),
                    data: { userid: userid },
                    success: function (data) {
                        $.ui.hideMask();
                        $("#btnHomeSubmit,#btnSubmit").removeAttr("disabled");
                        var obj = eval(data)[0];
                        if (obj == undefined || obj == null) {
                            alert('支付验证失败！');
                            return false;
                        }

                        if (obj.r == 1) {
                            var orderamount = parseFloat($("#spantotal").text());
                            if (isNaN(orderamount)) {
                                alert("订单金额异常！");
                                return false;
                            }
                            var co = false;
                            var msg = "<label style='width:100%; text-align:center;'>帐户余额：<font style='color:red;'>￥" + obj.m + "</font><br>点击确认支付继续！</label>";
                            if (obj.m < orderamount) {
                                co = true;
                                msg = "<label style='width:100%;text-align:center;'>帐户余额：<font style='color:red;'>￥" + obj.m + "</font><br>不足已支付该订单,请更改支付方式！</label>";
                            }
                            $.ui.popup({
                                title: "预存款支付",
                                message: msg,
                                cancelOnly: co,
                                cancelText: '取消',
                                doneText: '确认支付',
                                doneCallback: function () {
                                    if (callback != undefined && callback != null)
                                        callback();
                                }
                            });
                        } else {
                            $.ui.popup({
                                title: "帐户验证",
                                message: "<input type='text' disabled='disabled' style='background-color:grey; color:green;font-weight:bolder;font-size:130%;' id=\"payloginanme\" value='" + obj.l + "'/><input type=\"password\" style='color:black;' id=\"paypwd\" placeholder=\"密码\"  /><label id='lblmsg' style='color:red;width:100%;text-align:center;'></label>",
                                cancelText: '取消',
                                doneText: '提交',
                                autoCloseDone: false,
                                doneCallback: function (self) {
                                    var loginname = $('#payloginanme').val();
                                    var pwd = $('#paypwd').val();
                                    if (pwd == "") {
                                        $("#lblmsg").text("密码不能为空！");
                                        return false;
                                    }
                                    var isBack = true;
                                    if (!isBack) {
                                        return false;
                                    }
                                    $("#lblmsg").text("");
                                    $("#action").text('. . .');
                                    var data = { loginname: loginname, pwd: stringToHex(pwd) };
                                    $.ui.showMask("请稍等");
                                    $("#action").attr('disabled', 'disabled');
                                    $.ajax({
                                        url: "/ajax/user.ashx?t=v&r=" + Math.random(),
                                        data: data,
                                        success: function (data) {
                                            isBack = true;
                                            $("#action").text('提交');
                                            $.ui.hideMask();
                                            var obj = eval(data)[0];
                                            if (obj != null && obj != undefined) {
                                                if (obj.r == 1) {
                                                    self.hide();
                                                    var orderamount = parseFloat($("#spantotal").text());
                                                    if (isNaN(orderamount)) {
                                                        alert("订单金额异常！");
                                                        return false;
                                                    }
                                                    var co = false;
                                                    var msg = "<label style='width:100%; text-align:center;'>帐户余额：<font style='color:red;'>￥" + obj.m + "</font><br>点击确认支付继续！</label>";
                                                    if (orderamount > obj.m) {
                                                        co = true;
                                                        msg = "<label style='width:100%;text-align:center;'>帐户余额：<font style='color:red;'>￥" + obj.m + "</font><br>不足已支付该订单,请更改支付方式！</label>";
                                                    }
                                                    $.ui.popup({
                                                        title: "预存款支付",
                                                        message: msg,
                                                        cancelOnly: co,
                                                        cancelText: '取消',
                                                        doneText: '确认支付',
                                                        doneCallback: function (self) {
                                                            self.hide();
                                                            if (callback != undefined && callback != null)
                                                                callback();
                                                        }
                                                    });
                                                } else {
                                                    $("#lblmsg").text(obj.msg);
                                                }
                                            }
                                        },
                                        error: function () {
                                            $.ui.hideMask();
                                        }
                                    })
                                }
                            });

                        }
                    },
                    error: function (error) {
                        $.ui.hideMask();
                        $("#btnHomeSubmit,#btnSubmit").removeAttr("disabled");
                        alert(error.responseText);
                    }
                })
            } else {
                if (callback != undefined && callback != null)
                    callback();
            }
            return false;
        }
        function stringToHex(pwd) {
            if (pwd == null) {
                return "";
            }

            var s = "";
            for (var i = 0; i < pwd.length; i++) {
                var hex = (pwd.charCodeAt(i) << 2).toString(16);
                while (hex.length < 8) {
                    hex = "0" + hex;
                }
                s = s + hex;
            }
            return s;
        }

    </script>
    <script type="text/javascript">
        $(document).ready(function () {
            $("#btnSubmit").click(function () {
                if ($($("#ulBuy li")[0]).find("a").text() == "请先选择要购买的商品") {
                    alert("请选择购买商品");
                    return false;
                }
                var phone = $("#txtPhone").val();
                if (phone == "") {
                    alert("请输入手机号！");
                    // $("#txtPhone").focus();
                    return false;
                }
                if (phone.length != 11 || isNaN(phone)) {
                    alert("手机号码格式不正确！");
                    return false;
                }
                if ($("#txtcode").val() == "") {
                    alert("请输入激活码！");
                    //$("#txtcode").focus();
                    return false;
                }
                if ($("#txtName").val() == "") {
                    alert("请输入收货人姓名！");
                    // $("#txtName").focus();
                    return false;
                }

                if ($("#s_building").attr("value") == "" || $("#s_building").attr("value") == undefined || $("#s_building").attr("value") == null || $("#s_building").attr("value") == "请选择"
                || $("#hbid").val() == "") {
                    alert("请选择楼宇！");
                    // $("#s_building").focus();
                    return false;
                }

                if ($("#ddlTime").attr("value") == null || $("#ddlTime").attr("value") == undefined || $("#ddlTime").attr("value") == "") {
                    alert("请选择送货时间！");
                    //$("#ddlTime").focus();
                    return false;
                }

                if ($("#ddlPayType").attr("value") == null || $("#ddlPayType").attr("value") == undefined || $("#ddlPayType").attr("value") == "") {
                    alert("请选择支付方式！");
                    // $("ddlPayType").focus();
                    return false;
                }
                if ($("#s_address").attr("value") == "" || $("#s_address").attr("value") == null || $("#s_address").attr("value") == undefined) {
                    alert("请补全地址！");
                    //$("#txtAddress").select();
                    return false;
                }
                if ($("#s_address").attr("value").length >= 50) {
                    alert("详细地址不能超过50个字符!");
                    return false;
                }
                if (!ValidatePay($("#ddlPayType").attr("value"), Submit))
                    return false;

            })
        });
        function Submit() {
            var ly = $("#s_city").text() + $("#s_district").text() + $("#s_building").text() + $("#s_address").text();
            if (confirm("地址：" + ly)) {
                var mobile = encodeURIComponent($("#txtPhone").val());
                var code = encodeURIComponent($("#txtcode").val());
                var name = encodeURIComponent($("#txtName").val());
                var buildingid = $("#s_building").attr("value");
                if (buildingid == null || buildingid == "" || buildingid == undefined || buildingid == '请选择')
                    buildingid = encodeURIComponent($("#hbid").val());
                buildingid = encodeURIComponent(buildingid);
                var address = encodeURIComponent($("#s_address").attr("value"));
                var time = encodeURIComponent($("#ddlTime").attr("value"));
                var btype = encodeURIComponent($("#hbtype").val());
                var batch = encodeURIComponent($("#hbatch").val());
                var paytype = encodeURIComponent($("#ddlPayType").attr("value"));
                var uid = encodeURIComponent($("#huid").val());
                if (uid == null || uid == undefined || uid == "null")
                    uid = "";
                var startype = encodeURIComponent($("#hstartype").val());
                var starremark = encodeURIComponent($("#hstarremark").val());
                var commoditys = "";
                $(".divc").each(function () {
                    var qty = $(this).find("a").attr("value");
                    var cid = $(this).find(".divc-cid").val();
                    var cname = $(this).attr("title");
                    if (qty != undefined && qty > 0 && cid != undefined && cid != "") {
                        commoditys += cid + "|" + qty + "|" + cname + ",";
                    }

                })
                if (commoditys == "") {
                    alert("没有选择商品！");
                    return false;
                }
                var data = { uid: uid, mobile: mobile, code: code, name: name, buildingid: buildingid, address: address, time: time, mby: "m",
                    BType: btype, commoditys: commoditys, BType: btype, StarType: startype, StarRemark: starremark, paytype: paytype, batch: batch
                };
                if (!beforeSubmit(data))
                    return false;
                $("#btnSubmit").attr("disabled", "disabled");
                $.ui.showMask('正在提交');
                $.ajax({
                    url: "/ajax/bailouOperator.ashx?OP=Submit&r=" + Math.random(),
                    type: "Post",
                    data: data,
                    success: function (msg) {
                        $("#btnSubmit").removeAttr("disabled");
                        $.ui.hideMask();
                        alert(msg);
                        if (msg.indexOf('成功') >= 0) {
                            ClearProduct();
                            if (paytype == "CE6D2CD9-2A5B-467A-96BC-3CE99135D4D0") {
                                Alipay();
                            } else {

                                $.ui.loadContent("#orderlist", false, false, "slide");
                            }
                        }
                    },
                    error: function () {
                    }
                })
            }
            return false;
        }
    </script>
    <script type="text/javascript">
        $(document).ready(function () {
            $("#btnHomeSubmit").click(function () {
                if ($($("#ulBuy li")[0]).find("a").text() == "请先选择要购买的商品") {
                    alert("请选择购买商品");
                    return false;
                }
                if ($("#txt_home_name").val() == "") {
                    alert("请输入收货人姓名！");
                    return false;
                }

                if ($("#txt_home_code").val() == "") {
                    alert("请输入激活码！");
                    //$("#txtcode").focus();
                    return false;
                }
                var phone = $("#txt_home_phone").val();
                if (phone == "") {
                    alert("请输入手机号！");
                    // $("#txtPhone").focus();
                    return false;
                }
                if (phone.length != 11 || isNaN(phone)) {
                    alert("手机号码格式不正确！");
                    return false;
                }

                if (($("#s_home_district").attr("value") == "" || $("#s_home_district").attr("value") == undefined || $("#s_home_district").attr("value") == null || $("#s_home_district").attr("value") == "请选择")) {
                    alert("请选择送货区县！");
                    // $("#s_building").focus();
                    return false;
                }

                var city = $("#s_home_city").text();
                if ("上海北京天津".indexOf(city) < 0) {
                    if (($("#s_home_region").attr("value") == "" || $("#s_home_region").attr("value") == undefined || $("#s_home_region").attr("value") == null || $("#s_home_region").attr("value") == "请选择")) {
                        alert("请选择送货区！");
                        return false;
                    }
                }

                if ($("#a_address").attr("value") == "" || $("#a_address").attr("value") == null || $("#a_address").attr("value") == undefined) {
                    alert("请补全地址！");
                    //$("#txtAddress").select();
                    return false;
                }
                if ($("#a_address").attr("value").length >= 50) {
                    alert("详细地址不能超过50个字符!");
                    return false;
                }
                if ($("#ddlHomeTime").attr("value") == null || $("#ddlHomeTime").attr("value") == undefined || $("#ddlHomeTime").attr("value") == "") {
                    alert("请选择送货时间！");
                    //$("#ddlTime").focus();
                    return false;
                }

                if ($("#ddlHomePayType").attr("value") == null || $("#ddlHomePayType").attr("value") == undefined || $("#ddlHomePayType").attr("value") == "") {
                    alert("请选择支付方式！");
                    // $("ddlPayType").focus();
                    return false;
                }
                if (!ValidatePay($("#ddlHomePayType").attr("value"), HomeSubmit))
                    return false;
            })
        })

        function HomeSubmit() {
            var ly = $("#s_home_district").text();
            var address = $("#a_address").attr("value");
            if (confirm("地址为：" + address)) {
                var mobile = $("#txt_home_phone").val();
                var name = $("#txt_home_name").val();
                var buildingid = $("#s_home_district").attr("value");
                var regionid = $("#s_home_region").attr("value");
                regionid = regionid == null ? "" : regionid;
                var regionname = $("#s_home_region").text();
                regionname = regionid == "" ? "" : regionname;
                var addresskey = $("#s_home_district").text();
                buildingid = (buildingid);
                var cityid = $("#s_home_city").attr("vlaue");
                var cityname = $("#s_home_city").text();
                var time = $("#ddlHomeTime").attr("value");
                var paytype = $("#ddlHomePayType").attr("value");
                var code = $("#txt_home_code").val();
                var uid = $("#huid").val();
                if (uid == null || uid == undefined || uid == "null")
                    uid = "";
                var commoditys = "";
                var total = 0;
                $(".divc").each(function () {
                    var qty = $(this).find("a").attr("value");
                    var cid = $(this).find(".divc-cid").val();
                    if (qty != undefined && qty > 0 && cid != undefined && cid != "") {
                        commoditys += cid + "|" + qty + "|1,";
                    }
                })
                if (commoditys == "") {
                    alert("没有选择商品！");
                    return false;
                }
                var paymentid = paytype + "|0";
                var btype = $("#hbtype").val();
                //var code = $("#hcode").val();
                var isfr = $("#hisfr").val();
                var batch = encodeURIComponent($("#hbatch").val());
                var data = { userid: uid, consigneephone: mobile, consigneename: name, areaid: buildingid, address: address, deliverytime: time, commoditys: commoditys, paymentid: paymentid, needinvoince: 0, cityname: cityname
                    , addresskey: address, addressdetail: addresskey + address, btype: btype, code: code, isfr: isfr, batch: batch, regionid: regionid, regionname: regionname
                };
                if (!beforeSubmit(data))
                    return false;
                $("#btnHomeSubmit").attr("disabled", "disabled");
                $.ui.showMask('正在提交');
                $.ajax({
                    url: "/ajax/AddOrder.ashx?op=add&r=" + Math.random() + "&btype=" + btype,
                    type: "Post",
                    data: data,
                    success: function (msg) {
                        $("#btnHomeSubmit").removeAttr("disabled");
                        $.ui.hideMask();
                        var obj = eval(msg)[0];
                        alert(obj.Msg);
                        if (obj.R == 1) {
                            ClearProduct();
                            if ($("#ddlHomePayType").attr("value") == "CE6D2CD9-2A5B-467A-96BC-3CE99135D4D0") {
                                Alipay();
                            } else {
                                $.ui.loadContent("#orderlist", false, false, "slide");
                            }
                        }
                    },
                    error: function (error) {
                        alert(error.responseText);
                    }
                })
            }
            return false;
        }
    </script>
    <script type="text/javascript">
        function Alipay() {
            $.ui.showMask('正在跳转支付宝');
            window.location.href = "http://ygbank.yiguo.com/ALIPAY/mPay.aspx";
        }
    </script>
</head>
<body>
           <div width=400px>
        很高兴认识你,高兴认识你,高兴认识你,高兴认识你,高兴认识你,高兴认识你,高兴认识你,高兴认识你,高兴认识你,高兴认识你,<br>
        <img src="http://sdk.tools.vipsinaapp.com/static/image/sae_editor/logo.gif" width=100px>
        </div>
    
    
    <form name="Form1" method="post" action="mall.aspx?code=WNFFK2F&amp;EnpName=&amp;BType=c7c09d9fcdcbc1cec493c2c1c2c3c8&amp;Batch=%u5fae%u4fe10625&amp;UserId=831e800c-147e-474b-8a03-8bbec99b42c9&amp;UserName=yiguo_1417026113&amp;Mobile=&amp;EndTime=2013-09-30&amp;Time=1425727966502" id="Form1">
<div>
<input type="hidden" name="__VIEWSTATE" id="__VIEWSTATE" value="/wEPDwUKLTU4MjM3NDUwM2RkP/huFcPLyybcBYnAut3+vyYHKEA=" />
</div>

<div>

	<input type="hidden" name="__EVENTVALIDATION" id="__EVENTVALIDATION" value="/wEWDwL9m8fwCQKVlI0kApT64pkEAuTR9sIIApWUwSQCsNTY+QwC3qf89gcCqP+W6AgC+5CxvQ0CoojYuAcC6M6vTwLChPy+DQLEku2wCALEhISFCwLCi9reA+PpV2c/OAfjVAWG56O5Ureg44jJ" />
</div>
    <input name="hbid" type="hidden" id="hbid" value="200124" />
    <input name="hbtype" type="hidden" id="hbtype" value="8" />
    <input name="hbatch" type="hidden" id="hbatch" value="微信0625" />
    <input name="huid" type="hidden" id="huid" value="831e800c-147e-474b-8a03-8bbec99b42c9" />
    <input name="hstartype" type="hidden" id="hstartype" value="500" />
    <input name="hstarremark" type="hidden" id="hstarremark" />
    <input name="hcode" type="hidden" id="hcode" value="WNFFK2F" />
    <input name="hisfr" type="hidden" id="hisfr" />
    <input name="hCitys" type="hidden" id="hCitys" value="1" />
    <input name="hCityName" type="hidden" id="hCityName" value="上海" />
    <div id="afui" class="ios">
        <div id="content">
            <div id="aftransitions" class="panel" data-footer='footerui' data-load="load" data-unload="unload">
                <div class="plist">
                    <ul style="padding: 0px;">
                        
                        <li>
                            <script type="text/javascript">
                                var obj = eval( {"title":"<span style=\"color:#000000;font-size:20px;font-weight:bold;\"> 易果楼送超值购 </span><span style=\"color:#000000;font-size:20px;\"><span style=\"color:#CF5926;font-size:18px;\"><strong>可购多份，免运费</strong></span></span><span style=\"color:#000000;font-size:20px;font-weight:bold;\"><br />\n我们诚邀您和您的好友共同分享<br />\n</span><br />","recommend":"<p>\n\t<span style=\"font-size:24px;font-weight:bold;\">活动介绍：</span><br />\n<span style=\"color:#575556;font-size:14px;font-weight:normal;\">即日起关注易果网-微信公众账号并回复“<span> <span style=\"color:#C91A2B;\">楼送，手机号</span></span>”，即可获得“活动激活码”<br />\n<span style=\"color:#C91A2B;\">选择您所在办公楼为收货地址，既可参与：<br />\n以上超值特惠<br />\n可订购多份，免运费！</span><br />\n<span>您可在收货时，选择现金或POS机支付，商品数量有限，售完即止。<br />\n<span style=\"color:blue;\">特别说明：商品仅限配送到办公楼，对于非办公楼地址，易果网有权取消订单。</span></span><br />\n<span><span></span></span></span> \n</p>","rule":"<span style=\"font-size:14px;font-weight:normal;\"> 1. 本活动仅限配送至上海、北京、杭州、苏州、天津指定办公楼；<br />\n2. 本活动优惠商品数量有限，售完即止；<br />\n3. 运费规则：免运费；<br />\n4. 支付方式：现金、POS机、预存款、支付宝；<br />\n5. 本活动仅限易果网注册用户参加；<br />\n6. 微信楼配订单，不与网站其它优惠活动同享，不送U币；<br />\n7. 商品一经发货，不做改期，敬请谅解。 <br />\n</span>","js":"var glbTimeHtml = [{ title: '2013-11-20', value: '2013-11-20' }, { title: '2013-11-21', value: '2013-11-21'}];\nvar glbSZTimeHtml = [{ title: '2014-06-28', value: '2014-06-28'}];\nglbSZTimeHtml = null;\n\n$(\"#s_city\").attr(\"fid\", \"100000,200000,600000,400000\");\n//$(\"#ddlTime\").attr(\"data\",[{title:'2013-10-09',value:'2013-10-09'},{title:'2013-10-10',value:'2013-10-10'}]);\n//$(\"#ddlTime\").attr(\"data\", glbTimeHtml);\nglbTimeHtml = eval($(\"#ddlTime\").attr(\"data\"));\n\nsetOnlyBuyOne(\"qty_10276\");\nsetSaleOut(\"\", \"北京天津\");\nsetSaleOut(\"\", \"北京天津石家庄\");\nsetSaleOut(\"\", \"上海杭州苏州\");\nsetSaleOut(\"qty_41418\", \"\");\nsetPayment();\n//$(\"#qty_11882\").text(\"已售罄\").removeAttr(\"href\").removeAttr(\"data\");\n//$(\"#qty_41418\").text(\"已售罄\").removeAttr(\"href\").removeAttr(\"data\");\n//$(\"#qty_41421\").text(\"已售罄\").removeAttr(\"href\").removeAttr(\"data\");\n\nfunction afterAddressAuto(data) {\n\n    if (data == null || data == undefined || data.Bid == null) {\n        return;\n    }\n\n    $(\"#ddlTime\").text(\"收货日期[结单时间为下午六点]\");\n    $(\"#ddlTime\").removeAttr(\"value\");\n\n    var city = getCityNameByBId(data.Bid);\n    if (\"无锡石家庄廊坊宁波\".indexOf(city) >= 0 && glbSZTimeHtml != null) {\n        $(\"#ddlTime\").attr(\"data\", glbSZTimeHtml);\n    }\n}\n\nfunction listChange(e, selecttext, selectvalue) {\n    if (e == null || e == undefined) {\n        return;\n    }\n\n    if (e.attr(\"id\") == \"s_city\") {\n        $(\"#ddlTime\").text(\"收货日期[结单时间为下午六点]\");\n        $(\"#ddlTime\").removeAttr(\"value\");\n        if (\"无锡石家庄廊坊宁波\".indexOf(e.text()) >= 0) {\n            if (glbSZTimeHtml != null) {\n                $(\"#ddlTime\").attr(\"data\", glbSZTimeHtml);\n            }\n        }\n        else {\n            $(\"#ddlTime\").attr(\"data\", glbTimeHtml);\n        }\n    }\n}\n\nfunction beforeSubmit(data) {\n\n    if (data == null || data == undefined || data.commoditys == null || data.commoditys == \"\") {\n        alert('请选择商品');\n        return false;\n    }\n\n    var city = getCityNameByBId(data.buildingid);\n    var commoditys = data.commoditys.toLowerCase();\n\n    data.fcommodity = \"57ede725-f7f7-483c-922d-9b5041b5bc71|9b14c5e4-b362-4dc1-88db-b210d79eb85b|fca5e86f-ec16-4b07-ac92-bd055374b4fc\";\n    data.disabled = 0;\n\n    if (city == \"北京\" && commoditys.indexOf(\"372064ca-79e4-4a7d-a343-d06ddd91fb5c\") >= 0) {\n        alert(\"江西超大赣南脐橙，北京地区已售完！\");\n        return false;\n    }\n\n    if (commoditys.indexOf(\"d415b3cd-35b6-4d3f-903e-b3a2237cb49c\") >= 0 && (data.time < \"2015-03-02\")) {\n        alert(\"进口无籽黑提2kg，3月02日（星期一）开始配送！\");\n        return false;\n    }\n\n    if (\"北京天津廊坊\".indexOf(city) >= 0 && commoditys.indexOf(\"aded07db-e39f-41d0-a90f-eead9c1ac944\") >= 0 && (data.time < \"2015-02-03\")) {\n        alert(\"zespri奇异果（普通绿果）20个（约90g-100g/个），北京、天津、廊坊地区，2月03日（星期二）开始配送！\");\n        return false;\n    }\n\n    if (\"北京天津廊坊\".indexOf(city) >= 0 && commoditys.indexOf(\"c9f48a91-6027-470c-bc75-e4b2ef5ea7b4\") >= 0 && (data.time < \"2015-02-04\")) {\n        alert(\"澳洲草饲西冷牛排150g*4份，北京、天津、廊坊地区，2月04日（星期四）开始配送！\");\n        return false;\n    }\n\n    if (\"北京天津廊坊\".indexOf(city) >= 0 && commoditys.indexOf(\"d308a791-d2ea-4dfd-80c1-3b16ff84d542\") >= 0 && (data.time < \"2015-01-30\")) {\n        alert(\"进口牛油果20枚，北京、天津、廊坊地区，1月30日（星期五）开始配送！\");\n        return false;\n    }\n\n    if (\"北京\".indexOf(city) >= 0 && commoditys.indexOf(\"f8845a2a-478d-423e-b7eb-c4ab1998aefc\") >= 0 && (data.time < \"2015-02-05\")) {\n        alert(\"精选红霞草莓2盒(40粒)+智利蓝莓3盒，北京地区，02月05日（星期四）开始配送！\");\n        return false;\n    }\n\n    if (\"北京天津石家庄\".indexOf(city) >= 0 && (data.time < \"2014-12-30\")) {\n        alert(\"北京、天津、石家庄地区，12月30日（星期二）开始配送！\");\n        return false;\n    }\n\n    if (\"上海北京杭州天津苏州无锡石家庄廊坊昆山宁波\".indexOf(city) < 0) {\n        alert(\"本次楼送活动不能配送至：\" + city);\n        return false;\n    }\n\n    return true;\n}\n\nfunction getCityNameByBId(bid) {\n\n    if (bid > 100000 && bid < 200000) { return \"北京\"; }\n    if (bid > 200000 && bid < 300000) { return \"上海\"; }\n    if (bid > 300000 && bid < 400000) { return \"南京\"; }\n    if (bid > 400000 && bid < 500000) { return \"天津\"; }\n    if (bid > 500000 && bid < 600000) { return \"苏州\"; }\n    if (bid > 600000 && bid < 700000) { return \"杭州\"; }\n    if (bid > 700000 && bid < 800000) { return \"无锡\"; }\n    if (bid > 800000 && bid < 900000) { return \"石家庄\"; }\n    if (bid > 900000 && bid < 1000000) { return \"廊坊\"; }\n    if (bid > 1000000 && bid < 1100000) { return \"昆山\"; }\n    if (bid > 1100000 && bid < 1200000) { return \"宁波\"; }\n\n    return \"\";\n}\n\n$(document).ready(function () {\n    $(\"#qty_160427\").unbind(\"click\");\n    $(\"#qty_160427\").attr(\"href\", \"javascript:void()\");\n    if ((window.location.href.indexOf(\"61435110\") < 0) && ($.os.chrome || $.os.ie)) {\n        //document.write(\"\\u672C\\u9875\\u9762\\u4EC5\\u5728\\u624B\\u673A\\u5FAE\\u4FE1\\u4E2D\\u4F7F\\u7528\");\n    }\n});\n\nfunction setOnlyBuyOne(cs) {\n    var arr = cs.split(\",\");\n    for (var i = 0; i < arr.length; i++) {\n        $(\"#\" + arr[i]).attr(\"data\", [{ value: 0, title: 0 }, { value: 1, title: 1}]);\n    }\n}\n\nfunction setSaleOut(cs, city) {\n    var currCity = $(\"#hCityName\").val();\n    var arr = cs.split(\",\");\n    for (var i = 0; i < arr.length; i++) {\n        if (city == null || city == \"\" || city == 'undefined') {\n            $(\"#\" + arr[i]).text(\"已售罄\").removeAttr(\"href\").removeAttr(\"data\");\n        }\n        else if (city.indexOf(currCity) >= 0) {\n            $(\"#\" + arr[i]).text(\"已售罄\").removeAttr(\"href\").removeAttr(\"data\");\n        }\n    }\n}\n\nfunction setPayment() {\n    var currCity = $(\"#hCityName\").val();\n    if (currCity != null && \"无锡石家庄廊坊宁波\".indexOf(currCity) >= 0) {\n        //$(\"#ddlPayType\").attr(\"data\", [{ value: \"A4C0B15B-B686-48A4-9684-2CF61FAAA13D\", title: \"现金支付\"}]);\n    }\n    if (currCity != null && \"石家庄\".indexOf(currCity) >= 0) {\n        $(\"#ddlPayType\").attr(\"data\", [{ value: \"79D283C3-9539-48FA-BEE8-8B4D728FB5CF\", title: \"预存款\" }, { value: \"CE6D2CD9-2A5B-467A-96BC-3CE99135D4D0\", title: \"支付宝\"}]);\n    }\n    if (currCity != null) {\n        if (currCity == \"无锡\") {\n            //glbSZTimeHtml = [{ title: '2014-05-27', value: '2014-05-27'}];\n        }\n        if (currCity == \"宁波\") {\n            //glbSZTimeHtml = [{ title: '2014-05-28', value: '2014-05-28'}];\n        }\n        if (currCity == \"石家庄\") {\n            //glbSZTimeHtml = [{ title: '2014-05-29', value: '2014-05-29'}];\n        }\n    }\n}","PCTitle":"<p style=\"color:#000000;font-size:24px;font-weight:bold;\" id=\"title\">\n\t<span style=\"color:#C91A2B;\">易果楼送超值购 可购多份，免运费</span><br />\n我们诚邀您和您的好友共同分享\n</p>","PCRecommend":"","PCRule":"1. 本活动仅限配送至上海、北京、杭州、苏州、天津指定办公楼；<br />\n2. 本活动优惠商品数量有限，售完即止；<br />\n3. 运费规则：免运费；<br />\n4. 支付方式：收货时现金或POS机支付；<br />\n5. 本活动仅限易果网注册用户参加；<br />\n6. 微信楼配订单，不与网站其它优惠活动同享，不送U币；<br />\n7. 商品一经发货，不做改期，敬请谅解。","PCJS":"setTimeout(function () {\n    $(\"#ctl00_ContentPlaceHolder1_s_city\").find(\"option[value='300000']\").remove();\n}, 1000);\n\nvar glbTimeHtml = '<option value=\"2014-01-02\">2014-01-02</option><option value=\"2014-01-03\">2014-01-03</option>';\n//$(\"#ctl00_ContentPlaceHolder1_s_city\").attr(\"fid\", \"100000,200000,600000,400000,500000\");\n//$(\"#ctl00_ContentPlaceHolder1_ddlTime\").empty().append(glbTimeHtml);\nglbTimeHtml = $(\"#ctl00_ContentPlaceHolder1_ddlTime\").html();\n\nvar glbSZTimeHtml = '<option value=\"2014-06-28\">2014-06-28</option>';\nglbSZTimeHtml = null;\n\n//$(\"#qty_10935\").attr(\"disabled\", true).empty();\n//$(\"#qty_41418\").attr(\"disabled\", true).empty();\n//$(\"#qty_41421\").attr(\"disabled\", true).empty();\nsetSaleOut(\"\", \"北京天津\");\nsetSaleOut(\"qty_50562\", \"北京天津石家庄\");\nsetSaleOut(\"\", \"上海杭州苏州\");\nsetSaleOut(\"qty_41418\", \"\");\nsetOnlyBuyOne(\"qty_10276\");\nsetPayment();\n\n$(\"#ctl00_ContentPlaceHolder1_s_city\").change(function () {\n    var cid = $(this).val();\n    if (cid == 700000 || cid == 800000 || cid == 900000 || cid == 1100000) {\n        if (glbSZTimeHtml != null) {\n            $(\"#ctl00_ContentPlaceHolder1_ddlTime\").empty().append(glbSZTimeHtml);\n        }\n    }\n    else {\n        $(\"#ctl00_ContentPlaceHolder1_ddlTime\").html(glbTimeHtml);\n    }\n});\n\nfunction afterAddressAuto(data) {\n\n    if (data == null || data == undefined || data.Bid == null) {\n        return;\n    }\n\n    var city = getCityNameByBId(data.Bid);\n    if (\"无锡石家庄廊坊宁波\".indexOf(city) >= 0) {\n        if (glbSZTimeHtml != null) {\n            $(\"#ctl00_ContentPlaceHolder1_ddlTime\").empty().append(glbSZTimeHtml);\n        }\n    }\n}\n\nfunction beforeSubmit(data) {\n\n    if (data == null || data == undefined || data.commoditys == null || data.commoditys == \"\") {\n        alert('请选择商品');\n        return false;\n    }\n\n    var city = getCityNameByBId(data.buildingid);\n    var commoditys = data.commoditys.toLowerCase();\n\n    data.fcommodity = \"57ede725-f7f7-483c-922d-9b5041b5bc71|9b14c5e4-b362-4dc1-88db-b210d79eb85b|fca5e86f-ec16-4b07-ac92-bd055374b4fc\";\n    data.disabled = 0;\n\n    if (city == \"北京\" && commoditys.indexOf(\"372064ca-79e4-4a7d-a343-d06ddd91fb5c\") >= 0) {\n        alert(\"江西超大赣南脐橙，北京地区已售完！\");\n        return false;\n    }\n\n    if (commoditys.indexOf(\"d415b3cd-35b6-4d3f-903e-b3a2237cb49c\") >= 0 && (data.time < \"2015-03-02\")) {\n        alert(\"进口无籽黑提2kg，3月02日（星期一）开始配送！\");\n        return false;\n    }\n\n    if (\"北京天津廊坊\".indexOf(city) >= 0 && commoditys.indexOf(\"aded07db-e39f-41d0-a90f-eead9c1ac944\") >= 0 && (data.time < \"2015-02-03\")) {\n        alert(\"zespri奇异果（普通绿果）20个（约90g-100g/个），北京、天津、廊坊地区，2月03日（星期二）开始配送！\");\n        return false;\n    }\n\n    if (\"北京天津廊坊\".indexOf(city) >= 0 && commoditys.indexOf(\"c9f48a91-6027-470c-bc75-e4b2ef5ea7b4\") >= 0 && (data.time < \"2015-02-04\")) {\n        alert(\"澳洲草饲西冷牛排150g*4份，北京、天津、廊坊地区，2月04日（星期四）开始配送！\");\n        return false;\n    }\n\n    if (\"北京天津廊坊\".indexOf(city) >= 0 && commoditys.indexOf(\"d308a791-d2ea-4dfd-80c1-3b16ff84d542\") >= 0 && (data.time < \"2015-01-30\")) {\n        alert(\"进口牛油果20枚，北京、天津、廊坊地区，1月30日（星期五）开始配送！\");\n        return false;\n    }\n\n    if (\"北京\".indexOf(city) >= 0 && commoditys.indexOf(\"f8845a2a-478d-423e-b7eb-c4ab1998aefc\") >= 0 && (data.time < \"2015-02-03\")) {\n        alert(\"精选红霞草莓2盒(40粒)+智利蓝莓3盒，北京地区，02月03日（星期二）开始配送！\");\n        return false;\n    }\n\n    if (\"北京天津石家庄\".indexOf(city) >= 0 && (data.time < \"2014-12-30\")) {\n        alert(\"北京、天津、石家庄地区，12月30日（星期二）开始配送！\");\n        return false;\n    }\n\n    if (\"上海北京杭州天津苏州无锡石家庄廊坊昆山宁波\".indexOf(city) < 0) {\n        alert(\"本次楼送活动不能配送至：\" + city);\n        return false;\n    }\n\n    return true;\n}\n\nfunction getCityNameByBId(bid) {\n\n    if (bid > 100000 && bid < 200000) { return \"北京\"; }\n    if (bid > 200000 && bid < 300000) { return \"上海\"; }\n    if (bid > 300000 && bid < 400000) { return \"南京\"; }\n    if (bid > 400000 && bid < 500000) { return \"天津\"; }\n    if (bid > 500000 && bid < 600000) { return \"苏州\"; }\n    if (bid > 600000 && bid < 700000) { return \"杭州\"; }\n    if (bid > 700000 && bid < 800000) { return \"无锡\"; }\n    if (bid > 800000 && bid < 900000) { return \"石家庄\"; }\n    if (bid > 900000 && bid < 1000000) { return \"廊坊\"; }\n    if (bid > 1000000 && bid < 1100000) { return \"昆山\"; }\n    if (bid > 1100000 && bid < 1200000) { return \"宁波\"; }\n\n    return \"\";\n}\n\nfunction setOnlyBuyOne(cs) {\n    var arr = cs.split(\",\");\n    for (var i = 0; i < arr.length; i++) {\n        var mqt = document.getElementById(arr[i]);\n        if (mqt != null) {\n            mqt.length = 2;\n        }\n    }\n}\n\nfunction setSaleOut(cs, city) {\n    var curr = null;\n    if (typeof (getCityByCookie) != \"undefined\") {\n        curr = getCityByCookie();\n    }\n    var arr = cs.split(\",\");\n    for (var i = 0; i < arr.length; i++) {\n        if (city == null || city == \"\" || city == 'undefined' || curr == null) {\n            $(\"#\" + arr[i]).attr(\"disabled\", true).empty();\n        }\n        else if (city.indexOf(curr.CityName) >= 0) {\n            $(\"#\" + arr[i]).attr(\"disabled\", true).empty();\n        }\n    }\n}\n\nfunction setPayment() {\n    var curr = null;\n    if (typeof (getCityByCookie) != \"undefined\") {\n        curr = getCityByCookie();\n    }\n    if (curr != null && \"无锡石家庄廊坊宁波\".indexOf(curr.CityName) >= 0) {\n        //$(\"#ctl00_ContentPlaceHolder1_ddlPayType\").empty().append('<option value=\"A4C0B15B-B686-48A4-9684-2CF61FAAA13D\">现金支付</option>');\n    }\n    if (currCity != null && \"石家庄\".indexOf(currCity) >= 0) {\n        $(\"#ddlPayType\").attr(\"data\", [{ value: \"79D283C3-9539-48FA-BEE8-8B4D728FB5CF\", title: \"预存款\" }, { value: \"CE6D2CD9-2A5B-467A-96BC-3CE99135D4D0\", title: \"支付宝\"}]);\n    }\n    if (\"无锡\" == curr.CityName) {\n        //glbSZTimeHtml = '<option value=\"2014-05-27\">2014-05-27</option>';\n    }\n    if (\"宁波\" == curr.CityName) {\n        //glbSZTimeHtml = '<option value=\"2014-05-28\">2014-05-28</option>';\n    }\n    if (\"石家庄\" == curr.CityName) {\n        //glbSZTimeHtml = '<option value=\"2014-05-29\">2014-05-29</option>';\n    }\n}","isFreight":"0","name":"【楼送活动】","date":"活动时间：2014-11-24 至 2015-03-13","batch":"","queryremark":"微信回复“楼送订单”可查询订单","coderemark":"微信回复“楼送，手机号 ”获取","timeremark":" (结单时间为下午六点,仅限工作日配送，双休除外）","temp":"若没有您的办公楼，请微信回复“申请新楼 市 区 楼名 地址”，如：申请新楼上海徐汇区安盛大厦汾阳路77号","Images":["http://img02.yiguo.com/e/web/130101/weixin/weixin_pic.jpg"]} );
                                if (obj != undefined) {
                                    if (obj.title != undefined) document.writeln(obj.title);
                                    if (obj.date != undefined) document.writeln("<span style='color:blue;'>" + obj.date + "</span>");
                                    if (obj.rule != undefined) $(document).ready(function () {
                                        $("#rulecontent").html(obj.rule);
                                    });
                                    if (obj.isFreight != undefined) $("#hisfr").val(obj.isFreight);
                                    if (obj.batch != undefined && obj.batch != "") $("#hbatch").val(obj.batch);
                                    if (obj.temp != undefined && obj.temp != "") {
                                        $(document).ready(function () { $("#spanTemp").text(obj.temp); });
                                    }
                                } </script>
                        </li>
                        
                                <li style="line-height: normal; height: auto;">
                                    <div class="product" style="height: auto;">
                                        <div class="p-img" id="img_50773">
                                            <img width="140px" align="middle" height="140px" value="/ajax/MallPic.ashx?id=d415b3cd-35b6-4d3f-903e-b3a2237cb49c">
                                        </div>
                                        <div class="divc" style="float: right; width: 140px; height: 140px; text-align: center;
                                            position: relative;" title="进口无籽黑提2kg">
                                            <div class="p-price">
                                                <input type="hidden" value="69.0000" />
                                                ￥69.00
                                                <span style="margin-left: 0px;">/箱</span>
                                            </div>
                                            <div style="text-align: right; position: absolute; bottom: 0px; right: 4px; width: 100%;">
                                                <input type="hidden" class="divc-cid" value="d415b3cd-35b6-4d3f-903e-b3a2237cb49c" />
                                                <ul class="list inset ulselect after" name="ulqty">
                                                    <li style="padding: 10px 20px;"><a id='qty_50773' title="购买数量"
                                                        href="#selectoptions" style="text-align: center; margin-top: -30px;" data="[{ value: 0, title:0 },{ value: 1, title: 1 }, { value: 2, title: 2 }, { value:3, title: 3 }, { value: 4, title: 4 }, { value: 5, title: 5 }, { value: 6, title:6 },{ value: 7, title: 7 }, { value: 8, title: 8 }, { value: 9, title: 9 }, { value:10, title: 10}]">
                                                        购买数量</a></li></ul>
                                            </div>
                                        </div>
                                        <div class="p-name">
                                            进口无籽黑提2kg
                                        </div>
                                    </div>
                                </li>
                            
                                <li style="line-height: normal; height: auto;">
                                    <div class="product" style="height: auto;">
                                        <div class="p-img" id="img_12581">
                                            <img width="140px" align="middle" height="140px" value="/ajax/MallPic.ashx?id=7c619874-574a-4899-a39c-c9ff4e015eb6">
                                        </div>
                                        <div class="divc" style="float: right; width: 140px; height: 140px; text-align: center;
                                            position: relative;" title="新西兰软枣奇异果2盒">
                                            <div class="p-price">
                                                <input type="hidden" value="79.0000" />
                                                ￥79.00
                                                <span style="margin-left: 0px;">/组</span>
                                            </div>
                                            <div style="text-align: right; position: absolute; bottom: 0px; right: 4px; width: 100%;">
                                                <input type="hidden" class="divc-cid" value="7c619874-574a-4899-a39c-c9ff4e015eb6" />
                                                <ul class="list inset ulselect after" name="ulqty">
                                                    <li style="padding: 10px 20px;"><a id='qty_12581' title="购买数量"
                                                        href="#selectoptions" style="text-align: center; margin-top: -30px;" data="[{ value: 0, title:0 },{ value: 1, title: 1 }, { value: 2, title: 2 }, { value:3, title: 3 }, { value: 4, title: 4 }, { value: 5, title: 5 }, { value: 6, title:6 },{ value: 7, title: 7 }, { value: 8, title: 8 }, { value: 9, title: 9 }, { value:10, title: 10}]">
                                                        购买数量</a></li></ul>
                                            </div>
                                        </div>
                                        <div class="p-name">
                                            新西兰软枣奇异果2盒
                                        </div>
                                    </div>
                                </li>
                            
                                <li style="line-height: normal; height: auto;">
                                    <div class="product" style="height: auto;">
                                        <div class="p-img" id="img_10957">
                                            <img width="140px" align="middle" height="140px" value="/ajax/MallPic.ashx?id=f24e71e0-6e54-4c22-82a5-32b80041830d">
                                        </div>
                                        <div class="divc" style="float: right; width: 140px; height: 140px; text-align: center;
                                            position: relative;" title="泰国龙眼2KG装">
                                            <div class="p-price">
                                                <input type="hidden" value="69.0000" />
                                                ￥69.00
                                                <span style="margin-left: 0px;">/箱</span>
                                            </div>
                                            <div style="text-align: right; position: absolute; bottom: 0px; right: 4px; width: 100%;">
                                                <input type="hidden" class="divc-cid" value="f24e71e0-6e54-4c22-82a5-32b80041830d" />
                                                <ul class="list inset ulselect after" name="ulqty">
                                                    <li style="padding: 10px 20px;"><a id='qty_10957' title="购买数量"
                                                        href="#selectoptions" style="text-align: center; margin-top: -30px;" data="[{ value: 0, title:0 },{ value: 1, title: 1 }, { value: 2, title: 2 }, { value:3, title: 3 }, { value: 4, title: 4 }, { value: 5, title: 5 }, { value: 6, title:6 },{ value: 7, title: 7 }, { value: 8, title: 8 }, { value: 9, title: 9 }, { value:10, title: 10}]">
                                                        购买数量</a></li></ul>
                                            </div>
                                        </div>
                                        <div class="p-name">
                                            泰国龙眼2KG装
                                        </div>
                                    </div>
                                </li>
                            
                                <li style="line-height: normal; height: auto;">
                                    <div class="product" style="height: auto;">
                                        <div class="p-img" id="img_12558">
                                            <img width="140px" align="middle" height="140px" value="/ajax/MallPic.ashx?id=031bf960-efc2-4b75-bc5a-c3b045fbb108">
                                        </div>
                                        <div class="divc" style="float: right; width: 140px; height: 140px; text-align: center;
                                            position: relative;" title="美国新奇士脐橙羊年礼盒装（22个，约190g/个）">
                                            <div class="p-price">
                                                <input type="hidden" value="99.0000" />
                                                ￥99.00
                                                <span style="margin-left: 0px;">/箱</span>
                                            </div>
                                            <div style="text-align: right; position: absolute; bottom: 0px; right: 4px; width: 100%;">
                                                <input type="hidden" class="divc-cid" value="031bf960-efc2-4b75-bc5a-c3b045fbb108" />
                                                <ul class="list inset ulselect after" name="ulqty">
                                                    <li style="padding: 10px 20px;"><a id='qty_12558' title="购买数量"
                                                        href="#selectoptions" style="text-align: center; margin-top: -30px;" data="[{ value: 0, title:0 },{ value: 1, title: 1 }, { value: 2, title: 2 }, { value:3, title: 3 }, { value: 4, title: 4 }, { value: 5, title: 5 }, { value: 6, title:6 },{ value: 7, title: 7 }, { value: 8, title: 8 }, { value: 9, title: 9 }, { value:10, title: 10}]">
                                                        购买数量</a></li></ul>
                                            </div>
                                        </div>
                                        <div class="p-name">
                                            美国新奇士脐橙羊年礼盒装（22个，约190g/个）
                                        </div>
                                    </div>
                                </li>
                            
                        <li><a href="#divrule" class="button" style="width: 100%;">活动细则</a> </li>
                        <li style="text-align: center;">客服电话：400-000-7788</li>
                        <li style="text-align: center;">易果生鲜：www.yiguo.com</li>
                    </ul>
                    <br />
                    <br />
                </div>
            </div>
            <a href="#orderlist" id="atran" style="display: none;"></a>
            
            <script type="text/javascript">
                function ExChangeCity(bid) {

                    var url = window.location.href.replace(/bid=\d+/i, "bid=" + bid);
                    if (url.indexOf("bid") == -1)
                        url = url.split("#")[0] + "&bid=" + bid + "&r=" + Math.random();
                    window.location.href = url;
                }
                function ShowAreaSelect() {
                    var strcitybtn = "<a onclick='javascript:ExChangeCity(200000)' class='button citybutton' style='color:black;width:49%;font-size:120%;'>上海</a>" +
                    "<a onclick='javascript:ExChangeCity(100000)' class='button citybutton' style='margin-left:4px;font-size:120%;color:black;width:49%;'>北京</a>" +
                    "<a onclick='javascript:ExChangeCity(600000)' class='button citybutton' style='font-size:120%;color:black;width:49%;'>杭州</a>" +
                    "<a onclick='javascript:ExChangeCity(400000)' class='button citybutton' style='margin-left:4px;font-size:120%;color:black;width:49%;'>天津</a>" +
                    "<a onclick='javascript:ExChangeCity(500000)' class='button citybutton' style='font-size:120%;color:black;width:49%;'>苏州</a>" +
                    "<a onclick='javascript:ExChangeCity(800000)' class='button citybutton' style='margin-left:4px;font-size:120%;color:black;width:49%;'>石家庄</a>" +
                    "<a onclick='javascript:ExChangeCity(700000)' class='button citybutton' style='font-size:120%;color:black;width:49%;'>无锡</a>" +
                    "<a onclick='javascript:ExChangeCity(900000)' class='button citybutton' style='margin-left:4px;font-size:120%;color:black;width:49%;'>廊坊</a>" +
                    "<a onclick='javascript:ExChangeCity(1000000)' class='button citybutton' style='font-size:120%;color:black;width:49%;'>昆山</a>" +
                    "<a onclick='javascript:ExChangeCity(1100000)' class='button citybutton' style='margin-left:4px;font-size:120%;color:black;width:49%;'>宁波</a>";

                    $.ui.popup({
                        title: "请选择送货城市",
                        message: strcitybtn,
                        cancelOnly: 'ha'
                    });
                }
                //                $(document).ready(function () {

                $.ui.ready(function () {
                    $.ui.backButtonText = "返回";
                    var citys = $("#hCitys").val();
                    $.query("#header").find("#pageTitle").append("<a class='change' href='ShowAreaSelect' style='font-size:100%;'>上海</a>");
                    $.query("#header").find("#pageTitle").click(function () { ShowAreaSelect(); })
                    if (citys == 0) {
                        $("#hCitys").val(2);
                        $.ui.blockUI(0.2);
                        $.ui.showMask('');
                        setTimeout(function () {
                            $.ui.hideMask();
                            ShowAreaSelect();
                        }, 100)
                    }
                    else {
                        var bid = $("#hbid").val();
                        if (bid != undefined && bid > 0)
                            $("#s_city").attr("fid", bid)
                    }
                })
                //                }) 
            </script>
            <div class="panel" id="transition1" data-footer="footerui" data-load="AddressAuto"
                data-unload="unload">
                <div class="formGroupHead">
                    购买的商品</div>
                <ul id="ulBuy" class="list inset ">
                    <li>请选择购买商品</li>
                </ul>
                <div class="formGroupHead">
                    收货信息</div>
                <input name="txtcode" type="text" id="txtcode" style="display:none" placeholder="微信激活码" value="WNFFK2F" />
                <span class="error"></span>
                <br />
                <input name="txtPhone" type="text" id="txtPhone" placeholder="手机号码" />
                <br />
                <input name="txtName" type="text" id="txtName" placeholder="收货人姓名" />
                <br />
                <ul class="list inset ulselect after">
                    <li class='select'><a id="s_city" title="省市" style="text-align: center;">省市</a></li>
                    <li class='select'><a id="s_district" title="区县" style="text-align: center;">区县 </a>
                    </li>
                    <li class='select'><a id="s_building" title="办公楼" style="text-align: center;">办公楼 </a>
                        <span id="saddress"></span></li>
                    <li class='select'><a href="#paneladdress" onclick='BindAddressBtn("s_address")'
                        id="s_address" style="text-align: center;">点击输入详细地址</a></li>
                    <li><a href="#selectoptions" id="ddlTime" data="[{title:'2015-03-09',value:'2015-03-09'},{title:'2015-03-10',value:'2015-03-10'},{title:'2015-03-11',value:'2015-03-11'},{title:'2015-03-12',value:'2015-03-12'},{title:'2015-03-13',value:'2015-03-13'}]" style="text-align: center;" title="收货日期[结单时间为下午六点] ">收货日期[结单时间为下午六点]
                    </a></li>
                    <li><a id="ddlPayType" href="#selectoptions" style="text-align: center;" title="支付方式"
                        data='[{ value: "065A7A0C-B42C-4445-8B80-5686C48E4666", title: "POS机支付"
    }, { value: "A4C0B15B-B686-48A4-9684-2CF61FAAA13D", title: "现金支付"},{value:"79D283C3-9539-48FA-BEE8-8B4D728FB5CF",title:"预存款"},{value:"CE6D2CD9-2A5B-467A-96BC-3CE99135D4D0",title:"支付宝"}]'>
                        支付方式</a> </li>
                </ul>
                <br />
                <div class='binding' style="display: none;">
                    <label style="text-align: left; font-size: 18px; font-weight: bold;">
                        配送地址:</label>
                    <br />
                    <input placeholder="配送地址" id="td_address" type="text" style="color: Blue;" readonly="readOnly"
                        disabled="disabled" />
                    <br />
                </div>
                <div class='binding' style="display: none;">
                    <a onclick="javascript:AddressSelect();" style="color: Red; float: right;" class="button">
                        重新选择地址>></a>
                    <br />
                    <br />
                    <br />
                    <br />
                    <br />
                </div>
                <div>
                    <div id="temp">
                    </div>
                </div>
                <div id="blfreight" style='text-align: right; color: Red; font-weight: bolder; display: none;'>
                </div>
                <input type="submit" name="btnSubmit" value="提交" id="btnSubmit" class="button" style="width: 100%; height: 40px;
                    font-size: 100%;" />
                <br />
                <span id="spanTemp" style='color: #CF5926;'></span>
                <br />
                <br />
                <br />
                <br />
                <br />
                <br />
                <br />
            </div>
            
            <div class="panel" id="selectoptions" data-modal="true" data-unload="UnLoadData">
                <h2 id="stitle">
                </h2>
                <div style="min-width: 250px; display: none;" id="divSearch">
                    <input id="txtKey" type="text" style="float: left; width: 70%; margin-left: 10px;
                        margin-right: 10px;" placeholder="关键字搜索" /><input onclick="Search(this)" style="float: left;
                            margin: 0px; height: 40px; width: 70px;" type="button" value="搜索" class="button" />
                </div>
                <ul class="list so" id="slist" style="clear: both;">
                </ul>
                <br />
                <br />
                <br />
                <br />
            </div>
            <div class="panel" id="divrule" data-footer="footerui">
                <h2>
                    活动细则:</h2>
                <div class="formGroupHead" id="rulecontent">
                </div>
                <a href="#aftransitions" class="button" style="width: 100%;">返回</a>
            </div>
            <div id="orderlist" class='panel' data-footer="footerui" data-load='loadorder'>
                <div class="formGroupHead">
                    我的订单 <a style='float: right;' href="tel:400-000-7788">400-000-7788</a></div>
                <ul class="list inset after orderlist">
                </ul>
            </div>
            <div id="paneladdress" class='panel' data-footer="footerui" data-modal="true">
                <h2>
                    请输入详细地址</h2>
                <h3 style='margin-left: 10px;'>
                    上海长宁</h3>
                <input class="areaAddress" type="text" style="width: 97%; margin: 10px;" placeholder="例如：A幢4楼" />
                <a class="button" style="width: 97%; margin-left: 10px; margin-right: 10px;">确定</a>
            </div>
            <div id="panelOrderDetails" class='panel' data-footer="footerui">
                <div class="formGroupHead">
                    订单明细<a style='float: right;' href="tel:400-000-7788">400-000-7788</a>
                </div>
                <a id="btnPay" href="#" class="c-btn-orange">去支付</a>
                <div class="input-group">
                    <label>
                        订单状态：</label><input id="orderstatus" type="text" value="" disabled="disabled" />
                    <label>
                        流水号：</label><input id="txtSN" type="text" disabled="disabled" />
                    <label>
                        收货人：</label><input id="txtCName" type="text" disabled="disabled" />
                    <label>
                        联系电话：</label><input id="txtCMobile" type="text" disabled="disabled" />
                    <label>
                        地址：</label><input id="txtCAddress" type="text" disabled="disabled" />
                    <label>
                        送货日期：</label><input id="txtDTime" type="text" disabled="disabled" />
                    <label>
                        订单日期：</label><input id="txtCTime" type="text" disabled="disabled" />
                    <label>
                        订单金额：</label><input id="txtTotalPrice" type="text" disabled="disabled" />
                    <label>
                        运费：</label><input id="txtFreight" type="text" disabled="disabled" />
                    <label>
                        支付方式：</label><input id="txtPayment" type="text" disabled="disabled" />
                </div>
                <div class="formGroupHead">
                    订单商品
                </div>
                <ul class="list inset orderlist">
                </ul>
                <div class="formGroupHead">
                    订单跟踪
                </div>
                <div style="border: 1px solid #ccc;border-radius: 6px;background-color: #fff;">
                    <ol id="order_logistics">
                    </ol>
                </div>
                <a href="#orderlist" class="button" style="width: 100%;">返回</a>
                <br />
                <br />
                <br />
                <br />
            </div>
        </div>
    </div>
    <footer id='footerui'>
                <a href="#aftransitions" id='A2'  class="pressed" >首页</a>
                                <a id="settle" href="#transition1" >结算</a>
                                <a  href="#orderlist" >订单</a>
            </footer>
    </form>
    <script type="text/javascript">
        if (obj != undefined) {
            if (obj.js != undefined)
                eval(obj.js);
        }
        function LoadScroll() {
            if ($.os.chrome || $.os.ie) {
                if (!((window.DocumentTouch && document instanceof DocumentTouch) || 'ontouchstart' in window)) {
                    var script = document.createElement("script");
                    script.src = "Scripts/jm/af.desktopBrowsers.js";
                    var tag = $("head").append(script);
                }
            }
        }
        $(document).ready(function () {
            document.addEventListener('WeixinJSBridgeReady', function onBridgeReady() {
                WeixinJSBridge.call('hideToolbar');
                WeixinJSBridge.call('hideOptionMenu');
            });
        })
    </script>
</body>
</html>
