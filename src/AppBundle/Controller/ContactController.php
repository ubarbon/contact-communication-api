<?php

namespace AppBundle\Controller;

use AppBundle\Model\Contact\ContactsResponse;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

/**
 * Class ContactController
 * @package AppBundle\Controller
 */
class ContactController extends Controller
{

    /**
     * @param int $page
     * @param int $total
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     * @throws \Doctrine\ORM\NoResultException
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function getContactsAction($page, $total)
    {
        if ($page <= 0 || $total <= 0) {
            throw new BadRequestHttpException('Page or Total parameter can not be less than or equal to zero');
        }

        $contactsResult = $this->getDoctrine()->getManager()->getRepository('AppBundle:Contact')->getContactsResult($this->getUser()->getId(), (($page - 1) * $total), $total);

        return $this->json(ContactsResponse::getResponse($contactsResult, $page, $total));
    }
}
