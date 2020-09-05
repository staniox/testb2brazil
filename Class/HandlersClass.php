<?php
include_once "BaseHandler.php";

class RemoveAcentosHandler extends BaseHandler {

  public function handle($request): ?string
  {
    $request =  preg_replace(array("/(á|à|ã|â|ä)/","/(Á|À|Ã|Â|Ä)/","/(é|è|ê|ë)/","/(É|È|Ê|Ë)/","/(í|ì|î|ï)/","/(Í|Ì|Î|Ï)/","/(ó|ò|õ|ô|ö)/","/(Ó|Ò|Õ|Ô|Ö)/","/(ú|ù|û|ü)/","/(Ú|Ù|Û|Ü)/","/(ñ)/","/(Ñ)/","/(ç)/","/(Ç)/"),explode(" ","a A e E i I o O u U n N c C"),$request);

    if(parent::getNext())
      return parent::handle($request);
    return $request;
  }
}

class RemoveEspacosDuplosHandler extends BaseHandler {

  public function handle($request): ?string
  {
    $request= str_replace('  ', ' ', $request);
    if(parent::getNext())
      return parent::handle($request);
    return $request;
  }
}

class ChangeEspacosHandler extends BaseHandler {

  public function handle($request): ?string
  {
    $request= str_replace(' ', '-', $request);

    if(parent::getNext())
      return parent::handle($request);
    return $request;
  }
}

class AddTag extends BaseHandler {
  private $openTag = "<strong>";
  private $closeTag = "</strong>";
  private $wordPositon = 2;

  public function handle($request): ?string
  {
    $array = explode(" ",$request);

    $regex = '/^(?:\w+ ){'.($this->wordPositon - 1).'}\K\w+/';
    $replacement = $this->openTag.'$0'.$this->closeTag;
    $request= preg_replace($regex, $replacement, $request,1);

    if(parent::getNext())
      return parent::handle($request);
    return $request;
  }

  // caso queira trocar a tag;
  public function setTag(string $openTag, string $closeTag){
    $this->openTag = $openTag;
    $this->closeTag = $closeTag;
  }

  //caso queira troca a posicao
  public function setWord(int $wordPosition){
   $this->wordPositon= $wordPosition;
  }

}

class AddBorderImg extends BaseHandler {

  public function handle($request)
  {

    $img = file_get_contents($request);

    $image = new Imagick(urlencode($request));
    $image -> writeImage('imgs/test.png');
    if(parent::getNext())
      return parent::handle($request);
    return $request;
  }
}
