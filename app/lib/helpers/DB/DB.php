<?
namespace App\Lib;


class DB{
    private static $_link;

    public function escapeString($str)
    {
        return DB::link()->real_escape_string($str);
    }

    public function connect()
    {
        self::$_link = mysqli_connect(
            Config::val('db.host'),
            Config::val('db.username'),
            Config::val('db.password'),
            Config::val('db.dbName')
        )
        or die( mysqli_error(self::$_link));

    }

    public function link()
    {
        return self::$_link;
    }



    public function query($sql)
    {
        self::link()->real_query($sql);

        if($res = DB::link()->store_result())
            return $res;
        else
            echo  DB::link()->error;
    }



}