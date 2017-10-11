<?php

namespace brunohulk\Yii2MongodbOdm;

use Doctrine\MongoDB\Connection;
use Doctrine\ODM\MongoDB\Configuration;
use Doctrine\ODM\MongoDB\DocumentManager;
use Doctrine\ODM\MongoDB\Mapping\Driver\AnnotationDriver;
use Yii;
use yii\base\Component;

/**
 * Class DoctrineODM, responsible to handle the Doctrine connection with MongoDb through of a Yii2 component instance
 *
 * @package brunohulk\Yii2MongodbOdm
 */
class DoctrineODM extends Component
{
    /**
     * @var \Doctrine\ODM\MongoDB\DocumentManager;
     */

    private $documentManager;
    /**
     * @var string DSN string connection
     */
    private $dsn;

    /**
     * @var string Database name
     */
    private $dbname;

    /**
     * @var string Path location to store the runtime files
     */
    private $runtimeDir;

    /**
     * @var string Path location where to store the collections mapped
     */
    private $documentsDir;


    /**
     * Bootstrap of the Yii2 component
     */
    public function init()
    {
        parent::init();
        $this->initDoctrine();
    }

    /**
     * Start the Doctrine configuration
     */
    public function initDoctrine()
    {
        $config = new Configuration();
        $config->setProxyDir($this->runtimeDir . '/Proxies');
        $config->setProxyNamespace('Proxies');
        $config->setHydratorDir($this->runtimeDir . '/Hydrators');
        $config->setHydratorNamespace('Hydrators');
        $config->setDefaultDB($this->dbname);
        $config->setMetadataDriverImpl(
            AnnotationDriver::create($this->documentsDir . '/documents')
        );

        AnnotationDriver::registerAnnotationClasses();

        $this->documentManager = DocumentManager::create(new Connection($this->dsn), $config);
    }

    /**
     * @param string $documentDir Define the document dir
     */
    public function setDocumentsdir($documentDir)
    {
        $this->documentsDir = $documentDir;
    }

    /**
     * @param string $runtimeDir Define the runtime dir
     * This Directory stores the doctrine extra files, like proxies and hydrator
     */
    public function setRuntimedir($runtimeDir)
    {
        $this->runtimeDir = $runtimeDir;
    }

    /**
     * @param string $dsn Define the DSN string connection
     */
    public function setDsn($dsn)
    {
        $this->dsn = $dsn;
    }

    /**
     * @param $dbname
     */
    public function setDbname($dbname)
    {
        $this->dbname = $dbname;
    }

    /**
     * @return \Doctrine\ODM\MongoDB\DocumentManager
     */
    public function getDocumentManager()
    {
        return $this->documentManager;
    }
}
