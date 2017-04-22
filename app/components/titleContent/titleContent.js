import React, {Component} from 'react';
import {
  Text
} from 'react-native';

import styles from './styles';

export default class TitleContent extends Component {

  constructor(props) {
    super(props);
  }

  render() {
    return (
      <Text style={styles.main}>
        {this.props.title}
      </Text>
    );
  }

}
