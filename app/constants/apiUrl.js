export default class ApiUrl {

  static ROOT = 'http://192.168.1.105/api';
  //static ROOT = 'http://192.168.1.102/public/api';

  static LOGIN = '/login';
  static REGISTER = '/register';
  static LOAD_APARTMENT = '/getApartments';
  static LOAD_BLOCK = '/getBlocks';
  
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

  static IMAGE = '/../';
}
