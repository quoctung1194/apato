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
import Picker from 'react-native-picker';

export default class Setting extends Component
{
    constructor()
    {
        super();
        // init setting
        this.loadSettings();
    }

    /**
     * Load settings
     */
    loadSettings()
    {
        const ds = new ListView.DataSource({rowHasChanged: (r1, r2) => r1 !== r2});

        this.state = {
            dataSource: ds.cloneWithRows([
                {id: 'changePass', value: I18n.t('changePass')},
                {id: 'language', value: I18n.t('language')},
                {id: 'logout', value: I18n.t('logout')}
            ]),
        };

        // init picker
        this.initPicker();
    }

    async initPicker()
    {
        // made data for language
        let languageData = [
            I18n.t('vietnamese'),
            I18n.t('english')
        ];

        //get default language
        let localeValue = await AsyncStorage.getItem('settings.language');
        // get language value for picker
        let languageValue =  this.getLanguageNameByLocale(localeValue);

        Picker.init({
            pickerData: languageData,
            selectedValue: [languageValue],
            pickerCancelBtnText: I18n.t('cancel'),
            pickerConfirmBtnText: I18n.t('agree'),
            pickerTitleText: I18n.t('language'),
            onPickerConfirm: this.pickerConfirm.bind(this)
        });
    }

    /**
     * picker confirm event
     */
    async pickerConfirm(value)
    {
        // set value into local storage
        let localeValue = this.getLocaleValue(value);
        await AsyncStorage.setItem('settings.language', localeValue);

        // change locale
        I18n.locale = localeValue;

        // reset settings value
        this.loadSettings();
        this.setState(this.state);
    }

    render()
    {
        return (
            <View style={this.styles.container}>
                {this.renderStatusBar()}
                <NavigationBar title={I18n.t('setting')} navigator={this.props.navigator} />
                <ListView
                    ref={'settingList'}
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
                style={this.styles.rowContainer}
                onPress={this.onPress.bind(this, rowData['id'])}
                underlayColor={'transparent'}>
                    <Text style={[this.styles.row, this.styles.marginLeft10]}>
                        {rowData['value']}
                    </Text>
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
            case 'language':
                this.changeLanguage();
                break;
        }
    }

    getLocaleValue(selectedValue)
    {
        if(selectedValue == I18n.t('vietnamese')) {
            return 'en-VN';
        } else {
            return 'en-US';
        }
    }

    getLanguageNameByLocale(localeValue)
    {
        if(localeValue == 'en-VN') {
            return I18n.t('vietnamese');
        } else {
            return I18n.t('english');
        }
    }

    logout()
    {
        AsyncStorage.removeItem('userInfo', () => {
            OneSignal.sendTags({userId: -1, apartmentId: -1});
            this.props.navigator.resetTo({sceneId: '000'});
        });
    }

    changeLanguage()
    {
        Picker.show();
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
        rowContainer: {
            height: 40,
            justifyContent: 'center'
        },
        row: {
            fontSize: 17,
            flex: 1,
            textAlignVertical: "center",
            color: 'gray'
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