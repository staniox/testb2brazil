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
  $addBorder = new AddBorderImg();

  return $addBorder->handle($request);
}
