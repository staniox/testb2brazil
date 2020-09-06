<?php


interface Handler
{
  public function setNext(Handler $handler): Handler;
  public function getNext(): ?Handler;

  public function handle($request);

}
