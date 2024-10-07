<?php

namespace App\Controller;

use App\Entity\BookVersion;
use App\Form\BookVersionType;
use App\Repository\BookVersionRepository;
use App\Repository\BorrowingRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Finder\Exception\AccessDeniedException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[Route('/book_version')]
final class BookVersionController extends AbstractController
{
    #[Route('/{page<\d+>}', name: 'app_book_version_index', methods: ['GET'])]
    #[IsGranted('ROLE_LIBRARIAN')]
    public function index(BookVersionRepository $bookVersionRepository, int $page = 1): Response
    {
        $bookVersions = $bookVersionRepository->findAll();
        $pages = ceil(count($bookVersions) / AppController::PER_PAGE);

        $results = array_slice($bookVersions, ($page - 1) * AppController::PER_PAGE, AppController::PER_PAGE);
        return $this->render('book_version/index.html.twig', [
            'book_versions' => $results,
            'page' => $page,
            'pages' => $pages
        ]);
    }

    #[Route('/can_be_reserved/{page<\d+>}', name: 'app_book_version_can_be_reserved', methods: ['GET'])]
    #[IsGranted('ROLE_USER')]
    public function bookVersionCanBeReserved(BookVersionRepository $bookVersionRepository, int $page = 1): Response
    {
        $bookVersions = $bookVersionRepository->findAllBookVersionCanBeReserved($this->getUser()->getId());
        $pages = ceil(count($bookVersions) / AppController::PER_PAGE);

        $results = array_slice($bookVersions, ($page - 1) * AppController::PER_PAGE, AppController::PER_PAGE);
        $userPenality = $this->getUser()->getPenality();

        if (
            null !== $userPenality
            && $userPenality > 0
        ){
            $this->addFlash('error', 'You cant borrow any Book. Regularise your late payment penalties');
            return $this->redirectToRoute('homepage', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('book_version/index_reservation.html.twig', [
            'book_versions' => $results,
            'page' => $page,
            'pages' => $pages,
        ]);
    }

    #[Route('/can_be_borrow/{page<\d+>}', name: 'app_book_version_can_be_borrow', methods: ['GET'])]
    #[IsGranted('ROLE_USER')]
    public function bookVersionCanBeBorrow(BookVersionRepository $bookVersionRepository, BorrowingRepository $borrowingRepository, int $page = 1): Response
    {
        $bookVersions = $bookVersionRepository->findAllBookVersionCanBeBorrowed($this->getUser()->getId());
        $pages = ceil(count($bookVersions) / AppController::PER_PAGE);

        $results = array_slice($bookVersions, ($page - 1) * AppController::PER_PAGE, AppController::PER_PAGE);
        $userPenality = $this->getUser()->getPenality();

        if (
            null !== $userPenality
            && $userPenality > 0
        ){
            $this->addFlash('error', 'You cant borrow any Book. Regularise your late payment penalties');
            return $this->redirectToRoute('homepage', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('book_version/index_reservation.html.twig', [
            'borrowings' => count($borrowingRepository->findActiveByUserId($this->getUser()->getId())),
            'book_versions' => $results,
            'page' => $page,
            'pages' => $pages
        ]);
    }

    #[Route('/new', name: 'app_book_version_new', methods: ['GET', 'POST'])]
    #[IsGranted('ROLE_LIBRARIAN')]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $bookVersion = new BookVersion();
        $form = $this->createForm(BookVersionType::class, $bookVersion);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($bookVersion);
            $entityManager->flush();

            return $this->redirectToRoute('app_book_version_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('book_version/new.html.twig', [
            'book_version' => $bookVersion,
            'form' => $form,
        ]);
    }

    #[Route('/show/{id}', name: 'app_book_version_show', methods: ['GET'])]
    #[IsGranted('ROLE_LIBRARIAN')]
    public function show(BookVersion $bookVersion): Response
    {
        return $this->render('book_version/show.html.twig', [
            'book_version' => $bookVersion,
        ]);
    }

    #[Route('/edit/{id}', name: 'app_book_version_edit', methods: ['GET', 'POST'])]
    #[IsGranted('ROLE_LIBRARIAN')]
    public function edit(Request $request, BookVersion $bookVersion, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(BookVersionType::class, $bookVersion);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_book_version_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('book_version/edit.html.twig', [
            'book_version' => $bookVersion,
            'form' => $form,
        ]);
    }

    #[Route('/delete/{id}', name: 'app_book_version_delete', methods: ['POST'])]
    #[IsGranted('ROLE_LIBRARIAN')]
    public function delete(Request $request, BookVersion $bookVersion, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$bookVersion->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($bookVersion);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_book_version_index', [], Response::HTTP_SEE_OTHER);
    }
}
