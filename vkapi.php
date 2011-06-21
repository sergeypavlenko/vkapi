<?php

session_start();

class VkApi {
	private $appId = 'id';
	private $secretKey = 'key';
	private $redirectUrl = 'http://example.com/vkapi/';
	
	public $token;
	
	public function setRedirectUrl($url) {
		$this->redirectUrl = $url;
	}
	
	public function setScope() {
		$scope = func_get_args();
		if (!empty($scope)) {
			$this->scope = ('&scope=' . implode($scope, ','));
		}
	}
	
	public function getLink() {
		return ('http://api.vk.com/oauth/authorize?client_id=' . $this->appId . '&redirect_uri=' . $this->redirectUrl . '&display=page' . (isset($this->scope) ? $this->scope : NULL));
	}
	
	public function isAuth() {
		if (isset($_SESSION['user_id'], $_SESSION['access_token'])) {
			$this->token->user_id = $_SESSION['user_id'];
			$this->token->access_token = $_SESSION['access_token'];
			
			return TRUE;
		} else {
			return FALSE;
		}
	}
	
	public function auth($url) {
		$_SESSION['user_id'] = $this->token->user_id;
		$_SESSION['access_token'] = $this->token->access_token;
		header('location: ' . $url);
	}
	
	public function logout() {
		unset($_SESSION['user_id'], $_SESSION['access_token']);
		header('location: index.php');
	}
	
	public function token($key) {
		$response = file_get_contents('https://api.vk.com/oauth/access_token?client_id=' . $this->appId . '&code=' . $key . '&client_secret=' . $this->secretKey);
		$this->token = json_decode($response);
		return (isset($this->token->access_token) ? TRUE : FALSE);
	}
	
	public function getMethod($name, $param = null) {
		$response = file_get_contents('https://api.vkontakte.ru/method/' . $name . '?uids=' . $this->token->user_id . '&access_token=' . $this->token->access_token . $param);
		$result = json_decode($response);
		return $result->response;
	}
}