<?php
use \App\Lib\ProductManager;
use App\Lib\CategoryManager;
use \App\Factories\ProductFactory;

class productsController{

    public function index()
    {
        return view('products.index', ['aaa'=>1121, ]);
    }


    public function listJson()
    {
        $ret = [];
        $list = ProductManager::getList();

        #   инитим категории
        if(count($list))
        {
            $cats = CategoryManager::getList();
            foreach ($list as $item)
                $item->initCategory($cats);
        }

//        $list[1]->category = null;  // !!!!!!!!!!!!!
        $ret['list'] = $list;

        return $ret;
    }



    public function editForm()
    {
        $id = $_REQUEST['id'];
        $MODEL['item'] = $id ? ProductManager::get($id) : null;
//        if($MODEL['item'])
//            $MODEL['item']->initProps();
        $MODEL['cats'] = CategoryManager::getList();

        return view('products.editForm', $MODEL);
    }


    public function editFormPropsPartial()
    {
        $product = $_REQUEST['productId'] ? ProductManager::get($_REQUEST['productId']) : null;
        $cat = $_REQUEST['catId'] ? CategoryManager::get($_REQUEST['catId']) : null;
        return view('products.editFormPropsPartial', ['cat'=>$cat, 'product' => $product, ]);
    }


    public function editFormSubmit()
    {
        $ret = [
            'result'=>'fail',
            'problems' => [],
        ];

        if($id = $_REQUEST['id'])
            $obj = ProductManager::get($id);
        else
            $obj = ProductFactory::create($_REQUEST['categoryId']);  //  если catId не выбран - не беда, создастся
                                                                //  родительский класс, и сработает его валидация
        #   раскладываем данные
        ProductManager::setValuesFromArray($obj, $_REQUEST);
        if(($result = $obj->validate()) !== true)
        {
            $ret['result'] = 'fail';
            $ret['problems'] = $result;
        }
        else
        {
            $ret['result'] = 'ok';
            #   сохраняем

        }

        return $ret;
    }





    public function test()
    {
//        $a = CategoryManager::getList(['id'=>2, ]);
//        vd($a);
//        $a = CategoryManager::get(3);
//        vd($a);

//        $a = PropManager::getList(['categoryId'=>2, ]);
//        vd($a);
//        $a = PropManager::get(3);
//        vd($a);

        $prod = ProductManager::get(3);
        vd($prod);
        $tmp = $prod->validate();
        vd($tmp);

//        vd($prod);
//        $a = App\Lib\ProductManager::getList(['catego1111ryId'=>2, ]);
//        vd($a);

//        $a = ProductFactory::create(ProductFactory::TYPE_BOOK);
        //vd($a);


//        $p = ProductProvider::get(2);
//        $p->initProps();
//        vd($p);



//        $a = CategoryProvider::getList();
//        vd($a);


//        $a = PropProvider::getList();
//        vd($a);


//        $p = ProductProvider::getList([
//            'categoryId' => 1,
//        ]);
//        vd($p);



        return view('products.test');
    }


}






