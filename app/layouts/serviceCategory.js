import React, {Component} from 'react';
import ReactNative from 'react-native';

import {
	View,
	StatusBar,
	Text,
	StyleSheet,
	ListView,
	Alert,
	Image,
	TouchableHighlight,
	Platform,
} from 'react-native';

import NavigationBar from '../components/navigationBar';
import BottomBar from '../components/bottomBar';
import LoadingIcon from '../components/loadingIcon';
import Url from '../utilizes/Url';
import ApiUrl from '../constants/apiUrl';
import I18n from 'react-native-i18n';

export default class ServiceCategory extends Component {

	constructor(props) {
        super(props);

        this.state = {
        	dataSource : this.setDataSource([]),
            isLoaded: false,
        };
    }

	render() {
		return (
			<View style={this.styles.container}>
				{this.renderStatusBar()}
				<NavigationBar title={I18n.t('serviceCategory')} navigator={navigator} backHome={true} />
				{this.renderContent()}
				<BottomBar
					navigator={this.props.navigator}
					avoidSceneId='006' />
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
            return this.renderServiceCategories()
        }
    }

    renderServiceCategories() {
    	return(
    		<View
    			alignItems={'stretch'}
    			style={this.styles.listCategoriesContainer}
    		>
    			<ListView
                    dataSource={this.state.dataSource}
                    renderRow={(rowData) =>
                        <RowItem
                            item={rowData}
                            navigator={this.props.navigator}
                        />
                    }
                />
    		</View>
    	);
    }

    componentDidMount() {
        setTimeout(this.fetchData.bind(this), 300);
    }

    fetchData() {
    	var context = this;
        var url = Url.generate(ApiUrl.ROOT + ApiUrl.TYPES);

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
		listCategoriesContainer: {
			alignSelf: 'stretch',
			flex: 1,
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
				onPress={this.redirectToDetailList.bind(this)}
			>

				<View style={this.styles.container}>
					<Text style={this.styles.title}>
						{this.item.name}
					</Text>

					<Image
		                source={{uri: ApiUrl.ROOT + ApiUrl.IMAGE + this.item.image}}
		                style={this.styles.image}
		                resizeMode={'cover'} />
				</View>

			</TouchableHighlight>
		);
	}

	redirectToDetailList() {
		this.props.navigator.push({
            sceneId: '007',
            passProps: {
				category: this.props.item,
            }
		});
	}

	styles = StyleSheet.create({
		container: {
			marginHorizontal: 5,
			marginBottom: 15,
		},
		title: {
			fontSize: 20,
			fontWeight: 'bold',
			fontFamily: 'Arial',
		},
		image: {
        	height: 200,
        	alignSelf: 'stretch',
		},
	});
}
