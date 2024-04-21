<?php

namespace App\Controller;

use App\Entity\Panier;
use App\Entity\Produit;
use App\Entity\User;
use App\Form\ProduitType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin', name: 'admin')]
class AdminController extends AbstractController
{
    #[Route('/listuser', name: '_listuser')]
    public function listuserAction(EntityManagerInterface $em): Response
    {
        $userRepository = $em->getRepository(User::class);
        $users = $userRepository->findAll();
        $args = array('users' => $users);

        return $this->render('admin/listuser.html.twig', $args);
    }

    #[Route('/supprimeruser/{id}', name: '_supprimeruser')]
    public function supprimeruserAction(EntityManagerInterface $em, Security $security, int $id): Response
    {
        $userRepository = $em->getRepository(User::class);
        $user = $userRepository->findOneBy(['id' => $id]);

        $panierRepository = $em->getRepository(Panier::class);
        $paniers = $panierRepository->findBy(['client' => $user]);
        if($user != $security->getUser() and $user->getRoles() != ['ROLE_SADMIN']) {
            foreach($paniers as $panier){
                $em->remove($panier);
            }
            $em->remove($user);
            $em->flush();
            $this->addFlash('info', 'Utilisateur supprimé');
        }
        else {
            $this->addFlash('info', 'Impossible de supprimer l utilisateur');
        }

        return $this->redirectToRoute('admin_listuser');
    }

    #[Route('/ajouterproduit', name: '_ajouterproduit')]
    public function ajouterproduitAction(EntityManagerInterface $em, Request $request): Response
    {
        $produit = new Produit();
        $form = $this->createForm(ProduitType::class, $produit);
        $form->add('send', SubmitType::class, ['label' => 'Envoyer']);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($produit);
            $em->flush();

            $this->addFlash('info', 'Ajout du produit réussie');

            return $this->redirectToRoute('app_menu');
        }

        if($form->isSubmitted()) {
            $this->addFlash('info', 'formulaire ajouter produit incorrect');
        }

        $args = array('form' => $form);

        return $this->render('admin/ajouterproduit.html.twig', $args);
    }
}
