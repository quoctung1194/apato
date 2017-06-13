import React, {Component} from 'react';
import OneSignal from 'react-native-onesignal';
import {
  View,
  StatusBar,
  Text,
  ListView,
  StyleSheet,
  Platform,
  TouchableHighlight,
  AsyncStorage
} from 'react-native';
import NavigationBar from '../components/navigationBar';
import I18n from 'react-native-i18n';

export default class Setting extends Component
{
    constructor()
    {
        super();
        const ds = new ListView.DataSource({rowHasChanged: (r1, r2) => r1 !== r2});
        this.state = {
            dataSource: ds.cloneWithRows([
                {id: 'changePass', value: I18n.t('changePass')},
                {id: 'logout', value: I18n.t('logout')}
            ]),
        };
    }

    render()
    {
        return (
            <View style={this.styles.container}>
                {this.renderStatusBar()}
                <NavigationBar title={I18n.t('setting')} navigator={this.props.navigator} />
                <ListView
                    dataSource={this.state.dataSource}
                    renderRow={this.renderRow.bind(this)}
                    renderSeparator={this.renderSeperator.bind(this)}
                />
            </View>
        );
    }

    renderRow(rowData)
    {
        return (
            <TouchableHighlight
                onPress={this.onPress.bind(this, rowData['id'])}
                underlayColor={'transparent'}>
                <View style={[this.styles.marginLeft10, this.styles.marginTop10]}>
                    <Text style={this.styles.row}>{rowData['value']}</Text>
                </View>
            </TouchableHighlight>
        );
    }

    renderSeperator(sectionID, rowID, adjacentRowHighlighted)
    {
        return (
            <View key={rowID} style={this.styles.seperator} />
        );
    }

    renderStatusBar()
    {
        return (
            <View style={this.styles.statusBar} >
                <StatusBar
                    barStyle="light-content"
                    backgroundColor={this.styles.statusBar.backgroundColor} />
            </View>
        );
    }

    onPress(id)
    {
        switch(id) {
            case 'changePass':
                this.props.navigator.push({sceneId: '010'});
                break;
            case 'logout':
                this.logout();
                break;
        }
    }

    logout() {
        AsyncStorage.removeItem('userInfo', () => {
            OneSignal.sendTags({userId: -1, apartmentId: -1});
            this.props.navigator.resetTo({sceneId: '000'});
        });
  }
    
    styles = StyleSheet.create({
        container: {
            flexDirection: 'column',
            flex: 1,
            backgroundColor: 'white',
            alignItems: 'stretch'
        },
        statusBar: {
            backgroundColor: '#0091C5',
            height: Platform.OS == 'ios' ? 20 : 0,
            alignSelf: 'stretch',
        },
        row: {
            fontSize: 20,
            flex: 1
        },
        marginLeft10: {
            marginLeft: 10,
        },
        marginTop5: {
            marginTop: 5,
        },
        marginTop10: {
            marginTop: 10,
        },
        seperator: {
            height: 1,
            backgroundColor: 'gray',
        }
    });    
}