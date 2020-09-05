<?php
include_once('Functions.php');
include_once('LoadAnyJson.php');
include_once('LoadJson.php');
include_once('../Class/PropertyClass.php');


$varFile= $_FILES['up_content']['tmp_name'];
$varUrl = $_POST['up_url'];

$load= new LoadAnyJson(new FileLoadJson());

$json = $load->loadJson($varFile);

if(!$json){
  $load->setType(new UrlLoadJson());
  $json = $load->loadJson($varUrl);
}



if($json && $json->articles)
{
  foreach ($json->articles as $article){
  $article->url=modificaUrl($article->title);
  $article->title=modificaTitle($article->title);
  $article->image=modificaImage($article->image);
  }


  echo "O Arquivo ".  basename( $_FILES['up_content']['name']). " foi submetido com sucesso.";
}
else{
  echo "Ocorreu um erro ao submeter, verifique o formulario e tente novamente.";
}
