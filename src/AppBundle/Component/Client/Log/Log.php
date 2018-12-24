<?php

namespace AppBundle\Component\Client\Log;

/**
 * Class Log
 * @package AppBundle\Component\Client\Log
 */
class Log
{

    /**
     * @var string
     */
    private $type;

    /**
     * @var string
     */
    private $originNumber;

    /**
     * @var string
     */
    private $targetNumber;

    /**
     * @var string
     */
    private $incoming;

    /**
     * @var string
     */
    private $contactName;

    /**
     * @var string
     */
    private $timeStamp;

    /**
     * @var string
     */
    private $duration;

    /**
     * Log constructor.
     * @param string $type
     * @param string $originNumber
     * @param string $targetNumber
     * @param string $incoming
     * @param string $contactName
     * @param string $timeStamp
     * @param string $duration
     */
    public function __construct($type, $originNumber, $targetNumber, $incoming, $contactName, $timeStamp, $duration)
    {
        $this->type = $type;
        $this->originNumber = $originNumber;
        $this->targetNumber = $targetNumber;
        $this->incoming = $incoming;
        $this->contactName = $contactName;
        $this->timeStamp = $timeStamp;
        $this->duration = $duration;
    }

    /**
     * @return string
     */
    public function getTypeValue()
    {
        return LogHelper::getTypeValue($this->getType());
    }

    /**
     * @return int
     */
    public function getOriginNumberValue()
    {
        return (int)$this->getOriginNumber();
    }

    /**
     * @return int
     */
    public function getTargetNumberValue()
    {
        return (int)$this->getTargetNumber();
    }

    /**
     * @return boolean
     */
    public function getIncomingValue()
    {
        return (boolean)$this->getIncoming();
    }

    /**
     * @return string
     */
    public function getContactNameValue()
    {
        $contactName = trim($this->getContactName());

        return $contactName ?: $this->getContactPhoneNumber();
    }

    /**
     * @return \DateTime
     * @throws \Exception
     */
    public function getDate()
    {
        return \DateTime::createFromFormat('YmdHis', $this->getTimeStamp());
    }

    /**
     * @return int
     */
    public function getDurationValue()
    {
        return (int)$this->duration;
    }

    /**
     * @return int
     */
    public function getContactPhoneNumber()
    {
        return $this->getIncomingValue() ? $this->getOriginNumberValue() : $this->getTargetNumberValue();
    }

    /**
     * @return string
     */
    public function getHash()
    {
        // Signed always  with the original values
        return md5(implode('', array($this->getType(), $this->getOriginNumber(), $this->getTargetNumber(), $this->getIncoming(), $this->getContactName(), $this->getTimeStamp(), $this->getDuration())));
    }

    /**
     * @return string
     */
    private function getType()
    {
        return $this->type;
    }

    /**
     * @return string
     */
    private function getOriginNumber()
    {
        return $this->originNumber;
    }

    /**
     * @return string
     */
    private function getTargetNumber()
    {
        return $this->targetNumber;
    }

    /**
     * @return string
     */
    private function getIncoming()
    {
        return $this->incoming;
    }

    /**
     * @return string
     */
    private function getContactName()
    {
        return $this->contactName;
    }

    /**
     * @return string
     */
    private function getTimeStamp()
    {
        return $this->timeStamp;
    }

    /**
     * @return string
     */
    private function getDuration()
    {
        return $this->duration;
    }
}