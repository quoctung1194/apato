import React, {Component} from 'react';
import ReactNative from 'react-native';

import {
  View,
  Text,
  StyleSheet,
  TouchableHighlight,
  Image,
  Platform
} from 'react-native';

export default class NavigationBar extends Component {
	render() {
		return (
			<View style={{flexDirection: 'row'}}>
				<View style={this.styles.topBar} >
					<TouchableHighlight
						style={this.styles.backButtonContainer}
						underlayColor={'transparent'}
						onPress={() => {
							if(this.props.backHome == undefined) {
								this.props.navigator.pop();
							} else {
								this.props.navigator.resetTo({
									sceneId: '002'
								});
							}
						}}
					>
						<Image source={require('../images/back.png')}
							style={this.styles.backButton} />
					</TouchableHighlight>

					<Text style={this.styles.title}>{this.props.title}</Text>
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
