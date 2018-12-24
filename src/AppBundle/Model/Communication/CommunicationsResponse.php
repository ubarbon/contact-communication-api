<?php

namespace AppBundle\Model\Communication;

use AppBundle\Model\ModelResult;

/**
 * Class CommunicationsResponse
 * @package AppBundle\Model\Communication
 */
class CommunicationsResponse
{
    /**
     * @param ModelResult $modelResult
     * @param int $page
     * @param int $total
     * @return array
     */
    public static function getResponse(ModelResult $modelResult, $page, $total)
    {
        $response = ModelResult::getPaginationResponse($modelResult, $page, $total);
        $response['communications'] = array();

        foreach ($modelResult->getRecords() as $communication) {
            $communicationItem = array(
                'id' => $communication['id'],
                'incoming' => $communication['incoming'],
                'date' => $communication['date']->format(\DateTime::ISO8601),
                'type' => $communication['type']
            );

            if ($communication['type'] === 'call') {
                $communicationItem['duration'] = (int)$communication['duration'];
            }

            $response['communications'][] = $communicationItem;
        }

        return $response;
    }
}