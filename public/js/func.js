// 公共函数库
var load = {};
var form = {};

$(function() {
	// load-加载
    load.show = function () {
    	$('.loading').removeClass('hide');
    }

    load.hide = function () {
    	$('.loading').addClass('hide');
    }

    // 获取ID绑定数据
    form.get = function (key) {
    	return $("input[name="+key+"]").val();
    }

    $('.delete').on('click', function(e){
      if(!confirm("确定删除么？删除后不可恢复")){ 
        return false;
      }
    })

})