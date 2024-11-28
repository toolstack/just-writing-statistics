<?php

$stopwords_json = file_get_contents('https://raw.githubusercontent.com/stopwords-iso/stopwords-iso/refs/heads/master/python/stopwordsiso/stopwords-iso.json');

if( $stopwords_json == FALSE ) {
    echo "Error retreiving stopwords file or file empty!";
    exit;
}

$stopwords_array = json_decode( $stopwords_json, true );

$code = "";

foreach( $stopwords_array as $locale => $words ) {
    foreach( $words as $word) {
        $code .= "\t\$stopwords['" . addslashes( $locale) . "'][] = '" . addslashes( $word ) . "';" . PHP_EOL;
    }
}

echo '<?php' . PHP_EOL;
echo PHP_EOL;
echo 'function jws_get_stop_words_list() {' . PHP_EOL;
echo "\t\$stopwords = array();" . PHP_EOL;
echo $code;
echo PHP_EOL;
echo "\treturn \$stopwords;" . PHP_EOL;
echo '}' . PHP_EOL;
