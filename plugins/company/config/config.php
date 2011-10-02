<?
/*-------------------------------------------------------
*
*   LiveStreet Engine Social Networking
*   Copyright © 2008 Mzhelskiy Maxim
*
*--------------------------------------------------------
*
*   Official site: www.livestreet.ru
*   Contact e-mail: rus.engine@gmail.com
*
*   GNU General Public License, version 2:
*   http://www.gnu.org/licenses/old-licenses/gpl-2.0.html
*
---------------------------------------------------------
*/

/**
 * Конфиг модуля "company" - Компании
 */
Config::Set('acl.vote.company.rating', -1); 		// порог рейтинга при котором юзер может голосовать за компанию
Config::Set('acl.create.feedback.rating', -5);		// порог рейтинга при котором юзер может добавлять отзыв
Config::Set('acl.create.company.rating', 0);		// порог рейтинга при котором пользователь может создать компанию

Config::Set('module.company.per_page', 9); 			// количество компаний на странице
Config::Set('module.company.on_block', 20);			// количество отображаемое в блоке
Config::Set('module.company.use_jobs', true);		// используется ли модуль Работа
Config::Set('module.company.topic_on_index', true);	// выводить все новые топики из КБ на главную
Config::Set('module.company.prefix', 'company'); 		// префикс для компаний
Config::Set('module.company.url', '___path.root.web___/___module.company.prefix___'); 
Config::Set('module.company.template_path', '___module.company.path___/templates/skin/default');
Config::Set('module.company.use_activate', false);		// используется премодерация компаний
Config::Set('module.company.use_convert_url', false);		// используется ли автоматическое создание URL по названию компании
// настройки загрузки логотипа
$config['module']['image']['company_logo']['jpg_quality']		= 100;
$config['module']['image']['company_logo']['watermark_use']		= false;
$config['module']['image']['company_logo']['round_corner']		= false;

// настройки руотинга
Config::Set('router.page.company', 'PluginCompany_ActionCompany'); 
Config::Set('router.page.companytag', 'PluginCompany_ActionCompanyTag');

// если поменяли префикс то подменяем ссылки действий
if (Config::Get('module.company.prefix') != 'company'){
	Config::Set('router.rewrite.company', '___module.company.prefix___'); 
	Config::Set('router.rewrite.companytag', '___module.company.prefix___tag');
}

Config::Set('db.table.company', 			'___db.table.prefix___company');
Config::Set('db.table.company_user', 		'___db.table.prefix___company_user');
Config::Set('db.table.company_tag', 		'___db.table.prefix___company_tag');
Config::Set('db.table.company_vote', 		'___db.table.prefix___company_vote');
Config::Set('db.table.company_country', 	'___db.table.prefix___company_country');
Config::Set('db.table.company_city', 		'___db.table.prefix___company_city');
Config::Set('db.table.company_feedback_read', '___db.table.prefix___company_feedback_read');



?>