wx.ready(function () {
  // 1 判断当前版本是否支持指定 JS 接口，支持批量判断
  document.querySelector('#checkJsApi').onclick = function () {
    wx.checkJsApi({
      jsApiList: [
        'getNetworkType',
        'chooseImage',
          'scanQRCode'
      ],
      success: function (res) {
        alert(JSON.stringify(res));
      }
    });
  };

    

    
      // 5.1 拍照、本地选图
  var images = {
    localId: [],
    serverId: []
  };
    
  document.querySelector('#chooseImage').onclick = function () {
  
    wx.chooseImage({
      success: function (res) {
        images.localId = res.localIds;
        alert('已选择 ' + res.localIds.length + ' 张图片');
      }
    });
  };
    
    
    
    
    // 7 地理位置接口
  // 7.1 查看地理位置
  document.querySelector('#openLocation').onclick = function () {
    wx.openLocation({
      latitude: 30.93082,
      longitude: 117.817825,
      name: 'TIT 创意园',
      address: '上海市浦东新区',
      scale: 14,
      infoUrl: 'http://weixin.qq.com'
    });
  };
    
    

  // 7.2 获取当前地理位置
  document.querySelector('#getLocation').onclick = function () {
    wx.getLocation({
      success: function (res) {
        alert(JSON.stringify(res));
      },
      cancel: function (res) {
        alert('用户拒绝授权获取地理位置');
      }
    });
  };

    
    
    
    
    // 9 微信原生接口
  // 9.1.1 扫描二维码并返回结果
  document.querySelector('#scanQRCode0').onclick = function () {
    wx.scanQRCode({
  //    desc: 'scanQRCode desc'
        success: function (res) {
            alert("OK");
        }
    });
  };
  // 9.1.2 扫描二维码并返回结果
  document.querySelector('#scanQRCode1').onclick = function () {
    wx.scanQRCode({
      needResult: 1,
  //    desc: 'scanQRCode desc',
      success: function (res) {
     //   if alert(JSON.stringify(res));
          alert( res.resultStr);
      }
    });
  };

    

    
    
    
    
    
    
    
    
});
    
    
    wx.error(function (res) {
  alert(res.errMsg);
});