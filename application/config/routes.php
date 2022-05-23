<?php
defined('BASEPATH') OR exit('No direct script access allowed');

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
|	https://codeigniter.com/user_guide/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There are three reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router which controller/method to use if those
| provided in the URL cannot be matched to a valid route.
|
|	$route['translate_uri_dashes'] = FALSE;
|
| This is not exactly a route, but allows you to automatically route
| controller and method names that contain dashes. '-' isn't a valid
| class or method name character, so it requires translation.
| When you set this option to TRUE, it will replace ALL dashes in the
| controller and method URI segments.
|
| Examples:	my-controller/index	-> my_controller/index
|		my-controller/my-method	-> my_controller/my_method
*/
$route['default_controller'] = 'home/HomeController';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;

$route['Home'] = 'home/HomeController';
$route['Dashboard'] = 'admin/AdminController';
// HOME / LOGIN
$route['admin'] = "admin/home/login";
// ECOMMERCE GROUP

$route['admin/product'] = "admin/ecommerce/product";
$route['admin/products'] = "admin/ecommerce/products";
$route['admin/product/(:num)'] = "admin/ecommerce/product/index/$1";
$route['admin/products/(:num)'] = "admin/ecommerce/products/index/$1";


$route['admin/fineart'] = "admin/ecommerce/fineart";
$route['admin/fineart/(:num)'] = "admin/ecommerce/fineart/index/$1";
$route['admin/designer'] = "admin/ecommerce/designer";
$route['admin/designer/(:num)'] = "admin/ecommerce/designer/index/$1";
$route['admin/designer'] = "admin/ecommerce/designer";
$route['admin/designer/(:num)'] = "admin/ecommerce/designer/index/$1";
$route['admin/material'] = "admin/ecommerce/material";
$route['admin/material/(:num)'] = "admin/ecommerce/material/index/$1";

$route['admin/relatedproducts'] = "admin/ecommerce/RelatedProducts";
$route['admin/defaultrelatedproducts'] = "admin/ecommerce/DefaultRelatedProducts";

$route['admin/furniture_publish'] = "admin/ecommerce/Furniture_Publish";
$route['admin/furniture_publish/(:num)'] = "admin/ecommerce/Furniture_Publish/index/$1";

$route['admin/furniture_products'] = "admin/ecommerce/Furniture_Products";
$route['admin/furniture_products/(:num)'] = "admin/ecommerce/Furniture_Products/index/$1";

$route['admin/lighting_publish'] = "admin/ecommerce/lighting_publish";
$route['admin/lighting_publish/(:num)'] = "admin/ecommerce/lighting_publish/index/$1";
$route['admin/lighting_products'] = "admin/ecommerce/lighting_products";
$route['admin/lighting_products/(:num)'] = "admin/ecommerce/lighting_products/index/$1";
$route['admin/removeSecondaryImage'] = "admin/ecommerce/publish/removeSecondaryImage";
$route['admin/row_delete'] = "admin/ecommerce/publish/row_delete";
$route['admin/products'] = "admin/ecommerce/products";
$route['admin/entries'] = "admin/ecommerce/entries";  
$route['admin/entries/contacts'] = "admin/ecommerce/entries/contact_entries";  
$route['admin/entries/priceQuotes'] = "admin/ecommerce/entries/priceQuotes";
$route['admin/entries/requestMoreContacts'] = "admin/ecommerce/entries/requestMoreContacts";  
$route['admin/entries/tradeContacts'] = "admin/ecommerce/entries/tradeContacts"; 
$route['admin/entries/materialContacts'] = "admin/ecommerce/entries/materialContacts";  
$route['admin/materials'] = "admin/ecommerce/materials";
$route['admin/finearts'] = "admin/ecommerce/finearts";
$route['admin/designers'] = "admin/ecommerce/designers";
$route['admin/products/(:num)'] = "admin/ecommerce/products/index/$1";
$route['admin/materials/(:num)'] = "admin/ecommerce/materials/index/$1";
$route['admin/finearts/(:num)'] = "admin/ecommerce/finearts/index/$1";
$route['admin/designers/(:num)'] = "admin/ecommerce/designers/index/$1";
$route['admin/productStatusChange'] = "admin/ecommerce/products/productStatusChange";
$route['admin/shopcategories'] = "admin/ecommerce/ShopCategories";
$route['admin/shopcategories/(:num)'] = "admin/ecommerce/ShopCategories/index/$1";
$route['admin/shopcategories/edit'] = "admin/ecommerce/ShopCategories/edit";
$route['admin/shopcategories/edit/(:num)'] = "admin/ecommerce/ShopCategories/edit/$1";
$route['admin/editshopcategorie'] = "admin/ecommerce/ShopCategories/editShopCategorie";
$route['admin/orders'] = "admin/ecommerce/orders";
$route['admin/orders/furniture'] = "admin/ecommerce/orders/furniture";
$route['admin/orders/(:num)'] = "admin/ecommerce/orders/index/$1";
$route['admin/changeOrdersOrderStatus'] = "admin/ecommerce/orders/changeOrdersOrderStatus";
$route['admin/brands'] = "admin/ecommerce/brands";
$route['admin/brands/edit'] = "admin/ecommerce/edit";
$route['admin/brands/edit/(:num)'] = "admin/ecommerce/brands/edit/$1";
$route['admin/mtc'] = "admin/ecommerce/materials/mtc";
$route['admin/changePosition'] = "admin/ecommerce/ShopCategories/changePosition";
$route['admin/discounts'] = "admin/ecommerce/discounts";
$route['admin/discounts/(:num)'] = "admin/ecommerce/discounts/index/$1";
// BLOG GROUP
$route['admin/blogpublish'] = "admin/blog/BlogPublish";
$route['admin/blogpublish/(:num)'] = "admin/blog/BlogPublish/index/$1";
$route['admin/blog'] = "admin/blog/blog";
$route['admin/blog/(:num)'] = "admin/blog/blog/index/$1";

// Tesimonials GROUP
$route['admin/testpublish'] = "admin/blog/TestPublish";
$route['admin/testpublish/(:num)'] = "admin/blog/TestPublish/index/$1";
$route['admin/testimonials'] = "admin/blog/testimonials";
$route['admin/testimonials/(:num)'] = "admin/blog/testimonials/index/$1";

// SETTINGS GROUP
$route['admin/settings'] = "admin/settings/settings";
$route['admin/styling'] = "admin/settings/styling";
$route['admin/templates'] = "admin/settings/templates";
$route['admin/titles'] = "admin/settings/titles";
$route['admin/pages'] = "admin/settings/pages";
$route['admin/emails'] = "admin/settings/emails";
$route['admin/emails/(:num)'] = "admin/settings/emails/index/$1";
$route['admin/history'] = "admin/settings/history";
$route['admin/history/(:num)'] = "admin/settings/history/index/$1";
// ADVANCED SETTINGS
$route['admin/languages'] = "admin/advanced_settings/languages";
$route['admin/filemanager'] = "admin/advanced_settings/filemanager";
$route['admin/adminusers'] = "admin/advanced_settings/adminusers";
// TEXTUAL PAGES
$route['admin/pageedit/(:any)'] = "admin/textual_pages/TextualPages/pageEdit/$1";
$route['admin/changePageStatus'] = "admin/textual_pages/TextualPages/changePageStatus";
// LOGOUT
$route['admin/logout'] = "admin/home/home/logout";
// Admin pass change ajax
$route['admin/changePass'] = "admin/home/home/changePass";
$route['admin/uploadOthersImages'] = "admin/ecommerce/publish/do_upload_others_images";
$route['admin/loadOthersImages'] = "admin/ecommerce/publish/loadOthersImages";

/*
  | -------------------------------------------------------------------------
  | Sample REST API Routes
  | -------------------------------------------------------------------------
 */
$route['api/products/(\w{2})/get'] = 'Api/Products/all/$1';
$route['api/product/(\w{2})/(:num)/get'] = 'Api/Products/one/$1/$2';
$route['api/product/set'] = 'Api/Products/set';
$route['api/product/(\w{2})/delete'] = 'Api/Products/productDel/$1';

$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;

$route['my-stripe'] = "StripeController";
$route['stripePost']['post'] = "StripeController/stripePost";
