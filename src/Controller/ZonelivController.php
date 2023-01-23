<?php

namespace App\Controller;

use App\Entity\Zoneliv;
use App\Form\ZonelivType;
use App\Repository\ZonelivRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/zoneliv')]
class ZonelivController extends AbstractController
{
    #[Route('/', name: 'app_zoneliv_index', methods: ['GET'])]
    public function index(ZonelivRepository $zonelivRepository): Response
    {
        return $this->render('zoneliv/index.html.twig', [
            'zonelivs' => $zonelivRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_zoneliv_new', methods: ['GET', 'POST'])]
    public function new(Request $request, ZonelivRepository $zonelivRepository): Response
    {
        $zoneliv = new Zoneliv();
        $form = $this->createForm(ZonelivType::class, $zoneliv);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $zonelivRepository->save($zoneliv, true);

            return $this->redirectToRoute('app_zoneliv_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('zoneliv/new.html.twig', [
            'zoneliv' => $zoneliv,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_zoneliv_show', methods: ['GET'])]
    public function show(Zoneliv $zoneliv): Response
    {
        return $this->render('zoneliv/show.html.twig', [
            'zoneliv' => $zoneliv,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_zoneliv_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Zoneliv $zoneliv, ZonelivRepository $zonelivRepository): Response
    {
        $form = $this->createForm(ZonelivType::class, $zoneliv);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $zonelivRepository->save($zoneliv, true);

            return $this->redirectToRoute('app_zoneliv_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('zoneliv/edit.html.twig', [
            'zoneliv' => $zoneliv,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_zoneliv_delete', methods: ['POST'])]
    public function delete(Request $request, Zoneliv $zoneliv, ZonelivRepository $zonelivRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$zoneliv->getId(), $request->request->get('_token'))) {
            $zonelivRepository->remove($zoneliv, true);
        }

        return $this->redirectToRoute('app_zoneliv_index', [], Response::HTTP_SEE_OTHER);
    }
}
