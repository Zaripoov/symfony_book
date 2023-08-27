<?php

namespace App\Controller;

use App\Entity\Book;
use App\Repository\BookRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DefaultController extends AbstractController
{
    public function __construct(private BookRepository $bookRepository, private EntityManagerInterface $em)
    {
    }

    #[Route('/newBook')]
    public function addNewBook()
    {
        $book = new Book();
        $book->setTitle('PHP 8');

        $this->em->persist($book);
        $this->em->flush();

        return new Response();
    }

    #[Route('/')]
    public function root(): JsonResponse
    {
        $books = $this->bookRepository->findAll();
        return $this->json($books);
    }
}