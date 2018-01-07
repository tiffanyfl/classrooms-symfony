<?php

namespace ClassBundle\Form;

use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Doctrine\ORM\EntityRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use ClassBundle\Entity\Classroom;

class ClassroomSeatType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
      $test = $options['empty_data'];
      $test2 = $options['label'];
      $builder->add('number')->add('seatClass', EntityType::class, array(
          'class' => 'ClassBundle:Classroom',
          'choice_label' => 'name',
              //'query_builder' => function (EntityRepository $er) {
        //return $er->createQueryBuilder('u')
            //->orderBy('u.name', 'ASC');
    //},
          //'preferred_choices' => 'id',
      ));
    }/**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'ClassBundle\Entity\Seat'
        ));
        $resolver->setDefaults([
			'empty_data',
      'id'
		]);
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'classbundle_seat';
    }


}
