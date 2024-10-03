<?php

namespace App\Controller;

use App\Entity\BookVersion;
use App\Entity\Borrowing;
use App\Entity\Reservation;
use App\Form\BorrowingType;
use App\Repository\BorrowingRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\ExpressionLanguage\Expression;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[Route('/borrowing')]
final class BorrowingController extends AbstractController
{
    #[Route('/librarian', name: 'app_borrowing_index', methods: ['GET'])]
    #[IsGranted('ROLE_LIBRARIAN')]
    public function librarianBorrowing(BorrowingRepository $borrowingRepository): Response
    {
        return $this->render('borrowing/index.html.twig', [
            'borrowings' => $borrowingRepository->findAll(),
        ]);
    }

    #[Route(name: 'app_borrowing_user_index', methods: ['GET'])]
    #[IsGranted('ROLE_USER')]
    public function userBorrowing(BorrowingRepository $borrowingRepository): Response
    {
        return $this->render('borrowing/user_index.html.twig', [
            'borrowings' => $borrowingRepository->findByUserId($this->getUser()->getId()),
        ]);
    }

    #[Route('/new', name: 'app_borrowing_new', methods: ['GET', 'POST'])]
    #[IsGranted('ROLE_USER')]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $canBorrow = $this->getUser()->getBorrowings()->count() < $this->getUser()->getMaxBorrow();
        if (!$canBorrow) {
            $this->addFlash('error' ,"Vous ne pouvez plus emprunter de livre pour l'instant !");
            return $this->redirectToRoute('app_borrowing_user_index', [], Response::HTTP_SEE_OTHER);
        }
        $borrowing = new Borrowing();
        $form = $this->createForm(BorrowingType::class, $borrowing);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $borrowingDate = new \DateTime();
            $returnDate = new \DateTime();
            $borrowing->setBorrowingDate($borrowingDate);
            $borrowing->setReturnDate($returnDate->modify('+30 days'));
            $borrowing->setReturned(false);
            $borrowing->setUser($this->getUser());
            $entityManager->persist($borrowing);
            $entityManager->flush();

            return $this->redirectToRoute('app_borrowing_user_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('borrowing/new.html.twig', [
            'borrowing' => $borrowing,
            'form' => $form,
        ]);
    }

    #[Route('/new/{bookVersionId}', name: 'app_borrowing_new_from_reservation', methods: ['GET', 'POST'])]
    #[IsGranted('ROLE_USER')]
    public function newFromReservation(BookVersion $bookVersionId, EntityManagerInterface $entityManager): Response
    {
        $canBorrow = $this->getUser()->getBorrowings()->count() < $this->getUser()->getMaxBorrow();
        if (!$canBorrow) {
            $this->addFlash('error' ,"Vous ne pouvez plus emprunter de livre pour l'instant !");
            return $this->redirectToRoute('app_borrowing_user_index', [], Response::HTTP_SEE_OTHER);
        }

        $borrowing = new Borrowing();
        $borrowing->setBookVersion($bookVersionId);
        $borrowingDate = new \DateTime();
        $returnDate = new \DateTime();
        $borrowing->setBorrowingDate($borrowingDate);
        $borrowing->setReturnDate($returnDate->add(\DateInterval::createFromDateString('30 day')));
        $borrowing->setReturned(false);
        $borrowing->setUser($this->getUser());
        $entityManager->persist($borrowing);
        $entityManager->flush();

        return $this->redirectToRoute('app_borrowing_user_index', [], Response::HTTP_SEE_OTHER);
    }

    #[Route('/{id}', name: 'app_borrowing_show', methods: ['GET'])]
    #[IsGranted(new Expression('is_granted("ROLE_USER") or is_granted("ROLE_LIBRARIAN")'))]
    public function show(Borrowing $borrowing): Response
    {
        return $this->render('borrowing/show.html.twig', [
            'borrowing' => $borrowing,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_borrowing_edit', methods: ['GET', 'POST'])]
    #[IsGranted('ROLE_LIBRARIAN')]
    public function edit(Request $request, Borrowing $borrowing, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(BorrowingType::class, $borrowing);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_borrowing_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('borrowing/edit.html.twig', [
            'borrowing' => $borrowing,
            'form' => $form,
        ]);
    }

    #[Route('/{id}/return', name: 'app_borrowing_return', methods: ['GET'])]
    #[IsGranted('ROLE_LIBRARIAN')]
    public function return(Request $request, Borrowing $borrowing, EntityManagerInterface $entityManager): Response
    {
        $borrowing->setReturned(true);
        $borrowing->setReturnDate(new \DateTime('now'));
        $entityManager->flush();

        $userReservation = $entityManager
            ->getRepository(Reservation::class)
            ->findOneBy(['bookVersion' => $borrowing->getBookVersion(), 'isActive' => true]);

        return $this->redirectToRoute('reservation_email', [
            "user" => $userReservation?->getUser()->getId(),
            "bookVersion" => $borrowing->getBookVersion()->getId()
        ], Response::HTTP_SEE_OTHER);
    }

    #[Route('/{id}', name: 'app_borrowing_delete', methods: ['POST'])]
    #[IsGranted('ROLE_LIBRARIAN')]
    public function delete(Request $request, Borrowing $borrowing, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$borrowing->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($borrowing);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_borrowing_index', [], Response::HTTP_SEE_OTHER);
    }
}
