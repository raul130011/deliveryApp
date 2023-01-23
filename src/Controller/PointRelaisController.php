<?php

namespace App\Controller;

use App\Entity\PointRelais;
use App\Form\PointRelaisType;
use App\Repository\PointRelaisRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin/point/relais')]
class PointRelaisController extends AbstractController
{
    #[Route('/', name: 'app_point_relais_index', methods: ['GET'])]
    public function index(PointRelaisRepository $pointRelaisRepository): Response
    {
        return $this->render('point_relais/index.html.twig', [
            'point_relais' => $pointRelaisRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_point_relais_new', methods: ['GET', 'POST'])]
    public function new(Request $request, PointRelaisRepository $pointRelaisRepository): Response
    {
        $pointRelai = new PointRelais();
        $form = $this->createForm(PointRelaisType::class, $pointRelai);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $pointRelaisRepository->save($pointRelai, true);

            return $this->redirectToRoute('app_point_relais_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('point_relais/new.html.twig', [
            'point_relai' => $pointRelai,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_point_relais_show', methods: ['GET'])]
    public function show(PointRelais $pointRelai): Response
    {
        return $this->render('point_relais/show.html.twig', [
            'point_relai' => $pointRelai,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_point_relais_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, PointRelais $pointRelai, PointRelaisRepository $pointRelaisRepository): Response
    {
        $form = $this->createForm(PointRelaisType::class, $pointRelai);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $pointRelaisRepository->save($pointRelai, true);

            return $this->redirectToRoute('app_point_relais_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('point_relais/edit.html.twig', [
            'point_relai' => $pointRelai,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_point_relais_delete', methods: ['POST'])]
    public function delete(Request $request, PointRelais $pointRelai, PointRelaisRepository $pointRelaisRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$pointRelai->getId(), $request->request->get('_token'))) {
            $pointRelaisRepository->remove($pointRelai, true);
        }

        return $this->redirectToRoute('app_point_relais_index', [], Response::HTTP_SEE_OTHER);
    }
}
