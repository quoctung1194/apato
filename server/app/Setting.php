<?php
namespace App;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model {

	protected $fillable = array(
		'id',
	);

	public function getTypes() {
		return json_decode($this->type);
	}
	
	public function getTags() {
		return json_decode($this->tag);
	}
}