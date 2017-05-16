import InitSetting from '../layouts/initSetting';

export default class Url {

	static generate(url, params = []) {
		//Processing params
		var i = 0;
		for(i = 0; i < params.length; i++) {
			url = url.replace("{?}", params[i]);
		}

		if(i > 1) {
			url += '&';
		} else {
			url += '?';
		}
		url += "api_token=" + InitSetting.userInfo.apiToken;

		return url;
	}
}