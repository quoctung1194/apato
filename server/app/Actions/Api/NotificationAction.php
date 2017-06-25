<?php
namespace App\Actions\Api;

use Illuminate\Support\Facades\Log;

use App\Apartment;
use App\Notification;
use App\App;

class NotificationAction {
	
	function getStickyHome($apartment) {
			$stickyHomeNotifications = Notification::where([
				['privacyType', '=', Notification::PRIVACY_PUBLIC],
				['isStickyHome', '=', '1'],
				['apartment_id', '=', $apartment->id],
			])
			->whereNull('deleted_at')
			->orderBy('created_at', 'desc')
			->get()->toArray();
			
			// get current login user
			$user = \Auth::guard('api')->user();

			$notifications = Notification::select('notifications.*')
			->leftJoin(
					'user_notifications',
					'notifications.id',
					'=',
					'user_notifications.notification_id')
			->where('isStickyHome', '=', '0')
			->where(function ($query) use ($apartment, $user) {
				$query->where(function ($query) use ($apartment) {
	                $query->where('notifications.apartment_id', $apartment->id)
	                	->where('notifications.block_id', NULL)
	                	->where('user_notifications.id', NULL);
	            });
				$query->orWhere(function ($query) use ($apartment, $user) {
	                $query->where('notifications.apartment_id', $apartment->id)
	                	->where('notifications.block_id', $user->room->floor->block->id);
	            });
	            $query->orWhere(function ($query) use ($apartment, $user) {
	                $query->where('notifications.apartment_id', $apartment->id)
	                	->where('user_notifications.user_id', $user->id);
	            });
        	})
			->orderBy('notifications.created_at', 'desc')
			->get()
			->toArray();

			$result = array_merge($stickyHomeNotifications, $notifications);
			return $result;
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
