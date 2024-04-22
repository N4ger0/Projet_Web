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
        $user = $userRepository->findOneBy(['id' => $security->getUser()]);

        $form = $this->createForm(UserType::class, $user);
        $form->get('password')->setData('');
        $form->add('send', SubmitType::class, ['label' => 'Envoyer']);

        $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {
                $user->setPassword($passwordHasher->hashPassword($user, $user->getPassword()));
                $em->persist($user);
                $em->flush();

                $this->addFlash('info', 'modification du compte réussie');

                if ($user->getRoles()==['ROLE_SADMIN']){
                    return $this->redirectToRoute('app_menu');
                }
                else{
                    return $this->redirectToRoute('client_listproduit');
                }
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

            $form = $this->createForm(PanierType::class, $panier, ['quantityMax' => $produit->getQuantity(), 'quantityMin' => $quantitemin, 'produit' => $produit]);
            $form->add('send', SubmitType::class, ['label' => 'Ajouter']);
            $form->handleRequest($request);

            dump($form);

            if ($form->isSubmitted() && $form->isValid()) {

                $produitSoumis = $form->getConfig()->getOption('produit');

                    if ($panier->getQuantity() + $quantityInDb == 0) {
                        $produitSoumis->setQuantity($produitSoumis->getQuantity() + $quantityInDb);
                        $em->remove($panier);
                    } elseif ($panier->getQuantity() + $quantityInDb > 0) {
                        $produitSoumis->setQuantity($produitSoumis->getQuantity() - $form->getData()->getQuantity());
                        $panier->setClient($security->getUser())
                            ->setProduit($produitSoumis)
                            ->setQuantity($panier->getQuantity() + $quantityInDb);
                        $em->persist($panier);
                    } elseif ($panier->getQuantity() + $quantityInDb < 0){
                        $produitSoumis->setQuantity($produitSoumis->getQuantity() + $form->getData()->getQuantity());
                        $panier->setClient($security->getUser())
                            ->setProduit($produitSoumis)
                            ->setQuantity($panier->getQuantity() + $quantityInDb);
                        $em->persist($panier);
                    }

                    $em->persist($produitSoumis);
                    $em->flush();

                    $this->addFlash('info', 'Modification du panier réussi !');

                return $this->redirectToRoute('client_listproduit');
            }

            if($form->isSubmitted()) {
                $this->addFlash('info', 'formulaire incorrect');
            }

            if ($request->isMethod('POST')) {
                return $this->redirectToRoute('client_listproduit');
            }

            $formViews[] = $form->createView();
        }

        $args = array('produits' => $produits, 'forms' => $formViews);
        return $this-> render('client/listproduit.html.twig', $args);
    }

    #[Route('/panier', name: '_panier')]
    public function panierAction(EntityManagerInterface $em, Security $security) : Response {
        $panierRepository = $em->getRepository(Panier::class);
        $paniers = $panierRepository->findBy(['client' => $security->getUser()]);

        $args = array('paniers' => $paniers);
        return $this->render('client/panier.html.twig', $args);
    }

    #[Route('/supprimerpanier/{id}', name: '_supprimerpanier')]
    public function supprimerpanierAction(EntityManagerInterface $em, int $id) : Response {
        $panierRepository = $em->getRepository(Panier::class);
        $panier = $panierRepository->findOneBy(['id' => $id]);
        $produit = $panier->getProduit();
        $produit->setQuantity($produit->getQuantity() + $panier->getQuantity());
        $em->persist($produit);
        $em->remove($panier);
        $em->flush();
        return $this->redirectToRoute('client_panier');
    }

    #[Route('/supprimertoutpanier', name: '_supprimertoutpanier')]
    public function supprimertoutpanierAction(EntityManagerInterface $em, Security $security) : Response {
        $panierRepository = $em->getRepository(Panier::class);
        $paniers = $panierRepository->findBy(['client' => $security->getUser()]);

        foreach($paniers as $panier) {
            $produit = $panier->getProduit();
            $produit->setQuantity($produit->getQuantity() + $panier->getQuantity());
            $em->persist($produit);
            $em->remove($panier);
        }
        $em->flush();
        return $this->redirectToRoute('client_panier');
    }

    #[Route('/commander', name: '_commander')]
    public function commanderAction(EntityManagerInterface $em, Security $security) : Response {
        $panierRepository = $em->getRepository(Panier::class);
        $paniers = $panierRepository->findBy(['client' => $security->getUser()]);

        foreach($paniers as $panier) {
            $em->remove($panier);
        }
        $em->flush();
        return $this->redirectToRoute('client_panier');
    }
}
