<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 29.05.17
 * Time: 14:50
 */

namespace sirgalas\menu\models;


use Yii;
use yii\base\Model;
use yii\web\UploadedFile;
use dosamigos\transliterator\TransliteratorHelper;
use yii\imagine\Image;
class UploadImage extends Model
{
    public $file;
    public function rules()
    {
        return [
            [['file'], 'file','skipOnEmpty' => true, 'extensions' => 'png, jpg, jpeg, gif'],
        ];
    }
    public function upload($fileName,$module){
        $this->file=$fileName;
        $basePath=date('Y').'/'.date('m');
        $uploadPath =$module->imageDownloadPath.''.$basePath;
        if (file_exists($uploadPath)) {
        } else {
            mkdir($uploadPath, 0777, true);
        }
        //$file = \yii\web\UploadedFile::getInstanceByName($fileName);
        $filenames=$this->traranslitImg($this->file->name);
        if ($this->validate()) {
            if(file_exists($uploadPath)) {
            } else {
                mkdir($uploadPath, 0777, true);
            }
            if ($this->file->saveAs($uploadPath . '/' . $filenames)){
                $this->imagerisize($uploadPath, $filenames,$module);
                return true;
            };
        } else {
            return var_dump($this->getErrors());
        }
    }
    protected function traranslitImg($img){
        $strArr = array('/', '\\', ',', '<', '>', '"', "ь", "ъ",' ',);
        $slugimmage = str_replace($strArr, '', $img);
        $slugimg = str_replace(' ', '', $slugimmage);
        $filenames=TransliteratorHelper::process($slugimg, '', 'en');
        return $filenames;
    }
    protected function imagerisize($uploadPath,$filenames,$module){
        $path = $uploadPath;
        $sizes= $module->imageResize;
        $count= 1;
        foreach ($sizes as $size){
            Image::thumbnail($path.'/'.$filenames, $size[0],$size[1])->save($path.'/'.$count.'-'.$filenames, ['quality' => 90]);
            $count++;
        }
        return true;
    }
}