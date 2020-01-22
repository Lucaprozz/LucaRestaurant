<?php

namespace App\Form;

use App\Entity\Reservatie;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TimeType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ReservatieType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('datum_tijd', TimeType::class, [
                'input' => 'datetime',
                'widget' => 'choice',
                'minutes' => [0, 15, 30, 45],
                'hours' => [17, 18, 19, 20, 21],
            ])
            ->add('aantal')
            ->add('user_id')
            ->add('medewerker_id')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Reservatie::class,
        ]);
    }
}
