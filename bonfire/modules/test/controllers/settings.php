<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class settings extends Admin_Controller {

	//--------------------------------------------------------------------


	public function __construct()
	{
		parent::__construct();

		$this->auth->restrict('Test.Settings.View');
		$this->load->model('test_model', null, true);
		$this->lang->load('test');
		
			Assets::add_css('flick/jquery-ui-1.8.13.custom.css');
			Assets::add_js('jquery-ui-1.8.13.min.js');
			Assets::add_css('jquery-ui-timepicker.css');
			Assets::add_js('jquery-ui-timepicker-addon.js');
		Template::set_block('sub_nav', 'settings/_sub_nav');
	}

	//--------------------------------------------------------------------



	/*
		Method: index()

		Displays a list of form data.
	*/
	public function index()
	{

		// Deleting anything?
		if (isset($_POST['delete']))
		{
			$checked = $this->input->post('checked');

			if (is_array($checked) && count($checked))
			{
				$result = FALSE;
				foreach ($checked as $pid)
				{
					$result = $this->test_model->delete($pid);
				}

				if ($result)
				{
					Template::set_message(count($checked) .' '. lang('test_delete_success'), 'success');
				}
				else
				{
					Template::set_message(lang('test_delete_failure') . $this->test_model->error, 'error');
				}
			}
		}

		$records = $this->test_model->find_all();

		Template::set('records', $records);
		Template::set('toolbar_title', 'Manage test');
		Template::render();
	}

	//--------------------------------------------------------------------



	/*
		Method: create()

		Creates a test object.
	*/
	public function create()
	{
		$this->auth->restrict('Test.Settings.Create');

		if ($this->input->post('save'))
		{
			if ($insert_id = $this->save_test())
			{
				// Log the activity
				$this->activity_model->log_activity($this->current_user->id, lang('test_act_create_record').': ' . $insert_id . ' : ' . $this->input->ip_address(), 'test');

				Template::set_message(lang('test_create_success'), 'success');
				Template::redirect(SITE_AREA .'/settings/test');
			}
			else
			{
				Template::set_message(lang('test_create_failure') . $this->test_model->error, 'error');
			}
		}
		Assets::add_module_js('test', 'test.js');

		Template::set('toolbar_title', lang('test_create') . ' test');
		Template::render();
	}

	//--------------------------------------------------------------------



	/*
		Method: edit()

		Allows editing of test data.
	*/
	public function edit()
	{
		$id = $this->uri->segment(5);

		if (empty($id))
		{
			Template::set_message(lang('test_invalid_id'), 'error');
			redirect(SITE_AREA .'/settings/test');
		}

		if (isset($_POST['save']))
		{
			$this->auth->restrict('Test.Settings.Edit');

			if ($this->save_test('update', $id))
			{
				// Log the activity
				$this->activity_model->log_activity($this->current_user->id, lang('test_act_edit_record').': ' . $id . ' : ' . $this->input->ip_address(), 'test');

				Template::set_message(lang('test_edit_success'), 'success');
			}
			else
			{
				Template::set_message(lang('test_edit_failure') . $this->test_model->error, 'error');
			}
		}
		else if (isset($_POST['delete']))
		{
			$this->auth->restrict('Test.Settings.Delete');

			if ($this->test_model->delete($id))
			{
				// Log the activity
				$this->activity_model->log_activity($this->current_user->id, lang('test_act_delete_record').': ' . $id . ' : ' . $this->input->ip_address(), 'test');

				Template::set_message(lang('test_delete_success'), 'success');

				redirect(SITE_AREA .'/settings/test');
			} else
			{
				Template::set_message(lang('test_delete_failure') . $this->test_model->error, 'error');
			}
		}
		Template::set('test', $this->test_model->find($id));
		Assets::add_module_js('test', 'test.js');

		Template::set('toolbar_title', lang('test_edit') . ' test');
		Template::render();
	}

	//--------------------------------------------------------------------


	//--------------------------------------------------------------------
	// !PRIVATE METHODS
	//--------------------------------------------------------------------

	/*
		Method: save_test()

		Does the actual validation and saving of form data.

		Parameters:
			$type	- Either "insert" or "update"
			$id		- The ID of the record to update. Not needed for inserts.

		Returns:
			An INT id for successful inserts. If updating, returns TRUE on success.
			Otherwise, returns FALSE.
	*/
	private function save_test($type='insert', $id=0)
	{
		if ($type == 'update') {
			$_POST['id'] = $id;
		}

		
		$this->form_validation->set_rules('test_abc','abc','');
		$this->form_validation->set_rules('test_qwerty1','qwerty','max_length[15]');
		$this->form_validation->set_rules('test_qwerty','qwerty','max_length[15]');

		if ($this->form_validation->run() === FALSE)
		{
			return FALSE;
		}

		// make sure we only pass in the fields we want
		
		$data = array();
		$data['test_abc']        = $this->input->post('test_abc') ? $this->input->post('test_abc') : '0000-00-00 00:00:00';
		$data['test_qwerty1']        = $this->input->post('test_qwerty1');
		$data['test_qwerty']        = $this->input->post('test_qwerty');

		if ($type == 'insert')
		{
			$id = $this->test_model->insert($data);

			if (is_numeric($id))
			{
				$return = $id;
			} else
			{
				$return = FALSE;
			}
		}
		else if ($type == 'update')
		{
			$return = $this->test_model->update($id, $data);
		}

		return $return;
	}

	//--------------------------------------------------------------------



}