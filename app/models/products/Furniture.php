<?
namespace App\Models;

use App\Models\Product;

class Furniture extends Product{
    public $height;
    public $width;
    public $length;

    public function validationMeta()
    {
        return array_merge( parent::validationMeta(), [
            'height' => [
                'type' => 'float',
                'errorMsg'=>'Укажите высоту!',
            ],
            'width' => [
                'type' => 'float',
                'errorMsg'=>'Укажите ширину!',
            ],
            'length' => [
                'type' => 'float',
                'errorMsg'=>'Укажите длину!',
            ],
        ]);
    }



}