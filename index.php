<?php
require('vkapi.php');
$VkApi = new VkApi();
$VkApi->setScope('photos');

if ($VkApi->isAuth()) {
	$info = $VkApi->getMethod('getProfiles');
	echo('Здравствуйте, ' . $info[0]->first_name . ' ' .  $info[0]->last_name . '!<br />');
	echo ('<a href="photos.php">Фотографии</a><br />');
	echo ('<a href="logout.php">Выход</a><br />');
} else {
	echo('<a href="#" onclick="location.href = \'' . $VkApi->getLink() . '\'">Вход через ВКонтакте</a>');
		
	if (isset($_GET['code'])) {
		if ($VkApi->token($_GET['code'])) {
			$VkApi->auth('index.php');
		}
	}
}