<?php

namespace TransportBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use TransportBundle\Entity\Transport;

class TransportAdminController extends Controller
{
    public function indexAction()
    {
        return $this->render('@Transport/Transport/Home2.html.twig');
    }
    public function AfficheAdminAction()
    {
        $em = $this->getDoctrine()->getManager();

        $tickets = $em->getRepository(Transport::class)->findAll();

        return $this->render('@Transport/Transport/afficheadmin.html.twig', array(
            'tickets' => $tickets,
        ));
    }
}
