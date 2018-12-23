<?php

namespace Tests\AppBundle\Controller\User;

use Tests\AppBundle\Controller\AbstractPreAuthenticatedTest;

class UserControllerTest extends AbstractPreAuthenticatedTest
{
    public function testGetContactsAction()
    {
        $page = 1;
        $total = 1; // to try paging with little data

        do {
            $client = $this->makeRequestWithAccess('GET', "api/v1/contacts/page/$page/total/$total");

            $this->assertEquals(200, $client->getResponse()->getStatusCode());
            $this->assertJson($client->getResponse()->getContent());

            $contactsResponse = json_decode($client->getResponse()->getContent(), true);

            $this->assertTrue(is_array($contactsResponse));
            $this->assertArrayHasKey('page', $contactsResponse);
            $this->assertArrayHasKey('total', $contactsResponse);
            $this->assertArrayHasKey('totalRecords', $contactsResponse);
            $this->assertArrayHasKey('hasNext', $contactsResponse);

            $this->assertArrayHasKey('contacts', $contactsResponse);
            $this->assertTrue(is_array($contactsResponse['contacts']));
            foreach ($contactsResponse['contacts'] as $contact) {
                $this->validateContactData($contact);
            }

            $this->assertTrue($contactsResponse['page'] === $page);
            $this->assertTrue($contactsResponse['total'] === $total);

            $page++;

        } while ($contactsResponse['hasNext']);

    }

    private function validateContactData($contactData)
    {
        $this->assertTrue(is_array($contactData));
        $this->assertArrayHasKey('id', $contactData);
        $this->assertArrayHasKey('name', $contactData);
        $this->assertArrayHasKey('phoneNumber', $contactData);
    }
}