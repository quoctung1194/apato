import React, {Component} from 'react';
import ReactNative from 'react-native';

import {
	View,
	Text,
	StyleSheet,
	ActivityIndicator,
	StatusBar,
	TouchableHighlight,
	Image,
	Alert,
	TextInput,
	findNodeHandle,
	TouchableOpacity,
	ScrollView,
	TouchableWithoutFeedback,
	Animated,
	WebView,
	Platform,
	InteractionManager,
	Keyboard
} from 'react-native';

import CheckBox from 'react-native-check-box';
import { KeyboardAwareScrollView } from 'react-native-keyboard-aware-scroll-view';
import dismissKeyboard from 'dismissKeyboard';
import TimerMixin from 'react-timer-mixin';
import ApiUrl from '../constants/apiUrl';
import Constant from '../constants/commonConstants';
import PieChart from 'react-native-pie-chart';
import RadioForm, {RadioButton, RadioButtonInput, RadioButtonLabel} from 'react-native-simple-radio-button';
import Url from '../utilizes/Url';
import InitSetting from '../layouts/initSetting';
import HTMLView from 'react-native-htmlview';
import BottomBar from '../components/bottomBar';
import DateFormat from 'dateformat';
import I18n from 'react-native-i18n';

//Declare Const
const DO_SURVEY_MODE = 0;
const COMPLETE_SURVEY_MODE = 1;

const CHECKBOX_TYPE = 0;
const RADIO_TYPE = 1;

var scrollView = undefined;

export default class Survey extends Component {

	state = {
		hideBottomBar: false,
	}

	render() {
		return (
			<View style={styles.container}>
				<View style={this.styles.statusBar} >
					<StatusBar barStyle="light-content" backgroundColor='#0091C5' />
				</View>
				<NavigationBar {...this.props} />
				<Content {...this.props} />
				{
					!this.state.hideBottomBar &&
					<BottomBar navigator={this.props.navigator} />
				}
	    	</View>
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
			shadowOpacity: 0,
			shadowOffset: {width: 0, height: 1},
		},
		statusBar: {
			backgroundColor: '#0091C5',
			height: Platform.OS == 'ios' ? 20 : 0,
			alignSelf: 'stretch',
		}
	})
}

class NavigationBar extends Component {
	render() {
		return (
			<View style={this.styles.container}>
				<View style={styles.topBar} >
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
							style={styles.backButton}/>
					</TouchableHighlight>

					<Text style={styles.title}>{I18n.t('survey')}</Text>
					<View style={styles.leftHolder} />
				</View>

			</View>
		);
	}

	styles = StyleSheet.create({
		container: {
			shadowOpacity: 0,
			shadowOffset: {width: 0, height: 0},
		},
		backButtonContainer: {
			width: 60,
		},
	})
}

class Content extends Component {

	state = {
		isLoaded: false,
		survey: {},
		options: [],
		buttonSubmit: {
        	text: '',
        	fadeAnim: 0,
        	isLoading: false,
      	},
      	isEnableOther: false,
      	doSurvey: false,
	}
	optionDataArray = [];

	constructor(props) {
		super(props);
		this.state.buttonSubmit.fadeAnim = new Animated.Value(1);
	}

	render() {
		if(!this.state.isLoaded) {
			return this._renderLoading();
		} else {
			return this._renderContent();
		}
	}

	_renderLoading() {
	    return (
	      <View style={styles.contentContainer}>
	        <ActivityIndicator
				style= {styles.loading}
				size='small'
				color='grey'
			/>
	      </View>
	    );
  	}

	_renderContent() {
		return(
			<ScrollView
				keyboardShouldPersistTaps={true}
				keyboardDismissMode={Platform.OS == 'android' ? 'none' : 'on-drag'}
				ref={(input) => {scrollView = input;}}
				style={styles.contentContainer}
			>
				{this._renderSurveyDetail()}
				{this._renderInteractRegion()}
				{this._renderSubmitButton()}
				{this._renderDetaiSurvey()}
			</ScrollView>
		);
	}

	_renderSurveyDetail() {
		var arrDateTime =  this.state.survey.created_at.split(' ');
    	var created_at = Date.parse(arrDateTime[0]);
    	var date = DateFormat(created_at, "mm/dd/yyyy");
    	var time = arrDateTime[1].substring(0,5);

		return (
      		<View>
	      		<View style={styles.topContentContainer}>

					<View style={styles.titleContainer}>
						<Text style={styles.titleContent}>
							{this.state.survey.title.toUpperCase()}
						</Text>
						<Text style={styles.createDateContent}>{date + ' - ' + time}</Text>
						<Text style={styles.codeContent}>{ I18n.t('code', {code: 'TBVLN289334'}) }</Text>
						<Text style={styles.expireContent}>{ I18n.t('endDate', {endDate: '11/11/2017'}) }</Text>
					</View>

					<Image source={require('../images/survey.png')}
						style={this.styles.image}/>
				</View>

				<Text style={styles.subTitleContent}>
					{this.state.survey.subTitle}
				</Text>
      		</View>
		);
	}
    //Render Survey Detail - END

    //Render Interact Region - START
    _renderInteractRegion() {
    	if (this.state.isCompleted) {
    		return this._renderChart();
    	} else {
    		if (!this.state.doSurvey) {
    			return;
    		} else {
    			return this._renderOptionsRegion();
    		}
    	}
    }

    _renderChart() {
    	return (
    		<Animated.View style={[this.styles.chartContainer, {opacity: this.state.buttonSubmit.fadeAnim}]} >
				<View style={{alignSelf: 'center'}}>
					<Text style={this.styles.titleChart}>
						{I18n.t('resultSurvey')}
					</Text>
					<OptionChart data={this.state.chartResults} />
				</View>
			</Animated.View>
    	);
    }

    _renderUserSelectionChart() {
		var data = this.state.chartResults;
		var userSelectionUI = [];

		for(var i = 0; i < data.length; i++) {
			if(data[i].checked) {
				userSelectionUI.push(
					<Text style={this.styles.textChart} key={i}>
						{(i + 1) + '. ' + data[i].content.toUpperCase()} ({I18n.t('selected')})
					</Text>
				);
			} else {
				userSelectionUI.push(
					<Text style={this.styles.textChart} key={i}>
						{(i + 1) + '. ' + data[i].content.toUpperCase()}
					</Text>
				);
			}
		}

		return userSelectionUI;
	}

	_renderOptionsRegion() {
		return (
			<Animated.View style={[this.styles.surveyContainer, {opacity: this.state.buttonSubmit.fadeAnim}]} >

			{this._renderOptions()}

			{
				this.state.isEnableOther &&
					<TextInput
						ref='otherTextInput'
						underlineColorAndroid={'transparent'}
						onFocus={this._inputFocused.bind(this, 'otherTextInput')}
						onEndEditing={this._inputEndEdit.bind(this, 'otherTextInput')}
						style={this.styles.otherText}
						placeholder={I18n.t('sendMoreInformation')}
						onChangeText={this._updateOtherOptionData.bind(this)}
						multiline={true} />
			}

			</Animated.View>
		);
	}

    _renderOptions() {
    	var uiOptionsArray = [];
		var data = this.state.options;

		//Render Checkbox
		if(this.state.survey.type_check == 0) {
			for(var i = 0; i < data.length; i++) {
				//Add To UI
				if(data[i].is_other == '0') {
					uiOptionsArray.push(
						<View key={data[i].id}>
							<CheckBox
							 	style={this.styles.checkbox}
								onClick={this._onChangeValueOption.bind(this, data[i].id)}
								rightTextView={
									<Text style={this.styles.textCheckbox}>{data[i].content}</Text>
								}
							/>
							<View style={this.styles.optionLine}></View>
						</View>
					);
				} else {
					uiOptionsArray.push(
						<CheckBox
							key={data[i].id}
						 	style={this.styles.checkbox}
							onClick={this._onClickOtherCheckbox.bind(this, data[i].id)}
							rightTextView={
								<Text style={this.styles.textCheckbox}>{data[i].content}</Text>
							}/>
					);
				}
			}
		} else {
			var radio_props = [];

  			for(var i = 0; i < data.length; i++) {
  				var option = {};
  				option.label = data[i].content;
  				option.value = data[i].id;

  				radio_props.push(option);
  			}

			uiOptionsArray.push(
				<View  key={'radioForm'}>
					<RadioForm
					  style={{flex: 1}}
					  radio_props={radio_props}
					  initial={-1}
					  formHorizontal={false}
					  labelHorizontal={true}
					  buttonColor={'#2196f3'}
					  buttonStyle={{colors: 'red'}}
					  animation={false}
					  onPress={this._onClickRadio.bind(this)}
					/>
				</View>
      		)
		}

		return uiOptionsArray;
	}
    //Render Interact Region - END

    //Submit Button - START
    _renderSubmitButton() {
    	return(
    		<View>
				<TouchableOpacity
					style={this.styles.submitButton}
					onPress={this._onclickButton.bind(this)}
					ref='buttonSubmit'>
					{
						this.state.buttonSubmit.isLoading &&
							<ActivityIndicator
		         				style= {this.styles.loadingButton}
		         				size='small'
		         				color='white' />
		 			}
		    		<Text style={this.styles.submitTextButton}>{this.state.buttonSubmit.text}</Text>

			    </TouchableOpacity>
    		</View>
    	);
    }

    _onclickButton() {
		//Check valid
		if(this.state.buttonSubmit.isLoading) {
			return;
		}
		if(!this.state.isCompleted) {
			if(!this.state.doSurvey) {
				this.state.doSurvey = true;
				this._setSubmitButtonUI();
				this.setState(this.state);
				this._redoSurvey();
			} else {
				this._onClickSubmitData();
			}
		} else {
			this._redoSurvey();
		}
	}

	_redoSurvey() {
		this._fadeOutButton();
		this.state.buttonSubmit.isLoading = true;
		this._fetchOptionsFromUrl();
	}

	_fetchOptionsFromUrl() {
    	var url = Url.generate(ApiUrl.ROOT + ApiUrl.NOTIFICATION_SURVEY_DATA, [this.props.notificationId]);
		var context = this;

	    fetch(url)
	      .then(function(response) {
	          	if(response.status == 200)  {
	            	return response.json();
	          	}

	          	throw new Error(I18n.t('tryAgain'));
	      })
	      .then(function(response) {
	    		context.state.buttonSubmit.text = I18n.t('completeSurvey');
	    		context.state.isCompleted = false;
				context.state.options = response.message.options;

				context.state.buttonSubmit.isLoading = false;
				context.state.isLoaded = true;
				context.optionDataArray = [];
			  	context._initDataOptions();
			  	context.setState(context.state);
			  	context._fadeInButton();

	      })
	      .catch(function(error) {
	          	context.state.buttonSubmit.isLoading = false;
			  	context.setState(context.state);

	      	  	Alert.alert(error.toString());
	      });
	}
    //Submit Button - END

    //Process Options Data - START
    _initDataOptions() {
		var data = this.state.options;

		for(var i = 0; i < data.length; i++) {
			//Add To data
			var option = {};
			option.id = data[i].id;
			option.checked = false;
			if(data[i].is_other != '0') {
				option.otherContent = "";
			}

			this.optionDataArray.push(option);
		}
	}

	_onChangeValueOption(key) {
		for(var i = 0; i < this.optionDataArray.length; i++) {
			option = this.optionDataArray[i];

			if(option.id == key) {
				option.checked = !option.checked;
				//Check is other option
				if(option.otherContent != undefined) {
					option.otherContent = "";
				}

				break;
			}
		}
	}

	_onClickOtherCheckbox(key) {
		this.state.isEnableOther = !this.state.isEnableOther;
		this.setState(this.state);

		if(this.state.isEnableOther) {
			this._inputEndEdit('otherTextInput');
		}
		this._onChangeValueOption(key)
	}

	_onClickRadio(key) {
		//Set checked for selected value
		for(var i = 0; i < this.optionDataArray.length; i++) {
			option = this.optionDataArray[i];
			option.checked = false;

			if(option.id == key) {
				option.checked = true;

				//Check is other option
				if(option.otherContent != undefined) {
					option.otherContent = "";
					this.state.isEnableOther = true;
					this.setState(this.state);
					this._inputFocused('otherTextInput');
				} else {
					this.state.isEnableOther = false;
					this.setState(this.state);
				}
			}
		}
	}

	_updateOtherOptionData(text) {
		data = this.optionDataArray;

		for(var i = 0; i < data.length; i++) {
			if(data[i].otherContent != undefined) {
				data[i].otherContent = text;
				return;
			}
		}
	}

	_onClickSubmitData() {
		var filterArray = this._filterCheckedOptionResult();
		var sendData = {};

		if(this.state.buttonSubmit.isLoading) {
			return;
		} else if(filterArray.length == 0) {
			Alert.alert(I18n.t('validOptions'));
			return;
		}
		else if(!this._checkLength()) {
			Alert.alert(I18n.t('validCharacterCount', {input: 'Nội dung', countCharacter: '14'}));
			return;
		}

		var url = ApiUrl.ROOT + ApiUrl.NOTIFICATION_SURVEY_SUBMIT_DATA;
		dismissKeyboard();

		sendData.notificationId = this.props.notificationId;
		sendData.result = filterArray;

		this.state.buttonSubmit.isLoading = true;
		this.setState(this.state);

		var context = this;

	    fetch(url, {
			method: 'POST',
			headers: {
				'Accept': 'application/json',
			    'Content-Type': 'application/json',
			    'Authorization': 'Bearer ' + InitSetting.userInfo.apiToken
			},
			body: JSON.stringify(sendData)
		})
	      .then(function(response) {
	          	if(response.status == 200)  {
	            	return response.json();
	          	}
	          	throw new Error('Vui long thu lai');
	      })
	      .then(function(response) {
	      		//Checking successful
	      		var isSuccessful = false;

	      		for(var property in response) {
	      			if(property == 'message') {
	      				isSuccessful = true;
	      			}
	      			break;
	      		}

	      		if(isSuccessful) {
	      			context._fadeOutButton();
	      			context._fetchChartData();
	      			context.state.isEnableOther = false;
	      		} else {
	      			Alert.alert(I18n.t('tryAgain'));
	      		}

	      })
	      .catch(function(error) {
		      	context.state.buttonSubmit.isLoading = false;
				context.setState(context.state);

		        Alert.alert(error.toString());
	      });
	}

	_checkLength() {
		if(this.state.isEnableOther) {
			var data = this.optionDataArray;
			var otherText = '';

			for(var i = 0; i < data.length; i++) {
				if(data[i].otherContent != undefined) {
					otherText = data[i].otherContent;
					break;
				}
			}

			if(otherText == undefined) {
				return false;
			} else if(otherText.trim() == '') {
				return false;
			} else if(otherText.length <= 14) {
				return false;
			} else {
				return true;
			}
		}

		return true;
	}

	_filterCheckedOptionResult() {
		var filteredArray = [];
		var optionDataArray = this.optionDataArray;

		for(var i = 0; i < optionDataArray.length; i++) {
			if(optionDataArray[i].checked) {
				filteredArray.push(optionDataArray[i]);
			}
		}

		return filteredArray;
	}
    //Process Options Data - END

    //Render Detail - START
    _renderDetaiSurvey() {
    	var url = Url.generate(ApiUrl.ROOT + ApiUrl.NOTIFICATION_SURVEY_DISPLAY_DETAIL, [this.props.notificationId])
    	return(
    		//WebView component inside the render method
			<WebView
				scrollEnabled={false}
				onNavigationStateChange={this.onNavigationChange.bind(this)}
				style={{height:this.state.detailHeight}}
				startInLoadingState={true}
                source={{uri: url}}
            />
    	);
    }

    //the handling method of the event onNavigationChange
	onNavigationChange(event) {
        if (event.title) {
            const htmlHeight = Number(event.title) //convert to number
            this.state.detailHeight = htmlHeight + 100;
            this.setState(this.state);
        }

     }
    //Render Detail - END

	componentDidMount() {
		TimerMixin.setTimeout(this.fetchDataFromUrl.bind(this), 100);
	}

	fetchDataFromUrl() {
    	var url = Url.generate(ApiUrl.ROOT + ApiUrl.NOTIFICATION_SURVEY_DATA, [this.props.notificationId])
		var context = this;

	    fetch(url)
	      .then(function(response) {
	          	if(response.status == 200)  {
	            	return response.json();
	          	}

	          	throw new Error(I18n('tryAgain'));
	      })
	      .then(function(response) {
	      		context.state.survey = response.message.survey;
	      		context.state.options = response.message.options;
	      		context.state.isCompleted = response.message.isCompleted;
	      		context.state.htmlContent = response.message.htmlContent;
	      		context.setState(context.state);

	      		if(response.message.isCompleted) {
	      			context._fetchChartData();
	      		} else {
	      			if(context.state.doSurvey) {
	      				context._fetchOptionsFromUrl();
	      			} else {
	      				context._setInitNewSurvey();
	      			}
	      		}
	      })
	      .catch(function(error) {
	       		Alert.alert(error.toString());
	      });
	}

	_fetchChartData() {
    	var url = Url.generate(ApiUrl.ROOT + ApiUrl.NOTIFICATION_SURVEY_DISPLAY_CHART, [this.props.notificationId]);
		var context = this;

	    fetch(url)
	      .then(function(response) {
	          	if(response.status == 200)  {
	            	return response.json();
	          	} else {
	          		throw new Error(I18n.t('tryAgain'));
	          	}
	      })
	      .then(function(response) {
	      		context.state.chartResults = response.message.userOptions;
				context.state.isLoaded = true;
				context.state.buttonSubmit.isLoading = false;
				context.state.isCompleted = true;
				context.state.doSurvey = true;
			  	context._setSubmitButtonUI();
			  	context._fadeInButton();
			  	context.setState(context.state);
	      })
	      .catch(function(error) {
	      	  	Alert.alert(error.toString());
	      });
	}

	_setInitNewSurvey() {
		this._setSubmitButtonUI();
		this.state.isLoaded = true;
		this.setState(this.state);
	}

	_setSubmitButtonUI() {
		if(!this.state.isCompleted) {
			if(!this.state.doSurvey) {
				this.state.buttonSubmit.text = I18n.t('joinSurvey');
			} else {
				this.state.buttonSubmit.text = I18n.t('completeSurvey');
			}
		} else {
			this.state.buttonSubmit.text = I18n.t('changeSurvey');
		}
	}

	_fadeInButton() {
		Animated.timing(
	        this.state.buttonSubmit.fadeAnim,
	        {
		          toValue: 1,
		          duration: 200,
		    },
      	).start();
	}

	_fadeOutButton() {
		Animated.timing(
        	this.state.buttonSubmit.fadeAnim,
	        {
	          toValue: 0,
	          duration: 200,
	        },
      	).start();
	}

	// Scroll a component into view. Just pass the component ref string.
	_inputFocused(refName) {
		setTimeout(() => {
			let scrollResponder = scrollView.getScrollResponder();
			scrollResponder.scrollResponderScrollNativeHandleToKeyboard(findNodeHandle(this.refs[refName]), 150, true);
		}, Platform.OS == 'ios' ? 50 : 100);
	}

	_inputEndEdit(refName) {
		setTimeout(() => {
			let scrollResponder = scrollView.getScrollResponder();
			scrollResponder.scrollResponderScrollNativeHandleToKeyboard(
				findNodeHandle(this.refs[refName]),
				0,
				true
			);
		}, 50);
	}

	styles = StyleSheet.create({
		detailButton: {
			flexDirection: 'row',
			justifyContent: 'center',
			height: 30,
			alignItems: 'center',
			backgroundColor: '#4b8bf2',
			marginTop: 5,
			borderRadius: 4,
			shadowOpacity: 0,
			shadowOffset: {width: 0, height: 2}
		},
		textButton: {
			color: 'white',
			fontSize: 14,
			fontWeight: '500'
		},
		image: {
			width: 60,
			height: 60,
		},
		interactContainer: {
			marginHorizontal: 6,
			flex: 1,
		},
		titleChart: {
			fontWeight: 'bold',
			fontSize: 16,
			color: '#D0465A',
			fontFamily: 'Helvetica',
		},
		chartContainer: {
			marginTop: 10,
			borderTopLeftRadius: 4,
			borderTopRightRadius: 4,
			flex: 1,
			flexDirection: 'column',
		},
		line: {
			backgroundColor: 'black',
			height: 2,
			marginTop: 10,
			marginBottom: 13
		},
		textChart: {
			fontWeight: 'bold',
			fontSize: 13,
			marginBottom: 5,
			fontFamily: 'Arial',
		},
		webView: {
			marginBottom: 5,
			flex: 1,
		},
		loadingButton: {
			marginRight: 10
		},
		submitButton: {
			flexDirection: 'row',
			justifyContent: 'center',
			height: 50,
			alignItems: 'center',
			backgroundColor: '#8BC44A',
			borderRadius: 4,
			marginVertical: 15,
			shadowOpacity: 0,
			shadowOffset: {width: 0, height: 2}
		},
		submitTextButton: {
			color: 'white',
			fontSize: 17,
			fontWeight: '500',
			fontFamily: 'Arial',
		},
		checkbox: {
			marginBottom: 5,
			marginTop: 5,
		},
		textCheckbox: {
			flex: 1,
			marginLeft: 15,
			fontWeight: 'bold',
			fontSize: 15,
			fontFamily: 'Arial',
		},
		surveyContainer: {
			marginTop: 15,
			backgroundColor: 'white',
			borderWidth: 1,
			padding: 8,
			borderRadius: 8,
			shadowOpacity: 0,
			shadowOffset: {width: 0, height: 2},
			flex: 1,
		},
		otherText: {
			height: 90,
			borderWidth: 1,
			borderRadius: 4,
			backgroundColor: 'white',
			paddingLeft: 6,
			fontWeight: '500',
			fontSize: 14,
			marginTop: 5,
			fontFamily: 'Arial',
			textAlignVertical: 'top',
		},
		optionLine: {
			backgroundColor: 'black',
			alignSelf: 'stretch',
			height: 1,
			marginVertical: 4
		}
	});
}

class Tag extends Component {
	render() {
		return (
			<View style={this.styles.main}>
				<Text style={this.styles.text}>
					{this.props.text}
				</Text>
			</View>
		);
	}

	styles = StyleSheet.create({
		main: {
			backgroundColor: '#0091C5',
			borderRadius: 4,
			overflow: 'hidden',
			alignSelf: 'flex-start',
		},
		text: {
			color: 'white',
			textAlign:'center',
			fontWeight: 'bold',
			marginVertical: 3,
			marginHorizontal: 5,
		},
	});
}

class OptionChart extends Component {

	render() {
		var data = this.props.data;
    	var chart_wh = 95;
    	var series = this._getSeries(data);
    	var sliceColor = this._getSliceColor(data);
	    return (
		    <View style={this.styles.container}>
		        <PieChart
		            chart_wh={chart_wh}
		            series={series}
		            sliceColor={sliceColor}
		            doughnut={true}
		            coverRadius={0.6}
		            coverFill={'#FFF'}
		            style={this.chart}
		        />

		        <View style={this.styles.content}>
		        	{this._renderContent()}
		        </View>
		    </View>
	    );
  	}

  	_getSeries(data) {
  		var series = [];

  		for(var i = 0; i < data.length; i++) {
  			if(data[i].chartNumber > 0) {
  				series.push(data[i].chartNumber);
  			}
  		}

  		return series;
  	}

  	_getSliceColor(data) {
  		var colors = [];

  		for(var i = 0; i < data.length; i++) {
  			if(data[i].chartNumber > 0) {
  				colors.push(data[i].color);
  			}
  		}

  		return colors;
  	}

  	_renderContent() {
  		var uiText = [];
  		var data = this.props.data;

  		for(var i = 0; i < data.length; i++) {
  			var percent = 0;
  			var total = this._getTotal(data);
  			var selectedText = '';

  			if(data[i].chartNumber > 0) {
  				percent = Math.round((data[i].chartNumber/total) * 100);
  			}

  			if(data[i].checked) {
  				selectedText += '(' + I18n.t('selected') + ')'
  			}

  			uiText.push(
  				<View key={i}>
	  				<Text style={[{color: data[i].color},this.styles.optionText]}>
	  					{percent + '% ' + data[i].content} <Text style={{color: 'red', flex: 1}}>{selectedText}</Text>
	  				</Text>
  				</View>
  			);
  		}

  		return uiText;
  	}

  	_getTotal(data) {
  		var total = 0;

  		for(var i = 0; i < data.length; i++) {
  			total += data[i].chartNumber;
  		}

  		return total;
  	}

  	chart = {
		marginTop: 10
	}

	styles = StyleSheet.create({
		container: {
			flexDirection: 'row',
			marginTop: Platform.OS == 'android' ? 20 : 10,
			marginBottom: Platform.OS == 'android' ? 15 : 0,
		},
		content: {
			flex: 1,
			justifyContent: 'center',
			marginTop: 2,
			marginLeft: 10
		},
		optionText: {
			marginBottom: 6,
			fontWeight: 'bold',
		}
	});
}

const styles = StyleSheet.create({
	loading: {
		margin: 30
	},
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
		textAlign:'center'
	},
	leftHolder: {
		height:25,
		width:60,
	},
	contentContainer: {
		paddingHorizontal: 8,
		paddingTop: 10,
		flexDirection: 'column',
		flex: 1,
		marginHorizontal: 5,
	},
	topContentContainer: {
		flexDirection: 'row',
	},
	titleContainer: {
		flexDirection: 'column',
		flex: 1,
	},
	titleContent: {
		fontWeight: 'bold',
		fontSize: 16,
		fontFamily: 'Arial',
	},
	createDateContent: {
		fontWeight: 'bold',
		fontSize: 13,
		marginTop: 20,
		fontFamily: 'Arial',
	},
	codeContent: {
		fontWeight: 'bold',
		fontSize: 13,
		fontFamily: 'Arial',
	},
	expireContent: {
		fontWeight: 'bold',
		fontSize: 13,
		color: 'red',
		marginTop: 5,
		marginBottom: 18,
		fontFamily: 'Arial',
	},
	subTitleContent: {
		fontSize: 15,
		fontWeight: 'bold',
		marginTop: 10,
		marginBottom: 7,
		textAlign: 'justify',
		fontFamily: 'Arial',
	}
});
