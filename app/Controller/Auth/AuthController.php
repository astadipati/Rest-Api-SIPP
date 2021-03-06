<?php

namespace App\Controller\Auth;

use App\Models\User;
use App\Controller\Controller;
use Respect\Validation\Validator as v;

class AuthController extends Controller
{
	public function getSignUp($request, $response)
	{
		// csrf
		var_dump($request->getAttribute('csrf_value'));
		// var_dump($this->csrf->getTokenValueKey());
		// end csrf
		return $this->view->render($response, 'auth/signup.twig');
	}
	public function postSignUp($request, $response)
	{
		$validation = $this->validator->validate($request, [
				'email' => v::noWhitespace()->notEmpty()->email()->emailAvailable(),
				'name' => v::notEmpty()->alpha(),
				'password' => v::noWhitespace()->notEmpty(),
			]);
		if ($validation->failed()) {
			// redirect back
			return $response->withRedirect($this->router->pathFor('auth.signup'));
		}

		$user = User::create([
			'email' => $request->getParam('email'),
			'name' =>$request->getParam('name'),
			'password'=>password_hash($request->getParam('password'),PASSWORD_DEFAULT),
			]);
		// var_dump($request->getParams());

		return $response->withRedirect($this->router->pathFor('home'));
	}
	
}
