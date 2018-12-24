<?php

namespace AppBundle\Component\Client\Log;

use AppBundle\Model\CommunicationTypeInterface;

/**
 * Class LogHelper
 * @package AppBundle\Component\Client\Log
 */
class LogHelper
{
    const COMMUNICATION_LOG_PATTERN = '/^([s|c]){1}([^\.]{9})([^\.]{9})([^\.]{1})([^\.]{24})([^\.]{14})([^\.]{6})?/i';
    const COMMUNICATION_LOG_PATTERN_MATCHES = array(
        1 => 'type',
        2 => 'originNumber',
        3 => 'targetNumber',
        4 => 'incoming',
        5 => 'contactName',
        6 => 'timeStamp',
        7 => 'duration'
    );

    /**
     * @param string $logContent
     * @return Log[]|
     */
    public static function getLogs($logContent)
    {
        /**
         * @var Log[] $result
         */
        $result = array();

        // TODO An alternative to avoid this method is to use another database engine, for example mongodb because they are manipulating log files, this is only for test
        foreach (explode(PHP_EOL, $logContent) as $lineNumber => $line) {
            if (preg_match(self::COMMUNICATION_LOG_PATTERN, $line, $matches)) {

                // set up an data log
                $dataLog = array();

                // loop through the pattern's matches and set the data array correctly
                foreach (self::COMMUNICATION_LOG_PATTERN_MATCHES as $i => $key) {
                    if (isset($matches[$i])) {
                        $dataLog[$key] = $matches[$i];
                    } else {
                        $dataLog[self::COMMUNICATION_LOG_PATTERN_MATCHES[$i]] = null;
                    }
                }

                // parse the data
                $result[] = self::buildLog($dataLog);
            }
        }

        return $result;
    }

    /**
     * @param string $type
     * @return string
     */
    public static function getTypeValue($type)
    {
        return strtolower($type) === 'c' ? CommunicationTypeInterface::CALL : CommunicationTypeInterface::SMS;
    }

    /**
     * @param array $dataLog
     * @return Log
     */
    private static function buildLog(array $dataLog)
    {
        return new Log(
            $dataLog[self::COMMUNICATION_LOG_PATTERN_MATCHES[1]],
            $dataLog[self::COMMUNICATION_LOG_PATTERN_MATCHES[2]],
            $dataLog[self::COMMUNICATION_LOG_PATTERN_MATCHES[3]],
            $dataLog[self::COMMUNICATION_LOG_PATTERN_MATCHES[4]],
            $dataLog[self::COMMUNICATION_LOG_PATTERN_MATCHES[5]],
            $dataLog[self::COMMUNICATION_LOG_PATTERN_MATCHES[6]],
            $dataLog[self::COMMUNICATION_LOG_PATTERN_MATCHES[7]]
        );
    }
}