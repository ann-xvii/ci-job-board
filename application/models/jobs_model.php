<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Jobs_model extends CI_Model {

	
	function __construct() {
		parent::__construct();
		$this->load->database();
	}


	/*
	get_jobs(): function displays all jobs, for example when a user first visits the site
	function also, when a user enters  search term the query is then changed to look for the specific search term in job_title and job_desc

	to return all results, that is to list all jobs
	to return results(jobs) that matches a user's search 
	*/


	function get_jobs($search_string) {
		if ($search_string == null) {
			$query = "SELECT * FROM jobs WHERE DATE(NOW()) < DATE(job_sunset_date)";
		} else {
			$query = "SELECT * FROM jobs WHERE job_title LIKE '%$search_string' OR job_desc LIKE '%$search_string' AND DATE(NOW()) < DATE(job_sunset_date)";
		}

		$result = $this->db->query($query);

		if ($result) {
			return $result;
		} else {
			return false;
		}
	}



	/*
	get_job(): this function fetches the details of a specific job advert for the Details and Apply view

	the function is passed the $job_id value from the jobs controller.
	the jobs controller gets the id of the job advert from $this->uri_segment(3) when the user clicks on the Apply link in viewes/jobs/view.php


	the get_job function simply returns all the data for point 2 (Details View)

	it joins the categories, types, and locations tables to the jobs table in order to ensure that the correct category, type, and location is displayed in the vies/jobs/apple.php view along with the specific job advert details
	*/

	function get_job($job_id) {
		$query = "SELECT * FROM jobs, categories, types, locations WHERE
					categories.cat_id = jobs.cat_id AND
					types.type_id = jobs.type_id AND
					locations.loc_id = jobs.loc_id AND
					job_id = ? AND
					DATE(NOW()) < DATE(job_sunset_date)";

		$result = $this->db->query($query, array($job_id));

		if ($result) {
			return $result;
		} else {
			return false;
		}
	}


	/*
	save_job() saves a job advert to the database when a user submits the form from the Create part of the site map

	the save_job function accepts an array of data from the jobs controller, $save_data
	the jobs controller's create function sends the $save_data array to the save_job() model function (because we call the save_job model function from within the controller, which we load as $this->load->model(jobs_model))

	the $save_data array contains the input from the form in the view/jobs/create.php view file
	*/

	function save_job($save_data) {
		if ($this->db->insert('jobs', $save_data)) {
			return $this->db->insert_id();
		} else {
			return false;
		}
	}


	/*
	The next three functions fetch all categories, types, and locations from their respective tables
	These fucntions are called by the jobs controller's create() function to ensure that the dropdowns are populated with correct data
	*/

	/*
	get_categories(): this fetches the categories from the categories table, it is used to populate the categories dropdown for the create process
	*/

	function get_categories() {
		return $this->db->get('categories');
	}


	/* 
	get_types(): this fetches types from the types table. it is used to populate the types dropdown for the create process
	*/
	function get_types() {
		return $this->db->get('types');
	}


	/*
	get_locations(): this fetches locations from the locations table. it is used to populate the locations dropdown for the create process
	*/
	function get_locations() {
		return $this->db->get('locations');
	}



}