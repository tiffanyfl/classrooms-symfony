<?php

namespace ClassBundle\Controller;

use ClassBundle\Entity\Classroom;
use ClassBundle\Entity\Seat;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;

/**
 * Classroom controller.
 *
 * @Route("classroom")
 */
class ClassroomController extends Controller
{
    /**
     * Lists all classroom entities.
     *
     * @Route("/", name="classroom_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $classrooms = $em->getRepository('ClassBundle:Classroom')->findAll();

        return $this->render('classroom/index.html.twig', array(
            'classrooms' => $classrooms,
        ));
    }

    /**
     * Creates a new classroom entity.
     *
     * @Route("/new", name="classroom_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $classroom = new Classroom();
        $form = $this->createForm('ClassBundle\Form\ClassroomType', $classroom);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($classroom);
            $em->flush();

            return $this->redirectToRoute('classroom_show', array('id' => $classroom->getId()));
        }

        return $this->render('classroom/new.html.twig', array(
            'classroom' => $classroom,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a classroom entity.
     *
     * @Route("/{id}", name="classroom_show")
     * @Method("GET")
     */
    public function showAction(Classroom $classroom)
    {
        $deleteForm = $this->createDeleteForm($classroom);

        return $this->render('classroom/show.html.twig', array(
            'classroom' => $classroom,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing classroom entity.
     *
     * @Route("/{id}/edit", name="classroom_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Classroom $classroom)
    {
        $deleteForm = $this->createDeleteForm($classroom);
        $editForm = $this->createForm('ClassBundle\Form\ClassroomType', $classroom);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('classroom_edit', array('id' => $classroom->getId()));
        }

        return $this->render('classroom/edit.html.twig', array(
            'classroom' => $classroom,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a classroom entity.
     *
     * @Route("/{id}", name="classroom_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Classroom $classroom)
    {
        $form = $this->createDeleteForm($classroom);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($classroom);
            $em->flush();
        }

        return $this->redirectToRoute('classroom_index');
    }

    /**
     * Creates a form to delete a classroom entity.
     *
     * @param Classroom $classroom The classroom entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Classroom $classroom)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('classroom_delete', array('id' => $classroom->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }

    /**
    *@Route("/{id}/assign/speaker", name="speaker_id")
    *@Method({"GET","POST"})
    */

    public function assignSpeaker(Request $request, Classroom $classroom){

        $assignForm = $this->createForm('ClassBundle\Form\ClassroomSpeakerType', $classroom);
        $assignForm->handleRequest($request);

        if ($assignForm->isSubmitted() && $assignForm->isValid()) {
            $speakers = $assignForm->get('speaker')->getData();
            foreach ($speakers as $speaker) {
                $classroom->addSpeaker($speaker);
            }

            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('classroom_show', array('id' => $classroom->getId()));
        }

        return $this->render('classroom/assign_speaker.html.twig', array(
            'classroom' => $classroom,
            'assign_form' => $assignForm->createView(),
        ));

    }

    /**
    *@Route("/{id}/add/seat", name="seat_class_id")
    *@Method({"GET","POST"})
    */
    public function addSeat($id, Request $request, Classroom $classroom){
        $seatClassroom = new Seat();
        $addForm = $this->createForm('ClassBundle\Form\ClassroomSeatType', $seatClassroom, ['label' => $id, 'empty_data' => $classroom]);
        $addForm->handleRequest($request);

        if ($addForm->isSubmitted() && $addForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $seatClassroom->setSeatClass($classroom);
            $em->persist($seatClassroom);
            $em->flush();
            return $this->redirectToRoute('classroom_show', array('id' => $classroom->getId()));
            console.log($id);
        }

        return $this->render('classroom/add_seat.html.twig', array(
            'seat' => $seatClassroom,
            'addseat_form' => $addForm->createView(),
        ));
    }

}
