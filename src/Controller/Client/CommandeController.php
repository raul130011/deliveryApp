<?php

namespace App\Controller\Client;

use App\Entity\Commande;
use App\Form\CommandeType;
use App\Repository\CommandeRepository;
use App\Repository\ClientRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;

#[Route('/client/commande')]
class CommandeController extends AbstractController
{
    #[Route('/', name: 'app_client_commande_index', methods: ['GET'])]
    public function index(CommandeRepository $commandeRepository,ClientRepository $clientRepository,MailerInterface $mailer,Security $security): Response
    {
        $user = $security->getUser();
        $client = $clientRepository->findOneBy(['user' => $user]);

        $email = (new Email())
        ->from('abderrazak.erouel@gmail.com')
        ->to('erouel13001@yahoo.fr')
        //->cc('cc@example.com')
        //->bcc('bcc@example.com')
        //->replyTo('fabien@example.com')
        //->priority(Email::PRIORITY_HIGH)
        ->subject('Notification Commande')
        //->text('Changement ')
        ->html('<p>Changement Etat de Commande .</p>');
        $mailer->send($email);
        $commandes = [];
        if(!empty($client)){
            $commandes = $commandeRepository->findBy(['Client' => $client]);
        }
        return $this->render('ClientTmp/commande/index.html.twig', [
            'commandes' => $commandes,
        ]);
    }

    #[Route('/new', name: 'app_client_commande_new', methods: ['GET', 'POST'])]
    public function new(Request $request, CommandeRepository $commandeRepository): Response
    {
        $commande = new Commande();
        $form = $this->createForm(CommandeType::class, $commande);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $commandeRepository->save($commande, true);

            return $this->redirectToRoute('app_client_commande_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('ClientTmp/commande/new.html.twig', [
            'commande' => $commande,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_client_commande_show', methods: ['GET'])]
    public function show(Commande $commande): Response
    {
       
        return $this->render('ClientTmp/commande/show.html.twig', [
            'commande' => $commande,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_client_commande_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Commande $commande, CommandeRepository $commandeRepository): Response
    {
        $form = $this->createForm(CommandeType::class, $commande);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $commandeRepository->save($commande, true);

            return $this->redirectToRoute('app_client_commande_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('ClientTmp/commande/edit.html.twig', [
            'commande' => $commande,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_client_commande_delete', methods: ['POST'])]
    public function delete(Request $request, Commande $commande, CommandeRepository $commandeRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$commande->getId(), $request->request->get('_token'))) {
            $commandeRepository->remove($commande, true);
        }

        return $this->redirectToRoute('app_client_commande_index', [], Response::HTTP_SEE_OTHER);
    }
}
