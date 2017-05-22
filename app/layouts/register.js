import React, {Component} from 'react';
import ReactNative from 'react-native';
import {
	View,
	Text,
	StyleSheet,
	Platform,
	StatusBar,
	TextInput,
	ScrollView,
  TouchableOpacity,
  ActivityIndicator,
  TouchableHighlight,
  Image
} from 'react-native';

import NavigationBar from '../components/navigationBar';
import I18n from 'react-native-i18n';
import ApiUrl from '../constants/apiUrl';
import InitSetting from '../layouts/initSetting';
import ModalDropdown from 'react-native-modal-dropdown';

export default class Register extends Component {

  state = {
    formData: {
      code: '',
      username: '',
      password: '',
      confirm_password: '',
      first_name: '',
      last_name: '',
      room: '',
      apartment_id: '',
      block_id: ''
    },
    isLoading: false,
    apartments: [],
    blocks: [],
  }

	render()
	{
		return (
			<View style={this.styles.container}>
				{this.renderStatusBar()}
				<NavigationBar title={''} navigator={this.props.navigator} />
				<ScrollView
					ref='scrollView'
					keyboardDismissMode={Platform.OS == 'ios' ? 'on-drag': 'none'}
					keyboardShouldPersistTaps={true}
					alignItems={'stretch'}
				>
					{this.renderContent()}
          {this.renderSubmitButton()}
				</ScrollView>
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

	renderContent()
	{
    let codeProps = {
      returnKeyType: 'next',
      onSubmitEditing: () => {
        this.refs['username'].focus();
      }
    }

    let usernameProps = {
      returnKeyType: 'next',
      onSubmitEditing: () => {
        this.refs['email'].focus();
      }
    }

    let passwordProps = {
      returnKeyType: 'next',
      onSubmitEditing: () => {
        this.refs['confirm_password'].focus();
      }
    }

    let confirmPasswordProps = {
      returnKeyType: 'next',
      onSubmitEditing: () => {
        this.refs['username'].focus();
      }
    }

    let firstNameProps = {
      returnKeyType: 'next',
      onSubmitEditing: () => {
        this.refs['last_name'].focus();
      }
    }

    let lastNameProps = {
      returnKeyType: 'next',
      onSubmitEditing: () => {
        this.refs['password'].focus();
      }
    }

    let emailProps = {
      returnKeyType: 'next',
      onSubmitEditing: () => {
        this.refs['confirm_email'].focus();
      }
    }

    let emailConfirmProps = {
      returnKeyType: 'next',
      onSubmitEditing: () => {
        this.refs['room'].focus();
      }
    }

    let roomProps = {
      returnKeyType: 'done',
      onSubmitEditing: this.submitForm.bind(this),
    }

		return (
			<View>
        <View>
          <Text style={this.styles.titleHeader}>{I18n.t('register')}</Text>
        </View>
        {this.renderInput( 'first_name', I18n.t('first_name'), false, firstNameProps )}
        {this.renderInput( 'last_name', I18n.t('last_name'), false, lastNameProps )}
        {this.renderInput( 'password', I18n.t('password'), true, passwordProps )}
        {this.renderInput( 'confirm_password', I18n.t('confirm_password'), true, confirmPasswordProps )}
				{this.renderInput( 'username', I18n.t('phone_number'), false, usernameProps )}
        {this.renderInput( 'email', I18n.t('email'), false, emailProps )}
        {this.renderInput( 'confirm_email', I18n.t('confirm_email'), false, emailConfirmProps )}
        {this._renderApartments()}
        {this._renderBlocks()}
				{this.renderInput( 'room', I18n.t('room'), false, roomProps )}
			</View>
		)
	}

  _renderApartments() {
    return this._dropDownRender('apartments', this.state.apartments, this.state.formData.apartment_id);
  }

  _renderBlocks() {
    return this._dropDownRender('blocks', this.state.blocks, this.state.formData.block_id);
  }

  _dropDownRender(ref, data, selectedIndex) {
    let display = '';
    if (ref == 'apartments') {
      display = 'Chung cư';
      if(this.state.apartments.length > 0) {
        for(var i = 0; i < this.state.apartments.length; i++) {
          if(this.state.apartments[i].id == selectedIndex) {
            display = this.state.apartments[i].name;
            break;
          }
        }
      }
    } else if (ref == 'blocks') {
      display = 'Block';
      if(this.state.blocks.length > 0) {
        for(var i = 0; i < this.state.blocks.length; i++) {
          if(this.state.blocks[i].id == selectedIndex) {
            display = this.state.blocks[i].name;
            break;
          }
        }
      }
    }

    return(
      <View style={this.styles.dropdownContainer}>
        <ModalDropdown
          style={this.styles.modalDropdown}
          options={data}
          renderRow={this._dropdownRenderRow.bind(this)}
          onSelect={(id, value) => this._setDropdownValue(id, value, ref)}
        >
          <View style={this.styles.dropdownSubContainer}>
            <Text style={this.styles.dropdownTextDisplay} >
              {display}
            </Text>
            <Image
              source={require('../images/downArrow.png')}
              style={this.styles.dropdownIcon}
            />
          </View>
        </ModalDropdown>
      </View>
    );
  }

  _dropdownRenderRow(rowData, rowID, highlighted) {
      return (
        <TouchableHighlight style={{width: 500, height: 50}}>
          <View style={[this.styles.dropdowRowContainer, highlighted && {backgroundColor: 'lemonchiffon'}]}>
            <Text style={this.styles.dropdownRowText}>
              {rowData['name']}
            </Text>
          </View>
        </TouchableHighlight>
      );
    }

  _setDropdownValue(id, value, ref) {
    if(ref == 'apartments') {
      this.state.formData.apartment_id = this.state.apartments[id]['id'];
      this.loadBlocks(this.state.formData.apartment_id);
    } else if(ref == 'blocks') {
      this.state.formData.block_id = this.state.blocks[id]['id'];
    }

    this.setState(this.state);
  }

	renderInput(ref, placeholder, isPassword = false, props = {}) {
  	return (
  		<View style={this.styles.inputContainer}>
  			<TextInput
					ref={ref}
					underlineColorAndroid={'transparent'}
					placeholder={placeholder}
					secureTextEntry={isPassword}
					placeholderTextColor={'gray'}
					style={this.styles.input}
          blurOnSubmit={false}
          onFocus={this._inputFocused.bind(this, ref)}
          onChangeText={(text) => {
            this.state.formData[ref] = text;
          }}
					{...props}
				/>
  		</View>
  	)
  }

  renderSubmitButton() {
  	return (
  		<View style={this.styles.containerButton}>
				<TouchableOpacity
					style={this.styles.button}
					onPress={ this.submitForm.bind(this) }
				>
				{
					this.state.isLoading &&
						<ActivityIndicator
       				style= {this.styles.loadingButton}
       				size='small'
       				color='white' />
        }
	        	<Text style={this.styles.buttonText}>
	        		{I18n.t('submit')}
	        	</Text>
		      	</TouchableOpacity>
    	</View>
  	);
  }

  // Scroll a component into view. Just pass the component ref string.
  _inputFocused (refName) {
    setTimeout(() => {
      let scrollResponder = this.refs.scrollView.getScrollResponder();
      scrollResponder.scrollResponderScrollNativeHandleToKeyboard(
        ReactNative.findNodeHandle(this.refs[refName]),
        260, //additionalOffset
        true
      );
    }, 50);
  }

  componentDidMount() {
    this.refs['first_name'].focus();
    this.loadApartment();
  }

  loadBlocks(id) {
    var url = ApiUrl.ROOT + ApiUrl.LOAD_BLOCK + '/' + id;
      var context = this;
      fetch(url)
        .then(function(response) {
            if(response.status == 200)  {
              return response.json();
            }
        })
        .then(function(response) {
            context.state.blocks = response.items;
            context.setState(context.state);
        })
        .catch(function(error) {
            console.error(error);
            Alert.alert(error);
        });
  }

  loadApartment() {
      var url = ApiUrl.ROOT + ApiUrl.LOAD_APARTMENT;
      var context = this;

      fetch(url)
        .then(function(response) {
            if(response.status == 200)  {
              return response.json();
            }
        })
        .then(function(response) {
            context.state.apartments = response.items;
            context.setState(context.state);
        })
        .catch(function(error) {
            console.error(error);
            Alert.alert(error);
        });
  }

  submitForm()
  {
    let context = this;

    //Kiểm tra validate
    if(!this.validate())
    {
      return;
    }

    if(this.state.isLoading) {
      return;
    }

    this.state.isLoading = true;
    this.setState(this.state);

    //Submit data
    let url = ApiUrl.ROOT + ApiUrl.REGISTER;
    let formData = new FormData();

    //Gán dữ liệu vào formData
    for(var key in this.state.formData)
    {
      let value = this.state.formData[key].trim();
      formData.append(key, value);
    }

    //Send request
    fetch(url, {
      method: 'POST',
      headers: {
        'Content-Type': 'multipart/form-data',
      },
      body: formData,
    })
    .then(function(response) {
      if(response.status == 200)  {
        return response.json();
      } else {
        throw new Error('Vui lòng thử lại');
      }
    })
    .then(function(response) {
      let status = response.status;
      alert(response.message);

      if(response.status == 'successful')
      {
        context.props.navigator.pop();
      }

      context.state.isLoading = false;
      context.setState(context.state);
    })
    .catch(function(error) {
      alert(error.toString());
      context.state.isLoading = false;
      context.setState(context.state);
    });
  }

  validate()
  {
    let formData = this.state.formData;

    for(let key in formData)
    {
      let value = formData[key];
      if(value.trim() == '')
      {
        alert(I18n.t('emptyFields'));
        return false;
      }
    }

    //Valid password and confirm_password
  if(formData['password'] != formData['confirm_password'])
    {
      alert(I18n.t('confirm_password_not_match'));
      return false;
    }

    return true;
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
		input: {
			borderWidth: 10,
			borderRadius: 4,
			marginLeft: 4,
			marginRight: 4,
			height: 40,
			color: 'black',
			borderColor: 'gray',
			borderWidth: 1,
			paddingLeft: 10,
			fontSize: 15,
			fontFamily: 'Arial',
		},
		inputContainer: {
			marginTop: 15,
		},
    containerButton: {
      height: 55,
      backgroundColor: '#4b8bf2',
      marginLeft: 4,
      marginRight: 4,
      marginTop: 15,
      borderRadius: 4,
    },
    button: {
      flex: 1,
      alignItems: 'center',
      justifyContent: 'center',
      flexDirection: 'row',
    },
    buttonText: {
      color: 'white',
      fontSize: 18,
      fontFamily: 'Arial',
    },
    loadingButton: {
      marginRight: 10
    },
    titleHeader: {
      fontSize: 30,
      fontWeight: '400',
      textAlign : 'center',
      marginTop: 10
    },
    dropdownContainer: {
      flexDirection: 'row',
      marginTop: 17,
      marginBottom: 5,
      paddingLeft: 5,
      paddingRight: 5,
    },
    modalDropdown: {
      flex: 1
    },
    dropdownSubContainer: {
      flexDirection: 'row',
      height: 37,
      borderRadius: 4,
      borderWidth: 1,
      backgroundColor: 'white',
      justifyContent: 'center',
      alignItems: 'center',
    },
    dropdownTextDisplay: {
      marginLeft: 5,
      fontSize: 15,
      flex: 1,
      fontFamily: 'Arial',
    },
    dropdownIcon: {
      height:15,
      width:15,
      marginRight: 12
    },
    dropdowRowContainer: {
      flex: 1,
        flexDirection: 'row',
        height: 38,
        alignItems: 'center',
    },
    dropdownRowText: {
      fontSize: 14,
      marginLeft: 5,
      fontFamily: 'Arial',
    },
	});

}