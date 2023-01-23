<?php
namespace App\EventListener;

use App\Entity\Commande;
use Doctrine\Persistence\Event\LifecycleEventArgs;

class ChangeStatusCommande
{
    public function postPersist(LifecycleEventArgs $args): void
    {
        $entity = $args->getObject();

        // if this listener only applies to certain entity types,
        // add some code to check the entity type as early as possible
        if (!$entity instanceof Commande) {
            var_dump($entity);
            die("koll");
        }

        $entityManager = $args->getObjectManager();
        // ... do something with the Product entity
    }

    public function postUpdate(Deplacement $deplacement, LifecycleEventArgs $args)
    {

    }

}