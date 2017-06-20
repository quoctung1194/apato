import React, {Component} from 'react';
import OneSignal from 'react-native-onesignal';

import {
	View,
	Alert,
	AsyncStorage,
	Platform
} from 'react-native';

var navigator = undefined;

if(Platform.OS == 'ios') {
	OneSignal.configure({
		onNotificationOpened: function(message, data, isActive) {
	      	if(navigator == undefined) {
	        	InitSetting.pendingNotification = data;
	      	} else {
	            if(isActive) {
	            	Alert.alert(
	                	'Thong Bao',
	                  	'Ban nhan duoc thong bao moi, ban co muon xem thong bao nay ngay bay gio hay khong ?',
	                	[
	                    	{text: 'Cancel', onPress: () => console.log('Cancel Pressed') },
	                    	{text: 'OK', onPress: () => _transToNotification(data)},
	                	]
	             	);
	            } else {
	              _transToNotification(data);
	            }
	    	}
		}
	});

} else {
	OneSignal.inFocusDisplaying(0);
	//Khi App đang được active
	OneSignal.addEventListener('received', (notification) => {
		Alert.alert(
			'Thông Báo',
			'Bạn có thông báo mới, bạn có muốn xem ngay bây giờ không ?',
			[
				{text: 'Cancel', onPress: () => console.log('Cancel Pressed') },
				{text: 'OK', onPress: () => _transToNotification(notification.payload.additionalData)},
			]
		);
	});
	OneSignal.addEventListener('opened', (openResult) => {
		var data = openResult.notification.payload.additionalData;
		if(navigator == undefined) {
			InitSetting.pendingNotification = data;
		} else {
			_transToNotification(data);
		}
	});
}

function _transToNotification(notificationData) {
	if(notificationData.isSurvey == undefined) {
		notificationData.isSurvey = false;
	}

	if(!notificationData.isSurvey) {
		navigator.push({
			sceneId: '003',
			passProps: {
				notificationId: notificationData.notificationId,
			}
		});
	} else {
		navigator.push({
			sceneId: '004',
			passProps: {
				notificationId: notificationData.notificationId,
			}
		});
	}
}

export default class InitSetting extends Component {
	static pendingNotification = undefined;
	static userInfo = undefined;

	constructor(props) {
    	super(props);
    	navigator = this.props.navigator;
  	}

  	render() {
  		return(
  			<View></View>
  		);
  	}

  	componentDidMount() {
		this._settingParams();
  	}

  	async _settingParams() {
  		var userInfo = InitSetting.userInfo;

		if(Platform.OS == 'ios') {
  			OneSignal.enableInAppAlertNotification(false);
		}
		OneSignal.sendTags({
            userId: userInfo.userId,
            apartmentId: userInfo.apartmentId,
            blockId: userInfo.blockId,
            floorId: userInfo.floorId,
            roomId: userInfo.roomId,
        });

		this._navigating();
  	}

  	_navigating() {
  		this.props.navigator.push({sceneId: '002'});

  		if(InitSetting.pendingNotification != undefined) {
  			_transToNotification(InitSetting.pendingNotification);
  			InitSetting.pendingNotification = undefined;
  		}
  	}
}
