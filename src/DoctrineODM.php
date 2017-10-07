<?php

namespace brunohulk\Yii2MongodbOdm;

use Doctrine\MongoDB\Connection;
use Doctrine\ODM\MongoDB\Configuration;
use Doctrine\ODM\MongoDB\DocumentManager;
use Doctrine\ODM\MongoDB\Mapping\Driver\AnnotationDriver;
use Yii;
use yii\base\Component;

class DoctrineODM extends Component
{
    private $documentManager = null;
    private $dsn;
    private $dbname;

    public function init()
    {
        parent::init();
        $this->initDoctrine();
    }

    public function initDoctrine()
    {
        $config = new Configuration();
        $config->setProxyDir(__DIR__ . '/Proxies');
        $config->setProxyNamespace('Proxies');
        $config->setHydratorDir(__DIR__ . '/Hydrators');
        $config->setHydratorNamespace('Hydrators');
        $config->setDefaultDB($this->dbname);
        $config->setMetadataDriverImpl(
            AnnotationDriver::create(dirname(dirname(__DIR__)) . '/documents')
        );

        AnnotationDriver::registerAnnotationClasses();

        $this->documentManager = DocumentManager::create(new Connection($this->dsn), $config);
    }

    public function setDsn($dsn)
    {
        $this->dsn = $dsn;
    }

    public function setDbname($dbname)
    {
        $this->dbname = $dbname;
    }

    public function getDocumentManager()
    {
        return $this->documentManager;
    }
}
