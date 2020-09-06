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

    $regex = '/^(?:\w+\s+){'.($this->wordPositon-1).'}\K\w+/';
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

class AddImg extends BaseHandler {

    public function handle($request)
    {
        $handle = fopen($request, 'rb');
        $image = new Imagick();
        $image->readImageFile($handle);
        $request= $GLOBALS['BaseDir'].basename($request);
        clearstatcache($request);
        $image->writeImage($request);


        if(parent::getNext())
            return parent::handle($request);
        return $request;
    }
}

class SetGreyscaleImg extends BaseHandler {

    public function handle($request)
    {
        $image = new Imagick ($request);
        $image->setImageType (2);
        clearstatcache($request);
        $image->writeImage($request);

        if(parent::getNext())
            return parent::handle($request);
        return $request;
    }
}

class AddBorderImg extends BaseHandler {

  public function handle($request)
  {
      $imageSource = new Imagick( $request );

      $borderWidth = 10;
      $borderColor = 'rgba(192,192,192)';
      $borderPadding = 0;


      $imageWidth = $imageSource->getImageWidth() + ( 2 * ( $borderWidth + $borderPadding ) );
      $imageHeight = $imageSource->getImageHeight() + ( 2 * ( $borderWidth + $borderPadding ) );

      $image = new Imagick();

      $image->newImage( $imageWidth, $imageHeight, new ImagickPixel( 'none' )
      );

      $border = new ImagickDraw();

      $border->setFillColor( 'none' );

      $border->setStrokeColor( new ImagickPixel( $borderColor ) );
      $border->setStrokeWidth( $borderWidth );
      $border->setStrokeAntialias( false );

      $border->rectangle(
          $borderWidth / 2 - 1,
          $borderWidth / 2 - 1,
          $imageWidth - ( ($borderWidth / 2) ),
          $imageHeight - ( ($borderWidth / 2) )
      );

      $image->drawImage( $border );

      $image->setImageFormat('png');

      $image->compositeImage(
          $imageSource, Imagick::COMPOSITE_DEFAULT,
          $borderWidth + $borderPadding,
          $borderWidth + $borderPadding
      );

      clearstatcache($request);
      $image->writeImage($request);
    if(parent::getNext())
      return parent::handle($request);
    return $request;
  }
}

class SetTextCenter extends BaseHandler {
    private $text = 'B2Brazil';
    public function handle($request)
    {
        $image = new Imagick($request);
        $draw = new ImagickDraw();

        $draw->setFillColor('black');

        $draw->setFontSize( 30 );
        $draw->setGravity(Imagick::GRAVITY_CENTER );

        $image->annotateImage($draw, 0, 0, 0, $this->text);

        clearstatcache($request);
        $image->writeImage($request);

        if(parent::getNext())
            return parent::handle($request);
        return basename($request);
    }
}
