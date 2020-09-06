<?php

class LoadAnyJson
{
  private $type;

  public function __construct($type){
    $this->type = $type;
  }

  public function setType(LoadJson $type)
  {
    $this->type = $type;
  }

  public function loadJson($path)
  {
    return $this->type->load($path);
  }
}
