<?
namespace App\Models;

use App\Models\Product;

class DVD extends Product{
    public $size;


    public function validationMeta()
    {
        return array_merge( parent::validationMeta(), [
            'size' => [
                'type' => 'text',
                'errorMsg'=>'Укажите объём!',
            ],

        ]);
    }

}