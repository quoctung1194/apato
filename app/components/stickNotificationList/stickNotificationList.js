import React, {Component} from 'react'
import {
    Text,
    View,
    ListView,
    Animated,
    ActivityIndicator,
    Alert,
    TouchableHighlight,
    StyleSheet,
    ScrollView,
    Image
} from 'react-native';

import ApiUrl from '../../constants/apiUrl';
import Constant from '../../constants/commonConstants';
import Url from '../../utilizes/Url';
import DateFormat from 'dateformat';

export default class StickNotificationList extends Component {

    data = [];

    constructor(props) {
        super(props);
        var ds = new ListView.DataSource({ rowHasChanged:(r1, r2) => r1 != r2 });

        this.state = {
            dataSource : ds.cloneWithRows([]),
            isLoaded: false,
        };
    }

    fetchDataFromUrl() {
        var context = this;
        var url = Url.generate(ApiUrl.ROOT + ApiUrl.STICKY_HOME_NOTIFICATIONS);

        fetch(url)
            .then(function(response) {
                if(response.status == 200)  {
                    return response.json();
                }
            })
            .then(function(response) {
                context.setData(response.message, context);

                var currentState = context.state;
                currentState.isLoaded = true;
                context.setState(currentState);
            })
            .catch(function(error) {
                Alert.alert(error.toString())
            });
    }

    setData(jsonData, context) {
        context.data = jsonData;
        var currentState = context.state;
        currentState.dataSource = context.state.dataSource.cloneWithRows(context.data);
    }

    render() {
        if(!this.state.isLoaded) {
            return this.renderLoading()
        } else {
            return this.renderContent()
        }
    }

    componentDidMount() {
        setTimeout(this.fetchDataFromUrl.bind(this), 300);
    }

    renderLoading() {
        return (
            <View style={{flex: 1, alignSelf: 'stretch'}}>
                <ActivityIndicator
                    style={{
                        margin: 30,
                    }}
                    size='small'
                    color='white'
                />
            </View>
        );
    }

    renderContent() {
        if(this.data.length > 0) {
            context = this;
            return (
                <ScrollView
                    style={{
                        backgroundColor: 'rgba(0,0,0,0.5)',
                        alignSelf: 'stretch',
                        flex: 1,
                    }}
                    alignItems={'stretch'}
                >
                    <ListView
                        scrollEnabled={false}
                        style={styles.listView}
                        dataSource = {this.state.dataSource}
                        renderRow = {(rowData, sectionID, rowID) =>
                            <RowItem
                                data={rowData}
                                navigator={context.props.navigator}
                            />
                        }
                    />
                </ScrollView>
            );
        } else {
            return (
                <Text style={{color: 'white', flex: 1, marginTop: 10}}>No Data</Text>
            );
        }
    }

    renderSeparator(sectionID, rowID, adjacentRowHighlighted) {
        return (
            <View
                key={rowID}
                style={{
                    height: adjacentRowHighlighted ? 4 : 1,
                    backgroundColor: adjacentRowHighlighted ? '#3B5998' : '#CCCCCC',
                }}
            />
        );
    }
}

class RowItem extends Component {
  
  render() {
    var color = 'white';
    var arrDateTime =  this.props.data.created_at.split(' ');
    var created_at = Date.parse(arrDateTime[0]);
    var date = DateFormat(created_at, "mm/dd/yyyy");
    var time = arrDateTime[1].substring(0,5);

    if(this.props.data.isStickyHome == 1) {
        color = '#FBFACE';
    }

    return(
	    <TouchableHighlight
            underlayColor={'transparent'}
	     	onPress={() => {
				var sceneId = '';

				if(this.props.data.notificationType == Constant.TYPE_SURVEY) {
					sceneId = '004';
				} else {
					sceneId = '003';
				}

		        this.props.navigator.push({
		            sceneId: sceneId,
		            passProps: {
		                notificationId: this.props.data.id,
		            }
		        });    
	        }}
        >

            <View style={[styles.rowContainer, {backgroundColor: color}]}>

                <View style={{flex: 1}}>
                    <View
                        style={{
    		              marginVertical: 10,
    		              marginHorizontal: 5,
    		            }}
                    >
                        <View
                            style={{
                                flexDirection: 'row',
                                alignItems: 'center',
                            }}
                        >
                            <View
                                style={{
                                    flexDirection: 'column',
                                    alignItems: 'center',
                                    marginRight: 7,
                                }}
                            >
                                {
                                    this.props.data.notificationType == Constant.TYPE_SURVEY &&
                                        <Image
                                            resizeMode={'stretch'}
                                            source={require('../../images/survey.png')}
                                            style={styles.surveyImage}
                                        />
                                }
                                {
                                    this.props.data.notificationType == Constant.TYPE_NORMAL &&
                                        <Image
                                            resizeMode={'stretch'}
                                            source={require('../../images/notification.png')}
                                            style={styles.notificationImage}
                                        />
                                }

                                <View style={styles.timeContainer}>
                                    <Text style={styles.time}>
                                        {date}
                                    </Text>
                                    <Text style={styles.time}>
                                        {time}
                                    </Text>
                                </View>

                            </View>

                            <View
                                style={{
                                    flexDirection: 'column',
                                    alignSelf: 'flex-start',
                                    flex: 1,
                                }}
                            >
                                <Text
                                    style={{
                                        fontWeight: 'bold',
                                        fontSize: 13,
            		                }}
                                    ellipsizeMode={'tail'}
                                    numberOfLines={1}
                                >
                                    {this.props.data.title.toUpperCase()}
        		                </Text>

                                <Text
                                    style={{
                                        fontSize: 12,
                                        marginTop: 5,
                                        textAlign: 'justify'
                                    }}
                                    ellipsizeMode={'tail'}
                                    numberOfLines={4}
                                >
                                    {this.props.data.subTitle}
                                </Text>
                            </View>

                        </View>

                    </View>
                </View>
            </View>
    	</TouchableHighlight>
    );
  }
}

const styles = StyleSheet.create({
	rowContainer: {
		flexDirection: 'row',
        marginTop: 25,
        marginHorizontal: 15,
	},
    imageContainer: {
        width: 50,
        alignItems: 'center'
    },
    surveyImage: {
        width: 35,
        height: 35,
        marginRight: 5,
    },
    notificationImage: {
        width: 33,
        height: 33,
        marginRight: 5,
    },
    listView: {
        backgroundColor: 'rgba(0,0,0,0)',
        marginBottom: 25,
    },
    time: {
        fontWeight: 'bold',
        fontSize: 10,
    },
    timeContainer: {
        marginTop: 7,
        alignItems: 'center',
    }
});
