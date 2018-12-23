<?php

namespace Tests\AppBundle\Controller\User;

use Tests\AppBundle\Controller\AbstractPreAuthenticatedTest;

class UserControllerTest extends AbstractPreAuthenticatedTest
{
    public function testGetContactsAction()
    {
        $client = $this->makeRequestWithAccess('GET', '/api/v1/contacts');

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $this->assertJson($client->getResponse()->getContent());

        $contactsResponse = json_decode($client->getResponse()->getContent(), true);

        $this->assertTrue(is_array($contactsResponse));
        $this->assertArrayHasKey('contacts', $contactsResponse);
        $this->assertTrue(is_array($contactsResponse['contacts']));

        foreach ($contactsResponse['contacts'] as $contact) {
            $this->assertArrayHasKey('id', $contact);
            $this->assertArrayHasKey('name', $contact);
            $this->assertArrayHasKey('phoneNumber', $contact);
        }
    }

}