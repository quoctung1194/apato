import React, {Component} from 'react';
import ReactNative from 'react-native';

import {
  View,
  StyleSheet,
  ActivityIndicator
} from 'react-native';

export default class LoadingIcon extends Component {

	render() {
		return(
			<View style={this.styles.loadingContainer}>
                <ActivityIndicator
                    style={this.styles.loading}
                    size='small'
                    color='gray'
                />
            </View>
		);
	}

	styles = StyleSheet.create({
		loadingContainer: {
			flex: 1,
		},
		loading: {
			margin: 30,
		}
	});
}