import React, {Component} from 'react';
import {
  View,
  StatusBar,
  Text,
  StyleSheet,
  Image,
  TouchableHighlight,
  ActivityIndicator,
  WebView,
  Alert,
  ScrollView,
  Platform,
} from 'react-native';

import ApiUrl from '../constants/apiUrl';
import TimerMixin from 'react-timer-mixin';
import Url from '../utilizes/Url';
import BottomBar from '../components/bottomBar';
import I18n from 'react-native-i18n';

export default class Notification extends Component {

  render() {
    return (
	    <View style={styles.container} >

	    	<View style={styles.statusBar} >
				<StatusBar barStyle="light-content" backgroundColor='#0091C5' />
			</View>

	        <View style={styles.topBar} >
	          <TouchableHighlight
	          	underlayColor={'transparent'}
	          	style={styles.backButtonContainer}
	           	onPress={() => {
	           		if(this.props.isSurvey == undefined) {
		            	this.props.navigator.resetTo({
							sceneId: '002'
						});
	            	} else {
	            		this.props.navigator.pop();
	            	}
	           }}>
	            <Image source={require('../images/back.png')}
	              style={styles.backButton}/>
	          </TouchableHighlight>
	          <Text style={styles.title}>{I18n.t('notification')}</Text>
	          <View style={styles.leftHolder} />
	        </View>

			<DisplayContent id={this.props.notificationId} />

			<BottomBar navigator={this.props.navigator}/>
    	</View>
    );
  }
}

class DisplayContent extends Component {

	state = {
		heightOfWebView: 1000,
		htmlContent: '',
		isLoading: true,
	}

	constructor(props) {
		super(props);
		this.uri = Url.generate(ApiUrl.ROOT + ApiUrl.NOTIFICATION_DISPLAY_DETAIL, [this.props.id]);
	}

    render() {
    	if(this.state.isLoading) {
    		return this._renderLoading();
    	} else {
    		return this._renderContent();
    	}
    }

    _renderLoading() {
    	return (
    		<ActivityIndicator
    			size='small'
                color='gray'
                style={styles.loading}
            />
    	)
    }

    _renderContent() {
    	return (
    		<View style={{flex: 1}}>
		    	<WebView scrollEnabled={true}
		                source={{html: this.state.htmlContent}}
		                style={[{height: this.state.heightOfWebView}, styles.detail]}
		      			javaScriptEnabled={true}
		      	>
				</WebView>
			</View>
    	);
    }

    _onNavigationChange(event) {
        if (event.title) {
            var htmlHeight = Number(event.title);
            this.state.heightOfWebView = (htmlHeight + 10);
            this.setState(this.state);
        }
    }

    componentDidMount() {
    	this._fetchDataFromUrl();
    }

    _fetchDataFromUrl() {
        var context = this;
        var url = this.uri;

        fetch(url)
            .then(function(response) {
                if(response.status == 200)  {
                    return response.text();
                } else {
                	throw new Error('Vui long thu lai');
                }
            })
            .then(function(response) {
                context.state.htmlContent = response;
                context.state.isLoading = false;
                context.setState(context.state);
            })
            .catch(function(error) {
            	Alert.alert(error.toString());

                context.state.isLoading = false;
                context.setState(context.state);
            });
    }
}

const styles = StyleSheet.create({
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
		textAlign:'center',
		fontFamily: 'Helvetica',
	},
	leftHolder: {
		height:25,
		width:60,
	},
	loading: {
		flex: 1,
		marginTop: 5
	},
	detail: {
		marginHorizontal: 5,
	},
	statusBar: {
		backgroundColor: '#0091C5',
		height: Platform.OS == 'ios' ? 20 : 0,
		alignSelf: 'stretch',
	},
	backButtonContainer: {
		width: 60,
	}
});
