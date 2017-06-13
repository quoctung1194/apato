import React, {Component} from 'react';
import {
  View,
  StatusBar,
  Text,
  StyleSheet,
  Platform,
  ScrollView,
  TextInput,
  TouchableOpacity,
  ActivityIndicator
} from 'react-native';
import I18n from 'react-native-i18n';
import NavigationBar from '../components/navigationBar';
import ApiUrl from '../constants/apiUrl';
import Url from '../utilizes/Url';

export default class ChangePass extends Component
{
    state = {
        oldPassword: '',
        newPassword: '',
        confirmNewPassword: '',
        isLoading: false,
    };

    render()
    {
        return (
            <View style={this.styles.container}>
                {this.renderStatusBar()}
                <NavigationBar title={I18n.t('changePass')} navigator={this.props.navigator} />
                {this.renderForm()}
            </View>
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

    renderForm()
    {
        return (
            <ScrollView
                keyboardDismissMode={Platform.OS == 'ios' ? 'on-drag': 'none'}
                keyboardShouldPersistTaps={true}
                alignItems={'stretch'} >
                <View style={this.styles.marginTop15}>
                    <TextInput
                        ref={'oldPassword'}
                        underlineColorAndroid={'transparent'}
                        placeholder={I18n.t('oldPassword')}
                        secureTextEntry={true}
                        placeholderTextColor={'gray'}
                        style={this.styles.input}
                        blurOnSubmit={false}
                        returnKeyType={'next'}
                        onSubmitEditing={() => {
                            this.refs['newPassword'].focus();
                        }}
                        onChangeText={(text) => {
                            this.state.oldPassword = text;
                        }} />

                    <TextInput
                        ref={'newPassword'}
                        underlineColorAndroid={'transparent'}
                        placeholder={I18n.t('newPassword')}
                        secureTextEntry={true}
                        placeholderTextColor={'gray'}
                        style={[this.styles.input, this.styles.marginTop15]}
                        blurOnSubmit={false}
                        returnKeyType={'next'}
                        onSubmitEditing={() => {
                            this.refs['confirmNewPassword'].focus();
                        }}
                        onChangeText={(text) => {
                            this.state.newPassword = text;
                        }} />

                    <TextInput
                        ref={'confirmNewPassword'}
                        underlineColorAndroid={'transparent'}
                        placeholder={I18n.t('confirmNewPassword')}
                        secureTextEntry={true}
                        placeholderTextColor={'gray'}
                        style={[this.styles.input, this.styles.marginTop15]}
                        blurOnSubmit={false}
                        returnKeyType={'next'}
                        onSubmitEditing={this.submitForm.bind(this)}
                        onChangeText={(text) => {
                            this.state.confirmNewPassword = text;
                        }} />

                    {this.renderSubmitButton()}
                </View>
            </ScrollView>
        );
    }

    renderSubmitButton()
    {
        return (
            <View style={this.styles.containerButton}>
                <TouchableOpacity
                    style={this.styles.button}
                    onPress={this.submitForm.bind(this)}>
                    {
                        this.state.isLoading &&
                        <ActivityIndicator
                            style= {this.styles.loadingButton}
                            size='small'
                            color='white' />
                    }
                    <Text style={this.styles.buttonText}>
                        {I18n.t('submit')}
                    </Text>
                </TouchableOpacity>
            </View>
        );
    }

    submitForm()
    {
        if(this.state.isLoading) {
            return;
        }

        // checking confirm password is correct
        let oldPassword =  this.state.oldPassword;
        let newPassword = this.state.newPassword;
        let confirmNewPassword = this.state.confirmNewPassword;

        if(oldPassword == '') {
            alert(I18n.t('oldPassword_notEmpty'));
            this.refs['oldPassword'].focus();
            return;
        }

        if(newPassword == '') {
            alert(I18n.t('newPassword_notEmpty'));
            this.refs['newPassword'].focus();
            return;
        }

        if(newPassword != confirmNewPassword) {
            alert(I18n.t('confirm_password_not_match'));
            this.refs['confirmNewPassword'].focus();
            return;
        }

        // init form data
        let formData = new FormData();
        formData.append('oldPassword', oldPassword);
        formData.append('newPassword', newPassword);
        formData.append('confirmNewPassword', confirmNewPassword);

        // init url
        let url = Url.generate(ApiUrl.ROOT + ApiUrl.CHANGE_PASS);
        let context = this;

        // show waiting effect
        this.state.isLoading = true;
        this.setState(this.state);

        // submit form
        fetch(url, {
            method: 'POST',
            headers: {
                'Content-Type': 'multipart/form-data',
            },
            body: formData,
        })
        .then(function(response) {
            if(response.status == 200)  {
                return response.json();
            }
            throw new Error(I18n.t('tryAgain'));
        })
        .then(function(response) {
            // hide waiting effect
            context.state.isLoading = false;

            if(response.status) { // successful
                context.props.navigator.pop();
            }
            // alert message from server
            alert(response.message);

            // render view
            context.setState(context.state);
        })
        .catch(function(error) {
            // hide waiting effect
            context.state.isLoading = false;
            // render view
            context.setState(context.state);
            // alert error message
            alert(error.toString());
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
        input: {
            borderWidth: 10,
            borderRadius: 4,
            marginLeft: 4,
            marginRight: 4,
            height: 40,
            color: 'black',
            borderColor: 'gray',
            borderWidth: 1,
            paddingLeft: 10,
            fontSize: 15,
            fontFamily: 'Arial',
        },
        marginTop15: {
            marginTop: 15
        },
        buttonText: {
            color: 'white',
            fontSize: 18,
            fontFamily: 'Arial',
        },
        button: {
            flex: 1,
            alignItems: 'center',
            justifyContent: 'center',
            flexDirection: 'row',
        },
        loadingButton: {
            marginRight: 10
        },
        containerButton: {
            height: 55,
            backgroundColor: '#4b8bf2',
            marginLeft: 4,
            marginRight: 4,
            marginTop: 15,
            borderRadius: 4,
        },
    });    
}
