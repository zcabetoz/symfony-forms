<?php

namespace App\Controller;

use App\Document\Post;
use App\Form\ContactType;
use Doctrine\ODM\MongoDB\DocumentManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;

final class PageController extends AbstractController
{
    #[Route('/', name: 'home', methods: ['GET'])]
    public function index(DocumentManager $dm): Response
    {
        return $this->render('page/index.html.twig',[
            'posts' => $dm->getRepository(Post::class)->findAll(),
        ]);
    }

    #[Route('/contactos-v1', name: 'contact_v1', methods: ['GET', 'POST'])]
    public function contactV1(Request $request): Response
    {
        $form = $this->createForm(ContactType::class);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $this->addFlash('danger', 'Mensaje enviado correctamente');
            return $this->redirectToRoute('contact_v1');
        }

        return $this->render('page/contact-v1.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
