<?
namespace App\Lib;

#   ГРУППЫ УРЛОВ
#   (чтобы система автоопределения контроллера и экшена действовала в подкатегории, например "admin")
Route::urlGroup('admin');
Route::urlGroup('operator');


#   КАСТОМНЫЕ РОУТЫ
Route::create('products/editForm', 'ProductsController@editForm');
Route::create('qwe/rty/uio/{int}', 'TestController@index2');
Route::create('prod/{int}', 'TestController@index3');
Route::create('qwe/rty/uio', 'TestController@index');
//Route::create('products', 'ProductsController@index');


//Route::create('admin/', 'admin/IndexController@index');

?>