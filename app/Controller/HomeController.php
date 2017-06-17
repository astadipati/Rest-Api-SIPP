<?php

namespace App\Controller;

// use App\Models\User;  
use Slim\Views\Twig as View;

class HomeController extends Controller
{
	// protected $view; //ini dipindahkan ke Controller
	// public function __construct (View $view)
	// {
	// 	$this->view = $view;
	// }
	public function index($request, $response)
	{
		// User::create([
		// 	'name' => 'Kenshin',
		// 	'email' => 'kensin@kenshin.com',
		// 	'password' => '139',
		// 	]);
		// $user = User::where('email','rama@rama.com')->first();
		// var_dump($user->email);
		// $user = $this->db->table('users')->find(1);
		// var_dump($user->email); 
		// die();
		return $this->view->render($response, 'home.twig');

	}
}
