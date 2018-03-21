# yii2-wordperss-menu
Это расширение позволить создавать  меню по типу wordpress. Тоесть в админке вы устанвливаете меню как с уровнеями вложености 
так и добавляете заранее созданые меню.
Устанавливается
```
composer require sirgalas/yii2-wordpress-menu
```
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
            'modelDb' =>  '\common\models\YourModel',
        ],
```
+ **modelDb** - в случае если используется своя база данных  без использования миграции

---
frontend
```php
<?= MenuView::widget([
       'name'              =>  'Футер лево',
        'nameAlias'         =>  'slug',
        'menu'              =>['linkTemplate' => '<a href="{url}"><span class="fa fa-angle-right"></span>{label}</a>','options'=>['class' => false]]
]);
?>
```
+ **name** - id базы
+ **nameAlias** - как в pattern будет называться get - запрос
+ **nav** - Если вы используете виджет Nav необходимо указать этот ключ  значением к которому будет настроики виджета в виде пасива согласно документации виджета
+ **menu** - Если вы используете виджет Menu необходимо указать этот ключ  значением к которому будет настроики виджета в виде пасива согласно документации виджета
+ **navBar** - Если вы используете виджет NavBar необходимо указать этот ключ  значением к которому будет настроики виджета в виде пасива согласно документации виджета
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


миграция
```
php yii migrate/ --migrationPath=@vendor/sirgalas/yii2-wordperss-menu/migrations
```


Если вы хотите использовать свою базу то для этого необходимо (повторяю ещё раз)  в
```php
commom\config\main.php
'menu'  =>[
            'class' =>  'sirgalas\menu\MenuModule',
            'modelDb' =>  '\common\models\YourModel',
        ],
```
в моделе необходимо подключить поведение
```php
use sirgalas\menu\behaviors\MenuBaseWordpressBehavior;
'BaseMenu' => [
                'class'             =>  MenuBaseWordpressBehavior::className(),
                'nameModel'         =>  '\common\models\YourModel',
                'dbName'            =>  'yourtable',
                'idBehavior'        =>  'id',
                'name'              =>  'name',
                'content'           =>  'content',
                'serviceField'      =>  'description',
                'nameServiceField'  =>  'menus'
            ],
```
+ ***nameModel*** namespace модели
+ ***dbName*** название таблицы
+ ***idBehavior*** столбец id
+ ***name*** столбец содержащий название строки базы
+ ***content*** солбец куда необходимо сохранять данные меню
+ ***serviceField nameServiceField*** используются для поисковой модели, это поисковое поле для выборки из вашей базы всех меню
---

в общем итоге вот так у меня получилось это
backend
вложеное меню (выпадающее меню)
https://nimbus.everhelper.me/client/notes/share/1033948/fpvyz4o96inaqhpv7246
основное меню 
https://nimbus.everhelper.me/client/notes/share/1033957/qc2xb6wgcwysaac2gsfz

есть возможность определять вложенность таким образом 
https://nimbus.everhelper.me/client/notes/share/1033970/aycfg9ylkiy8uwvrh2xi


frontend
https://dl.dropboxusercontent.com/1/view/hlv8uxg4wm53s6t/Apps/Shutter/%C3%90%C2%92%C3%91%C2%8B%C3%90%C2%B4%C3%90%C2%B5%C3%90%C2%BB%C3%90%C2%B5%C3%90%C2%BD%C3%90%C2%B8%C3%90%C2%B5_004.png
https://dl.dropboxusercontent.com/1/view/8glnfop5ozhmdal/Apps/Shutter/%C3%90%C2%92%C3%91%C2%8B%C3%90%C2%B4%C3%90%C2%B5%C3%90%C2%BB%C3%90%C2%B5%C3%90%C2%BD%C3%90%C2%B8%C3%90%C2%B5_005.png


вот ссылки на сайты где использовано расширение [магазин одежды](http://miliydom.com.ua/), [магазин косметики](http://krymray.ru/)
в планах допилить верстку и отойти от json формата докумената. Буду рад любой помощи. Присоединяйтесь
```php 'description'=>'menus'```
