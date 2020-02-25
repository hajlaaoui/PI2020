<?php

namespace OpportuniteBundle\Controller;

use OpportuniteBundle\Entity\opportunite;
use OpportuniteBundle\Entity\postulation;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Postulation controller.
 *
 * @Route("postulation")
 */
class postulationController extends Controller
{
    /**
     * Lists all postulation entities.
     *
     * @Route("/", name="postulation_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $postulations = $em->getRepository('OpportuniteBundle:postulation')->findAll();

        return $this->render('postulation/index.html.twig', array(
            'postulations' => $postulations,
        ));
    }

    /**
     * Creates a new postulation entity.
     *
     * @Route("/{id}/new", name="postulation_new")
     * @Method({"GET", "POST"})
     */
    public function postulationAction(opportunite $opportunite)
    {
        $postulation = new Postulation();

        $test = false;
        $postulateur = $this ->getUser();
        $post = $this->getDoctrine()->getRepository(postulation::class)->findBy(array('fos_user'=>$postulateur,'opportunite'=>$opportunite->getId()));
        if ($post != null)
        {
            var_dump('user already registred');
            $test = true;
        }
        else {
            $postulation->setFosUser($postulateur);
            $postulation->setOpportunite($opportunite);
            //$postulation->setDate(date('dd/mm/YYYY'));
            $count = $opportunite->getNbPlace();
            if ($count == 0)
            {
                $count = 0 ;
            }
            $opportunite->setNbPlace($count - 1);
            $em = $this->getDoctrine()->getManager();
            $em->persist($postulation);
            $em->flush();

            $basic  = new \Nexmo\Client\Credentials\Basic('a9f6406c', 'oAwWMpjAQEhmCbr6');
            $client = new \Nexmo\Client($basic);

            $message = $client->message()->send([
                'to' => '21652371878',
                'from' => 'SolidarityRefugee',
                'text' => 'Merci pour postuler dans notre opportunité'
            ]);
        }

        //$form = $this->createForm('OpportuniteBundle\Form\postulationType', $postulation);
        //$form->handleRequest($request);

        /*if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($postulation);
            $em->flush();

            return $this->redirectToRoute('postulation_show', array('id' => $postulation->getId()));
        }*/

        //return $this->redirectToRoute('opportunite_show', array('id' => $opportunite->getId()));

        return $this->render('opportuniteclient/showfront.html.twig', array(
            'opportunite' => $opportunite,
            'test' => $test,

        ));
    }

    /**
     * Finds and displays a postulation entity.
     *
     * @Route("/{id}", name="postulation_show")
     * @Method("GET")
     */
    public function showAction(postulation $postulation)
    {
        $deleteForm = $this->createDeleteForm($postulation);

        return $this->render('postulation/show.html.twig', array(
            'postulation' => $postulation,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing postulation entity.
     *
     * @Route("/{id}/edit", name="postulation_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, postulation $postulation)
    {
        $deleteForm = $this->createDeleteForm($postulation);
        $editForm = $this->createForm('OpportuniteBundle\Form\postulationType', $postulation);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('postulation_edit', array('id' => $postulation->getId()));
        }

        return $this->render('postulation/edit.html.twig', array(
            'postulation' => $postulation,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a postulation entity.
     *
     * @Route("/{id}", name="postulation_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, postulation $postulation)
    {
        $form = $this->createDeleteForm($postulation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($postulation);
            $em->flush();
        }

        return $this->redirectToRoute('postulation_index');
    }

    /**
     * Creates a form to delete a postulation entity.
     *
     * @param postulation $postulation The postulation entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(postulation $postulation)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('postulation_delete', array('id' => $postulation->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
