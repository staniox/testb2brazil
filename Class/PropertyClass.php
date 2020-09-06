<?php
require_once "HandlersClass.php";

function modificaUrl($request){
  $rmAcento = new RemoveAcentosHandler();
  $rmEspacoDuplo = new RemoveEspacosDuplosHandler();
  $chEspaco = new ChangeEspacosHandler();

  $rmAcento->setNext($rmEspacoDuplo)->setNext($chEspaco);

  return $rmAcento->handle($request);
}

function modificaTitle($request){
  $addTag = new AddTag();

  return $addTag->handle($request);
}

function modificaImage($request){
  $addImg = new AddImg();
  $setGreyscale= new SetGreyscaleImg();
  $addBorder = new AddBorderImg();
  $addText = new SetTextCenter();

  $addImg->setNext($setGreyscale)->setNext($addBorder)->setNext($addText);

  return $addImg->handle($request);
}
