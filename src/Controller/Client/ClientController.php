<?php

namespace App\Controller\Client;

use App\Entity\Client;
use App\Form\ClientType;
use App\Repository\ClientRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\HttpFoundation\JsonResponse;

#[Route('/client/client')]
class ClientController extends AbstractController
{
    #[Route('/getAdresse', name: 'app_client_get_adresse', methods: ['GET'])]
    public function index(ClientRepository $clientRepository,Security $security): Response
    {
        $user = $security->getUser();
        $client = $clientRepository->findOneBy(['user' => $user]);
        $adresse = [
            "adresse" => $client->getAdresse(),
            "ville" => $client->getVille(),
            "codePostal" => $client->getCodePostal(),
            "pays" => $client->getPays()
        ];
        return new JsonResponse($adresse);
    }

}
