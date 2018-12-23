<?php

namespace AppBundle\Model\Contact;

use AppBundle\Model\ModelResult;

/**
 * Class ContactsResponse
 * @package AppBundle\Model\Contact
 */
class ContactsResponse
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
        $response['contacts'] = array();

        foreach ($modelResult->getRecords() as $contact) {
            $response['contacts'][] = array(
                'id' => $contact['id'],
                'name' => $contact['name'],
                'phoneNumber' => $contact['phoneNumber']
            );
        }

        return $response;
    }
}