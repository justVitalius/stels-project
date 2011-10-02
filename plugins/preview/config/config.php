<?php

/*-------------------------------------------------------
*
*   LsMods Developer Team
*   Author: Yuriy Sergeev aka randomtoy
*   Visit us: http://lsmods.ru
---------------------------------------------------------
*/
$config=array();

//Топик обязательно должен использовать превью: true, false
$config['topic_allways_use_preview'] = false;

//Конвертация аватаров из версии 0.3 при активации
//$config['convert'] = false;  //включить $config['convert'] = true;

//Обрезать с сохранением пропорций
//$config['preview_use_proportion'] = true;

//вписывать картинку в размер. true = вписывать, false = обрезать квадратом. используется при $config['preview_use_proportion'] = false;
$config['preview_use_proportion'] = false;
$config['preview_no_crop'] = false;

/*
 * Cписок размеров аватаров у превью, двумерный массив
 * вида размер1(90x40),размер2(50x30)
 */
$config['preview_size'] = array(array(590,360),array(280,280),array(120,90),array(50,30));

return $config;
?>
