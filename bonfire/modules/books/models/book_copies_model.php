<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Book_copies_model extends BF_Model {

	protected $table		= "book_copies";
	protected $key			= "id";
	protected $soft_deletes	= true;
	protected $date_format	= "datetime";
	protected $set_created	= true;
//	protected $set_modified = true;
	protected $created_field = "created_on";
//	protected $modified_field = "modified_on";
	
	public function get_all_books_in_category($book_id)
	{
		$this->where('book_id', $book_id);
		$this->where('deleted',0);
		return $this->find_all();
	}
	
	public function get_num_of_copies_each_book()
	{
		$query = "
			select book_id, count(*) as num_of_books
			from bf_book_copies
			group by book_id;
			";
		
		$result = $this->db->query($query)->result();
		
		return $result;
	}
	
	public function get_available_book_copies($book_id)
	{
		$query = "
			select * from bf_book_copies
			where bf_book_copies.book_id = ".$book_id." and bf_book_copies.id not in (
			select bf_issue_book.book_copy_id
			from bf_issue_book
			where bf_issue_book.submit_date is null);
			";
		
		$result = $this->db->query($query)->result();
		
		return $result;
	}
	
	public function get_available_book_copies_for_edit($book_id,$book_copy_id)
	{
		$query = "
			select * from bf_book_copies
			where bf_book_copies.book_id = ".$book_id." and bf_book_copies.id not in (
			select bf_issue_book.book_copy_id
			from bf_issue_book
			where bf_issue_book.submit_date is null and bf_issue_book.book_copy_id <> ".$book_copy_id.");
			";
		
		$result = $this->db->query($query)->result();
		
		return $result;
	}
	
	public function add_book_quantity($data)
	{
		return $this->db->insert_batch($this->table, $data);
	}
}