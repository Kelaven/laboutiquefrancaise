<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Repository\CategoryRepository;

class CategoryController extends AbstractController
{
    #[Route('/categorie/{slug}', name: 'app_category')]
    public function index($slug, CategoryRepository $categoryRepository): Response
    {
        // $category = $categoryRepository->findAll(); // exemple pour récupérer toutes mes catégories
        // dd($category);

        $category = $categoryRepository->findOneBySlug($slug);
        
        return $this->render('category/index.html.twig', [
            'category' => $category,
        ]);
    }
}
