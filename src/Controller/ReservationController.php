<?php

namespace App\Controller;

use App\Entity\BookVersion;
use App\Entity\Reservation;
use App\Form\ReservationType;
use Symfony\Component\ExpressionLanguage\Expression;
use App\Repository\ReservationRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[Route('/reservation')]
final class ReservationController extends AbstractController
{
    #[Route('/user/{page<\d+>}' ,name: 'app_reservation_user_index', methods: ['GET'])]
    #[IsGranted('ROLE_USER')]
    public function userReservation(ReservationRepository $reservationRepository, int $page = 1): Response
    {
        $reservations = $reservationRepository->findAllActiveByUserId($this->getUser()->getId());
        $pages = ceil(count($reservations) / AppController::PER_PAGE);

        $results = array_slice($reservations, ($page - 1) * AppController::PER_PAGE, AppController::PER_PAGE);
        return $this->render('reservation/user_index.html.twig', [
            'reservations' => $results,
            'page' => $page,
            'pages' => $pages,
        ]);
    }
    #[Route('/librarian/{page<\d+>}' ,name: 'app_reservation_index', methods: ['GET'])]
    #[IsGranted('ROLE_LIBRARIAN')]
    public function index(ReservationRepository $reservationRepository, int $page = 1): Response
    {
        $activeReservations = $reservationRepository->findAllActive();
        $pages = ceil(count($activeReservations) / AppController::PER_PAGE);

        $results = array_slice($activeReservations, ($page - 1) * AppController::PER_PAGE, AppController::PER_PAGE);
        return $this->render('reservation/index.html.twig', [
            'reservations' => $results,
            'page' => $page,
            'pages' => $pages,
        ]);
    }

    #[Route('/new', name: 'app_reservation_new', methods: ['GET', 'POST'])]
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

        $reservation = new Reservation();
        $form = $this->createForm(ReservationType::class, $reservation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $reservation->setActive(true);
            $reservation->setUser($this->getUser());
            $entityManager->persist($reservation);
            $entityManager->flush();

            return $this->redirectToRoute('app_reservation_user_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('reservation/new.html.twig', [
            'reservation' => $reservation,
            'form' => $form,
        ]);
    }

    #[Route('/new/{bookVersionId}', name: 'app_reservation_new_from_book_list', methods: ['GET'])]
    #[IsGranted('ROLE_USER')]
    public function newBookReservation(Request $request, BookVersion $bookVersionId, EntityManagerInterface $entityManager): Response
    {
        $userPenality = $this->getUser()->getPenality();

        if (
            null !== $userPenality
            && $userPenality > 0
        ){
            $this->addFlash('error', 'You cant borrow any Book. Regularise your late payment penalties');
            return $this->redirectToRoute('homepage', [], Response::HTTP_SEE_OTHER);
        }

        $reservation = new Reservation();
        $reservation->setUser($this->getUser());
        $reservation->setBookVersion($bookVersionId);
        $reservation->setActive(true);

        $entityManager->persist($reservation);
        $entityManager->flush();

        return $this->redirectToRoute('app_reservation_user_index', [], Response::HTTP_SEE_OTHER);
    }

    #[Route('/{id}', name: 'app_reservation_show', methods: ['GET'])]
    #[IsGranted(new Expression('is_granted("ROLE_USER") or is_granted("ROLE_LIBRARIAN")'))]
    public function show(Reservation $reservation): Response
    {
        if ($this->getUser()->getId() !== $reservation->getUser()->getId() && $this->isGranted('ROLE_USER')) {
            throw new AccessDeniedException('This reservation is not accessible to you');
        }

        return $this->render('reservation/show.html.twig', [
            'reservation' => $reservation,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_reservation_edit', methods: ['GET', 'POST'])]
    #[IsGranted('ROLE_USER')]
    public function edit(Request $request, Reservation $reservation, EntityManagerInterface $entityManager): Response
    {
        if ($this->getUser()->getId() !== $reservation->getUser()->getId()) {
            throw new AccessDeniedException('This reservation is not accessible to you');
        }

        $form = $this->createForm(ReservationType::class, $reservation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_reservation_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('reservation/edit.html.twig', [
            'reservation' => $reservation,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_reservation_delete', methods: ['POST'])]
    #[IsGranted('ROLE_USER')]
    public function delete(Request $request, Reservation $reservation, EntityManagerInterface $entityManager): Response
    {
        if ($this->getUser()->getId() !== $reservation->getUser()->getId()) {
            throw new AccessDeniedException('This reservation is not accessible to you');
        }

        if ($this->isCsrfTokenValid('delete'.$reservation->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($reservation);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_reservation_index', [], Response::HTTP_SEE_OTHER);
    }
}
