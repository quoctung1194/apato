export default class ApiUrl {

  //static ROOT = 'http://server.apato.me/public/api';
  static ROOT = 'http://192.168.1.103/api';

  static LOGIN = '/login';
  static REGISTER = '/register';
  static LOAD_APARTMENT = '/getApartments';
  static LOAD_BLOCK = '/getBlocks';
  static LOAD_FLOOR = '/getFloors';
  static LOAD_ROOM = '/getRooms';
  
  static STICKY_HOME_NOTIFICATIONS = '/notification/stickyHomeNotifications';
  static NOTIFICATION_DETAIL = '/notification/notificationDetail/';
  static NOTIFICATION_DISPLAY_DETAIL = '/notification/notificationContentDetail/{?}';
  static NOTIFICATION_SURVEY_DATA = '/notification/survey/{?}';
  static NOTIFICATION_SURVEY_SUBMIT_DATA = '/notification/survey/save';
  static NOTIFICATION_SURVEY_DISPLAY_CHART = '/notification/survey/getCompletedSurveyData/{?}';
  static NOTIFICATION_SURVEY_DISPLAY_DETAIL = '/notification/survey/content/{?}';

  static REQUIREMENT_INIT_DATA = '/setting/{?}';
  static REQUIREMENT_SUBMIT_DATA = '/requirement/save';

  static TYPES = '/service/types';
  static SERVICE_DETAIL_LIST = '/service/list/{?}';
  static SERVICE_DETAIL_CLICK = '/serviceClick/click/{?}';
  static SERVICE_DETAIL_CALL_PERMISSION = '/serviceCall/getPermission/{?}';

  // user settings
  static CHANGE_PASS = '/user/changePass';

  static IMAGE = '/../';
}
