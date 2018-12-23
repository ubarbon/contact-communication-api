<?php

namespace AppBundle\Model\Contact;

use AppBundle\Model\ModelResult;

/**
 * Class ContactResponse
 * @package AppBundle\Model\Contact
 */
class ContactResponse
{

    /**
     * @param ModelResult $modelResult
     * @param int $page
     * @param int $total
     * @return array
     */
    public static function getResponse(ModelResult $modelResult, $page, $total)
    {
        $response = array(
            'page' => (int)$page,
            'total' => (int)$total,
            'totalRecords' => $modelResult->getTotalRecords(),
            'hasNext' => (($page * $total) < $modelResult->getTotalRecords()),
            'contacts' => array()
        );

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