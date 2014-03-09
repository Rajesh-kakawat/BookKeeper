<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Books_model extends BF_Model {

	protected $table		= "books";
	protected $key			= "id";
	protected $soft_deletes	= true;
	protected $date_format	= "datetime";
	protected $set_created	= true;
	protected $set_modified = true;
	protected $created_field = "created_on";
	protected $modified_field = "modified_on";
	
	public function get_total_no_of_book()
	{
		return $this->count_by('deleted',0);
	}
	
	public function get_available_books()
	{
		/*$query = "
			select bf_books.*
			from bf_books inner join bf_book_copies
			on bf_books.id = bf_book_copies.book_id
			where bf_book_copies.issued = 0
			group by bf_books.id;
		";*/
		$query = "
			select bf_books.*
			from bf_books inner join bf_book_copies
			where bf_book_copies.id not in (
			select bf_issue_book.book_copy_id
			from bf_issue_book
			where bf_issue_book.submit_date is null)
			group by bf_books.id;
			";
		
		return $this->db->query($query)->result();
	}
	
	public function get_available_books_for_edit($book_id)
	{
		$query = "
			select bf_books.*
			from bf_books inner join bf_book_copies
			where bf_book_copies.id not in (
			select bf_issue_book.book_copy_id
			from bf_issue_book
			where bf_issue_book.submit_date is null)
			or bf_books.id = ".$book_id."
			group by bf_books.id;
			";
		
		return $this->db->query($query)->result();
	}
	
}
