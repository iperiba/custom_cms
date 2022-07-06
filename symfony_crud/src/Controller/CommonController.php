<?php

namespace App\Controller;

use App\Entity\Article;
use App\Form\ArticleType;
use App\Repository\ArticleRepository;
use App\Repository\CategoryRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class CommonController extends AbstractController
{
    #[Route('/{slug}', name: 'app_common_show', methods: ['GET'], priority: 0)]
    public function show(Request $request, ArticleRepository $articleRepository, CategoryRepository $categoryRepository): Response
    {
        $slug = $request->attributes->get('_route_params')['slug'];
        $categorySlugs = $categoryRepository->getSpecificAttributeFromCategoryElements('slug');
        if (in_array($slug, $categorySlugs)) {
            return $this->render('category/show.html.twig', [
                'category' => $categoryRepository->findOneBy(['slug' => $slug])
            ]);
        }

        return $this->render('article/show.html.twig', [
            'article' => $articleRepository->findOneBy(['slug' => $slug])
        ]);
    }

    #[Route('/{category}/{slug}', name: 'app_category_article_show', methods: ['GET'], priority: 0)]
    public function showCategoryArticleSlug(Request $request, ArticleRepository $articleRepository, CategoryRepository $categoryRepository): Response
    {
        $category = $request->attributes->get('_route_params')['category'];
        $slug = $request->attributes->get('_route_params')['slug'];
        return $this->render('article/show.html.twig', [
            'article' => $articleRepository->getArticleBySlugAndCategory($slug, $category)
        ]);
    }
}
