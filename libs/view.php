<?php
if(!defined('IRB_KEY')) {
   header("HTTP/1.1 404 Not Found");
   exit(file_get_contents('./404.html'));
}

function parseTpl($cont, $data = '') {
    if(is_array($data)) {
        extract($data, EXTR_PREFIX_ALL, 'tpl');
        ob_start();
        eval('?>'. $cont .'<?php ');
        $cont = ob_get_contents();
        ob_end_clean();
    }
    return $cont;
}

function getTpl($tpl) {
    return (file_exists(IRB_ROOT.'/skins/tpl/'.$tpl.'.php') ? file_get_contents(IRB_ROOT.'/skins/tpl/'.$tpl.'.php') : die('The template <b>'.$tpl.'.php</b> is absent in the specification'));
}

function htmlChars($data) {
    return (is_array($data) ? array_map("htmlChars", $data) : htmlspecialchars($data));
}


function translateWord($string)
{
    $string = preg_replace('#[^0-9a-zа-яё\s_-]#ui', '', $string);
    $ru = array(
        'А', 'Б', 'В', 'Г', 'Д', 'Е', 'Ё',
        'Ж', 'З', 'И', 'Й', 'К', 'Л', 'М',
        'Н', 'О', 'П', 'Р', 'С', 'Т', 'У',
        'Ф', 'Х', 'Ц', 'Ч', 'Ш', 'Щ', 'Ы',
        'Ъ', 'Ь', 'Э', 'Ю', 'Я',
        'а', 'б', 'в', 'г', 'д', 'е', 'ё',
        'ж', 'з', 'и', 'й', 'к', 'л', 'м',
        'н', 'о', 'п', 'р', 'с', 'т', 'у',
        'ф', 'х', 'ц', 'ч', 'ш', 'щ', 'ы',
        'ъ', 'ь', 'э', 'ю', 'я', ' '
    );
    $en = array(
        "A",  "B",  "V",  "G",  "D",  "E",   "E",
        "ZH", "Z",  "I",  "J",  "K",  "L",   "M",
        "N",  "O",  "P",  "R",  "S",  "T",   "U",
        "F" , "X" , "CZ", "CH", "SH", "SHH", "Y",
        "",   "",   "E", "YU", "YA",
        "a",  "b",  "v",  "g",  "d",  "e",   "e",
        "zh", "z",  "i",  "j",  "k",  "l",   "m",
        "n",  "o",  "p",  "r",  "s",  "t",   "u",
        "f" , "x" , "cz", "ch", "sh", "shh", "y",
        "",    "",  "e", "yu", "ya", "-"
    );
    $string = str_replace($ru, $en, $string);
    return  strtolower($string);
}

function clearTextHtml($text)
{
   $tags = array ('~<script[^>]*?>.*?</script>~si' => '',
                    '~<br.*?>~i'                   => ' ',
                    '~<hr.*?>~i'                   => ' ',
                    '~</p>~i'                      => ' ',
                    '~</h[1|2|3|4|5|6]>~i'         => ' ',
                    '~</t[r|h|d]>~i'               => ' ',
                    '~</div>~i'                    => ' ',
                    '~</li>~i'                     => ' ',
                    '~&(nbsp|#160);~i'             => ' ',
                    '~&(quot|#34);~i'              => '"',
                    '~&(amp|#38);~i'               => '&',
                    '~&(copy|#169);~i'             => '©'
                    );

    return strip_tags(preg_replace(array_keys($tags), array_values($tags), $text));
}

function substrText($text, $length = 100)
{
    $arr = explode(' ', $text);
    $arr = array_slice($arr, 0, $length + 1);
    return implode(' ', $arr);
}