Плагин "Ad units" (версия 1.0.0) для LiveStreet 0.4.2

Распространяется бесплатно.
Автор: Бишовец Николай (netlanc)
Связаться можно на сайте http://netlanc.net/ либо в личке на http://livestreet.ru/ (netlanc)

ОПИСАНИЕ

Добавляет пользователям возможность размещать на сайте рекламные блоки на страницах своих блогов и топиков в виде ссылок, банеров, медиа контента.
Призван стимулировать пользователей писать хорошие топики на сайте.
Есть возможность размещения рекламы в различных местах сайта (над шапкой, под футером, в начале и конце контента, в отдельный блок "Реклама").
Если пользователь не добавил рекламные блоки - тогда выводятся блоки админа (пользователя с id = 1)

НАСТРОЙКИ

Файл /plugins/localflv/config/config.php:

    /* включение/отключение возможности размещать рекламу всем пользователям: all - для всех, admin - только для админов*/
    Config::Set('config.adunits.permit.user', 'all');

УСТАНОВКА

1. Скопировать содержимое врхива в каталог /plugins/
2. Через панель управления плагинами (/admin/plugins/) запустить его активацию.
3. При успешной акитивации

      - в БД добавится таблица prefix_adunits из /plugins/adunits/dump.sql

  в противном случае выполните sql-запрос из файла /plugins/adunits/dump.sql
  CREATE TABLE `prefix_adunits` (
    `adunits_id` int(11) NOT NULL auto_increment,
    `user_id` int(11) NOT NULL,
    `adunits_code` longtext character set utf8,
    `adunits_setting` text character set utf8,
    `adunits_setting_more` longtext character set utf8,
    `adunits_date_add` datetime NOT NULL,
    `adunits_date_edit` datetime NOT NULL,
    PRIMARY KEY  (`adunits_id`)
  ) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

УДАЛЕНИЕ

1. Через панель управления плагинами (/admin/plugins/) запустить деактивацию

для жаждущих оказать матподдержку на развитие плагина сообщаю координаты для донейта:
Wm
R111527346489
Z370370411130
E104398793342
U233436054036

яШа дЕньги
41001382110646
