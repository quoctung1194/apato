import React, {Component} from 'react';
import ReactNative from 'react-native';
import {
	View,
	Text,
	StyleSheet,
	Platform,
	StatusBar,
	TextInput,
	ScrollView,
  TouchableOpacity,
  ActivityIndicator
} from 'react-native';

import NavigationBar from '../components/navigationBar';
import I18n from 'react-native-i18n';
import ApiUrl from '../constants/apiUrl';
import InitSetting from '../layouts/initSetting';

export default class Register extends Component {

  state = {
    formData: {
      code: '',
      username: '',
      password: '',
      confirm_password: '',
      first_name: '',
      last_name: '',
      room: ''
    },
    isLoading: false,
  }

	render()
	{
		return (
			<View style={this.styles.container}>
				{this.renderStatusBar()}
				<NavigationBar title={I18n.t('register')} navigator={this.props.navigator} />
				<ScrollView
					ref='scrollView'
					keyboardDismissMode={Platform.OS == 'ios' ? 'on-drag': 'none'}
					keyboardShouldPersistTaps={true}
					alignItems={'stretch'}
				>
					{this.renderContent()}
          {this.renderSubmitButton()}
				</ScrollView>
			</View>
		);
	}

	renderStatusBar() {
		return (
			<View style={this.styles.statusBar} >
				<StatusBar
					barStyle="light-content"
					backgroundColor={this.styles.statusBar.backgroundColor} />
			</View>
		);
	}

	renderContent()
	{
    let codeProps = {
      returnKeyType: 'next',
      onSubmitEditing: () => {
        this.refs['username'].focus();
      }
    }

    let usernameProps = {
      returnKeyType: 'next',
      onSubmitEditing: () => {
        this.refs['password'].focus();
      }
    }

    let passwordProps = {
      returnKeyType: 'next',
      onSubmitEditing: () => {
        this.refs['confirm_password'].focus();
      }
    }

    let confirmPasswordProps = {
      returnKeyType: 'next',
      onSubmitEditing: () => {
        this.refs['first_name'].focus();
      }
    }

    let firstNameProps = {
      returnKeyType: 'next',
      onSubmitEditing: () => {
        this.refs['last_name'].focus();
      }
    }

    let lastNameProps = {
      returnKeyType: 'next',
      onSubmitEditing: () => {
        this.refs['room'].focus();
      }
    }

    let roomProps = {
      returnKeyType: 'done',
      onSubmitEditing: this.submitForm.bind(this),
    }

		return (
			<View>
				{this.renderInput( 'code', I18n.t('code'), false, codeProps)}
				{this.renderInput( 'username', I18n.t('username'), false, usernameProps )}
				{this.renderInput( 'password', I18n.t('password'), true, passwordProps )}
        {this.renderInput( 'confirm_password', I18n.t('confirm_password'), true, confirmPasswordProps )}
				{this.renderInput( 'first_name', I18n.t('first_name'), false, firstNameProps )}
				{this.renderInput( 'last_name', I18n.t('last_name'), false, lastNameProps )}
				{this.renderInput( 'room', I18n.t('room'), false, roomProps )}
			</View>
		)
	}

	renderInput(ref, placeholder, isPassword = false, props = {}) {
  	return (
  		<View style={this.styles.inputContainer}>
  			<TextInput
					ref={ref}
					underlineColorAndroid={'transparent'}
					placeholder={placeholder}
					secureTextEntry={isPassword}
					placeholderTextColor={'gray'}
					style={this.styles.input}
          blurOnSubmit={false}
          onFocus={this._inputFocused.bind(this, ref)}
          onChangeText={(text) => {
            this.state.formData[ref] = text;
          }}
					{...props}
				/>
  		</View>
  	)
  }

  renderSubmitButton() {
  	return (
  		<View style={this.styles.containerButton}>
				<TouchableOpacity
					style={this.styles.button}
					onPress={ this.submitForm.bind(this) }
				>
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

  // Scroll a component into view. Just pass the component ref string.
  _inputFocused (refName) {
    setTimeout(() => {
      let scrollResponder = this.refs.scrollView.getScrollResponder();
      scrollResponder.scrollResponderScrollNativeHandleToKeyboard(
        ReactNative.findNodeHandle(this.refs[refName]),
        260, //additionalOffset
        true
      );
    }, 50);
  }

  componentDidMount() {
    this.refs['code'].focus();
  }

  submitForm()
  {
    let context = this;

    //Kiểm tra validate
    if(!this.validate())
    {
      return;
    }

    if(this.state.isLoading) {
      return;
    }

    this.state.isLoading = true;
    this.setState(this.state);

    //Submit data
    let url = ApiUrl.ROOT + ApiUrl.REGISTER;
    let formData = new FormData();

    //Gán dữ liệu vào formData
    for(var key in this.state.formData)
    {
      let value = this.state.formData[key].trim();
      formData.append(key, value);
    }

    //Send request
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
      } else {
        throw new Error('Vui lòng thử lại');
      }
    })
    .then(function(response) {
      let status = response.status;
      alert(response.message);

      if(response.status == 'successful')
      {
        context.props.navigator.pop();
      }

      context.state.isLoading = false;
      context.setState(context.state);
    })
    .catch(function(error) {
      alert(error.toString());
      context.state.isLoading = false;
      context.setState(context.state);
    });
  }

  validate()
  {
    let formData = this.state.formData;

    for(let key in formData)
    {
      let value = formData[key];
      if(value.trim() == '')
      {
        alert(I18n.t('emptyFields'));
        return false;
      }
    }

    //Valid password and confirm_password
  if(formData['password'] != formData['confirm_password'])
    {
      alert(I18n.t('confirm_password_not_match'));
      return false;
    }

    return true;
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
		inputContainer: {
			marginTop: 15,
		},
    containerButton: {
      height: 55,
      backgroundColor: '#4b8bf2',
      marginLeft: 4,
      marginRight: 4,
      marginTop: 15,
      borderRadius: 4,
    },
    button: {
      flex: 1,
      alignItems: 'center',
      justifyContent: 'center',
      flexDirection: 'row',
    },
    buttonText: {
      color: 'white',
      fontSize: 18,
      fontFamily: 'Arial',
    },
    loadingButton: {
      marginRight: 10
    },
	});

}