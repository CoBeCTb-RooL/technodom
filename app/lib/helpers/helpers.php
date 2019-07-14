<?

function vd($data){
    echo '<pre>'; var_dump($data); echo '</pre>';
//    echo '<pre>' . var_export($data, true) . '</pre>';
/*    highlight_string("<?php\n\$data =\n" . var_export($data, true) . ";\n?>");*/
}


function startsWith($needle, $haystack) {
    return preg_match('/^' . preg_quote($needle, '/') . '/', $haystack);
}

function endsWith($needle, $haystack) {
    return preg_match('/' . preg_quote($needle, '/') . '$/', $haystack);
}