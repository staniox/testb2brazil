<?php
function parseJson(string $file, string $url){

  if($file)
    $content = $file;
  elseif ($url)
    $content = $url;
  else
    return null;

    return json_decode(file_get_contents($content));

}

function ManipulaArticles( $articles){
  foreach ( $articles as $key => $article){
  }
}
