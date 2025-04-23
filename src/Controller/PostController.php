<?php

namespace App\Controller;

use App\Document\Post;
use App\Form\PostType;
use Doctrine\ODM\MongoDB\DocumentManager;
use Doctrine\ODM\MongoDB\MongoDBException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Throwable;

final class PostController extends AbstractController
{
    /**
     * @throws MongoDBException
     * @throws Throwable
     */
    #[Route('/post/crear', name: 'post_create', methods: ['GET', 'POST'])]
    public function index(DocumentManager $dm, Request $request): Response
    {
        $form = $this->createForm(PostType::class);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $dm->persist($form->getData());
            $dm->flush();

            $this->addFlash('success', 'Publicación guardada con éxito');
            return $this->redirectToRoute('post_create');
        }
        return $this->render('post/create.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @throws Throwable
     * @throws MongoDBException
     */
    #[Route('/post/{id}/editar', name: 'post_edit', methods: ['GET', 'POST'])]
    public function postEditarAction(Post $post, Request $request, DocumentManager $dm) : Response
    {
        $form = $this->createForm(PostType::class, $post);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $dm->flush();

            $this->addFlash('success', 'Publicación editada con éxito');
            return $this->redirectToRoute('post_edit', ['id' => $post->getId()]);
        }

        return $this->render('post/edit.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
