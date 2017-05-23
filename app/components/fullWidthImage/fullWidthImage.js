import React, {Component} from 'react';
import {
  View,
  Image
} from 'react-native';

import styles from './styles';

export default class FullWidthImage extends Component {

  constructor(props) {
    super(props);
  }

  render() {
    return (
      <View style={styles.mainView}>
        <Image source={{uri: this.props.uri}}
          style={{
            height: this.props.height,
            flex: 1
          }} />
      </View>
    );
  }

}
