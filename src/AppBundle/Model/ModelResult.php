<?php

namespace AppBundle\Model;

/**
 * Class ModelResult
 * @package AppBundle\Model\Contact
 */
class ModelResult
{

    /**
     * @var int
     */
    private $totalRecords;

    /**
     * @var array
     */
    private $records;

    /**
     * ModelResult constructor.
     * @param int $totalRecords
     * @param array $records
     */
    public function __construct($totalRecords, $records)
    {
        $this->totalRecords = $totalRecords;
        $this->records = $records;
    }

    /**
     * @return int
     */
    public function getTotalRecords()
    {
        return $this->totalRecords;
    }

    /**
     * @param int $totalRecords
     */
    public function setTotalRecords($totalRecords)
    {
        $this->totalRecords = $totalRecords;
    }

    /**
     * @return array
     */
    public function getRecords()
    {
        return $this->records;
    }

    /**
     * @param array $records
     */
    public function setRecords($records)
    {
        $this->records = $records;
    }
}