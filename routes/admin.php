<?php 

use core\app;

/*panel*/
app::get('/panel/admin', '/panel/index', 'admin', ['Panel']);

/*section*/
app::get('/panel/section/page/([0-9]+)', '/section/section', 'admin', ['Panel']);
app::get('/panel/section/show/([0-9]+)', '/section/show/([0-9]+)', 'admin', ['Panel']);
app::get('/panel/section/create', '/section/create', 'admin', ['Panel']);
app::post('/panel/section/create', '/section/sectionCreate', 'admin', ['Panel']);
app::get('/panel/section/update/([0-9]+)', '/section/update/([0-9]+)', 'admin', ['Panel']);
app::post('/panel/section/update', '/section/sectionUpdate', 'admin', ['Panel']);
app::get('/panel/section/delete/([0-9]+)', '/section/sectionDelete/([0-9]+)', 'admin', ['Panel']);
app::get('/panel/section/destroy/([0-9]+)', '/section/sectionDestroy/([0-9]+)', 'admin', ['Panel']);
app::get('/panel/section/status/([0-9]+)', '/section/SectionStatus/([0-9]+)', 'admin', ['Panel']);
app::get('/panel/section/search/key/(.*?)', '/section/sectionSearchEngine', 'admin', ['Panel']);
app::get('/panel/section/search/data/([0-9a-zA-Z-_]+)/([0-9a-zA-Z-_]+)/page/([0-9]+)', 
	'/section/sectionSearch/([0-9a-zA-Z-_]+)/([0-9a-zA-Z-_]+)', 'admin', ['Panel']);

/*Category*/
app::get('/panel/category/page/([0-9]+)', '/Category/Category', 'admin', ['Panel']);
app::get('/panel/category/show/([0-9]+)', '/Category/show/([0-9]+)', 'admin', ['Panel']);
app::get('/panel/category/create', '/Category/create', 'admin', ['Panel']);
app::post('/panel/category/create', '/Category/CategoryCreate', 'admin', ['Panel']);
app::get('/panel/category/update/([0-9]+)', '/Category/update/([0-9]+)', 'admin', ['Panel']);
app::post('/panel/category/update', '/Category/CategoryUpdate', 'admin', ['Panel']);
app::get('/panel/category/delete/([0-9]+)', '/Category/CategoryDelete/([0-9]+)', 'admin', ['Panel']);
app::get('/panel/category/destroy/([0-9]+)', '/Category/CategoryDestroy/([0-9]+)', 'admin', ['Panel']);
app::get('/panel/category/status/([0-9]+)', '/category/CategoryStatus/([0-9]+)', 'admin', ['Panel']);
app::get('/panel/category/search/key/(.*?)', '/Category/CategorySearchEngine', 'admin', ['Panel']);
app::get('/panel/category/search/data/([0-9a-zA-Z-_]+)/([0-9a-zA-Z-_]+)/page/([0-9]+)', 
	'/Category/CategorySearch/([0-9a-zA-Z-_]+)/([0-9a-zA-Z-_]+)', 'admin', ['Panel']);
app::get('/panel/categories/([0-9a-zA-Z-_\+]+)/page/([0-9]+)', 
'/category/BySection/([0-9a-zA-Z-_\+]+)', 'admin', ['Panel']);

/*profile*/
app::get('/panel/profile', '/profile/ProfileInfo', 'admin', ['Panel']);
app::post('/panel/profile/update', '/profile/profileUpdate', 'admin', ['Panel']);

/*article*/
app::get('/panel/article/page/([0-9]+)', '/article/article', 'admin', ['Panel']);
app::get('/panel/article/show/([0-9]+)', '/article/show/([0-9]+)', 'admin', ['Panel']);
app::get('/panel/articles/([0-9a-zA-Z-_\+]+)/([0-9a-zA-Z-_\+]+)/page/([0-9]+)', 
'/article/ByCategory/([0-9a-zA-Z-_\+]+)/([0-9a-zA-Z-_\+]+)', 'admin', ['Panel']);
app::get('/panel/article/create', '/article/create', 'admin', ['Panel']);
app::post('/panel/article/create', '/article/articleCreate', 'admin', ['Panel']);
app::get('/panel/article/update/([0-9]+)', '/article/update/([0-9]+)', 'admin', ['Panel']);
app::post('/panel/article/update', '/article/ArticleUpdate', 'admin', ['Panel']);
app::get('/panel/article/delete/([0-9]+)', '/article/ArticleDelete/([0-9]+)', 'admin', ['Panel']);
app::get('/panel/article/destroy/([0-9]+)', '/article/ArticleDestroy/([0-9]+)', 'admin', ['Panel']);
app::get('/panel/article/status/([0-9]+)', '/article/articleStatus/([0-9]+)', 'admin', ['Panel']);
app::get('/panel/article/search/key/(.*?)', '/article/ArticleSearchEngine', 'admin', ['Panel']);
app::get('/panel/article/search/data/([0-9a-zA-Z-_]+)/([0-9a-zA-Z-_]+)/page/([0-9]+)', 
	'/article/ArticleSearch/([0-9a-zA-Z-_]+)/([0-9a-zA-Z-_]+)', 'admin', ['Panel']);

/*setting*/
app::get('/panel/setting/page/([0-9]+)', '/setting/setting', 'admin', ['Panel']);
app::get('/panel/setting/show/([0-9]+)', '/setting/show/([0-9]+)', 'admin', ['Panel']);
app::get('/panel/setting/update/([0-9]+)', '/setting/update/([0-9]+)', 'admin', ['Panel']);
app::post('/panel/setting/update', '/setting/settingUpdate', 'admin', ['Panel']);
app::get('/panel/setting/search/key/(.*?)', '/setting/settingSearchEngine', 'admin', ['Panel']);
app::get('/panel/setting/search/data/([0-9a-zA-Z-_]+)/([0-9a-zA-Z-_]+)/page/([0-9]+)', 
	'/setting/settingSearch/([0-9a-zA-Z-_]+)/([0-9a-zA-Z-_]+)', 'admin', ['Panel']);

/*guest*/
app::get('/panel/guest/page/([0-9]+)', '/guest/guest', 'admin', ['Panel']);
app::get('/panel/guest/show/([0-9]+)', '/guest/show/([0-9]+)', 'admin', ['Panel']);
app::get('/panel/guest/delete/([0-9]+)', '/guest/guestDelete/([0-9]+)', 'admin', ['Panel']);
app::get('/panel/guest/destroy/([0-9]+)', '/guest/guestDestroy/([0-9]+)', 'admin', ['Panel']);
app::get('/panel/guest/search/key/(.*?)', '/guest/guestSearchEngine', 'admin', ['Panel']);
app::get('/panel/guest/search/data/([0-9a-zA-Z-_\.]+)/([0-9a-zA-Z-_\.]+)/page/([0-9]+)', 
	'/guest/guestSearch/([0-9a-zA-Z-_\.]+)/([0-9a-zA-Z-_\.]+)', 'admin', ['Panel']);
