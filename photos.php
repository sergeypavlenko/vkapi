<?php
require('vkapi.php');
$VkApi = new VkApi();

if ($VkApi->isAuth()) {
	echo ('<a href="index.php">Главная</a><br />');
	echo ('<a href="logout.php">Выход</a><br />');
	
	$list = $VkApi->getMethod('photos.getAll', "&count=5");
	unset($list[0]);
	foreach ($list as $key => $val) {
		echo('<img src="' . $val->src_small . '" /><br />');
	}
} else {
	$VkApi->setRedirectUrl('http://example.com/photos.php');

	echo('<a href="#" onclick="location.href = \'' . $VkApi->getLink() . '\'">Вход через ВКонтакте</a>');
		
	if (isset($_GET['code'])) {
		if ($VkApi->token($_GET['code'])) {
			$VkApi->auth('photos.php');
		}
	}
}