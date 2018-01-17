$(function(){

    // 登录请求
    $('.login-submit').on('click',function(e) {
        load.show();
        var name = $('#name').val();
        var password = $('#password').val();

        $('#name_login').addClass('hide');
        $('#password_login').addClass('hide');

        if (!Validate.check(name, 'token')) {
            $('#name_login').removeClass('hide');
            load.hide();
            return false;
        };

        if (!Validate.check(password, 'password')) {
            $('#password_login').removeClass('hide');
            load.hide();
            return false;
        }

        var params = {
            url: 'login/login',
            type: 'POST',
            data: {
              'name':name,
              'password':password
            },
            sCallback: function (data) {
              switch (data.code) {
                case 0:
                    window.location.href = Config.Url + 'admin/layout';
                break;
                case 1:
                    $('#name_login').removeClass('hide');
                    $('#password_login').removeClass('hide');
                    load.hide();
                break;
              }
            }
          };
        Http.request(params);
    })

    // 辅助键盘登录按键
    $(document).keyup(function(event) {
        switch(event.keyCode) {
            case 13:
            if ($('.loading').hasClass('hide')) {
                $('.login-submit').click();
            }
        }
    })

    // 验证码及其更换
    $('#recovery').on('click', function(e) {
        $('#recovery > img').attr('src', Config.Url + 'recovery/create');
    })

    $('#ex').on('click', function(e) {
        $('#recovery > img').attr('src', Config.Url + 'recovery/create');
    })

    // 提交修改表单
    $('#find_pw').on('click', function (e) {
        load.show();
        var token = form.get('find_user');
        var recovery = form.get('recovery');

        if (!Validate.check(token, 'token')) {
            alert('请输入正确的账号信息！');
            load.hide();
            return false;
        };

        var params = {
            url: 'login/recovery',
            type: 'POST',
            data: {
              'token':token,
              'recovery':recovery
            },
            sCallback: function (data) {
                switch (data.code) {
                    case 0:
                        alert('成功');
                    break;
                    default:
                        $('#recovery > img').attr('src', Config.Url + 'recovery/create');
                        alert(data.msg);
                        load.hide();
                    break;
                }
              console.log(data);
            }
          };
        Http.request(params);


    })


})