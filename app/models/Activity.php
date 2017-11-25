<?php

class Activity extends \Phalcon\Mvc\Model
{

    /**
     *
     * @var integer
     * @Primary
     * @Identity
     * @Column(type="integer", length=11, nullable=false)
     */
    public $activityid;

    /**
     *
     * @var string
     * @Column(type="string", length=100, nullable=false)
     */
    public $activityname;

    /**
     *
     * @var string
     * @Column(type="string", length=300, nullable=false)
     */
    public $activitydescription;

    /**
     *
     * @var string
     * @Column(type="string", nullable=false)
     */
    public $activitydate;

    /**
     *
     * @var string
     * @Column(type="string", length=100, nullable=false)
     */
    public $activityplace;

    /**
     * Initialize method for model.
     */
    public function initialize()
    {
        $this->setSchema("activity");
        $this->setSource("activity");
    }

    /**
     * Returns table name mapped in the model.
     *
     * @return string
     */
    public function getSource()
    {
        return 'activity';
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return Activity[]|Activity|\Phalcon\Mvc\Model\ResultSetInterface
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return Activity|\Phalcon\Mvc\Model\ResultInterface
     */
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }

}
