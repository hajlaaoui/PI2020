<?php

namespace OpportuniteBundle\Controller;

use AppBundle\Entity\User;
use Gregwar\CaptchaBundle\Type\CaptchaType;
use MartinGeorgiev\SocialPost\Message;
use MartinGeorgiev\SocialPost\SocialNetwork;
use OpportuniteBundle\Entity\opportunite;
use OpportuniteBundle\Entity\postulation;
use Swift_Message;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpFoundation\Request;

/**
 * Opportunite controller.
 *
 * @Route("opportunite")
 */
class opportuniteController extends Controller
{
    /**
     * Lists all opportunite entities.
     *
     * @Route("/", name="opportunite_index")
     * @Method("GET")
     */
    public function indexAction()
    {

        $em = $this->getDoctrine()->getManager();
        $date = date('d/m/Y');

        $opportunites = $em->getRepository('OpportuniteBundle:opportunite')->findAll();

        return $this->render('opportunite/index.html.twig', array(
            'opportunites' => $opportunites,
            'date' =>$date,
        ));
    }
    public function indexaddAction(Request $request)
    {/*
        $em = $this->getDoctrine()->getManager();

        $opportunites = $em->getRepository('OpportuniteBundle:opportunite')->findAll();

        return $this->render('opportuniteadd/index.html.twig', array(
            'opportunites' => $opportunites,
        ));*/

        $paginator=$this->get('knp_paginator');
        $em = $this->getDoctrine()->getManager();
        $oppRep = $em->getRepository(opportunite::class);
        $alloppQuery = $oppRep->createQueryBuilder('o')->getQuery();

        $opps = $paginator->paginate(
            $alloppQuery,
            $request->query->getInt('page', 1),
            3
        );
        return $this->render('opportuniteadd/index.html.twig', ['pagination' => $opps]);



    }

    /**
     * Creates a new opportunite entity.
     *
     * @Route("/new", name="opportunite_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $opportunite = new Opportunite();
        $form = $this->createForm('OpportuniteBundle\Form\opportuniteType', $opportunite);
        $form->add('captcha', CaptchaType::class);
        $form->handleRequest($request);


        if ($form->isSubmitted() && $form->isValid()) {
            $image=$opportunite->getImage();
            $imageName = md5(uniqid()).'.'.$image ->guessExtension();
            $image->move(
                $this->getParameter('imageopp_directory'),$imageName
            );
            $opportunite->setImage($imageName);
            $em = $this->getDoctrine()->getManager();
            $em->persist($opportunite);
            $em->flush();

            return $this->redirectToRoute('opportunite_show', array('id' => $opportunite->getId()));
        }

        return $this->render('opportunite/new.html.twig', array(
            'opportunite' => $opportunite,
            'form' => $form->createView(),
        ));
    }
    public function newclientAction(Request $request)
    {
        $opportunite = new Opportunite();
        $opportunite->setEtat(false);
        $form = $this->createForm('OpportuniteBundle\Form\opportuniteType', $opportunite);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($opportunite);
            $em->flush();
            //Envoi d'un mail:
            // Create the Transport
            $transport = (new \Swift_SmtpTransport('smtp.gmail.com', 587, 'tls'))
                ->setUsername('hajlaouijihed10@gmail.com')
                ->setPassword('rwjoteqmmpkmewem');


           // You could alternatively use a different transport such as Sendmail:

            // Sendmail
            //$transport = new \Swift_SendmailTransport('/usr/sbin/sendmail -bs');


            // Create the Mailer using your created Transport
            $mailer = new \Swift_Mailer($transport);
            $user = $em->getRepository('AppBundle:User')->findAll();
            $mails=array();
            $mails=array();
            // Create a message
            $message = (new Swift_Message('Reply for your request'))
                ->setFrom('hajlaouijihed10@gmail.com')
            //    ->setTo('jihed.hajlaoui@esprit.tn')
                ->setBody('Dear ' .$opportunite->getDescriptionOpportunite(). ', Your request will be treated within 24 hours.');
            foreach ($user as $u)
            {
                array_push($mails,$u->getEmail());
            }
            $message->setTo($mails);
            // Send the message
            $mailer->send($message);
            ///////////////////

            return $this->redirectToRoute('opportunite_index', array('id' => $opportunite->getId()));
        }

        return $this->render('opportuniteclient/new.html.twig', array(
            'opportunite' => $opportunite,
            'formclient' => $form->createView(),
        ));
    }

    /*public function newclientAction(Request $request)
    {
        $opportunite = new Opportunite();
        $opportunite->setEtat(false);
        $form = $this->createForm('OpportuniteBundle\Form\opportuniteType', $opportunite);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($opportunite);
            $em->flush();

            return $this->redirectToRoute('opportunite_index', array('id' => $opportunite->getId()));
        }

        return $this->render('opportuniteclient/new.html.twig', array(
            'opportunite' => $opportunite,
            'formclient' => $form->createView(),
        ));
    }*/

    public function approuverAction(opportunite $opportunite)
    {
        $em = $this->getDoctrine()->getManager()->getRepository('OpportuniteBundle:opportunite')->approuver($opportunite->getId());
        //Envoi d'un mail:
        // Create the Transport
        $transport = (new \Swift_SmtpTransport('smtp.gmail.com', 587, 'tls'))
            ->setUsername('hajlaouijihed10@gmail.com')
            ->setPassword('rwjoteqmmpkmewem');


        // You could alternatively use a different transport such as Sendmail:

        // Sendmail
        //$transport = new \Swift_SendmailTransport('/usr/sbin/sendmail -bs');


        // Create the Mailer using your created Transport
        $mailer = new \Swift_Mailer($transport);
        $user =$this->getDoctrine()->getManager()->getRepository('AppBundle:User')->findAll();
        $mails=array();
        // Create a message
        $message = (new Swift_Message('Reply for your request'))
            ->setFrom('hajlaouijihed10@gmail.com')
            //    ->setTo('jihed.hajlaoui@esprit.tn')
            ->setBody('notre opportunite est un offre de : ' .$opportunite->getDescriptionOpportunite(). ', postuler avant '.$opportunite->getDate());
        foreach ($user as $u)
        {
            array_push($mails,$u->getEmail());
        }
        $message->setTo($mails);
        // Send the message
        $mailer->send($message);
        ///////////////////

        return $this->redirectToRoute('opportuniteadd_index');
    }

    /**
     * Finds and displays a opportunite entity.
     *
     * @Route("/{id}", name="opportunite_show")
     * @Method("GET")
     */
    public function showAction(opportunite $opportunite)
    {

        $deleteForm = $this->createDeleteForm($opportunite);
        $em = $this->getDoctrine()->getManager();
        $postulation = $em->getRepository('OpportuniteBundle:postulation')->findBy(array(
         'opportunite'=>$opportunite->getId()
     ));
        return $this->render('opportunite/show.html.twig', array(
            'opportunite' => $opportunite,
            'delete_form' => $deleteForm->createView(),
            'postulations' => $postulation,
        ));
    }

    /**
     * Finds and displays a opportunite entity.
     *
     * @Route("/{id}", name="opportunite_showfront")
     * @Method("GET")
     */
    public function showfrontAction(opportunite $opportunite)
    {
        //$deleteForm = $this->createDeleteForm($opportunite);
        $test = false;
        $postulateur = $this ->getUser();
        $post = $this->getDoctrine()->getRepository(postulation::class)->findBy(array('fos_user'=>$postulateur,'opportunite'=>$opportunite->getId()));
        if ($post != null)
        {
            var_dump('user already registred');
            $test = true;
        }
        return $this->render('opportuniteclient/showfront.html.twig', array(
            'opportunite' => $opportunite,
            'test'=>$test
            //'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing opportunite entity.
     *
     * @Route("/{id}/edit", name="opportunite_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, opportunite $opportunite)
    {
        $deleteForm = $this->createDeleteForm($opportunite);
        $editForm = $this->createForm('OpportuniteBundle\Form\opportuniteType', $opportunite);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('opportunite_edit', array('id' => $opportunite->getId()));
        }

        return $this->render('opportunite/edit.html.twig', array(
            'opportunite' => $opportunite,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a opportunite entity.
     *
     * @Route("/{id}", name="opportunite_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, opportunite $opportunite)
    {
        //$form = $this->createDeleteForm($opportunite);
        //$form->handleRequest($request);

        //if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($opportunite);
            $em->flush();
        //}

        return $this->redirectToRoute('opportuniteadd_index');
    }

    /**
     * Creates a form to delete a opportunite entity.
     *
     * @param opportunite $opportunite The opportunite entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(opportunite $opportunite)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('opportunite_delete', array('id' => $opportunite->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }


}
