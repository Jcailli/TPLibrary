<?php

namespace App\Controller;

use App\Entity\BookVersion;
use App\Form\BookVersionType;
use App\Repository\BookVersionRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[Route('/book_version')]
final class BookVersionController extends AbstractController
{
    #[Route(name: 'app_book_version_index', methods: ['GET'])]
    #[IsGranted('ROLE_LIBRARIAN')]
    public function index(BookVersionRepository $bookVersionRepository): Response
    {
        return $this->render('book_version/index.html.twig', [
            'book_versions' => $bookVersionRepository->findAll(),
        ]);
    }

    #[Route('/can_be_reserved', name: 'app_book_version_can_be_reserved', methods: ['GET'])]
    #[IsGranted('ROLE_USER')]
    public function bookVersionCanBeReserved(BookVersionRepository $bookVersionRepository): Response
    {
        return $this->render('book_version/index_reservation.html.twig', [
            'book_versions' => $bookVersionRepository->findAllBookVersionBorrowed(),
        ]);
    }

    #[Route('/can_be_borrow', name: 'app_book_version_can_be_borrow', methods: ['GET'])]
    #[IsGranted('ROLE_USER')]
    public function bookVersionCanBeBorrow(BookVersionRepository $bookVersionRepository): Response
    {
        return $this->render('book_version/index_reservation.html.twig', [
            'book_versions' => $bookVersionRepository->findAllBookVersionNotBorrowedAndNotReserved(),
        ]);
    }

    #[Route('/new', name: 'app_book_version_new', methods: ['GET', 'POST'])]
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

    #[Route('/{id}', name: 'app_book_version_show', methods: ['GET'])]
    public function show(BookVersion $bookVersion): Response
    {
        return $this->render('book_version/show.html.twig', [
            'book_version' => $bookVersion,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_book_version_edit', methods: ['GET', 'POST'])]
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

    #[Route('/{id}', name: 'app_book_version_delete', methods: ['POST'])]
    public function delete(Request $request, BookVersion $bookVersion, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$bookVersion->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($bookVersion);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_book_version_index', [], Response::HTTP_SEE_OTHER);
    }
}
