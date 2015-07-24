<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
| -------------------------------------------------------------------------
| URI ROUTING
| -------------------------------------------------------------------------
| This file lets you re-map URI requests to specific controller functions.
|
| Typically there is a one-to-one relationship between a URL string
| and its corresponding controller class/method. The segments in a
| URL normally follow this pattern:
|
|	example.com/class/method/id/
|
| In some instances, however, you may want to remap this relationship
| so that a different class/function is called than the one
| corresponding to the URL.
|
| Please see the user guide for complete details:
|
|	http://codeigniter.com/user_guide/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There area two reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router what URI segments to use if those provided
| in the URL cannot be matched to a valid route.
|
*/
/*$route['url_request'] = 'controller path' */
$route['default_controller'] = "site";

/* site controller routes */
$route['home'] = 'site/home';
$route['about'] = 'site/about';
$route['help'] = 'site/help';
$route['privacy'] = 'site/privacy';
$route['advertise'] = 'site/advertise';
$route['feedback'] = 'site/feedback';
$route['login'] = 'site/login';
$route['register'] = 'site/register';
$route['logout'] = 'site/logout';

/* users controller routes*/
$route['profile'] = 'users/index';
$route['profile/edit']='users/edit';
$route['profile/view_information']='users/view_information';
$route['profile/view_contact']='users/view_contact';
$route['profile/edit_information']='users/edit_information';
$route['profile/edit_contact']='users/edit_contact';
$route['profile/save']='users/save';

$route['profile/(:any)'] = 'users/index/$1';
$route['forgot'] = 'users/forgot';
$route['followers'] = 'users/followers';
$route['followers/(:any)'] = 'users/followers/$1';
$route['following'] = 'users/following';
$route['following/(:any)'] = 'users/following/$1';
$route['shelf']='users/shelf';
$route['shelf/(:any)']='users/shelf/$1';
$route['wishlist']='users/wishlist';
$route['wishlist/(:any)']='users/wishlist/$1';
$route['users/load_user_pic_uploader']='users/load_user_pic_uploader';
$route['users/update_profile_picture']='users/update_profile_picture';
$route['users/save_lat_lon']='users/save_lat_lon';
/* group controller routes*/
$route['groups']='groups/index';
/* books controller routes*/
$route['book'] = 'books/index';
$route['book/(:any)'] = 'books/index/$1';
/* authors controller routes*/
$route['author'] = 'authors/index';
$route['author/(:any)'] = 'authors/index/$1';
/* publishers controller routes*/
$route['publisher'] = 'publishers/index';
$route['publisher/(:any)'] = 'publishers/index/$1';
/* status controller routes*/
$route['post'] = 'statuses/post';
$route['load/posts/(:num)/(:num)'] = 'statuses/loadContent/$1/$2';
$route['posts/(:any)'] = 'statuses/show_post/$1';
$route['post/delete'] = 'statuses/delete';

/* search controller routes*/
$route['search'] = 'searches/index';
$route['get_suggested_searches'] = 'searches/get_suggestions';
$route['search/books'] = 'searches/books';
$route['search/authors'] = 'searches/authors';
$route['search/publishers'] = 'searches/publishers';
$route['search/book/(:num)/(:any)'] = 'searches/nearest_users/$1/$2';
$route['list/owners/(:num)/(:any)/(:num)/(:num)'] = 'searches/load_nearest_users/$1/$2/$3/$4';
$route['search/results/(:any)/(:any)/(:num)/(:num)'] = 'searches/get_results/$1/$2/$3/$4';
$route['search/(:any)'] = 'searches/index';

/* folllow and unfollow routes*/
$route['user/follow'] = 'users/follow';
$route['user/unfollow'] = 'users/unfollow';
/* messages controller routes*/
$route['messages/load_message_panel'] = 'messages/load_message_panel';
$route['messages/load_compose_panel'] = 'messages/load_compose_panel';
$route['messages/send'] = 'messages/send_message';
$route['messages/send/(:any)'] = 'messages/send_message/$1';
$route['messages/show/(:any)'] = 'messages/show/$1';


/* notification controller routes*/
$route['notifications'] = 'notifications/index';
$route['check_notification'] = 'notifications/check_new';

/* borrow controller routes*/
$route['borrows'] = 'borrows/index';
$route['borrow/request'] = 'borrows/insert';
$route['borrow/approve/(:any)'] = 'borrows/approve/$1';
$route['borrow/ignore/(:any)'] = 'borrows/ignore/$1';
$route['borrow/cancel/(:any)'] = 'borrows/cancel/$1';
$route['borrow/load/sent/(:num)/(:num)'] = 'borrows/loadsent/$1/$2';
$route['borrow/load/received/(:num)/(:num)'] = 'borrows/loadreceived/$1/$2';

/* comments controller routes*/
$route['showcomments/(:any)'] = 'comments/get_all_comments/$1';
$route['post/comment'] = 'comments/set_comment';

/* like controller routes */
$route['like/(:any)'] = 'likes/like_post/$1';
$route['unlike/(:any)'] = 'likes/unlike_post/$1';

/* like controller routes */
$route['post/review'] = 'reviews/set_review';

/* admin default controller routes */
$route['admin'] = 'admin/defaultController/index';
/* admin books controller routes */
$route['admin/books'] = 'admin/books/index';
$route['admin/books/insert'] = 'admin/books/insert';
$route['admin/books/view/(:num)'] = 'admin/books/view/$1';
$route['admin/books/update'] = 'admin/books/update/$1';
$route['admin/books/update/(:num)'] = 'admin/books/update/$1';
$route['admin/books/delete'] = 'admin/books/delete';
/* admin genres controller routes */
$route['admin/genres'] = 'admin/genres/index';
$route['admin/genres/(:num)'] = 'admin/genres/index/$1';
$route['admin/genres/insert'] = 'admin/genres/insert';
$route['admin/genres/view/(:num)'] = 'admin/genres/view/$1';
$route['admin/genres/update'] = 'admin/genres/update/$1';
$route['admin/genres/update/(:num)'] = 'admin/genres/update/$1';
$route['admin/genres/delete'] = 'admin/genres/delete';
/* admin users controller routes */
$route['admin/users'] = 'admin/users/index';
$route['admin/users/(:num)'] = 'admin/users/index/$1';
$route['admin/users/view/(:num)'] = 'admin/users/view/$1';
$route['admin/users/insert'] = 'admin/users/insert';
$route['admin/users/update'] = 'admin/users/update/$1';
$route['admin/users/update/(:num)'] = 'admin/users/update/$1';
$route['admin/users/delete'] = 'admin/users/delete';
/* admin publishers controller routes */
$route['admin/publishers'] = 'admin/publishers/index';
$route['admin/publishers/(:num)'] = 'admin/publishers/index/$1';
$route['admin/publishers/insert'] = 'admin/publishers/insert';
$route['admin/publishers/view/(:num)'] = 'admin/publishers/view/$1';
$route['admin/publishers/update'] = 'admin/publishers/update/$1';
$route['admin/publishers/update/(:num)'] = 'admin/publishers/update/$1';
$route['admin/publishers/delete'] = 'admin/publishers/delete';
/* admin authors controller routes */
$route['admin/authors'] = 'admin/authors/index';
$route['admin/authors/(:num)'] = 'admin/authors/index/$1';
$route['admin/authors/insert'] = 'admin/authors/insert';
$route['admin/authors/view/(:num)'] = 'admin/authors/view/$1';
$route['admin/authors/update'] = 'admin/authors/update/$1';
$route['admin/authors/update/(:num)'] = 'admin/authors/update/$1';
$route['admin/authors/delete'] = 'admin/authors/delete';

$route['(:any)'] = 'site/index';
$route['404_override'] = '';


/* End of file routes.php */
/* Location: ./application/config/routes.php */