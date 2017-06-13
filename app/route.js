import React, {Component} from 'react';
import {
  Navigator,
  Alert,
} from 'react-native';
import TimerMixin from 'react-timer-mixin';
import OneSignal from 'react-native-onesignal';

import Dashboard from './layouts/dashboard';
import Notification from './layouts/notification';
import Survey from './layouts/survey';
import Requirement from './layouts/requirement';
import Login from './layouts/login';
import InitSetting from './layouts/initSetting';
import ServiceCategory from './layouts/serviceCategory';
import ServiceDetailList from './layouts/serviceDetailList';
import Register from './layouts/register';
import Setting from './layouts/setting';
import ChangePass from './layouts/changePass';

export default class Route extends Component {

  constructor(props) {
    super(props);
  }

  render() {
    return(
      <Navigator
        ref='nav'
        initialRoute={{ sceneId: '000' }}
        renderScene={ this.renderScene } />
    );
  }

  componentDidMount() {
    navigator = this.refs.nav;
  }

  renderScene(route, navigator) {  
    switch(route.sceneId) {
      case '000':
        return <Login navigator={navigator} {...route.passProps} />;
      case '001':
        return <InitSetting navigator={navigator} {...route.passProps} />;
      case '002':
        return <Dashboard navigator={navigator} {...route.passProps} />;
      case '003':
        return <Notification navigator={navigator} {...route.passProps} />;
	    case '004':
		    return <Survey navigator={navigator} {...route.passProps} />;
      case '005':
        return <Requirement navigator={navigator} {...route.passProps} />
      case '006':
        return <ServiceCategory navigator={navigator} {...route.passProps} />
      case '007':
        return <ServiceDetailList navigator={navigator} {...route.passProps} />
      case '008':
        return <Register navigator={navigator} {...route.passProps} />
      case '009':
        return <Setting navigator={navigator} {...route.passProps} />
      case '010':
        return <ChangePass navigator={navigator} {...route.passProps} />
    };
  }

}
