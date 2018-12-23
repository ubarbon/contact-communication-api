<?php

namespace Tests\AppBundle\Controller\User;

use Tests\AppBundle\Controller\AbstractPreAuthenticatedTest;

/**
 * Class CommunicationControllerTest
 * @package Tests\AppBundle\Controller\User
 */
class CommunicationControllerTest extends AbstractPreAuthenticatedTest
{
    public function testGetCommunicationsAction()
    {
        // Fetch contacts from user
        $contactsResponse = UserControllerTest::getContactsResponse($this, 1, 10);

        foreach ($contactsResponse['contacts'] as $contact) {
            $page = 1;
            $total = 1; // to try paging with little data

            do {
                // Fetch communication from contact
                $client = $this->makeRequestWithAccess('GET', "api/v1/contact/{$contact['id']}/communications/page/$page/total/$total");

                $this->assertEquals(200, $client->getResponse()->getStatusCode());
                $this->assertJson($client->getResponse()->getContent());

                $communicationsResponse = json_decode($client->getResponse()->getContent(), true);

                $this->assertTrue(is_array($communicationsResponse));
                $this->assertArrayHasKey('page', $communicationsResponse);
                $this->assertArrayHasKey('total', $communicationsResponse);
                $this->assertArrayHasKey('totalRecords', $communicationsResponse);
                $this->assertArrayHasKey('hasNext', $communicationsResponse);

                $this->assertArrayHasKey('communications', $communicationsResponse);
                $this->assertTrue(is_array($communicationsResponse['communications']));
                foreach ($communicationsResponse['communications'] as $communication) {
                    $this->validateCommunicationData($communication);
                }

                $this->assertTrue($communicationsResponse['page'] === $page);
                $this->assertTrue($communicationsResponse['total'] === $total);

                $page++;

            } while ($communicationsResponse['hasNext']);
        }
    }

    /**
     * @param array $communication
     */
    private function validateCommunicationData($communication)
    {
        $this->assertTrue(is_array($communication));
        $this->assertArrayHasKey('id', $communication);
        $this->assertArrayHasKey('hash', $communication);
        $this->assertArrayHasKey('incoming', $communication);
        $this->assertArrayHasKey('date', $communication);
        $this->assertArrayHasKey('type', $communication);

        if ($communication['type'] === 'call') {
            $this->assertArrayHasKey('duration', $communication);
        }
    }
}