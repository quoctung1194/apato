import React, {Component} from 'react';
import ReactNative from 'react-native';

import {
  View,
  StatusBar,
  Text,
  StyleSheet,
  TouchableWithoutFeedback,
  TouchableHighlight,
  Image,
  ScrollView,
  Alert,
  TextInput,
  TouchableOpacity,
  Switch,
  ActivityIndicator,
  Platform,
  Keyboard
} from 'react-native';

import dismissKeyboard from 'dismissKeyboard';
import ModalDropdown from 'react-native-modal-dropdown';
import Url from '../utilizes/Url';
import ApiUrl from '../constants/apiUrl';
import ImagePicker from 'react-native-image-crop-picker';
import InitSetting from '../layouts/initSetting';
import BottomBar from '../components/bottomBar';
import I18n from 'react-native-i18n';

export default class Requirement extends Component {
    state = {
		hideBottomBar: false,
	}

	render() {
		return (
			<TouchableWithoutFeedback onPress={()=> dismissKeyboard()}>

				<View style={this.styles.container}>

					<View style={this.styles.statusBar} >
						<StatusBar barStyle="light-content" backgroundColor='#0091C5' />
					</View>

					<NavigationBar {...this.props} />
					<RequirementForm {...this.props} />
                    {
    					!this.state.hideBottomBar &&
    					<BottomBar navigator={this.props.navigator} avoidSceneId='005' />
    				}
		    	</View>

	    	</TouchableWithoutFeedback>
		);
	}

    componentWillMount () {
  		this.keyboardDidShowListener = Keyboard.addListener('keyboardDidShow', this._keyboardDidShow.bind(this));
  		this.keyboardDidHideListener = Keyboard.addListener('keyboardDidHide', this._keyboardDidHide.bind(this));
	}

	componentWillUnmount () {
    	this.keyboardDidShowListener.remove();
    	this.keyboardDidHideListener.remove();
  	}

	_keyboardDidShow () {
    	this.state.hideBottomBar = true;
		this.setState(this.state);
  	}

	_keyboardDidHide () {
    	this.state.hideBottomBar = false;
		this.setState(this.state);
  	}

	styles = StyleSheet.create({
		container: {
			flexDirection: 'column',
			flex: 1,
			backgroundColor: '#EFF4F7',
			justifyContent: 'center',
			alignItems: 'stretch'
		},
		statusBar: {
			backgroundColor: '#0091C5',
			height: Platform.OS == 'ios' ? 20 : 0,
			alignSelf: 'stretch',
		}
	});
}

class NavigationBar extends Component {
	render() {
		return (
			<View style={{flexDirection: 'row'}}>
				<View style={this.styles.topBar} >
					<TouchableHighlight
						underlayColor={'transparent'}
						style={this.styles.backButtonContainer}
						onPress={() => {
							this.props.navigator.resetTo({
								sceneId: '002'
							});
						 }}
					>
						<Image source={require('../images/back.png')}
							style={this.styles.backButton} />
					</TouchableHighlight>

					<Text style={this.styles.title}>{I18n.t('sendRequirement')}</Text>
					<View style={this.styles.leftHolder} />
				</View>

			</View>
		);
	}

	styles = StyleSheet.create({
		container: {
			flexDirection: 'column',
			flex: 1,
			backgroundColor: '#ffffff',
			justifyContent: 'flex-start',
		},
		topBar: {
			height: 40,
			backgroundColor: '#0F71AB',
			flexDirection: 'row',
			justifyContent: 'center',
			alignItems: 'center',
			flex: 1
		},
		backButton: {
			marginLeft: 5,
			height:25,
			width:25,
		},
		title: {
			color: '#ffffff',
			fontSize: 20,
			flex: 1,
			textAlign:'center',
			fontFamily: 'Helvetica',
		},
		leftHolder: {
			height:25,
			width:60,
		},
		backButtonContainer: {
          width: 60,
        },
	});
}

class RequirementForm extends Component {

	state = {
		types: [],
		selectedIndexType: 0,
		selectedIndexTag: 0,
		tags: [],
		initLoaded: false,
		hideLoading: false,
		title: '',
		description: '',
		repeatProblem: false,
		button: {
			isLoading: false,
		},
		images: [],
	}

	//Render Region - START
	render() {
		if(!this.state.hideLoading) {
			return this._renderLoading();
		}

		if(this.state.initLoaded) {
			return this._renderForm();
		}

		return(
			<Text>{I18n.t('tryAgain')}</Text>
		);
	}

	_renderLoading() {
	    return (
	      <View style={this.styles.loading}>
	        <ActivityIndicator
		        size='small'
		        color='grey' />
	      </View>
	    );
  	}

	_renderForm() {
		return (
			<View style={this.styles.container}>
				{this._renderInput()}

			</View>
		);
	}

	_renderInput() {
		return(
			<ScrollView
				ref='scrollView'
				style={this.styles.inputContainer}
				alignItems={'stretch'}
				keyboardShouldPersistTaps={true}
				keyboardDismissMode={Platform.OS == 'ios' ? 'on-drag' : 'none'}
			>
				{this._renderTypes()}
				{this._renderTags()}
				{this._renderTitle()}
				{this._renderDescription()}
				{this._renderRepeatProblems()}
				{this._renderSubmitButton()}
			</ScrollView>
		);
	}

	_renderTypes() {
		return this._dropDownRender('types', this.state.types, this.state.selectedIndexType);
	}

	_renderTags() {
		return this._dropDownRender('tags', this.state.tags, this.state.selectedIndexTag);
	}

	_dropDownRender(ref, data, selectedIndex) {
		return(
			<View style={this.styles.dropdownContainer}>
				<ModalDropdown
					style={this.styles.modalDropdown}
					options={data}
					renderRow={this._dropdownRenderRow.bind(this)}
					onSelect={(id, value) => this._setDropdownValue(id, value, ref)}
				>
					<View style={this.styles.dropdownSubContainer}>
						<Text style={this.styles.dropdownTextDisplay} >
							{data[selectedIndex]}
						</Text>
						<Image
							source={require('../images/downArrow.png')}
							style={this.styles.dropdownIcon}
						/>
					</View>
				</ModalDropdown>
			</View>
		);
	}

	_dropdownRenderRow(rowData, rowID, highlighted) {
	    return (
	      <TouchableHighlight style={{width: 300}}>
	        <View style={[this.styles.dropdowRowContainer, highlighted && {backgroundColor: 'lemonchiffon'}]}>
	          <Text style={this.styles.dropdownRowText}>
	            {rowData}
	          </Text>
	        </View>
	      </TouchableHighlight>
	    );
  	}

  	_setDropdownValue(id, value, ref) {
  		if(ref == 'types') {
  			this.state.selectedIndexType = id;
  		} else if(ref == 'tags') {
  			this.state.selectedIndexTag = id;
  		}

  		this.setState(this.state);
  	}

  	_renderTitle() {
  		return(
  			<View style={this.styles.titleContainer}>
				<View style={this.styles.titleLabelContainer}>
					<Text style={this.styles.titleLabel}>
						{I18n.t('title')}
					</Text>
				</View>

				<View style={this.styles.titleInputContainer}>
					<TextInput
				        style={this.styles.titleInput}
				        editable={true}
				        maxLength={40}
				        onChangeText={(text) => {
				        	this.state.title = text;
				        	this.setState(this.state);
				        }}
				    />
				</View>
			</View>
  		);
  	}

  	_renderDescription() {
  		return(
  			<View style={this.styles.descriptionContainer}>
				<TextInput
					ref='description'
                    underlineColorAndroid={'transparent'}
					onFocus={this._inputFocused.bind(this, 'description')}
					onEndEditing={this._inputEndEdit.bind(this, 'description')}
			        style={this.styles.descriptionInput}
			        editable={true}
			        maxLength={500}
			        multiline={true}
			        onChangeText={(text) => {
			        	this.state.description = text;
			        	this.setState(this.state);
				    }}
			    />

				<View style={this.styles.imageContainer}>
					<View style={this.styles.imageButtonContainer}>
						{this._renderImages()}
					</View>
					<TouchableOpacity
						onPress={()=>this._pickImages()}
						style={this.styles.imageTouchableOpacity}>
						<Text style={this.styles.imageButtonLabel}>
							{I18n.t('addPictures')}
						</Text>
					</TouchableOpacity>
				</View>
			</View>
  		);
  	}

  	_renderRepeatProblems() {
  		return(
  			<View style={this.styles.repeateProblemsContainer}>
				<Text style={this.styles.repeateProblemsLabel}>
					{I18n.t('repeatProblem')}
				</Text>
				<Switch
					onValueChange={(value) => {
						this.state.repeatProblem = value;
						this.setState(this.state);
					}}
					value={this.state.repeatProblem} />
			</View>
  		);
  	}

  	_renderImages() {
  		var images = this.state.images;
  		var imagesUI = [];

  		for(var i = 0; i < images.length; i++) {
	  		imagesUI.push(
	  			<Image key={i} source={{uri: images[i].path}}
       				style={this.styles.image} />
	  		);
  		}

  		return imagesUI;
  	}

  	_renderSubmitButton() {
  		return (
  			<View style={this.styles.submitContainer}>
					<TouchableOpacity style={this.styles.submitTouchableOpacity}
						onPress={() => {
							this._submitData();
						}}
					>
						{
							this.state.button.isLoading &&
								<ActivityIndicator
			         				style= {this.styles.loadingButton}
			         				size='small'
			         				color='white' />
	         			}
						<Text style={this.styles.submitLabel}>{I18n.t('sendRequirement').toUpperCase()}</Text>
					</TouchableOpacity>
			</View>
  		);
  	}

  	componentDidMount() {
		if(!this.state.initLoaded) {
			setTimeout(this._fetchInitData.bind(this), 300);
		}
	}

	_fetchInitData() {
    	var url = ApiUrl.ROOT + ApiUrl.REQUIREMENT_INIT_DATA;
    	var context = this;

		url = Url.generate(url, [InitSetting.userInfo.apartmentId]);
	    fetch(url)
	      .then(function(response) {
	          	if(response.status == 200)  {
	            	return response.json();
	          	} else {
	          		context._hideInitLoading();
	          	}
	      })
	      .then(function(response) {
	      		context._processInitData(response.message);
	    		context._hideInitLoading();
	    		context._displayForm();
	      })
	      .catch(function(error) {
	          console.error(error);
	          Alert.alert(error);
	          context._hideInitLoading();
	      });
	}

	_processInitData(result) {
		var types =  result.types;
		var tags = result.tags;
		var typeState = [];
		var tagState = [];

		for(var i = 0; i < types.length; i++) {
			typeState.push(types[i].content);
		}
		this.state.types = typeState;

		for(var i = 0; i < tags.length; i++) {
			tagState.push(tags[i].content);
		}
		this.state.tags = tagState;

		this.setState(this.state);
	}
	//Render Region - END

	_hideInitLoading() {
		this.state.hideLoading = true;
		this.setState(this.state);
	}

	_displayForm() {
		this.state.initLoaded = true;
		this.setState(this.state);
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

	_inputEndEdit(refName) {
		setTimeout(() => {
			let scrollResponder = this.refs.scrollView.getScrollResponder();
			scrollResponder.scrollResponderScrollNativeHandleToKeyboard(
				ReactNative.findNodeHandle(this.refs[refName]),
				0,
				true
			);
		}, 50);
	}

  	_submitData() {
  		if(this.state.button.isLoading) {
			return;
		}

		var context = this;
  		var url = ApiUrl.ROOT + ApiUrl.REQUIREMENT_SUBMIT_DATA;
  		var apiToken = InitSetting.userInfo.apiToken;
  		var body = new FormData();

  		this._isDisplayWaitingButton(true);

  		//Process images
  		for(var i = 0 ; i < this.state.images.length; i++) {
	  		var image = {
				uri: this.state.images[i].path,
				type: 'image/jpeg',
				name: 'images' + i + '.jpg',
			};
			body.append('images[' + i + ']', image);
		}

		body.append('selectedIndexType', this.state.selectedIndexType);
		body.append('selectedIndexTag', this.state.selectedIndexTag);
		body.append('description', this.state.description);
		body.append('repeatProblem', Number(this.state.repeatProblem));
		body.append('title', this.state.title);

  	fetch(url, {
			method: 'POST',
			headers: {
				'Content-Type': 'multipart/form-data',
			    'Authorization': 'Bearer ' + apiToken
			},
			body: body,
		})
	    .then(function(response) {
          	if(response.status == 200)  {
            	return response.json();
          	} else {
          		context._isDisplayWaitingButton(false);
          		return response.text();
          	}
      	})
      	.then(function(response) {
      		//Checking successful
      		var isSuccessful = false;
      		context._isDisplayWaitingButton(false);

      		for(var property in response) {
      			if(property == 'message') {
      				isSuccessful = true;
      			}
      			break;
      		}

      		if(isSuccessful) {
      			Alert.alert(
      			  I18n.t('notification'),
				  I18n.t('sendRequirementSucessful'),
				  [
				    {text: 'OK', onPress: () => context.props.navigator.resetTo({sceneId: '002'})},
				  ]
				);

      		} else {
      			Alert.alert(I18n.t('tryAgain'));
      		}

      	})
      	.catch(function(error) {
	      	console.error(error);
	        Alert.alert(error);
	        context._isDisplayWaitingButton(false);
      	});
  	}

  	_isDisplayWaitingButton(value) {
  		this.state.button.isLoading = value;
  		this.setState(this.state);
  	}

  	_pickImages() {
		ImagePicker.openPicker({
			multiple: true,
			maxFiles: '2',
			compressImageQuality: 0.5
		}).then(images => {
			if(images.length > 0) {
				this.state.images = images;
				this.setState(this.state);
			}
		}).catch(e => alert(e));
  	}

	styles = StyleSheet.create({
		loading: {
			flex: 1,
			marginTop: 15
		},
		container: {
			flexDirection: 'column',
			flex: 1,
			alignItems: 'center'
		},
		inputContainer: {
			margin: 10,
			backgroundColor: '#EFF4F7',
			flexDirection: 'column',
			alignSelf: 'stretch',
		},
		dropdownContainer: {
			flexDirection: 'row',
			marginTop: 10
		},
		modalDropdown: {
			flex: 1
		},
		dropdownSubContainer: {
			flexDirection: 'row',
			height: 35,
			borderRadius: 4,
			borderWidth: 1,
			backgroundColor: 'white',
			justifyContent: 'center',
			alignItems: 'center',
		},
		dropdownTextDisplay: {
			marginLeft: 5,
			fontSize: 15,
			flex: 1,
			fontFamily: 'Arial',
		},
		dropdownIcon: {
			height:15,
			width:15,
			marginRight: 12
		},
		dropdowRowContainer: {
			flex: 1,
    		flexDirection: 'row',
    		height: 38,
    		alignItems: 'center',
		},
		dropdownRowText: {
			fontSize: 14,
			marginLeft: 5,
			fontFamily: 'Arial',
		},
		titleContainer: {
			flexDirection: 'row',
			height: 35,
			alignItems: 'center',
			marginTop: 10,
			backgroundColor: 'white',
			borderWidth: 1,
			borderRadius: 4,
		},
		titleLabelContainer: {
			width: 60,
			height: 33,
			justifyContent: 'center',
		},
		titleLabel: {
			fontSize: 15,
			marginLeft: 5
		},
		titleInputContainer: {
			flex: 1,
			height: 50,
		},
		titleInput: {
			flex: 1,
        	height: 50,
        	marginLeft: 5,
        	fontSize: 14,
        	fontFamily: 'Arial',
		},
		descriptionContainer: {
			height: 170,
			alignItems: 'center',
			marginTop: 10,
			backgroundColor: 'white',
			borderWidth: 1,
			borderRadius: 4
		},
		descriptionInput: {
			height: 90,
			marginLeft: 5,
			fontSize: 15,
			fontFamily: 'Arial',
            alignSelf: 'stretch',
            textAlignVertical: 'top',
		},
		imageContainer: {
			flexDirection: 'row',
			flex: 1,
			alignItems: 'flex-end'
		},
		imageButtonContainer: {
			flex: 1,
			flexDirection: 'row',
			alignItems: 'center',
			paddingBottom: 5
		},
		imageTouchableOpacity: {
			width: 100,
			height: 40,
			marginBottom: 5,
			alignItems: 'center',
			justifyContent: 'center',
			backgroundColor: '#E5D04D',
			borderRadius: 4,
			marginRight: 4
		},
		imageButtonLabel: {
			fontSize: 14,
			color: 'white',
			fontWeight: '500',
			fontFamily: 'Arial',
		},
		repeateProblemsContainer: {
			marginTop: 10,
			flexDirection: 'row',
			justifyContent: 'flex-end',
			alignItems: 'center',
			flex: 1
		},
		repeatProblemsContainer: {
			fontSize: 14,
			marginRight: 5,
			fontWeight: '500',
			fontFamily: 'Arial',
		},
		repeateProblemsLabel: {
			fontSize: 15,
			marginRight: 5,
			fontWeight: '500'
		},
		submitContainer: {
			alignItems: 'stretch',
			marginTop: 10,
		},
		submitTouchableOpacity: {
			flexDirection: 'row',
			justifyContent: 'center',
			height: 50,
			alignItems: 'center',
			backgroundColor: '#8BC44A',
			borderRadius: 4,
			shadowOpacity: 0,
			shadowOffset: {width: 0, height: 2}
		},
		submitLabel: {
			color: 'white',
			fontSize: 17,
			fontWeight: '500',
			fontFamily: 'Arial',
		},
		loadingButton: {
			marginRight: 10
		},
		image: {
			width: 70,
			height: 70,
			borderRadius: 2,
			marginLeft: 4
		}
	});
}

class Header extends Component {
	render() {
		return (
			<View style={this.style.container}>
				<View style={this.style.holder} />
				<View style={this.style.icon} />
			</View>
		);
	}

	style = StyleSheet.create({
		container: {
			flexDirection: 'row',
		},
		holder: {
			flex: 1,
		},
		icon: {
			width: 55,
			height: 55,
			backgroundColor: 'green'
		}
	});
}
