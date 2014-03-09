<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Student_model extends BF_Model {

	protected $table		= "student";
	protected $key			= "id";
	protected $soft_deletes	= true;
	protected $date_format	= "datetime";
	protected $set_created	= true;
	protected $set_modified = true;
	protected $created_field = "created_on";
	protected $modified_field = "modified_on";
	
	public function get_total_no_of_student()
	{
		//$this->where('active',1);
		$this->where('deleted',0);
		return $this->count_all();
	}
	
}
