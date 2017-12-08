# Yii2 extension for using MongoDB and Doctrine #

[![Latest Stable Version](https://poser.pugx.org/brunohulk/yii2-mongodb-doctrine/v/stable)](https://packagist.org/packages/brunohulk/yii2-mongodb-doctrine)
[![Downloads](https://poser.pugx.org/brunohulk/yii2-mongodb-doctrine/downloads)](https://packagist.org/packages/brunohulk/yii2-mongodb-doctrine)
[![License](https://poser.pugx.org/brunohulk/yii2-mongodb-doctrine/license)](https://packagist.org/packages/brunohulk/yii2-mongodb-doctrine)

## About ##
This component was created with the purpose of allowing us to use all benefits of the Doctrine in Yii2 using the
MongoDB ODM version. There are others solutions which use MongoDB and the active record pattern from Yii, but the vast
Doctrine documentation and its better way to deal with embedded documents made its case.

## Installation ##
Require the library with Composer:

```
composer require brunohulk/yii2-mongodb-doctrine
```

Then, to activate the component, you have to add the follow entry inside the web.php file replacing the default database
params by your customise data:

```php
'doctrineOdm' => [
    'class' => 'brunohulk\Yii2MongodbOdm\DoctrineODM',
    'dsn' => 'mongodb://mongodb:27017', #DSN string connection
    'dbname' => 'database_name'  #Database name,
    'documentsDir' => __DIR__ . '/../../documents/', # Directory which stores your mapped collections
    'runtimeDir' =>  __DIR__ . '/../../runtime/' # The Yii2 runtime dir or other directory to store the Doctrine extra files
]
```

## Usage ##
To start using the Document manager all you have to do is call the method below in any place you desire, like a controller:

```php
class User extends Controller
{
    private $documentManager;

    public function init()
    {
        $this->documentManager = Yii::$app->doctrineOdm->getDocumentManager();
    }

    public function actionCreate()
    {
        $user = new User;
        $user->name = "Bruno";

        $this->documentManager->persist($user);
        $this->documentManager

    }

```
For the last step, is necessary to create a `documents` folder within the `common` directory in your Yii project, all the
documents mapped must be there, the following example is related to previous doc block.
```php
/**
 * @ODM\Document(collection="user")
 */
class User
{
    /**
     * @ODM\Id
     */
    public $id;

    /**
     * @ODM\Field(name="name", type="string")
     */
    public $name;

}
```

Special thanks for [David Rocha](https://github.com/davidasrocha)
