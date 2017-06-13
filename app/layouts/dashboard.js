import React, {Component} from 'react';
import OneSignal from 'react-native-onesignal';
import {
  View,
  StatusBar,
  Text,
  Alert,
  StyleSheet,
  TouchableOpacity,
  Image,
  Linking,
  AsyncStorage,
  ScrollView,
  Dimensions,
  Platform,
} from 'react-native';

import HTMLView from 'react-native-htmlview';
import StickNotificationList from '../components/stickNotificationList/stickNotificationList';
import TitleContent from '../components/titleContent/titleContent';
import FullWidthImage from '../components/fullWidthImage/fullWidthImage';
import FulfillButton from '../components/fulfillButton/fulfillButton';
import InitSetting from './initSetting';
import SplashScreen from 'react-native-splash-screen';
import BottomBar from '../components/bottomBar';

export default class Dashboard extends Component {

  constructor(props) {
    super(props);
    this.apartment = {
        id: InitSetting.userInfo.apartmentId,
        name: InitSetting.userInfo.apartmentName,
    };
  }

  render() {
    return (
        <View style={styles.mainView}>
            <View style={{backgroundColor: '#0091C5', height: Platform.OS == 'ios' ? 20 : 0, alignSelf: 'stretch'}} >
              <StatusBar
                  barStyle="light-content"
                  backgroundColor='#0091C5'
                  hidden={false} />
            </View>

            <View style={this.styles.topContainer}>
                <TouchableOpacity onPress={()=>this.redirectSetting()}>
                    <Image
                      source={require('../images/menuNavigation.png')}
                      style={this.styles.menu}
                    />
                </TouchableOpacity>

                <View style={this.styles.titleContainer}>
                    <Text style={this.styles.title}>{this.apartment.name}</Text>
                </View>

                <View style={this.styles.menu}/>
            </View>

            <Image
                source={require('../images/background.png')}
                style={this.styles.imageBackground}
                resizeMode={'cover'}
            >
                <StickNotificationList navigator={this.props.navigator} />
            </Image>

            <BottomBar avoidSceneId='002' navigator={this.props.navigator}/>
      </View>
    );
  }

  redirectSetting() {
    this.props.navigator.push({sceneId: '009'}) 
  }

  styles = StyleSheet.create({
    topContainer: {
        flexDirection: 'row',
        justifyContent: 'center',
        alignItems: 'center',
        alignSelf: 'stretch',
        height: 40,
        backgroundColor: '#0F71AB'
    },
    placeHolder: {
        height: 35,
    },
    imageBackground: {
        flex: 1,
        width: Dimensions.get('window').width,
        alignSelf: 'center',
    },
    menu: {
        width: 30,
        height: 30,
        marginLeft: 5,
    },
    titleContainer: {
        flex: 1,
        alignItems: 'center',
    },
    title: {
        color: '#ffffff',
        fontSize: 20,
        fontFamily: 'Helvetica',
    },
  });
}

class AdBanner extends Component {
    render() {
        return (
            <View style={this.styles.container}>

            </View>
        );
    }

    styles = StyleSheet.create({
        container: {
            alignSelf: 'stretch',
            height: 90,
            backgroundColor: '#CCCCCC',
        },
    });
}

const styles = StyleSheet.create({
  mainView: {
    flex: 1,
    flexDirection: 'column',
    justifyContent: 'center',
    alignItems: 'center',
    backgroundColor: 'white',
  },
  bottomContainer: {
    flexDirection: 'column',
    flex: 1,
    justifyContent: 'flex-end'
  },
  groupButton: {
    flexDirection: 'row',
    height: 55,
    backgroundColor: '#4b8bf2',
    alignSelf: 'flex-end'
  }
});
