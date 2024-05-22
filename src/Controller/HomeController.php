<?php

namespace App\Controller;

use App\Repository\MovieRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    private $movieRepository;

    public function __construct(MovieRepository $movieRepository)
    {
        $this->movieRepository = $movieRepository;
    }

    #[Route('/', name: 'app_home')]
    public function index(): Response
    {
        $latestMovies = $this->movieRepository->findBy([], ['releaseDate' => 'DESC'], 15);
        $featuredMovies = $this->movieRepository->findFeaturedMovies();

        return $this->render('home/index.html.twig', [
            'latestMovies' => $latestMovies,
            'featuredMovies' => $featuredMovies,
        ]);
    }


}
