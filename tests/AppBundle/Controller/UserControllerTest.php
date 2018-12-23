<?php

namespace Tests\AppBundle\Controller\User;

use Tests\AppBundle\Controller\AbstractPreAuthenticatedTest;

/**
 * Class UserControllerTest
 * @package Tests\AppBundle\Controller\User
 */
class UserControllerTest extends AbstractPreAuthenticatedTest
{
    public function testGetContactsAction()
    {
        $page = 1;
        $total = 1; // to try paging with little data

        do {
            // Fetch contacts from user
            $contactsResponse = self::getContactsResponse($this, $page, $total);

            $this->assertTrue($contactsResponse['page'] === $page);
            $this->assertTrue($contactsResponse['total'] === $total);

            $page++;

        } while ($contactsResponse['hasNext']);

    }

    /**
     * @param AbstractPreAuthenticatedTest $abstractPreAuthenticatedTest
     * @param int $page
     * @param int $total
     * @return mixed
     */
    public static function getContactsResponse(AbstractPreAuthenticatedTest $abstractPreAuthenticatedTest, $page, $total)
    {
        $client = $abstractPreAuthenticatedTest->makeRequestWithAccess('GET', "api/v1/contacts/page/$page/total/$total");

        $abstractPreAuthenticatedTest->assertEquals(200, $client->getResponse()->getStatusCode());
        $abstractPreAuthenticatedTest->assertJson($client->getResponse()->getContent());

        $contactsResponse = json_decode($client->getResponse()->getContent(), true);

        $abstractPreAuthenticatedTest->assertTrue(is_array($contactsResponse));
        $abstractPreAuthenticatedTest->assertArrayHasKey('page', $contactsResponse);
        $abstractPreAuthenticatedTest->assertArrayHasKey('total', $contactsResponse);
        $abstractPreAuthenticatedTest->assertArrayHasKey('totalRecords', $contactsResponse);
        $abstractPreAuthenticatedTest->assertArrayHasKey('hasNext', $contactsResponse);

        $abstractPreAuthenticatedTest->assertArrayHasKey('contacts', $contactsResponse);
        $abstractPreAuthenticatedTest->assertTrue(is_array($contactsResponse['contacts']));
        foreach ($contactsResponse['contacts'] as $contact) {
            self::validateContactData($abstractPreAuthenticatedTest, $contact);
        }

        return $contactsResponse;
    }

    /**
     * @param AbstractPreAuthenticatedTest $abstractPreAuthenticatedTest
     * @param array $contactData
     */
    public static function validateContactData(AbstractPreAuthenticatedTest $abstractPreAuthenticatedTest, $contactData)
    {
        $abstractPreAuthenticatedTest->assertTrue(is_array($contactData));
        $abstractPreAuthenticatedTest->assertArrayHasKey('id', $contactData);
        $abstractPreAuthenticatedTest->assertArrayHasKey('name', $contactData);
        $abstractPreAuthenticatedTest->assertArrayHasKey('phoneNumber', $contactData);
    }
}