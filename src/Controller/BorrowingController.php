<?php

namespace App\Controller;

use App\Entity\BookVersion;
use App\Entity\Borrowing;
use App\Entity\Reservation;
use App\Form\BorrowingLibrarianType;
use App\Form\BorrowingType;
use App\Repository\BorrowingRepository;
use App\Service\MailService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\ExpressionLanguage\Expression;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[Route('/borrowing')]
final class BorrowingController extends AbstractController
{
    public function __construct(
        private readonly MailService $mailService,
    ){}

    #[Route('/librarian/{page<\d+>}', name: 'app_borrowing_index', methods: ['GET'])]
    #[IsGranted(new Expression('is_granted("ROLE_ADMIN") or is_granted("ROLE_LIBRARIAN")'))]
    public function index(BorrowingRepository $borrowingRepository, int $page = 1): Response
    {
        $activeBorrowings = $borrowingRepository->findAllActive();
        $pages = ceil(count($activeBorrowings) / AppController::PER_PAGE);

        $results = array_slice($activeBorrowings, ($page - 1) * AppController::PER_PAGE, AppController::PER_PAGE);
        return $this->render('borrowing/index.html.twig', [
            'borrowings' => $results,
            'page' => $page,
            'pages' => $pages
        ]);
    }

    #[Route('/{page<\d+>}', name: 'app_borrowing_user_index', methods: ['GET'])]
    #[IsGranted('ROLE_USER')]
    public function userBorrowing(BorrowingRepository $borrowingRepository, int $page = 1): Response
    {
        $activeBorrowings = $borrowingRepository->findActiveByUserId($this->getUser()->getId());
        $pages = ceil(count($activeBorrowings) / AppController::PER_PAGE);

        $results = array_slice($activeBorrowings, ($page - 1) * AppController::PER_PAGE, AppController::PER_PAGE);
        return $this->render('borrowing/user_index.html.twig', [
            'borrowings' => $results,
            'page' => $page,
            'pages' => $pages
        ]);
    }

    #[Route('/history/{page<\d+>}', name: 'app_borrowing_user_history', methods: ['GET'])]
    #[IsGranted('ROLE_USER')]
    public function userBorrowingHistory(BorrowingRepository $borrowingRepository, int $page = 1): Response
    {
        $activeBorrowings = $borrowingRepository->findByUserId($this->getUser()->getId());
        $pages = ceil(count($activeBorrowings) / AppController::PER_PAGE);

        $results = array_slice($activeBorrowings, ($page - 1) * AppController::PER_PAGE, AppController::PER_PAGE);
        return $this->render('borrowing/index_history.html.twig', [
            'borrowings' => $results,
            'page' => $page,
            'pages' => $pages
        ]);
    }

    #[Route('/new', name: 'app_borrowing_new', methods: ['GET', 'POST'])]
    #[IsGranted('ROLE_USER')]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $userPenality = $this->getUser()->getPenality();

        if (
            null !== $userPenality
            && $userPenality > 0
        ){
            $this->addFlash('error', 'You cant borrow any Book. Regularise your late payment penalties');
            return $this->redirectToRoute('homepage', [], Response::HTTP_SEE_OTHER);
        }

        $canBorrow = count($entityManager->getRepository(Borrowing::class)
                ->findActiveByUserId($this->getUser()->getId())
                ) < $this->getUser()->getMaxBorrow();
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
        $userPenality = $this->getUser()->getPenality();

        if (
            null !== $userPenality
            && $userPenality > 0
        ){
            $this->addFlash('error', 'You cant borrow any Book. Regularise your late payment penalties');
            return $this->redirectToRoute('homepage', [], Response::HTTP_SEE_OTHER);
        }

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

    #[Route('/show/{id}', name: 'app_borrowing_show', methods: ['GET'])]
    public function show(Request $request, Borrowing $borrowing): Response
    {
        return $this->render('borrowing/show.html.twig', [
            'path' => $request->headers->get('referer'),
            'borrowing' => $borrowing,
        ]);
    }

    #[Route('/librarian/{id}/edit', name: 'app_borrowing_edit', methods: ['GET', 'POST'])]
    #[IsGranted(new Expression('is_granted("ROLE_ADMIN") or is_granted("ROLE_LIBRARIAN")'))]
    public function edit(Request $request, Borrowing $borrowing, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(BorrowingLibrarianType::class, $borrowing);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            if ($borrowing->getBorrowingDate() > $borrowing->getReturnDate()) {
                $this->addFlash("error", "The return date cannot be earlier than the borrowing date !");

                return $this->render('borrowing/edit.html.twig', [
                    'borrowing' => $borrowing,
                    'form' => $form,
                ]);
            }
            $entityManager->flush();

            return $this->redirectToRoute('app_borrowing_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('borrowing/edit.html.twig', [
            'borrowing' => $borrowing,
            'form' => $form,
        ]);
    }

    /**
     * @throws TransportExceptionInterface
     */
    #[Route('/librarian/{id}/return', name: 'app_borrowing_return', methods: ['GET'])]
    #[IsGranted(new Expression('is_granted("ROLE_ADMIN") or is_granted("ROLE_LIBRARIAN")'))]
    public function return(Request $request, Borrowing $borrowing, EntityManagerInterface $entityManager): Response
    {
        $borrowing->setReturned(true);
        $borrowing->setReturnDate(new \DateTime('now'));
        $entityManager->flush();

        $userReservation = $entityManager
            ->getRepository(Reservation::class)
            ->findOneBy(['bookVersion' => $borrowing->getBookVersion(), 'isActive' => true]);

        if (null !== $userReservation) {
            if ($this->mailService->notifyUserReservationReady($userReservation))
            {
                $this->redirectToRoute('app_borrowing_index', [], Response::HTTP_SEE_OTHER);
            }
        }

        return $this->redirectToRoute('app_borrowing_index', [], Response::HTTP_SEE_OTHER);
    }

    #[Route('/librarian/{id}', name: 'app_borrowing_delete', methods: ['POST'])]
    #[IsGranted(new Expression('is_granted("ROLE_ADMIN") or is_granted("ROLE_LIBRARIAN")'))]
    public function delete(Request $request, Borrowing $borrowing, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$borrowing->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($borrowing);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_borrowing_index', [], Response::HTTP_SEE_OTHER);
    }
}
