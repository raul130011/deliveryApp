<?php

namespace App\Form;

use App\Entity\Commande;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class CommandeType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('Client')
            ->add('adresseDepart')
            ->add('adresseArrivee')
            ->add('type',ChoiceType::class, [
                'choices' => [
                    "Livraison à domicile"=>1,
                    "Livraison au lieu de travail "=>2,
                    "Point de relais"=>3
            ]])
            ->add('etat',ChoiceType::class, [
                'choices' => [
                    "En Attente"=>1,
                    "Payé"=>2,
                    "Rejeté"=>3,
                    "En cours"=>4,
                    "Livré"=>5
            ]])
            ->add('creneau')
            ->add('prixHt')
            ->add('prixTtc')
            ->add('Livreur')

        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Commande::class,
        ]);
    }
}
