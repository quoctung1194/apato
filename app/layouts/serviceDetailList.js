import React, {Component} from 'react';
import ReactNative from 'react-native';
import I18n from 'react-native-i18n';

import {
	View,
	StatusBar,
	Text,
	StyleSheet,
	ActivityIndicator,
	ListView,
	Alert,
	Image,
	TouchableHighlight,
	TouchableOpacity,
	Linking,
	Platform,
} from 'react-native';

import NavigationBar from '../components/navigationBar';
import BottomBar from '../components/bottomBar';
import LoadingIcon from '../components/loadingIcon';
import Url from '../utilizes/Url';
import ApiUrl from '../constants/apiUrl';
import Button from '../components/button';

export default class ServiceDetailList extends Component {

	constructor(props) {
        super(props);

        this.state = {
        	dataSource : this.setDataSource([]),
            isLoaded: false,
            noData: false,
        };

        this.category = this.props.category;
    }


  	render() {
		return (
			<View style={this.styles.container}>
				{this.renderStatusBar()}
				<NavigationBar title={this.category.name} navigator={navigator} />
				{this.renderContent()}
				<BottomBar navigator={this.props.navigator} />
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

	renderContent() {
    	if(!this.state.isLoaded) {
            return (<LoadingIcon />);
        } else {
            return this.renderServiceDetailList()
        }
    }

    renderServiceDetailList() {
    	return(
    		<View
    			alignItems={'stretch'}
    			style={this.styles.listDetailContainer}
    		>
    		{
				!this.state.noData ?
				(
	    			<ListView
	                    dataSource={this.state.dataSource}
	                    renderRow={(rowData) =>
	                        <RowItem
	                            item={rowData}
	                            navigator={this.props.navigator}
	                        />
	                    }
	                />
	            )
	            :
	            (
	            	<Text>{I18n.t('noData')}</Text>
	            )
            }

    		</View>
    	);
    }

    componentDidMount() {
        setTimeout(this.fetchData.bind(this), 300);
    }

    fetchData() {
    	var context = this;
        var url = Url.generate(ApiUrl.ROOT + ApiUrl.SERVICE_DETAIL_LIST, [this.category.id]);

        fetch(url)
	        .then(function(response) {
	            if(response.status == 200)  {
	                return response.json();
	            }
	        })
	        .then(function(response) {
	        	var currentState = context.state;

	        	currentState.dataSource = context.setDataSource(response.message);
	            currentState.isLoaded = true;

	            //Kiem tra co du lieu hay khong
	            if(response.message.length == 0) {
	            	currentState.noData = true;
	            }

	            context.setState(currentState);
	        })
	        .catch(function(error) {
	            Alert.alert(error);
	        });
    }

    setDataSource(data) {
    	var ds = new ListView.DataSource({ rowHasChanged:(r1, r2) => r1 != r2 });
    	return ds.cloneWithRows(data);
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
		listDetailContainer: {
			alignSelf: 'stretch',
			flex: 1,
			marginTop: 5,
			alignItems: 'center',
		},
	});

}

class RowItem extends Component {

	constructor(props) {
		super(props);
		this.item = this.props.item;
	}

	render() {
		return (
			<TouchableHighlight
				underlayColor={'transparent'}
				onPress={this.redirectUrl.bind(this)}
			>

				<View style={this.styles.container}>
					<Text style={this.styles.title}>
						{this.item.name}
					</Text>
					<Image
		                source={{uri: ApiUrl.ROOT + ApiUrl.IMAGE + this.item.image}}
		                style={this.styles.image}
		                resizeMode={'cover'}
		            />
					{this.renderButtons()}
					<Text style={this.styles.content}>
						{this.item.content}
					</Text>
				</View>

			</TouchableHighlight>
		);
	}

	renderButtons() {
		return (
			<View style={this.styles.buttonGroupContainer}>
				{
					this.item.phone != '' &&
					(
						<View style={{flexDirection: 'row'}}>
							<Button
								title={I18n.t('call').toUpperCase()}
								onPress={this.callAction.bind(this)}
								style={[this.styles.button, this.styles.callButton]}
							/>
							<View style={this.styles.buttonSeperator} />
						</View>
					)
				}
				<Button
					title={I18n.t('callMeBack').toUpperCase()}
					onPress={() => Alert.alert('Update Later')}
					style={[this.styles.button, this.styles.reCallButton]}
				/>
			</View>
		);
	}

	redirectUrl() {
		var url = Url.generate(ApiUrl.ROOT + ApiUrl.SERVICE_DETAIL_CLICK, [this.item.id]);
		fetch(url);
		Linking.openURL(this.item.url);
	}

	callAction() {

		var context = this;
        var url = Url.generate(ApiUrl.ROOT + ApiUrl.SERVICE_DETAIL_CALL_PERMISSION, [this.item.id]);

        fetch(url)
	        .then(function(response) {
	            if(response.status == 200) {
	                return response.json();
	            }
	        })
	        .then(function(response) {
	        	if(response.result) {
	        		Alert.alert(
					    'Xác Nhận',
					    'Bạn muốn gọi số ' + context.item.phone + ' ?',
					    [
					        {text: 'Huỷ', onPress: () => console.log('Cancel Pressed') },
					        {text: 'Đồng ý', onPress: () => Linking.openURL('tel:' + context.item.phone)},
					    ]
					);
	        	} else {
	        		Alert.alert(response.message);
	        	}
	        })
	        .catch(function(error) {
	            Alert.alert(error.toString());
	        });
	}

	styles = StyleSheet.create({
		container: {
			marginHorizontal: 5,
			marginBottom: 30,
			alignItems: 'center',
		},
		title: {
			fontSize: 20,
			fontWeight: 'bold',
			marginBottom: 5,
			fontFamily: 'Arial',
		},
		image: {
        	height: 200,
        	alignSelf: 'stretch',
		},
		buttonGroupContainer: {
			marginTop: 10,
			flexDirection: 'row',
		},
		buttonSeperator: {
			width: 30,
		},
		button: {
			width: 140,
		},
		callButton: {
			backgroundColor: '#8BC44A',
		},
		reCallButton: {
			backgroundColor: '#F26722',
		},
		content: {
			marginTop: 10,
			fontFamily: 'Arial',
			textAlign: 'justify',
		}
	});
}
