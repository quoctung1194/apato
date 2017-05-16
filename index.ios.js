import { AppRegistry } from 'react-native';
import Route from './app/route';
import I18n from 'react-native-i18n';
import {lang as vnLang} from './app/i18n/en-VN';

AppRegistry.registerComponent('ApartmentManagement', () => Route);

I18n.translations = {
  'en-VN': vnLang,
}