<?php
$config['menu_default_links_color'] = '#90ee90';

$config['menu_categories'] = [
	MENU_CATEGORY_NEWS => ['id' => 'news', 'name' => 'Notícias'],
	MENU_CATEGORY_ACCOUNT => ['id' => 'account', 'name' => 'Conta'],
	MENU_CATEGORY_COMMUNITY => ['id' => 'community', 'name' => 'Comunidade'],
	MENU_CATEGORY_FORUM => ['id' => 'forum', 'name' => 'Fórum'],
	MENU_CATEGORY_LIBRARY => ['id' => 'library', 'name' => 'Biblioteca'],
	MENU_CATEGORY_SHOP => ['id' => 'shops', 'name' => 'Loja']
];

$config['menus'] = require __DIR__ . '/menus.php';
