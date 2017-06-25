<?php
namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Notification extends Model {
	const PRIVACY_PUBLIC = 0;
	const PRIVACY_PRIVATE = 1;
	
	const TYPE_SURVEY = 1;
	const TYPE_NORMAL = 0;
	
	const CHECK_SINGLE = 1;
	const CHECK_MULTIPLE = 0;

	use SoftDeletes;
	
	protected $fillable = [
		'title',
		'subTitle',
		'content',
		'isStickyHome',
		'remindDate'
	];

	public function surveyOptions()
	{
		return $this->hasMany('App\SurveyOption');
	}

	/**
	 * 
	 */
	public function createdBy()
	{
		return $this->belongsTo('App\Admin', 'created_by', 'id');
	}

	public function receivers()
	{
		return $this->hasMany('App\UserNotification');
	}
}
