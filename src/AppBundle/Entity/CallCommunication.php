<?php

namespace AppBundle\Entity;

/**
 * CallCommunication
 */
class CallCommunication extends Communication
{
    /**
     * @var string
     */
    private $duration;

    /**
     * Set duration
     *
     * @param string $duration
     *
     * @return CallCommunication
     */
    public function setDuration($duration)
    {
        $this->duration = $duration;

        return $this;
    }

    /**
     * Get duration
     *
     * @return string
     */
    public function getDuration()
    {
        return $this->duration;
    }
}

