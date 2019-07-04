<?

function view($view, $params=null)
{
    return App\Lib\State::view($view, $params);
}



function exception($str)
{
    echo '<h2 style="font-weight: normal; color: #ff272d;  ">ОШИБКА! ' .$str.'</h2>';
}