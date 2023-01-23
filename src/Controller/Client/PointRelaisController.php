<?php

namespace App\Controller\Client;

use App\Entity\PointRelais;
use App\Repository\PointRelaisRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\SerializerInterface;

#[Route('/client/point/relais')]
class PointRelaisController extends AbstractController
{
    #[Route('/listPointRelais', name: 'app_point_relais_list', methods: ['GET'])]
    public function listRelais(PointRelaisRepository $pointRelaisRepository): Response
    {
        return new JsonResponse($pointRelaisRepository->findByAllJson());
    }

    #[Route('/listPointRelaisOne', name: 'app_point_relais_one', methods: ['GET'])]
    public function listRelaisOne(Request $request,PointRelaisRepository $pointRelaisRepository,SerializerInterface $serializer): Response
    {
        $Point = $pointRelaisRepository->findByOneJson($request->query->get("point_relais_id"));
        return new JsonResponse($Point[0]);
    }
}
