<?php

namespace sirgalas\menu\controllers;


use sirgalas\menu\models\MenuSearch;
use sirgalas\menu\models\UploadImage;
use yii\helpers\Json;
use yii\web\Controller;
use sirgalas\menu\models\MenuGet;
use yii\web\NotFoundHttpException;
use yii\web\Response;
use Yii;
use sirgalas\menu\models\Menu;

class MenubackendController extends Controller
{
    public function actionIndex(){
        $searchModel = new MenuSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        return $this->render('index',[
            'module'=>$this->module,
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

       public function actionCreate(){
           $module=$this->module;
           if(isset(Yii::$app->modules['menu']->modelDb)) {
               $menuModel = Yii::$app->modules['menu']->modelDb;
               $model= new $menuModel();
           }else{
               $model= new MenuGet();
           }
           if(isset(Yii::$app->modules['menu']->modelDb)) {
               $exp=explode('\\',Yii::$app->modules['menu']->modelDb);
               $modelForNameInput=end($exp);
           }else{
               $modelForNameInput='MenuGet';
           }
           $menuGet= new MenuGet();
           $uploadModel=new UploadImage();
           if (Yii::$app->request->isAjax) {
               $request=Yii::$app->request;
               if($request->isPost){
                   $fileName = 'file';
                   if (isset($_FILES[$fileName])) {
                       $file = \yii\web\UploadedFile::getInstanceByName($fileName);
                       $uplImg=$uploadModel->upload($file ,$module);
                       if ($uplImg) {
                           return $this->render('create', [
                               'model' => $model,
                               'module' => $module,
                               'menuGet'=> $menuGet,
                               'uploadModel' => $uploadModel,
                               'modelForNameInput'=>$modelForNameInput
                           ]);
                       }else{
                       return var_dump($file);
                       }
                   }
               }else{
                   $get=Yii::$app->request->get();
                   foreach ($module->models as $value){
                        if($value['class']===$get['className']){
                            $found =$value;
                            break;
                        }
                   }
                   return $this->renderAjax('_dropfile', [
                       'model'  => $model,
                       'module' => $module,
                       'found'  =>$found,
                       'menuGet'=> $menuGet,
                       'modelForNameInput'  =>  $modelForNameInput,
                       'id'     =>  $get['id'],
                       'uploadModel' => $uploadModel
                   ]);
               }
           }
           if ($model->load(Yii::$app->request->post())) {
                    if($model->save()){
                        return $this->redirect('index');
                    }else{
                        return var_dump($model->getErrors());
                    }

           }
               return $this->render('create', [
                   'model' => $model,
                   'module' => $module,
                   'menuGet'=> $menuGet,
                   'modelForNameInput'=> $modelForNameInput,
                   'found' => null,
                   'uploadModel' => $uploadModel
               ]);
           }

        public function actionUpdate($id){
            $model = $this->findModel($id);
            $menuGet= new MenuGet();
            $module=$this->module;
            $uploadModel=new UploadImage();
            if(isset(Yii::$app->modules['menu']->modelDb)) {
                $exp=explode('\\',Yii::$app->modules['menu']->modelDb);
                $modelForNameInput=end($exp);
            }else{
                $modelForNameInput='MenuGet';
            }
            if (Yii::$app->request->isAjax) {
                $request=Yii::$app->request;
                if($request->isPost){
                    $fileName = 'file';
                    if (isset($_FILES[$fileName])) {
                        $file = \yii\web\UploadedFile::getInstanceByName($fileName);
                        $uplImg=$uploadModel->upload($file ,$module);
                        if ($uplImg) {
                            return $this->render('create', [
                                'model' => $model,
                                'module' => $module,
                                'uploadModel' => $uploadModel,
                                'modelForNameInput'=> $modelForNameInput,
                            ]);
                        }else{
                            return var_dump($file);
                        }
                    }
                }else{
                    $get=Yii::$app->request->get();
                    foreach ($module->models as $value){
                        if($value['class']===$get['className']){
                            $found =$value;
                            break;
                        }
                    }
                    return $this->renderAjax('_dropfile', [
                        'model'  => $model,
                        'module' => $module,
                        'menuGet'=> $menuGet,
                        'found'  =>$found,
                        'id'     =>  $get['id'],
                        'uploadModel' => $uploadModel,
                        'modelForNameInput'=> $modelForNameInput,
                    ]);
                }
            }
            if ($model->load(Yii::$app->request->post())&&$model->save()) {
                return $this->redirect('index');
            }
            if(isset(Yii::$app->modules['menu']->modelDb)) {
                $menuModel = Yii::$app->modules['menu']->modelDb;
                $menuSetup=new $menuModel;
                $modelContent=$menuSetup->getContent();
                $jsonObj=Json::decode($model->$modelContent,false);
                
            }else{
                $jsonObj=Json::decode($model->content,false);
            }

            return $this->render('update', [
                'model' => $model,
                'module' => $module,
                'menuGet'=> $menuGet,
                'found' => null,
                'jsonObj'=> $jsonObj,
                'uploadModel' => $uploadModel,
                'modelForNameInput'=> $modelForNameInput,
            ]);
        }

    public function actionDelete($id)
    {
        $this->findModel($id)->delete();
        return $this->redirect('index');
    }
    

        protected function findModel($id)
        {
            if(isset(Yii::$app->modules['menu']->modelDb)) {
                $menuModel = Yii::$app->modules['menu']->modelDb;
                $model= $menuModel::findOne($id);
            }else{
                $model = MenuGet::findOne($id);
            }

            if ($model !== null) {
                return $model;
            } else {
                throw new NotFoundHttpException('The requested page does not exist.');
            }
        }

}