import React, {Component} from 'react';
import {
  TouchableOpacity,
  Text
} from 'react-native';

import styles from './styles';

export default class FulfillButton extends Component {
  constructor(props) {
    super(props);
  }

  render() {
    return(
      <TouchableOpacity
       onPress={this.props.onPress}
       style={[
         {borderTopWidth: this.props.borderTopWidth},
         styles.main
       ]}>
        <Text style={styles.textDisplay}>
          {this.props.title}
        </Text>
      </TouchableOpacity>
    )
  }
}
