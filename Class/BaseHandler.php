<?php


abstract class BaseHandler
{
  private $nextHandler;

  public function setNext($handler)
  {
    $this->nextHandler = $handler;
    return $handler;
  }

  public function getNext(){
    if ($this->nextHandler)
      return true;
      return false;

  }

  public function handle($request)
  {
    if ($this->nextHandler) {
      return $this->nextHandler->handle($request);
    }

    return null;
  }
}
