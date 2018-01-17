var Validate = {};

$(function(){
	Validate.check = function(data, type) {
		if (!data) {
			return false;
		}

		switch (type) {
			case 'string':
				return Validate.string(data);
			break;
			case 'token':
				return Validate.token(data);
			break;
			case 'password':
				return Validate.password(data);
			break;

		}
	}

	// 检查是否为字符串
	Validate.string = function(data) {
		return typeof data == 'string';
	}

	/**
	 * 检查用户名
	 * 只允许输入大小写字母-数字-和特殊字符.
	 * @return bool
	 */
	Validate.token = function(data) {
		var reg = /^([0-9]|[a-z]|[A-Z]|\.)*$/;
  		return reg.test(data);
	}

	/**
	 * 检查密码
	 * 只允许输入大小写字母-数字-和特殊字符.
	 * @return bool
	 */
	Validate.password = function(data) {
		var reg = /^([0-9]|[a-z]|[A-Z]|\.)*$/;
  		return reg.test(data);
	}

})