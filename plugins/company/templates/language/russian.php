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
 * Русский языковой файл для плагина "company" 
 */
return array(
	/**
	 * Компании
	 */
	'companies' => 'Компании',
	'companies_my' => 'Мои компании',
	'blog_menu_company' => 'Корпоративные',
	'company_edit' => 'редактировать компанию',
	'company_add_topic' => 'написать в блог',
	'company_delete' => 'удалить компанию',
	/* Меню компаний*/
	'company_menu_profile' => 'Профиль',
	'company_menu_vacancies' => 'Вакансии',
	'company_menu_feedbacks' => 'Отзывы',
	'company_menu_blog' => 'Блог',
	'company_menu_users' => 'Пользователи',
	'company_menu_create' => 'Создать компанию',
	'company_feedback_acl' => 'Ваш рейтинг слишком мал для написания отзывов',
	'company_feedback_add_text_error' => 'Текст отзыва должен быть от 2 до 5000 символов и не содержать запрещенные теги',
	
	/* Компании */

	'company_blog_prefix' => 'Блог компании',
	/* header.company.tpl */
	'company_rating' => 'Рейтинг',
	'company_vote_count' => 'голосов',
	'company_activate' => 'активировать',
	'company_deactivate' => 'деактивировать',	

	/* index.tpl */
	'company_info_legalname' => 'Юр. наименование',
	'company_info_description' => 'О себе',
	'company_info_tags' => 'Деятельность',
	'company_info_site' => 'Сайт',
	'company_info_email' => 'Почта',
	'company_info_phone' => 'Телефоны',
	'company_info_fax' => 'Факс',
	'company_info_place' => 'Откуда',
	'company_info_boss' => 'Руководитель',
	'company_info_datebasis' => 'Дата основания',
	'company_info_countworkers' => 'Штат сотрудников',
	'company_info_admins' => 'Администраторы',
	'company_info_moderators' => 'Модераторы',
	'company_info_moderators_empty' => 'Модераторов здесь не замеченно',
	'company_info_employes' => 'Сотрудники',
	'company_info_employes_empty' => 'Сотрудников здесь не замеченно',
	'company_info_admirers' => 'Поклонники',
	'company_info_admirers_empty' => 'Поклонников здесь не замеченно',

	/* add.tpl */
	'company_add_header' => 'Создание новой компании',
	'company_add_name' => 'Наименование компании',
	'company_add_name_note' => 'Напишите название компании, по которому вашу компанию узнают.',
	'company_add_url' => 'URL компании',
	'company_add_url_note' => 'Название компании на латынице по которому она будет доступна на нашем сайте (сайт.ру/company/URL), по смыслу должно совпадать с названием компании и быть на латинице. Пробелы заменяться на "_". Внимание! URL нельзя изменить после создания компании!',
	'company_add_description' => 'Краткое описание компании',
	'company_add_description_note' => 'Напиште о компании, то что заинтересует клиента и даст понять, что ваша компания из себя представляет. Ограничение 255 символов.',
	'company_add_tags' => 'Виды деятельности',
	'company_add_tags_note' => 'Метки нужно разделять запятой. Например: <i>недвижимость</i>, <i>IT</i>, <i>SEO</i>, <i>аренда</i>, <i>окна</i>, <i>доставка</i>.',
	'company_add_place' => 'Местоположение компании',
	'company_add_place_note' => 'Укажите где находится ваша компания',
	'company_add_place_country' => 'Страна',
	'company_add_place_city' => 'Город',
	'company_add_submit' => 'Зарегистрировать',
	
	/* edit.tpl */
	'company_edit_header' => 'Создание новой компании',
	'company_edit_legalname' => 'Юридическое наименование компании',
	'company_edit_legalname_note' => 'Напишите название компании по юридическим документам.',
	'company_edit_description' => 'О себе',
	'company_edit_description_note' => 'О себе',
	'company_edit_address' => 'Адрес',
	'company_edit_site' => 'Сайт',
	'company_edit_site_note' => 'Укажите адрес сайта вашей компании.',
	'company_edit_email' => 'Адрес электронной почты',
	'company_edit_email_note' => 'Укажить адрес на который клиенты будут отправлять письма.',
	'company_edit_phone' => 'Телефоны',
	'company_edit_phone_note' => 'Укажите контактные телефоны. В формате (код горда)телефон, телефон. Например: (495)3334445, 5553334',
	'company_edit_fax' => 'Факс',
	'company_edit_fax_note' => 'Если есть, укажите номер факса.',
	'company_edit_boss' => 'Руководитель компании',
	'company_edit_boss_note' => 'Кто же у вас главный?',
	'company_edit_datebasis' => 'Дата основания компании',
	'company_edit_datebasis_note' => 'Укажите когда была создана компания, по юридическим документам.',
	'company_edit_countworkers' => 'Штат сотрудников компании',
	'company_edit_countworkers_note' => 'Укажите примерное число работников в компании',
	'company_edit_vacancy' => 'Вакансии компании',
	'company_edit_vacancy_note' => 'Напиште какие сотрудники вам требуются. Ограничение 70000 символов.',
	'company_edit_logo' => 'Логотип',
	'company_edit_logo_delete' => 'удалить',
	'company_edit_submit' => 'Сохранить изменения',

	/* admin.tpl */
	'company_users_header' => 'Редактирование компании',
	'company_users_admin' => 'администратор',
	'company_users_moderator' => 'модератор',
	'company_users_employe' => 'сотрудник',
	'company_users_admirer' => 'поклонник',
	'company_users_isadmin' => 'это вы &mdash; настоящий администратор!',
	'company_users_isowner' => 'это создатель компании.',
	'company_users_note' => 'После нажатия на кнопку &laquo;Сохранить изменения&raquo;, права пользователей будут сохранены',
	'company_users_replaceowner' => 'Я находясь в трезвом уме и светлой памяти, хочу передать права на компанию, пользователю',
	'company_users_replaceowner_submit' => 'Передать',
	'company_users_submit' => 'Сохранить изменения',
	'company_users_onlyone' => 'Пока в компании только вы.',
	
	/* companies.tpl */
	'company_companies_header' => 'Лучшие компании',

	/* feedbacks.tpl */
	'company_feedbacks_title' => 'Отзывы',
	'company_feedbacks_was_delete' => 'отзыв был удален',
	'company_feedbacks_add' => 'Отозваться',
	/* company_list */
	'company_feedbacks_write_feedback' => 'написать отзыв',
	'company_feedbacks_read_feedback' => 'читать отзывы',
	'company_notfound_companies' => 'Таких компаний еще не появилось.',


	/* vacancies.tpl */
	'company_vacancies_title' => 'Вакансии компании',
	'company_vacancies_empty' => 'В настоящий момент вакансий не найдено.',

	/* whois.tpl */
	'company_is_work' => 'Работаю',
	'company_is_like' => 'Нравится',

	/* menu.profile.tpl */
	'company_pub_feedback' => 'Отзывы',

	/* Заголовки окон */
	'company_title_add' => 'Добавление компании',
	'company_title_edit' => 'Редактирование компании',
	'company_title_edit_users' => 'Редактирование пользователей компании',
	'company_title_view_blogs' => 'Блоги компаний',
	'company_title_view_profile' => 'Профиль компании',
	'company_title_view_blogs' => 'Блоги компаний',


	/* Ошибки */
	
	'company_error_write_company_blog' => 'Для того чтобы сюда писать нужно быть в этой компании!',
	'company_error_lowrating' => 'Вы еще не достаточно окрепли чтобы зарегистрировать компанию.',
	'company_error_add_name_text' => 'Наименование компании должно быть от 2 до 255 символов.',
	'company_error_add_name_exsist' => 'Компания с таким названием уже существует',
	'company_error_add_url_text' => 'URL компании должен быть от 4 до 50 символов и только на латинице + цифры и знаки "-", "_"',
	'company_error_add_url_bad' => 'URL компании должен отличаться от',
	'company_error_add_url_exsist' => 'Такой URL компании уже есть.',
	'company_error_add_description_text' => 'Текст описания компании должен быть от 10 до 255 символов',
	'company_error_edit_load_logo' => 'Не удалось загрузить логотип',
	'company_error_edit_email' => 'Неверный формат e-mail',
	'company_error_edit_countworkers' => 'Не шалите, столько не было в списке сотрудников',
	'company_error_edit_tags' => 'Проверьте правильность видов деятельности',
	'company_feedback_acl' => 'Ваш рейтинг слишком мал для написания отзывов',
	'company_feedback_add_text_error' => 'Текст отзыва должен быть от 2 до 3000 символов и не содержать левые теги',
	

	'company_notice_edit_profile' => 'Профиль успешно сохранён',
	'company_notice_edit_users' => 'Права сохранены',
	'company_notice_edit_users_owner' => 'У компании теперь новый владелец',
	

	'company_notice_feedback_colapce' => 'Отзыв свернут',
	'company_notice_feedback_expand' => 'Отзыв развернут',
	'company_notice_feedback_deleted' => 'Отзыв удален',
	'company_notice_feedback_repaired' => 'Отзыв восстановлен',
	'company_error_feedback_edit' => 'Возникли проблемы при изменении отзыва!',
	'company_error_feedback_notfound' => 'Отзыв не найден',
	'company_error_notfound' => 'Компания не найдена',
	'company_notice_voted' => 'Вы уже голосовали за эту компанию!',
	'company_notice_voted_owner' => 'Вы не можете голосовать за свою компанию!',
	'company_notice_voted_notfound' => 'Вы голосуете за несуществующую компанию!',
	'company_notice_join' => 'Вы теперь в компании',
	'company_notice_leave' => 'Вы покинули компанию',
	'company_notice_join_owner' => 'Зачем вы хотите вступить в эту компанию? Вы и так ее хозяин!',



	'company_congratulation' => 'Ура',
	'company_attention' => 'Внимание!',

	'company_vote_ok' => 'Ваш голос учтен',
	'company_vote_after' => 'Попробуйте проголосовать позже',
	'company_vote_values' => 'Голосовать можно только +1 либо -1!',
	'company_vote_acl' => 'У вас не хватает рейтинга и силы для голосования!',

	'company_email_hide' => 'Только зарегистрированные пользователи могут видеть электропочту',

	'company_profile_menu_companies' => 'Компании',


	/**
	 * Блоки
	 */
	'block_company' => 'Компании',
	'block_company_rating' => 'Рейтинг',
	'block_company_allcompanies' => 'все компании',
	'block_company_tags' => 'Страны',
	'block_stream_feedbacks' => 'Отзывы',
	'block_companiesincity' => 'Компании в городе',

);

?>