import React, {Component} from 'react';
import ReactNative from 'react-native';

import {
	View,
	Text,
	StyleSheet,
	TouchableOpacity
} from 'react-native';

export default class Button extends Component {

	render() {
		return (
			<View>
				<TouchableOpacity
					style={[this.styles.button, this.props.style]}
					onPress={this.props.onPress}
				>
					<Text style={this.styles.buttonLabel}>{this.props.title}</Text>
				</TouchableOpacity>
			</View>
		);
	}

	styles = StyleSheet.create({
		button: {
			backgroundColor: 'white',
			width: 100,
			height: 50,
			borderRadius: 4,
			alignItems: 'center',
			justifyContent: 'center',
		},
		buttonLabel: {
			color: 'white',
			fontSize: 15,
			fontWeight: 'bold',
			fontFamily: 'Arial',
		},
	});
}