<?
namespace App\Models;


class Book extends Product{
    public $author;
    public $weight;

    public function validationMeta()
    {
        return array_merge( parent::validationMeta(), [
            'author' => [
                'type' => 'text',
                'errorMsg'=>'Укажите автора!',
            ],
            'weight' => [
                'type' => 'float',
                'errorMsg'=>'Укажите вес!',
            ],

        ]);
    }

}