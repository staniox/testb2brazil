<?php


interface LoadJson
{
  public function load(string $path);
}

class FileLoadJson implements LoadJson
{
  public function load(string $path)
  {
    return json_decode(file_get_contents($path));
  }
}

class UrlLoadJson implements LoadJson
{
  public function load(string $path)
  {
    return json_decode(file_get_contents($path));
  }
}
