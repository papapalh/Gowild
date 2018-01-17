var Http = {};

$(function() {
    // http 请求类
    Http.request = function (params, noRefetch){
        var that = this,
            url=Config.Url + params.url;
        if(!params.type){
            params.type='get';
        }

        $.ajax({
            type: params.type,
            url: url,
            data: params.data,
            success: function(data) {
                var obj = JSON.parse(data);
                params.sCallback && params.sCallback(obj);
            },
            fail: function (err) {
                alert(err);
            }
        });
    }
})