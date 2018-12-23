<?php

namespace AppBundle\Controller;

use AppBundle\Model\Communication\CommunicationsResponse;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\HttpKernel\Exception\ConflictHttpException;

/**
 * Class CommunicationController
 * @package AppBundle\Controller
 */
class CommunicationController extends Controller
{

    /**
     * @param int $contactId
     * @param int $page
     * @param int $total
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     * @throws \Doctrine\ORM\NoResultException
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function getCommunicationsAction($contactId, $page, $total)
    {
        if ($page <= 0 || $total <= 0) {
            throw new BadRequestHttpException('Page or Total parameter can not be less than or equal to zero');
        }

        if (!$contact = $this->getDoctrine()->getManager()->getRepository('AppBundle:Contact')->findOneBy(array('id' => $contactId, 'user' => $this->getUser()->getId()))) {
            throw new ConflictHttpException("No found contact with id:{$contactId} for user with id:{$this->getUser()->getId()}");
        }

        $communicationsResult = $this->getDoctrine()->getManager()->getRepository('AppBundle:Communication')->getCommunicationsResult($this->getUser()->getId(), $contactId, (($page - 1) * $total), $total);

        return $this->json(CommunicationsResponse::getResponse($communicationsResult, $page, $total));
    }
}
