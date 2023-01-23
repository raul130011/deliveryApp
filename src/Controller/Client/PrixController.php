<?php

namespace App\Controller\Client;

use App\Repository\PrixRepository;
use App\Repository\ZonelivRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Security;
use App\Service\ClaculatePrix;
use Symfony\Component\HttpFoundation\JsonResponse;

#[Route('/client/prix')]
class PrixController extends AbstractController
{
    
    #[Route('/getPrixColis', name: 'get_client_prix_by_livreur', methods: ['GET', 'POST'])]
    public function edit(Request $request, Security $security,ClaculatePrix $calculatePrix,PrixRepository $prixRepository,ZonelivRepository $zonelivRepository): Response
    {
        $user = $security->getUser();
        $klm = $request->query->get("kilometrage");
        $poids = $request->query->get("colisPoids");
        $longueurs = $request->query->get("colisLongueur");
        $largeurs = $request->query->get("colisLargeur");
        $hauteurs = $request->query->get("colisHauteur");
        $listPrices = $calculatePrix->findPrices($klm,$poids,$longueurs,$largeurs,$hauteurs,$prixRepository,$zonelivRepository);
        return new JsonResponse($listPrices);
    }
}
