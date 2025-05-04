<?php

namespace App\Controller;

use App\Entity\Article;
use App\Entity\Category;
use App\Form\ArticleType;
use App\Form\CategoryType;
use App\Repository\ArticleRepository;
use App\Repository\CategoryRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;

class IndexController extends AbstractController
{
    #[Route('/', name: 'article_list')]
    public function index(ArticleRepository $articleRepository): Response
    {
        $articles = $articleRepository->findAll();
        return $this->render('articles/index.html.twig', [
            'articles' => $articles
        ]);
    }

    #[Route('/article/new', name: 'new_article')]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $article = new Article();
        $form = $this->createForm(ArticleType::class, $article);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($article);
            $entityManager->flush();

            $this->addFlash('success', 'Article ajouté avec succès');
            return $this->redirectToRoute('article_list');
        }

        return $this->render('articles/new.html.twig', [
            'form' => $form->createView()
        ]);
    }

    #[Route('/article/{id}', name: 'article_show')]
    public function show(Article $article): Response
    {
        return $this->render('articles/show.html.twig', [
            'article' => $article
        ]);
    }

    #[Route('/article/edit/{id}', name: 'article_edit')]
    public function edit(Request $request, Article $article, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(ArticleType::class, $article);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();
            
            $this->addFlash('success', 'Article modifié avec succès');
            return $this->redirectToRoute('article_list');
        }

        return $this->render('articles/edit.html.twig', [
            'form' => $form->createView(),
            'article' => $article
        ]);
    }

    #[Route('/article/delete/{id}', name: 'article_delete')]
    public function delete(Article $article, EntityManagerInterface $entityManager): Response
    {
        $entityManager->remove($article);
        $entityManager->flush();
        
        $this->addFlash('success', 'Article supprimé avec succès');
        return $this->redirectToRoute('article_list');
    }

    #[Route('/category/newCat', name: 'new_category')]
    public function newCategory(Request $request, EntityManagerInterface $entityManager): Response
    {
        $category = new Category();
        $form = $this->createForm(CategoryType::class, $category);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($category);
            $entityManager->flush();
            
            $this->addFlash('success', 'Catégorie ajoutée avec succès');
            return $this->redirectToRoute('category_list');
        }

        return $this->render('categories/new.html.twig', [
            'form' => $form->createView()
        ]);
    }

    #[Route('/categories', name: 'category_list')]
    public function categoryList(CategoryRepository $categoryRepository): Response
    {
        $categories = $categoryRepository->findAll();
        return $this->render('categories/index.html.twig', [
            'categories' => $categories
        ]);
    }

    #[Route('/category/{id}', name: 'category_show')]
    public function showCategory(Category $category): Response
    {
        return $this->render('categories/show.html.twig', [
            'category' => $category
        ]);
    }

    #[Route('/category/edit/{id}', name: 'category_edit')]
    public function editCategory(Request $request, Category $category, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(CategoryType::class, $category);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();
            
            $this->addFlash('success', 'Catégorie modifiée avec succès');
            return $this->redirectToRoute('category_list');
        }

        return $this->render('categories/edit.html.twig', [
            'form' => $form->createView(),
            'category' => $category
        ]);
    }

    #[Route('/category/delete/{id}', name: 'category_delete')]
    public function deleteCategory(Category $category, EntityManagerInterface $entityManager): Response
    {
        // Vérifier si la catégorie contient des articles
        if (count($category->getArticles()) > 0) {
            $this->addFlash('error', 'Impossible de supprimer cette catégorie car elle contient des articles');
            return $this->redirectToRoute('category_list');
        }
        
        $entityManager->remove($category);
        $entityManager->flush();
        
        $this->addFlash('success', 'Catégorie supprimée avec succès');
        return $this->redirectToRoute('category_list');
    }
}