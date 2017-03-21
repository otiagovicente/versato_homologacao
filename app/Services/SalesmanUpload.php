<?php
namespace App\Services;

use App\Contracts\Upload;

use Illuminate\Support\Facades\Storage;

/**
 * Created by PhpStorm.
 * User: otiagovicente
 * Date: 05/12/16
 * Time: 22:34
 */

class SalesmanUpload implements Upload {

	protected $driver;
	protected $public;

	public function __construct($driver, $public)
	{
		$this->driver = $driver;
		$this->public = $public;

		return $this;
	}

	public function upload($file, $folder){


		//Faz upload da imagem para o Driver AWS S3
		$image = $file->store($folder,$this->driver);
		$this->publish($image);
		//Retorna a url completa da imagem que será salva no campo photo do produto
		return Storage::disk('s3')->url($image);

	}

	private function publish($image){
		//Torna acessível publicamente a imagem
		if($this->public) Storage::disk($this->driver)->setVisibility($image, 'public');

	}

}