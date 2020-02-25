<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use DonsBundle\Entity\Notification;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction(Request $request)
    {
        // replace this example code with whatever you need
        return $this->render('default/index.html.twig', [
            'base_dir' => realpath($this->getParameter('kernel.project_dir')).DIRECTORY_SEPARATOR,
        ]);
    }

    /**
     * @Route("/admin", name="dashboard")
     */
    public function indexAdminAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $notifications = $em->getRepository('DonsBundle:Notification')->findAll();
        // replace this example code with whatever you need
        return $this->render('base2.html.twig', [
            'base_dir' => realpath($this->getParameter('kernel.project_dir')).DIRECTORY_SEPARATOR,
            'notifications' => $notifications
        ]);
    }
}
