<?php

namespace App\Controller\Livreur;

use App\Entity\Prix;
use App\Form\PrixType;
use App\Form\PrixLivType;
use App\Repository\PrixRepository;
use App\Repository\LivreurRepository;
use App\Repository\ZonelivRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Security;


#[Route('/livreur/prix')]
class PrixController extends AbstractController
{

    #[Route('/edit', name: 'app_prix_livreur_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, PrixRepository $prixRepository, ZonelivRepository $zonelivRepository,LivreurRepository $livreurRepository,Security $security): Response
    {
        $user = $security->getUser();
        $livreur = $livreurRepository->findOneBy(['user' => $user]);
        $zones = $zonelivRepository->findAll();
        $prixss= $prixRepository->findBy(["livreur"=>$livreur]);
        $prices = [];
        foreach($prixss as $index=>$value){
            $prices[$value->getZone()->getId()] = $value->getPrixht();
        }
        $form = $this->createForm(PrixLivType::class);
        $form->handleRequest($request);
        $em = $this->getDoctrine()->getManager();
        if ($form->isSubmitted() && $form->isValid()) {
            $prixs=$prixRepository->findBy(["livreur"=>$livreur]);            
            foreach($prixs as $ind=>$val){
                $em->remove($val);
            }
            $em->flush();            
            $prixHt = $request->request->get("prixht");
            $zones =  $request->request->get("zoneid");
            foreach($prixHt as $ind2=>$val2){
                $price = new Prix();
                $zone = $zonelivRepository->find($zones[$ind2]);
                $price->setPrixht($val2);
                $price->setZone($zone);
                $price->setLivreur($livreur);
                $prixRepository->save($price, true);
            }
            $em->flush();
            return $this->redirectToRoute('app_prix_livreur_edit', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('LivreurTmp/prix/edit.html.twig', [
            'form' => $form,
            'zones' => $zones,
            'prices' => $prices
        ]);
    }
}
