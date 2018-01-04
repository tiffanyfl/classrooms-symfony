<?php

namespace ClassBundle\Controller;

use ClassBundle\Entity\Seat;
use ClassBundle\Entity\Student;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

/**
 * Seat controller.
 *
 * @Route("seat")
 */
class SeatController extends Controller
{
    /**
     * Lists all seat entities.
     *
     * @Route("/", name="seat_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $seats = $em->getRepository('ClassBundle:Seat')->findAll();

        return $this->render('seat/index.html.twig', array(
            'seats' => $seats,
        ));
    }

    /**
     * Creates a new seat entity.
     *
     * @Route("/new", name="seat_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $seat = new Seat();
        $form = $this->createForm('ClassBundle\Form\SeatType', $seat);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($seat);
            $em->flush();

            return $this->redirectToRoute('seat_show', array('id' => $seat->getId()));
        }

        return $this->render('seat/new.html.twig', array(
            'seat' => $seat,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a seat entity.
     *
     * @Route("/{id}", name="seat_show")
     * @Method("GET")
     */
    public function showAction(Seat $seat)
    {
        $deleteForm = $this->createDeleteForm($seat);

        return $this->render('seat/show.html.twig', array(
            'seat' => $seat,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing seat entity.
     *
     * @Route("/{id}/edit", name="seat_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Seat $seat)
    {
        $deleteForm = $this->createDeleteForm($seat);
        $editForm = $this->createForm('ClassBundle\Form\SeatType', $seat);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('seat_edit', array('id' => $seat->getId()));
        }

        return $this->render('seat/edit.html.twig', array(
            'seat' => $seat,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a seat entity.
     *
     * @Route("/{id}", name="seat_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Seat $seat)
    {
        $form = $this->createDeleteForm($seat);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($seat);
            $em->flush();
        }

        return $this->redirectToRoute('seat_index');
    }




    /**
    *@Route("/{id}/assign/student", name="student_id")
    *@Method({"GET", "POST"})
    */
    public function assignSeatStudent(Request $request, Seat $seat)
    {
      $addstuForm = $this->createForm('ClassBundle\Form\SeatStudentType', $seat);

      $addstuForm->handleRequest($request);

      if($addstuForm->isSubmitted() && $addstuForm->isValid()) {
        $stuseat = $addstuForm->get('seatStudent')->getData();
        foreach ($stuseat as $stud) {
          $seat->addSeatStudent($stud);
        }

        $this->getDoctrine()->getManager()->flush();
        return $this->redirectToRoute('seat_show', array('id' => $seat->getId()));
      }

      return $this->render('seat/student_seat.html.twig', array(
        'seat' => $seat,
        'seatForm' => $addstuForm->createView(),
      ));
    }

    /**
     * Creates a form to delete a seat entity.
     *
     * @param Seat $seat The seat entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Seat $seat)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('seat_delete', array('id' => $seat->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
