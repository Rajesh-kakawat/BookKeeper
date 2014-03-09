<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Books extends Authenticated_Controller {

	//--------------------------------------------------------------------


	public function __construct()
	{
		parent::__construct();

		//$this->auth->restrict('Books.Content.View');
		$this->load->model('books_model', null, true);
		$this->load->model('book_copies_model', null, true);
		$this->lang->load('books');
	}

	public function index($filter='all', $offset=0)
	{

		$where = array();
		$show_deleted = FALSE;
		
		// Filters
		if (preg_match('{first_letter-([A-Z])}', $filter, $matches))
		{
			$filter_type = 'first_letter';
			$first_letter = $matches[1];
		}
		elseif (preg_match('{isbn-([A-Za-z0-9]+)}',$filter, $matches))
		{			
			$filter_type = 'isbn';
			$isbn = $matches[1];
		}
		else
		{
			$filter_type = $filter;
		}
		
		switch($filter_type)
		{
		
			case 'deleted':
				$where['books.deleted'] = 1;
				$show_deleted = TRUE;
				break;
		
			case 'first_letter':
				$where['SUBSTRING( LOWER(title), 1, 1)='] = $first_letter;
				break;
				
			case 'isbn':
				$where['isbn'] = $isbn;
				Template::set('filter_isbn', $isbn);
				break;
		
			case 'all':
				$where['books.deleted'] = 0;
				$show_deleted = FALSE;
				break;
				
			default:
				show_404("books/index/$filter/");
		}
		
		// Fetch the members to display
		$this->books_model->where($where);
		$book_records = $this->books_model->find_all();

//=====================================================================
		$books_copies = array();
		
		$books_copies_records = $this->book_copies_model->get_num_of_copies_each_book();
		
		foreach ($books_copies_records as $record)
		{
			$books_copies[$record->book_id]=$record->num_of_books;
		}
//=====================================================================		
		Template::set('book_records', $book_records);
		Template::set('books_copies', $books_copies);
		Template::set('filter_type', $filter_type);
		Template::set('toolbar_title', 'Manage Books');
		Template::render();
	}
	
	public function delete($id)
	{

		if($this->book_copies_model->find_by('book_id',$id))
		{
			Template::set_message('First delete all book copies', 'error');
		}
		else 
		{
			$result = $this->books_model->delete($id);
			if ($result)
			{
				Template::set_message(lang('books_delete_success'), 'success');
			}
			else
			{
				Template::set_message(lang('books_delete_failure') . $this->books_model->error, 'error');
			}
		}
		
		redirect('books/index');
	}
	
	public function delete_book_copy($book_id,$id)
	{
		$this->load->model('issue_book/issue_book_model', null, true);
		if($this->issue_book_model->check_for_issued_book($id))
		{
			Template::set_message('Can not delete issued book', 'error');
		}
		else 
		{
			$result = $this->book_copies_model->delete($id);
			if ($result)
			{
				Template::set_message(lang('books_delete_success'), 'success');
			}
			else
			{
				Template::set_message(lang('books_delete_failure') . $this->books_model->error, 'error');
			}
		}
		
		redirect('books/book_detail/'.$book_id);
	}
	
	public function create()
	{
		if ($this->input->post('save'))
		{
			if ($insert_id = $this->save_books())
			{
				// Log the activity
				$this->activity_model->log_activity($this->current_user->id, lang('books_act_create_record').': ' . $insert_id . ' : ' . $this->input->ip_address(), 'books');

				Template::set_message(lang('books_create_success'), 'success');
				Template::redirect('/books');
			}
			else
			{
				Template::set_message(lang('books_create_failure') . $this->books_model->error, 'error');
			}
		}
		Assets::add_module_js('books', 'books.js');

		Template::set('toolbar_title', lang('books_create') . ' Books');
		Template::render();
	}

	public function edit()
	{
		$id = $this->uri->segment(3);
		if (empty($id))
		{
			Template::set_message(lang('books_invalid_id'), 'error');
			redirect('/books');
		}

		if (isset($_POST['save']))
		{
			//$this->auth->restrict('Books.Content.Edit');

			if ($this->save_books('update', $id))
			{
				// Log the activity
				$this->activity_model->log_activity($this->current_user->id, lang('books_act_edit_record').': ' . $id . ' : ' . $this->input->ip_address(), 'books');

				Template::set_message(lang('books_edit_success'), 'success');
			}
			else
			{
				Template::set_message(lang('books_edit_failure') . $this->books_model->error, 'error');
			}
		}
		Template::set('books', $this->books_model->find($id));
		Assets::add_module_js('books', 'books.js');

		Template::set('toolbar_title', lang('books_edit') . ' Books');
		Template::render();
	}

	//--------------------------------------------------------------------

	public function book_detail($book_id)
	{
		$book_details = $this->books_model->find($book_id);
		
		$books_in_category = $this->book_copies_model->get_all_books_in_category($book_id);
		$books_in_category_arr = array();
		if (isset($books_in_category) && is_array($books_in_category) && count($books_in_category))
		{
			foreach ($books_in_category as $book)
				$books_in_category_arr[$book->id] = $book;
		}

		$this->load->model('issue_book/issue_book_model');
		//$books_issue_info = $this->issue_book_model->get_book_issue_info($id);
		$books_in_category_issued = $this->issue_book_model->get_book_category_issue_info($book_id);
		
		$books_in_category_issued_arr = array();
		if (isset($books_in_category_issued) && is_array($books_in_category_issued) && count($books_in_category_issued))
		{
			foreach ($books_in_category_issued as $book)
				$books_in_category_issued_arr[$book->book_copy_id] = $book;
		}
		
		Template::set('book_id', $book_id);
		Template::set('book_details', $book_details);
		Template::set('books_in_category_arr', $books_in_category_arr);
		Template::set('books_in_category_issued_arr', $books_in_category_issued_arr);
		Template::set('toolbar_title', lang('book_detail'));
		Template::render();
	}
	public function get_copies_by_book_id($book_id)
	{
		$book_copies = $this->book_copies_model->get_available_book_copies($book_id);
		
		echo json_encode($book_copies);
	}
	
	public function get_copies_by_book_id_for_edit($book_id,$book_copy_id)
	{
		$book_copies = $this->book_copies_model->get_available_book_copies_for_edit($book_id,$book_copy_id);
		
		echo json_encode($book_copies);
	}
	
	public function add_book_quantity($book_id = '')
	{
		
		if (isset($_POST['add']))
		{
			
			//$this->auth->restrict('Books.Content.Edit');
			
			if ($this->add_book())
			{
				// Log the activity
				$this->activity_model->log_activity($this->current_user->id, lang('book_copies_act_add_record'). ' : ' . $this->input->ip_address(), 'book_copies');

				Template::set_message(lang('books_edit_success'), 'success');
			}
			else
			{
				Template::set_message(lang('books_edit_failure') . $this->books_model->error, 'error');
			}
		}
		
		$books = $this->books_model->find_all();
		$books_dropdown_values = array(''=>'Select Book');
		foreach ($books as $book)
			$books_dropdown_values[$book->id] = $book->title;
		
		Template::set('books_dropdown_values', $books_dropdown_values);
		Template::set('book_id', $book_id);
		Template::render();
	}
	
	public function add_book()
	{
		$this->form_validation->set_rules('book_copies_num_of_books','Number of Books','required|trim|max_length[10]');
		if ($this->form_validation->run() === FALSE)
		{
			return FALSE;
		}
		$this->form_validation->set_rules('book_copies_book_id','Book','required|trim|max_length[100]');
		$num_of_books = $_POST['book_copies_num_of_books'];
		$i=0;		
		for ($i=0; $i<$num_of_books; $i++)
		{
			$this->form_validation->set_rules('book_copies_book_uid['.$i.']','Book UID fields cannot be EMPTY','required|trim|max_length[50]');
		}

		if ($this->form_validation->run() === FALSE)
		{
			return FALSE;
		}
		
		$data = array();
		for ($i=0; $i<$num_of_books; $i++)
		{
			$temp = array();
			
			$temp['book_id']	= $_POST['book_copies_book_id'];
			$temp['book_uid']	= $_POST['book_copies_book_uid'][$i];
			array_push($data, $temp);
		}
		
		return $this->book_copies_model->add_book_quantity($data);
		
	}
	
	public function submit_book($book_id,$issue_id)
	{
		$this->load->model('issue_book/issue_book_model');
		if ($this->issue_book_model->submit_book($issue_id))
		{
			// Log the activity
			$this->activity_model->log_activity($this->current_user->id, lang('issue_book_act_edit_record').': ' . $id . ' : ' . $this->input->ip_address(), 'issue_book');

			Template::set_message('Book Submitted', 'success');
		}
		else
		{
			Template::set_message('Fail to Submit Book' . $this->issue_book_model->error, 'error');
		}
		redirect('books/book_detail/'.$book_id);
	}
	
	
	//--------------------------------------------------------------------
	
	//--------------------------------------------------------------------
	// !PRIVATE METHODS
	//--------------------------------------------------------------------

	private function save_books($type='insert', $id=0)
	{
		if ($type == 'update') {
			$_POST['id'] = $id;
		}


		$this->form_validation->set_rules('books_isbn','ISBN','required|trim|max_length[100]');
		$this->form_validation->set_rules('books_title','Title','trim|max_length[500]');
		$this->form_validation->set_rules('books_author','Author','trim|max_length[50]');
		$this->form_validation->set_rules('books_publisher','Publisher','trim|max_length[50]');
		$this->form_validation->set_rules('books_year','Year','trim|max_length[50]');

		if ($this->form_validation->run() === FALSE)
		{
			return FALSE;
		}

		// make sure we only pass in the fields we want

		$data = array();
		$data['isbn']        = $this->input->post('books_isbn');
		$data['title']        = $this->input->post('books_title');
		$data['author']        = $this->input->post('books_author');
		$data['publisher']        = $this->input->post('books_publisher');
		$data['year']        = date("Y-m-d", strtotime($this->input->post('books_year')));

		if ($type == 'insert')
		{
			$id = $this->books_model->insert($data);

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
			$return = $this->books_model->update($id, $data);
		}

		return $return;
	}

	//--------------------------------------------------------------------

}