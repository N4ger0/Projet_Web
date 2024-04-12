<?php

namespace App\Controller;

use App\Entity\Panier;
use App\Entity\Produit;
use App\Entity\User;
use App\Form\PanierType;
use App\Form\UserType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/client', name: 'client')]
class ClientController extends AbstractController
{
    #[Route('/modifprofil', name: '_modifprofil')]
    public function modifprofilAction(Request $request, EntityManagerInterface $em, UserPasswordHasherInterface $passwordHasher, Security $security): Response
    {
        $userRepository = $em->getRepository(User::class);
        $user = $userRepository->findOneBy(['login' => $security->getUser()->getLogin()]);

        $form = $this->createForm(UserType::class, $user);
        $form->get('password')->setData('');
        $form->add('send', SubmitType::class, ['label' => 'Envoyer']);

        $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {
                $user->setAdmin(false)
                    ->setRoles(['ROLE_CLIENT'])
                    ->setPassword($passwordHasher->hashPassword($user, $user->getPassword()));
                $em->persist($user);
                $em->flush();

                $this->addFlash('info', 'modification du compte réussie');

                return $this->redirectToRoute('app_menu');
            }

            if ($form->isSubmitted()) {
                $this->addFlash('info', 'formulaire modification incorrect');
            }

            return $this->render('client/modifclient.html.twig', [
                'form' => $form->createView(),]);
    }

    #[Route('/listproduit', name: '_listproduit')]
    public function listproduitAction(EntityManagerInterface $em, Request $request, Security $security): Response
    {
        $produitRepository = $em->getRepository(Produit::class) ;
        $produits = $produitRepository->findAll();

        $panierRepository = $em->getRepository(Panier::class);

        $formViews = [] ;

        foreach ($produits as $produit) {
            $panier = $panierRepository->findOneBy(['client' => $security->getUser(), 'produit'=>$produit]);


            if($panier == null){
                $panier = new Panier();
                $quantitemin = 0 ;
            }
            else{
                $quantitemin = -($panier->getQuantity());
            }
            $quantityInDb = $panier->getQuantity();

            $form = $this->createForm(PanierType::class, $panier, ['quantityMax' => $produit->getQuantity(), 'quantityMin' => $quantitemin]);
            $form->add('send', SubmitType::class, ['label' => 'Ajouter']);
            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {
                    if ($panier->getQuantity() + $quantityInDb == 0) {
                        $em->remove($panier);
                    } else {
                        $panier->setClient($security->getUser())
                            ->setProduit($produit)
                            ->setQuantity($panier->getQuantity() + $quantityInDb);
                        $em->persist($panier);
                    }

                    $produit->setQuantity($produit->getQuantity() - ($quantityInDb + $form->getData()->getQuantity()));
                    $em->persist($produit);
                    $em->flush();

                    $this->addFlash('info', 'Modification du panier réussi !');

                return $this->redirectToRoute('client_listproduit');
            }

            if($form->isSubmitted()) {
                $this->addFlash('info', 'formulaire incorrect');
            }

            $formViews[] = $form->createView();
        }

        $args = array('produits' => $produits, 'forms' => $formViews);
        return $this-> render('client/listproduit.html.twig', $args);
    }
}
