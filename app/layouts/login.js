import React, {Component} from 'react';
import OneSignal from 'react-native-onesignal';
import I18n from 'react-native-i18n';
import {
	View,
	StatusBar,
	Text,
	Alert,
	StyleSheet,
	ScrollView,
	TextInput,
	TouchableOpacity,
	ActivityIndicator,
	AsyncStorage,
	Image,
	Platform,
	InteractionManager,
} from 'react-native';

import ApiUrl from '../constants/apiUrl';
import InitSetting from './initSetting';
import dismissKeyboard from 'dismissKeyboard';
import SplashScreen from 'react-native-splash-screen';

export default class Login extends Component {

	state = {
		params: {
			username: '',
			password: '',
		},
		isLoading: false,
		displayInput: false,
	}

	constructor(props) {
		super(props);
	}

	render() {
		return (
			<ScrollView
			    ref='scrollView'
				style={this.styles.container}
				alignItems={'stretch'}
				scrollEnabled={false}
				keyboardDismissMode={Platform.OS == 'ios' ? 'on-drag': 'none'}
				keyboardShouldPersistTaps={true}
			>
				<StatusBar hidden={true} />
				<MainImage />
			{
				!this.state.displayInput &&
				<ActivityIndicator
     				style={this.styles.loading}
     				size='small'
     				color='gray' />
			}

			{
				this.state.displayInput &&
				<View style={{marginTop: 20}}>
					<TextInput
						placeholder={I18n.t('username')}
						placeholderTextColor={'gray'}
						underlineColorAndroid={'transparent'}
						ref='username'
						onFocus={this._inputFocused.bind(this)}
						style={[this.styles.input, this.styles.username]}
						returnKeyType={'next'}
						blurOnSubmit={false}
						onSubmitEditing={() => {
	    					this.refs['password'].focus();
	  					}}
	  					onChangeText={(text) => {
				        	this.state.params.username = text;
					    }}
					/>
					<TextInput
						ref='password'
						underlineColorAndroid={'transparent'}
						placeholder={I18n.t('password')}
						placeholderTextColor={'gray'}
						secureTextEntry={true}
						onFocus={this._inputFocused.bind(this)}
						style={[this.styles.input, this.styles.password]}
						returnKeyType={'done'}
						onSubmitEditing={() => {
	    					this._inputEndEdit();
	    					this._submitData();
	  					}}
	  					onChangeText={(text) => {
				        	this.state.params.password = text;
					    }}
					/>
					<View style={this.styles.containerButton}>
						<TouchableOpacity
							style={this.styles.button}
							onPress={() => this._submitData()}
						>
						{
							this.state.isLoading &&
								<ActivityIndicator
			         				style= {this.styles.loadingButton}
			         				size='small'
			         				color='white' />
		         		}
				        	<Text style={this.styles.buttonText}>
				        		{I18n.t('login')}
				        	</Text>
				      	</TouchableOpacity>
			    </View>

			    	<TouchableOpacity
			    		onPress={() => this.props.navigator.push({sceneId: '008'}) }
			    	>
				    	<Text style={this.styles.registerText}>
				    		{I18n.t('notHaveAccountQuestion')}
				    	</Text>
			    	</TouchableOpacity>
		    	</View>
		    }
				<View style={{height: 500}} />
          	</ScrollView>
		);
	}

	_inputFocused () {
		if(Platform.OS == 'android')
		{
			InteractionManager.runAfterInteractions(() => {
				this.refs.scrollView.scrollTo({y: 150});
			});
		}
		else
		{
			setTimeout(() => {
				this.refs.scrollView.scrollTo({y: 100});
			}, 50);
		}
	}

	_inputEndEdit() {
		setTimeout(() => {
			this.refs.scrollView.scrollTo({y: 0});
		}, 50);
	}

	_submitData() {
		this._inputEndEdit();
		dismissKeyboard();
		if(this.state.isLoading) {
			return;
		}

		var context = this;
		var url = ApiUrl.ROOT + ApiUrl.LOGIN;
  		var body = new FormData();

  		context.state.isLoading = true;
  		context.setState(this.state);

  		body.append('username', this.state.params.username);
		body.append('password', this.state.params.password);

		fetch(url, {
			method: 'POST',
			headers: {
				'Content-Type': 'multipart/form-data',
			},
			body: body,
		})
	    .then(function(response) {
          	if(response.status == 200)  {
            	return response.json();
          	} else {
          		throw new Error();
          	}
      	})
      	.then(function(response) {

      		if(response.message == -1) {
      			throw new Error();
      		}

      		let userInfo = JSON.stringify(response.message);
      		InitSetting.userInfo = response.message;
      		AsyncStorage.setItem('userInfo', userInfo, () => {
      			context.props.navigator.push({sceneId: '001'});
      		});
      	})
      	.catch(function(error) {
      		setTimeout(() => {
				Alert.alert(error.toString());
			}, 100);
			context.state.isLoading = false;
			context.setState(context.state);
      	});
	}

	componentDidMount() {
		this._checkIsLogged();
		SplashScreen.hide();
	}

	async _checkIsLogged() {
		try {
			var userInfo = await AsyncStorage.getItem('userInfo');
			if(userInfo == null) {
				this.state.displayInput = true;
				setTimeout(() => {
					this.setState(this.state);
				}, 1000);
			} else {
				InitSetting.userInfo = JSON.parse(userInfo);
				setTimeout(() => {
					this.props.navigator.push({sceneId: '001'});
				}, 1000);
			}
		} catch (error) {
  			Alert.alert(error.toString());
		}
	}

	styles = StyleSheet.create({
		container: {
			flex: 1,
			backgroundColor: 'white',
		},
		loading: {
			marginTop: 80
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
		username: {
			marginTop: 20,
		},
		password: {
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
		sologanText: {
			color: 'black',
			alignSelf: 'center',
			fontSize: 16,
			fontFamily: 'Arial',
		},
		registerText: {
			color: 'gray',
			alignSelf: 'center',
			fontSize: 15,
			marginTop: 20,
			fontFamily: 'Arial',
		}
	});
}

class MainImage extends Component {
	render() {
		return (
			<View style={this.styles.container}>
				<Image
					resizeMode={'contain'}
					source={require('../images/defaultLogo.png')}
					style={this.styles.logo}/>
			</View>
		);
	}

	styles = StyleSheet.create({
		container: {
			height: 270,
			backgroundColor: 'rgba(0,0,0,0)',
			alignItems: 'center',
		},
		logo: {
			marginTop: 20,
			height: Platform.OS == 'android' ? 250 : 260,
		},
		background: {
			marginTop: 10,
			alignSelf: 'stretch',
			height: 180,
		}
	});
}
