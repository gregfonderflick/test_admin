<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class UserController extends AbstractController
{
    /**
     * @Route("/user/new", name="user_create")
     * @Route("/user/{id}/edit", name="user_edit")
     */


    public function form(User $user = null, Request $request, ObjectManager $manager)
    {

        if (!$user) {
            $user = new User();
        } /*else {
            $article->setUpdatedAt(new \DateTime());
        }*/

        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // $file stores the uploaded PDF file


            // ... persist the $product variable or any other work


            $manager = $this->getDoctrine()->getManager();

            // ... persist the $product variable or any other work
            $manager->persist($user);
            $manager->flush();

            return $this->redirect($this->generateUrl('user_show'));

        }

        return $this->render('user/create.html.twig', [
            'formUser' => $form->createView(),
            'user' => $user,
            'editMode' => $user->getId() !== null
        ]);

    }

    /**
     * @Route("/user/delete/{id}", name="user_delete")
     */
    public function remove($id)
    {
        $entityManager = $this->getDoctrine()->getManager();
        $user = $entityManager->getRepository(User::class)->find($id);
        if (!$user) {
            throw $this->createNotFoundException(
                'No article found for id' . $id
            );
        }

        $entityManager->remove($user);
        $entityManager->flush();

        return new Response('Delete user' . $id);
    }



    /**
     * @Route("/user/{id}", name="user_show")
     */
    public function show(User $user)
    {

        return $this->render('user/show.html.twig', [
            'controller_name' => 'ArticleController',
            'user' => $user
        ]);
    }

}
