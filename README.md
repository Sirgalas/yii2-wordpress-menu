# yii2-wordperss-menu
Это расширение позволить создавать  меню по типу wordpress. Тоесть в админке вы устанвливаете меню как с уровнеями вложености 
так и добавляете заранее созданые меню. 
Подключается
```php
backend/config/main.php 
'menu'  =>[
            'class' =>  'sirgalas\menu\MenuModule',
            'imageDownloadPath'     =>  Yii::getAlias('@frontend/').'web/image/menu/',
            'imageSetPath'     =>  Yii::getAlias('@frontendWebroot').'/image/menu/',
            'imageResize'   =>  [[80, 40],[179,156]],
            'extra_menu'    =>  2,
            'models' =>  [
                'class' =>  '\common\models\Category',
                'title' =>  'name',
                'label' =>  'выбирите категорию',
                'id'    =>  'id',
                'alias' =>  'slug_category',
                'path'  =>  '/category',
                'image' =>  'true'
            ],
],
```
---
+ **imageDownloadPath**, **imageSetPath** - указание путей при загрузке картинок (если к меню планируется подключить картинки)
+ **imageResize** - массив с желаемыми размерами картинок
+ **extra_menu** - дополнительные меню можно использовать для создания
+ **models** - масссив выборок для добавления пунктов меню
+ **models** - модель которую хотие добавить к выборке
+ **label** - название выпадающего списка в админке
+ **title** - из какого столбца брать пункты меню
+ **id** - из какого столбца брать id
+ **alias** - если вы указали алиасы в базе данных укажите столбец
+ **path** - путь для роутинга на frontend
+ **image** - если вы хотите добавлять картинки

---
common
``` php
common\config\main.php
'menu'  =>[
            'class' =>  'sirgalas\menu\MenuModule',
            'modelDb' =>  '\common\models\FrontendSetup',
        ],
```
+ **modelDb** - в случае если используется своя база данных  без использования миграции

---
frontend
```php
<?= MenuView::widget([
       'name'              =>  'Футер право',
       'nameAlias'         =>  'slug',
       'navWidget'         =>  'menu',
       'navBarOption' => ['class' => false,],
       'linkTemplate' => '<a href="{url}"><span class="fa fa-angle-right"></span>{label}</a>',
]);
?>
```
+ **name** - id базы
+ **nameAlias** - как в pattern будет называться get - запрос
+ **navWidget** - Какой виджет использоваться menu = Menu, navbar = NavBar
+ в остальном я попытался подключить все настройки этих виджетов

если вам не желаете использовать подключение этой модели sirgalas\menu\models\Menu
 и её метода renderMenu у которого обязательный атрибут является вызываемое меню и наименование гет параметра которое будет использоваться в роутинге.
 Пердположительно такокая запись
 ```php
  $modelMenu= new Menu();
  $modelMenu->renderMenu($menu,'alias');
  ```
 А в случае использования встроиной таблицы необходимо указать атрибуты в следуюшем порядке
 ```php
    $modelMenu= new Menu();
    $modelMenu->renderMenu($allMenu,$menu,'content','alias');
 ```


миграция php yii migrate/ --migrationPath=@vendor/sirgalas/yii2-wordperss-menu/migrations
