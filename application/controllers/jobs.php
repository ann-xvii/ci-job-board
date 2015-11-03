<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Jobs extends CI_Controller {

	function __construct() {
		parent::__construct();
		$this->load->helper('string');
		$this->load->helper('text');
		$this->load->model('Jobs_model');
		$this->load->library('form_validation');
		$this->form_validation->set_error_delimiters('<div class="alert alert-danger">', '</div>');
	}


	/* 
	index() function... one of the first things this function does is call the get_jobs() function of the Jobs model, passing to it the search string
	--
	if no search string was entered by the user in the search box, then this post array item will be empty, but that's okay because we test for it in the model
	--
	the result of this query is stored in $page_data["query"], which is ready to be passed to the views/jobs/view.php file, where a foreach() loop will display each job advert
	*/

	public function index() {
		// we first set the validation rules for search_string
		$this->form_validation->set_rules('search_string', $this->lang->line('search_string'), 'required|min_length[1]|max_length[125]');
		$page_data['query'] = $this->Jobs_model->get_jobs($this->input->post('search_string'));

		// if this is the first time the page is viewed, or if the validation fails, then $this->form->form_validation() will return a false value

		if ($this->form_validation->run() == FALSE) {
			$page_data['search_string'] = array('name' => 'search_string', 'class' => 'form-control', 'id' => 'search_string', 'value' => set_value('search_string', $this->input->post('search_string')), 'max_length' => '100', 'size' => '35');

			/*
			to display a list of jobs to the user, we call the get_jobs() function of the Jobs_model, passing to it any search string entered by the user, and storing the database result object in the $page_data array's item 'query'
			--
			we then pass the $page_data array to the views/jobs/view.php file:
			*/

			$page_data['query'] = $this->Jobs_model->get_jobs($this->input->post('search_string'));
			$this->load->view('templates/header');
			$this->load->view('nav/top_nav');
			$this->load->view('jobs/view', $page_data);
			$this->load->view('templates/footer');
		} else {
			$this->load->view('templates/header');
			$this->load->view('nav/top_nav');
			$this->load->view('jobs/view', $page_data);
			$this->load->view('templates/footer');
		}	
	} // end of index function



	/*
	the create function is a little more meaty: initially, we set out the form validation rules; but then just after, we call three model functions, get_categories, get_types, and get_locations, the results of which are stored in their own $save_data array items, and we will loop over these results in the view/jobs/create.php file and populate the HTML select dropdowns

	after this, we check whether the form has been submitted, and if so, whether it's been submitted with errors

	we build the form elements, specifying each element's settings and sending them in the $page_data array to the views/jobs/create.php view
	*/

	public function create(){

		// FORM VALIDATION RULES
		$this->form_validation->set_rules('job_title', $this->lang->line('job_title'), 'required|min_length[1]|max_length[125]');
		$this->form_validation->set_rules('job_desc', $this->lang->line('job_desc'), 'required|min_length[1]|max_length[3000]');
		$this->form_validation->set_rules('cat_id', $this->lang->line('cat_id'), 'required|min_length[1]|max_length[11]');
		$this->form_validation->set_rules('type_id', $this->lang->line('type_id'), 'required|min_length[1]|max_length[11]');
		$this->form_validation->set_rules('loc_id', $this->lang->line('loc_id'), 'required|min_length[1]|max_length[11]');
		$this->form_validation->set_rules('start_d', $this->lang->line('start_d'), 'min_length[1]|max_length[2]');
		$this->form_validation->set_rules('start_m', $this->lang->line('start_m'), 'min_length[1]|max_length[2]');
		$this->form_validation->set_rules('start_y', $this->lang->line('start_y'), 'min_length[1]|max_length[4]');
		$this->form_validation->set_rules('job_rate', $this->lang->line('job_rate'), 'required|min_length[1]|max_length[6]');
		$this->form_validation->set_rules('job_advertiser_name', $this->lang->line('job_advertiser_name'), 'required|min_length[1]|max_length[125]');
		$this->form_validation->set_rules('job_advertiser_email', $this->lang->line('job_advertiser_email'), 'min_length[1]|max_length[125]');
		$this->form_validation->set_rules('job_advertiser_phone', $this->lang->line('job_advertiser_phone'), 'min_length[1]|max_length[125]');
		$this->form_validation->set_rules('sunset_d', $this->lang->line('sunset_d'), 'min_length[1]|max_length[2]');
		$this->form_validation->set_rules('sunset_m', $this->lang->line('sunset_m'), 'min_length[1]|max_length[2]');
		$this->form_validation->set_rules('sunset_y', $this->lang->line('sunset_y'), 'min_length[1]|max_length[4]');


		// GET DROPDOWN FIELDS AND STORE IN PAGE_DATA
		$page_data['categories'] = $this->Jobs_model->get_categories();
		$page_data['types'] = $this->Jobs_model->get_types();
		$page_data['locations'] = $this->Jobs_model->get_locations();


		if ($this->form_validation->run() == FALSE) {
			$page_data['job_title'] = array('name' => 'job_title', 'class' => 'form-control', 'id' => 'job_title', 'value' => set_value('job_title', ''), 'maxlength' => '100', 'size' => '35');
			$page_data['job_desc'] = array('name' => 'job_desc', 'class' => 'form-control', 'id' => 'job_desc', 'value' => set_value('job_desc', ''), 'maxlength' => '3000', 'rows' => '6', 'cols' => '35');
			$page_data['start_d'] = array('name' => 'start_d', 'class' => 'form-control', 'id' => 'start_d', 'value' => set_value('start_d', ''), 'maxlength' => '100', 'size' => '35');
			$page_data['start_m'] = array('name' => 'start_m', 'class' => 'form-control', 'id' => 'start_m', 'value' => set_value('start_m', ''), 'maxlength' => '100', 'size' => '35');
			$page_data['start_y'] = array('name' => 'start_y', 'class' => 'form-control', 'id' => 'start_y', 'value' => set_value('start_y', ''), 'maxlength' => '100', 'size' => '35');
			$page_data['job_rate'] = array('name' => 'job_rate', 'class' => 'form-control', 'id' => 'job_rate', 'value' => set_value('job_rate', ''), 'maxlength' => '100', 'size' => '35');

			$page_data['job_advertiser_name'] = array('name' => 'job_advertiser_name', 'class' => 'form-control', 'id' => 'job_advertiser_name', 'value' => set_value('job_advertiser_name', ''), 'maxlength' => '100', 'size' => '35');
			$page_data['job_advertiser_email'] = array('name' => 'job_advertiser_email', 'class' => 'form-control', 'id' => 'job_advertiser_email', 'value' => set_value('job_advertiser_email', ''), 'maxlength' => '100', 'size' => '35');
			$page_data['job_advertiser_phone'] = array('name' => 'job_advertiser_phone', 'class' => 'form-control', 'id' => 'job_advertiser_phone', 'value' => set_value('job_advertiser_phone', ''), 'maxlength' => '100', 'size' => '35');
			$page_data['sunset_d'] = array('name' => 'sunset_d', 'class' => 'form-control', 'id' => 'sunset_d', 'value' => set_value('sunset_d', ''), 'maxlength' => '100', 'size' => '35');
			$page_data['sunset_m'] = array('name' => 'sunset_m', 'class' => 'form-control', 'id' => 'sunset_m', 'value' => set_value('sunset_m', ''), 'maxlength' => '100', 'size' => '35');
			$page_data['sunset_y'] = array('name' => 'sunset_y', 'class' => 'form-control', 'id' => 'sunset_y', 'value' => set_value('sunset_y', ''), 'maxlength' => '100', 'size' => '35');


			// load the views
			$this->load->view('templates/header');
			$this->load->view('nav/top_nav');
			$this->load->view('jobs/create', $page_data);
			$this->load->view('templates/footer');
			
		} else {
			// the data has passed validation and is stored in the $save_data array in preparation for saving to the database

			$save_data = array(
				'job_title' => $this->input->post('job_title'),
				'job_desc' => $this->input->post('job_desc'),
				'cat_id' => $this->input->post('cat_id'),
				'type_id' => $this->input->post('type_id'),
				'loc_id' => $this->input->post('loc_id'),
				'job_start_date' => $this->input->post('start_y') . '-' . $this->input->post('start_m') . '-' . $this->input->post('start_d'),
				'job_rate' => $this->input->post('job_rate'),
				'job_advertiser_name' => $this->input->post('job_advertiser_name'),
				'job_advertiser_email' => $this->input->post('job_advertiser_email'),
				'job_advertiser_phone' => $this->input->post('job_advertiser_phone'),
				'job_sunset_date' => $this->input->post('sunset_y') . '-' . $this->input->post('sunset_m') . '-' . $this->input->post('sunset_d')
			);


			// the $save_data array is then sent to the save_job function of Jobs_model, which will use set_flashdata
			// to generate a confirmation message if the save operation was successful or if an error was encountered

			if ($this->Jobs_model->save_job($save_data)) {
				$this->session->set_flashdata('flash_message', $this->lang->line('save_success_okay'));
				redirect ('jobs/create/');
			} else {
				$this->session->set_flashdata('flash_message', $this->lang->line('save_success_fail'));
				redirect ('jobs');
			}

		}
	} // end of create function



	/*
	apply function
	first define our form item validation rulees
	then check whether the form is being posted (submitted) or not-- we do this because the job ID can be passed to it in 2 ways

	1. the first way is using $this->uri->segment(3); the ID is passed to the apply function via the third uri segment if a user clicks on the Apply link or the job title in the views/jobs/view.php file

	2. the second way is $this->input->post('job_id'); the ID is passed to the apply function via the post array if the form has been submitted
		there is a hidden form element in the views/jobs/view.php file named job_id, the value of which is populated with the actual ID of the job being viewed
	*/

	public function apply() {

		$this->form_validation->set_rules('job_id', $this->lang->line('job_title'), 'required|min_length[1]|max_length[125]');
		$this->form_validation->set_rules('app_name', $this->lang->line('app_name'), 'required|min_length[1]|max_length[125]');
		$this->form_validation->set_rules('app_email', $this->lang->line('app_email'), 'required|min_length[1]|max_length[125]');
		$this->form_validation->set_rules('app_phone', $this->lang->line('app_phone'), 'required|min_length[1]|max_length[125]');
		$this->form_validation->set_rules('app_cover_note', $this->lang->line('app_cover_note'), 'required|min_length[1]|max_length[3000]');

		if ($this->input->post()) {
			$page_data['job_id'] = $this->input->post('job_id');
		} else {
			$page_data['job_id'] = $this->uri->segment(3);
		} // end if


		// we then test to see whether anything is returned
		// we use the num_rows() CodeIgniter function to see whether there are any rows in the returned database object
		// if there aren't, then we just set a flash message saying that the job is no longer available

		// if the job has been found, we pull out the data from the database and store it as local variables

		$page_data['query'] = $this->Jobs_model->get_job($page_data['job_id']);

		if ($page_data['query']->num_rows() == 1) {
			foreach ($page_data['query']->result() as $row) {
				$page_data['job_title'] = $row->job_title;
				$page_data['job_id'] = $row->job_id;

				// why isnt this in $page_data?
				$job_advertiser_name = $row->job_advertiser_name;
				$job_advertiser_email = $row->job_advertiser_email;
			}
		} else {
			$this->session->set_flashdata('flash_message', $this->lang->line('app_job_no_longer_exists'));
			redirect ('jobs');
		}

		/*
		we then move on to the form validation process: if this is the initial page view or if there were errors with the submit, then $this->form_validation->run() will have returned FALSE; if so, then we build our form items, defining their settings
		*/
		if ($this->form_validation->run() == FALSE) {
			$page_data['job_id'] = array('name' => 'job_id', 'class' => 'form-control', 'id' => 'job_id', 'value' => set_value('job_id', ''), 'maxlength' => '100', 'size' => '35');
			$page_data['app_name'] = array('name' => 'app_name', 'class' => 'form-control', 'id' => 'app_name', 'value' => set_value('app_name', ''), 'maxlength' => '100', 'size' => '35');
			$page_data['app_email'] = array('name' => 'app_email', 'class' => 'form-control', 'id' => 'app_email', 'value' => set_value('app_email', ''), 'maxlength' => '100', 'size' => '35');
			$page_data['app_phone'] = array('name' => 'app_phone', 'class' => 'form-control', 'id' => 'app_phone', 'value' => set_value('app_phone', ''), 'maxlength' => '100', 'size' => '35');
			$page_data['app_cover_note'] = array('name' => 'app_cover_note', 'class' => 'form-control', 'id' => 'app_cover_note', 'value' => set_value('app_cover_note', ''), 'maxlength' => '3000', 'rows' => '6', 'cols' => '35');


			// next pass our form items to the view, second argument $page_data
			$this->load->view('templates/header');
			$this->load->view('nav/top_nav');
			$this->load->view('jobs/apply', $page_data);
			$this->load->view('templates/footer');

			// if there was no error with the submit, then we will build an email to be sent to the advertiser of the job, to be sent to the email address contained in jobs.job_advertiser_email
		} else {
			/*
			we substitute variables sin the email using the str_replace() PHP function, replacing the variables with the details pulled from the database or form submit, such as the appicant's contact details and cover note
			*/

			$body = "Dear %job_advertiser_name%,\n\n";
			$body .= "%app_name% is applying for the position of %job_title%, \n\n";
			$body .= "The details of the application are:\n\n";
			$body .= "Applicant: %app_name%,\n\n";
			$body .= "Job Title: %job_title%,\n\n";
			$body .= "Applicant Email: %app_email%,\n\n";
			$body .= "Applicant Phone: %app_phone%,\n\n";
			$body .= "Cover Note: %app_cover_note%,\n\n";

			$body = str_replace('%job_advertiser_name%', $job_advertiser_name, $body);
			$body = str_replace('%app_name%', $this->input->post('app_name'), $body);
			$body = str_replace('%job_title%', $page_data['job_title'], $body);
			$body = str_replace('%app_email%', $this->input->post('app_email'), $body);
			$body = str_replace('%app_phone%', $this->input->post('app_phone'), $body);
			$body = str_replace('%app_cover_note%', $this->input->post('app_cover_note'), $body);


			/*
			if the email is sent successfully, we send a flash message to the applicant, informing them that their application has been sent (see following code)
			*/

			if (mail($job_advertiser_email, 'Application for ' . $page_data['job_title'], $body)) {
				$this->session->set_flashdata('flash_message', $this->lang->line('app_success_okay'));
			} else {
				$this->session->set_flashdata('flash_message', $this->lang->line('app_success_fail'));
			}
			redirect ('jobs/apply/'.$page_data['job_id']);
		}


	} // end of apply function


}
















