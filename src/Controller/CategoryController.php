<?php

namespace App\Controller;

use App\Document\Category;
use App\Form\CategoryType;
use Doctrine\ODM\MongoDB\DocumentManager;
use Doctrine\ODM\MongoDB\MongoDBException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Throwable;

final class CategoryController extends AbstractController
{
    #[Route('/categorias/index', name: 'categories_index')]
    public function index(DocumentManager $dm): Response
    {
        return $this->render('category/index.html.twig', [
            'categories' => $dm->getRepository(Category::class)->findAll(),
        ]);
    }

    /**
     * @throws Throwable
     * @throws MongoDBException
     */
    #[Route('/categorias/registrar/{id}', name: 'register_category', defaults: ['id'=>false], methods: ['GET', 'POST'])]
    public function registerCategoryAction(Request $request, DocumentManager $dm, $id): Response
    {
        $category = !$id? new Category() : $dm->getRepository(Category::class)->find($id);
        return $this->createFormCategory($category, $request, $dm);
    }

    /**
     * @throws MongoDBException
     * @throws Throwable
     */
    private function createFormCategory(Category $category, Request $request, DocumentManager $dm): Response
    {
        $form = $this->createForm(CategoryType::class, $category);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $dm->persist($category);
            $dm->flush();

            $this->addFlash('success', 'Categoría registrada con éxito');
            return $this->redirectToRoute('categories_index', ['id' => $category->getId()]);
        }
        return $this->render('category/register.category.html.twig', [
            'form' => $form->createView(),
            'category' => $category,
        ]);
    }
}
