<?php

namespace ClassBundle\Controller;

use ClassBundle\Entity\Speaker;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Speaker controller.
 *
 * @Route("speaker")
 */
class SpeakerController extends Controller
{
    /**
     * Lists all speaker entities.
     *
     * @Route("/", name="speaker_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $speakers = $em->getRepository('ClassBundle:Speaker')->findAll();

        return $this->render('speaker/index.html.twig', array(
            'speakers' => $speakers,
        ));
    }

    /**
     * Creates a new speaker entity.
     *
     * @Route("/new", name="speaker_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $speaker = new Speaker();
        $form = $this->createForm('ClassBundle\Form\SpeakerType', $speaker);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($speaker);
            $em->flush();

            return $this->redirectToRoute('speaker_show', array('id' => $speaker->getId()));
        }

        return $this->render('speaker/new.html.twig', array(
            'speaker' => $speaker,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a speaker entity.
     *
     * @Route("/{id}", name="speaker_show")
     * @Method("GET")
     */
    public function showAction(Speaker $speaker)
    {
        $deleteForm = $this->createDeleteForm($speaker);

        return $this->render('speaker/show.html.twig', array(
            'speaker' => $speaker,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing speaker entity.
     *
     * @Route("/{id}/edit", name="speaker_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Speaker $speaker)
    {
        $deleteForm = $this->createDeleteForm($speaker);
        $editForm = $this->createForm('ClassBundle\Form\SpeakerType', $speaker);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('speaker_edit', array('id' => $speaker->getId()));
        }

        return $this->render('speaker/edit.html.twig', array(
            'speaker' => $speaker,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a speaker entity.
     *
     * @Route("/{id}", name="speaker_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Speaker $speaker)
    {
        $form = $this->createDeleteForm($speaker);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($speaker);
            $em->flush();
        }

        return $this->redirectToRoute('speaker_index');
    }

    /**
     * Creates a form to delete a speaker entity.
     *
     * @param Speaker $speaker The speaker entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Speaker $speaker)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('speaker_delete', array('id' => $speaker->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
