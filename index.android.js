import { AppRegistry } from 'react-native';
import Route from './app/route';
import I18n from 'react-native-i18n';
import {lang as vnLang} from './app/i18n/en-VN';
import {lang as usLang} from './app/i18n/en-US';

I18n.locale = 'en-VN';
I18n.translations = {
  'en-VN': vnLang,
  'en-US': usLang
}
AppRegistry.registerComponent('ApartmentManagement', () => Route);
