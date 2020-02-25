<?php

namespace OpportuniteBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('OpportuniteBundle:Default:index.html.twig');
    }
}
