<?php

namespace App\Form;

use App\Entity\Zoneliv;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class ZonelivType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name')
            ->add('kilometrage',ChoiceType::class, [
                'choices' => [
                    "0-30 KM"=>1,
                    "31-100 KM"=>2,
                    "101-300 KM"=>3,
                    "301-600 KM"=>4,
                    "601-1200 KM"=>5,
                    "1201-2000 KM"=>6,
                    "2001-3000 KM"=>7,
                    "+3000 KM"=>8,
            ]])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Zoneliv::class,
        ]);
    }
}
