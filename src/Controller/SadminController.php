<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/sadmin', name: 'sadmin')]
class SadminController extends AbstractController
{
    #[Route('/ajouteradmin', name: '_ajouteradmin')]
    public function ajouteradminAction(Request $request, EntityManagerInterface $em, UserPasswordHasherInterface $passwordHasher): Response
    {
        $user = new User();
        $form = $this->createForm(UserType::class, $user);
        $form->add('send', SubmitType::class, ['label' => 'Envoyer']);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $user->setAdmin(true)
                ->setRoles(['ROLE_ADMIN'])
                ->setPassword($passwordHasher->hashPassword($user, $user->getPassword()));
            $em->persist($user);
            $em->flush();

            $this->addFlash('info', 'création de compte admin réussie');

            return $this->redirectToRoute('sadmin_ajouteradmin');
        }

        if($form->isSubmitted()) {
            $this->addFlash('info', 'formulaire ajouter admin incorrect');
        }

        return $this->render('sadmin/ajouteradmin.html.twig', [
            'form' => $form->createView(),]);
    }
}
