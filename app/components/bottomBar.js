import React, {Component} from 'react';
import I18n from 'react-native-i18n';

import {
  View,
  StatusBar,
  Text,
  Alert,
  StyleSheet,
  TouchableOpacity,
  Image,
  Linking,
} from 'react-native';

export default class BottomBar extends Component {

    render() {
        return (
            <View style={this.styles.container}>
                <TouchableOpacity
                  style={this.styles.iconContainer}
                  onPress={() =>
                    {
                        if(this.props.avoidSceneId == '002') {
                            return;
                        }

                        this._directToHome();
                    }
                  }
                >
                    <Image
                      source={require('../images/home.png')}
                      style={this.styles.icon}
                    />
                    <Text style={this.styles.text}>{I18n.t('home').toUpperCase()}</Text>
                </TouchableOpacity>
                <TouchableOpacity
                  style={this.styles.iconContainer}
                  onPress={() => this._makeCall()}
                >
                    <Image
                      source={require('../images/phone.png')}
                      style={this.styles.icon}
                    />
                    <Text style={this.styles.text}>{I18n.t('hotLine').toUpperCase()}</Text>
                </TouchableOpacity>
                <TouchableOpacity
                    style={this.styles.iconContainer}
                    onPress={() => {
                        if(this.props.avoidSceneId == '005') {
                            return;
                        }

                        this.props.navigator.push({
                          sceneId: '005',
                        });

                    }}
                >
                    <Image
                      source={require('../images/requirement.png')}
                      style={this.styles.icon}
                    />
                    <Text style={this.styles.text}>{I18n.t('sendRequirement').toUpperCase()}</Text>
                </TouchableOpacity>
                <TouchableOpacity
                    style={this.styles.iconContainer}
                    onPress={() => {
                        if(this.props.avoidSceneId == '006') {
                            return;
                        }
                        this.props.navigator.push({
                            sceneId: '006',
                        });
                    }}
                >
                    <Image
                      source={require('../images/cart.png')}
                      style={this.styles.icon}
                    />
                    <Text style={this.styles.text}>{I18n.t('service').toUpperCase()}</Text>
                </TouchableOpacity>
            </View>
        )
    }

    _makeCall() {
      Alert.alert(
          I18n.t('confirm'),
          I18n.t('confirmCallNumber', {number: '+84901660002'}),
          [
              {text: I18n.t('cancel'), onPress: () => console.log('Cancel Pressed') },
              {text: I18n.t('agree'), onPress: () => Linking.openURL('tel:+84901660002')},
          ]
      );
    }

    _directToHome() {
      this.props.navigator.resetTo({
              sceneId: '002'
      });
    }

    styles = StyleSheet.create({
        container: {
            height: 50,
            backgroundColor: '#E3E9EB',
            alignSelf: 'stretch',
            flexDirection: 'row',
            borderRadius: 4,
            borderWidth: 1,
            shadowOpacity: 0,
        },
        iconContainer: {
            flex: 1,
            justifyContent: 'center',
            alignItems: 'center',
        },
        text: {
            fontSize: 9
        },
        icon: {
            height: 30,
            width: 30,
        },
    });
}