<?php 
/**
 * @file
 * Contains \Drupal\username_exists\Form\AjaxCheckUsernameForm
 */
 
namespace Drupal\username_exists\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Ajax\AjaxResponse;
use Drupal\Core\Ajax\HtmlCommand;

class AjaxCheckUsernameForm extends FormBase{
	/**
	 * {@inheritdoc}
	 */
	public function getFormId(){
		return 'check_username_exist';
	}
	
	/**
	 * {@inheritdoc}
	 */
	public function buildForm(array $form, FormStateInterface $form_state){
		$form['username'] = [
			'#type' => 'textfield',
			'#title' => t('Check Username *'),
			'#maxlength' => 30,
			'#size' => 50,
			'#ajax' => [
				'callback' => '::checkUserName',
				'event' => 'change',
				'effect' => 'fade',
				'progress' => [
					'type' => 'bar',
					'message' => 'Checking username...',
				],
			],
			'#suffix' => '<div id="result_message"></div>',
		];
		
		return $form;
	}
	
	/**
	 * {@inheritdoc}
	 */
	public function checkUserName(array $form, FormStateInterface $form_state){
		$ajax_response = new AjaxResponse();
		//Array of existing username.
		$usernameArray =['username1', 'username2', 'username3'];
		
		$username_value = $form_state->getValue('username');
		//Check username value in $usernameArray
		if(in_array($username_value, $usernameArray)){
			$response_message ='Username already taken.';
		}else{
			$response_message ='Username available.';
		}
		
		$response = $ajax_response->addCommand(new HtmlCommand('#result_message', $response_message));
		return $response;
	}
	
	/**
	 * {@inheritdoc}
	 */
	public function submitForm(array &$form, FormStateInterface $form_state){
		
	}
		
}
