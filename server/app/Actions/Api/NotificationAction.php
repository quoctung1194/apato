<?php
namespace App\Actions\Api;

use Illuminate\Support\Facades\Log;

use App\Apartment;
use App\Notification;
use App\App;

class NotificationAction {
	
	function getStickyHome($apartment) {
		try {
			$stickyHomeNotifications = Notification::where([
				['privacyType', '=', Notification::PRIVACY_PUBLIC],
				['isStickyHome', '=', '1'],
				['apartment_id', '=', $apartment->id],
			])
			->whereNull('deleted_at')
			->orderBy('created_at', 'desc')
			->get()->toArray();
			
			$notifications = Notification::where([
				['privacyType', '=', Notification::PRIVACY_PUBLIC],
				['isStickyHome', '=', '0'],
				['apartment_id', '=', $apartment->id],
			])
			->whereNull('deleted_at')
			->orderBy('created_at', 'desc')
			->get()->toArray();
			
			$result = array_merge($stickyHomeNotifications, $notifications);
			return $result;
		}catch (\Exception $ex) {
			Log::error("NotificationAction - getStickyHome - " . $ex->getMessage());
			return array();
		}
	}
	
	function getNotificationDetail($id) {
		try {
			return Notification::findOrFail($id);
		} catch (\Exception $ex) {
			Log::error("NotificationAction - getNotificationDetail - " . $ex->getMessage());
			return new Notification();
		}
	}
}
