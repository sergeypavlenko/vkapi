<!doctype html>
<meta charset=utf-8 />

<?php
/**
 * Работа с API Вконтакте, на примере получения профиля пользователся
 * by Ilya Shalyapin, www.coderiver.ru
 */
 
  
/**
 * Поддержка OAuth 2.0 платформой ВКонтакте:
 * http://habrahabr.ru/blogs/social_networks/117211/?utm_source=twitterfeed&utm_medium=twitter
 * 
 * Диалог авторизации OAuth
 * http://vkontakte.ru/developers.php?o=-1&p=%C0%E2%F2%EE%F0%E8%E7%E0%F6%E8%FF%20%F1%E0%E9%F2%EE%E2
 * http://vkontakte.ru/developers.php?o=-1&p=%C4%E8%E0%EB%EE%E3%20%E0%E2%F2%EE%F0%E8%E7%E0%F6%E8%E8%20OAuth
 * 
 * Описание метода getProfiles:
 * http://vkontakte.ru/developers.php?o=-1&p=getProfiles
 * 
 * Выполнение запросов к API:
 * http://vkontakte.ru/developers.php?o=-1&p=%C2%FB%EF%EE%EB%ED%E5%ED%E8%E5%20%E7%E0%EF%F0%EE%F1%EE%E2%20%EA%20API
 * 
 * Open API:
 * http://vkontakte.ru/pages.php?o=-1&p=Open+API
 * 
 * Добавление приложения ВКонтакте
 * http://vkontakte.ru/apps.php?act=add
 */ 



/**
 * $APP_ID - идентификатор вашего приложения ВКонтакте
 * $SECRET - секретный код приложения
 * $REDIRECT_URI - урл к данному файлу, домен должен быть прописан в настроках приложения ВКонтакте
 */  

$APP_ID = '1111111';  
$SECRET = 'sdfga4dsafserwq234432';
$REDIRECT_URI = 'http://example.com/vkauth.php';
?>


<script>
function vkauth(){
    /** Перенаправляем на страницу авторизации ВКонтакте */
    location.href = 'http://api.vk.com/oauth/authorize?client_id=<?php echo $APP_ID;?>&redirect_uri=<?php echo $REDIRECT_URI;?>&display=page';
}
</script>
<a href="#" onclick="vkauth();" >Вход через ВКонтакте</a>

<?php

if ($code = $_GET['code']){
    /** Получаем access_token для работы с API */
    $resp1 = file_get_contents('https://api.vk.com/oauth/token?client_id='.$APP_ID.'&code='.$code.'&client_secret='.$SECRET);    
    $data1 = json_decode($resp1);    
    if ($data1->access_token) {
       // работа с API
       
       /** Получаем профиль пользователя */
       $resp2 = file_get_contents('https://api.vkontakte.ru/method/getProfiles?uids='.$data1->user_id.'&access_token='.$data1->access_token); 
       $data2 = json_decode($resp2);
       $name = $data2->response[0]->first_name.' '.$data2->response[0]->last_name;
       var_dump($name);
    }else{
       var_dump($data1);
    }        
}
