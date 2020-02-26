<?php

namespace TransportBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use TransportBundle\Entity\Transport;

class TransportController extends Controller
{
    public function AfficheAction()
    {
        $em = $this->getDoctrine()->getManager();

        $tickets = $em->getRepository(Transport::class)->findAll();

        return $this->render('@Transport/Transport/affiche.html.twig', array(
            'tickets' => $tickets,
        ));
    }
    public function nneAction()
    {
        //////
    }
}
