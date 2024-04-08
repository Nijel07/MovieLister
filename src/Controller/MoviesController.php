<?php

namespace App\Controller;

use App\Entity\Movie;
use App\Form\MovieFormType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route; 
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use App\Repository\MovieRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Security\Core\Security;

class MoviesController extends AbstractController
{

    private $movieRepository;
    private $em;

    public function __construct(MovieRepository $movieRepository, EntityManagerInterface $em)
    {
        $this->movieRepository = $movieRepository;
        $this->em = $em;
    }

    #[Route('/', name: 'movies_index')]
    public function index(MovieRepository $movieRepository): Response
    {
        $movies = $movieRepository->findAll();
        //findAll() - SELECT * FROM movies;
        //find() - SELECT * from movies WHERE id = 5;
        //findBy() - SELECT * from movies ORDER BY id DESC;
        //findOneBy() - SELECT * FROM movies WHERE id = 6 AND title = 'The Title' ORDER BY id DESC ;
        //count() - SELECT COUNT() from movies WHERE id = 1;
        return $this->render('movies/index.html.twig', [
            'movies' => $movies,
        ]);
    }

    #[Route('/movies/create', name:'create_movie')]
    public function create(Request $request): Response
    {
        $movie = new Movie();
        $form = $this->createForm(MovieFormType::class, $movie);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $newMovie = $form->getData();

            $imagePath = $form->get('imagePath')->getData();
            if ($imagePath){
                $newFileName =uniqid() . '.' . $imagePath->guessExtension();

                try {
                    $imagePath->move(
                        $this->getParameter('kernel.project_dir') . '/public/uploads',
                        $newFileName
                    );
                } catch (FileException $e) {
                    return new Response($e->getMessage());
                }

                $newMovie->setImagePath('/uploads/' . $newFileName);
            } 

            $this->em->persist($newMovie);
            $this->em->flush();

            return $this->redirectToRoute('movies_index');
        }

        return $this->render('movies/create.html.twig', [
            'form' => $form->createView()
        ]);
    }

    #[Route('/movies/edit/{id}', name: 'edit_movie')]
    public function edit($id, Request $request): Response
    {
       $movie = $this->movieRepository->find($id);
       $form = $this->createForm(MovieFormType::class, $movie);

       $form->handleRequest($request);
       $imagePath = $form->get('imagePath')->getData();

       if ($form->isSubmitted() && $form->isValid()) {
            if ($imagePath) {
                if ($movie->getImagePath() !== null) {
                    if (file_exists(
                        $this->getParameter('kernel.project_dir') . $movie->getImagePath()
                        )){
                        $this->getParameter('kernel.project_dir') . $movie->getImagePath();

                        $newFileName = uniqid() . '.' . $imagePath->guessExtension();

                        try {
                            $imagePath->move(
                                $this->getParameter('kernel.project_dir') . '/public/uploads',
                                $newFileName
                            );
                        } catch (FileException $e) {
                            return new Response($e->getMessage());
                        }

                        $movie->setImagePath('/uploads/ . $newFileName');
                        $this->em->flush();

                        return $this->redirectToRoute('movies_index');
                    }
                }
            } else {
                $movie->setTitle($form->get('title')->getData());
                $movie->setReleaseDate($form->get('releaseDate')->getData());
                $movie->setDescription($form->get('Description')->getData());

                $this->em->flush();
                return $this->redirectToRoute('movies_index');
            }
       }


       return $this->render('movies/edit.html.twig', [
            'movie' => $movie,
            'form' => $form->createView()
       ]);

    }

    #[Route('movies/delete/{id}', methods: ['GET', 'DELETE'], name: 'delete_movie')]
    public function delete($id): Response
    {
        $movie = $this->movieRepository->find($id);
        $this->em->remove($movie);
        $this->em->flush();

        return $this->redirectToRoute('movies_index');
    }

    #[Route('/movies/{id}', methods: ['GET'], name: 'movies_show')]
    public function show($id): Response
    {
        $movie = $this->movieRepository->find($id);
        //findAll() - SELECT * FROM movies;
        //find() - SELECT * from movies WHERE id = 5;
        //findBy() - SELECT * from movies ORDER BY id DESC;
        //findOneBy() - SELECT * FROM movies WHERE id = 6 AND title = 'The Title' ORDER BY id DESC ;
        //count() - SELECT COUNT() from movies WHERE id = 1;
        return $this->render('movies/show.html.twig', [
            'movie' => $movie,
        ]);
    }

}

