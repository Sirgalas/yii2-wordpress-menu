<?php

namespace sirgalas\menu\controllers;



use Imagine\Exception\RuntimeException;
use sirgalas\menu\services\MenuItemService;
use yii\web\Controller;
use sirgalas\menu\entities\MenuItem;
use Yii;
use sirgalas\menu\entities\MenuName;
use sirgalas\menu\search\MenuSearch;
use yii\web\NotFoundHttpException;

class BackendController extends Controller
{



    public function actionIndex(){
        $searchModel = new MenuSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionCreate(){
        $entities = new MenuName();

        if($entities->load(Yii::$app->request->post())){
            try{
                if(!$entities->save())
                    throw new \RuntimeException(json_encode($entities->errors));
                return $this->redirect('index');
            }catch (RuntimeException $e){
                Yii::$app->errorHandler->logException($e);
                Yii::$app->session->setFlash($e->getMessage());
            }
        }else{
            return $this->render('create',compact('entities'));
        }
    }
    public function actionUpdate($id){
        $entities = $this->findEntities($id);
        try{
            $datas=$this->module->getArrEntities();
        }catch (RuntimeException $e){
            Yii::$app->session->setFlash('не привязана не одна модель');
            return false;
        }
        $extra_menu=$this->module->getExtraMenu();
        $itemProvider=(new MenuItem)->allMenu($id);
        if($entities->load(Yii::$app->request->post())){
            try{
                if(!$entities->save())
                    throw new \RuntimeException(json_encode($entities->errors));
                return $this->redirect('index');
            }catch (RuntimeException $e){
                Yii::$app->errorHandler->logException($e);
                Yii::$app->session->setFlash($e->getMessage());
            }
        }else{
            return $this->render('update',compact('entities','datas','extra_menu','itemProvider'));
        }
    }


    public function actionDelete($id)
    {
        $this->findEntities($id)->delete();
        return $this->redirect('index');
    }

    public function actionAddItems(){

        
        $name= Yii::$app->request->post('name');
        $count=Yii::$app->request->post('count');
        $object= Yii::createObject($name);
        $entities=$object->findOne(Yii::$app->request->post('id'));
        $services=new MenuItemService();
        try{
            $services->ItemSave(Yii::$app->request->post(),$entities);
        }catch (\RuntimeException $ex){
            Yii::debug($ex->getMessage());
        }
        return $this->renderPartial('add-items',[
            'entities'=>$entities,
            'className'=>$name,
            'count'=>$count
        ]);
    }


        protected function findEntities($id)
        {
            $model = MenuName::findOne($id);

            if ($model !== null) {
                return $model;
            } else {
                throw new NotFoundHttpException('The requested page does not exist.');
            }
        }

}