<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserLibrarianType;
use App\Form\UserPenalityType;
use App\Form\UserProfileType;
use App\Form\UserType;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[Route('/user')]
final class UserController extends AbstractController
{
    #[Route('/admin', name: 'app_user_index', methods: ['GET'])]
    #[IsGranted('ROLE_ADMIN')]
    public function index(UserRepository $userRepository): Response
    {
        return $this->render('user/index.html.twig', [
            'users' => $userRepository->findAll(),
        ]);
    }

    #[Route('/admin/{id}', name: 'app_user_show', methods: ['GET'])]
    #[IsGranted('ROLE_ADMIN')]
    public function show(User $user): Response
    {
        return $this->render('user/show.html.twig', [
            'user' => $user,
        ]);
    }

    #[Route('/admin/{id}/edit', name: 'app_user_edit', methods: ['GET', 'POST'])]
    #[IsGranted('ROLE_ADMIN')]
    public function edit(Request $request, User $user, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_user_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('user/edit.html.twig', [
            'user' => $user,
            'form' => $form,
        ]);
    }

    #[Route('/admin/{id}', name: 'app_user_delete', methods: ['POST'])]
    #[IsGranted('ROLE_ADMIN')]
    public function delete(Request $request, User $user, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$user->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($user);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_user_index', [], Response::HTTP_SEE_OTHER);
    }

    #[Route('/penality', name: 'app_user_penality_index', methods: ['GET'])]
    #[IsGranted('ROLE_ADMIN')]
    public function indexPenality(UserRepository $userRepository): Response
    {
        return $this->render('user/index_penality.html.twig', [
            'users' => $userRepository->findAllPenalityUsers(),
        ]);
    }

    #[Route('/penality/{id}/edit', name: 'app_user_penality_edit', methods: ['GET', 'POST'])]
    #[IsGranted('ROLE_ADMIN')]
    public function editPenality(Request $request, User $user, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(UserPenalityType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_user_penality_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('user/edit_penality.html.twig', [
            'user' => $user,
            'form' => $form,
        ]);
    }

    #[Route('/librarian/{page<\d+>}', name: 'app_user_index_users', methods: ['GET'])]
    #[IsGranted('ROLE_LIBRARIAN')]
    public function indexUsers(UserRepository $userRepository, int $page = 1): Response
    {
        $users = $userRepository->findAllUsers();
        $pages = ceil(count($users) / AppController::PER_PAGE);

        if ($page < 1 || $page > $pages) {
            throw new NotFoundHttpException();
        }

        $results = array_slice($users, ($page - 1) * AppController::PER_PAGE, AppController::PER_PAGE);
        return $this->render('user/index_librarian.html.twig', [
            'users' => $results,
            'page' => $page,
            'pages' => $pages,
        ]);
    }

    #[Route('/librarian/{id}/edit', name: 'app_user_edit_librarian', methods: ['GET', 'POST'])]
    #[IsGranted('ROLE_LIBRARIAN')]
    public function editUserByLibrarian(Request $request, User $user, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(UserLibrarianType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_user_index_users', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('user/edit_librarian.html.twig', [
            'user' => $user,
            'form' => $form,
        ]);
    }

    #[Route('/{id}/profile', name: 'app_user_show_profile', methods: ['GET'])]
    public function showProfile(User $user): Response
    {
        if ($this->getUser()->getId() !== $user->getId()) {
            throw new AccessDeniedException('Only admin can access to this page');
        }

        return $this->render('user/show_profile.html.twig', [
            'user' => $user,
        ]);
    }

    #[Route('/{id}/edit_profile', name: 'app_user_edit_profile', methods: ['GET', 'POST'])]
    public function editProfile(Request $request, User $user, EntityManagerInterface $entityManager): Response
    {
        if ($this->getUser()->getId() !== $user->getId()) {
            throw new AccessDeniedException('Only admin can access to this page');
        }

        $form = $this->createForm(UserProfileType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_user_show_profile', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('user/edit_profile.html.twig', [
            'user' => $user,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_user_delete_profile', methods: ['POST'])]
    public function deleteProfile(Request $request, User $user, EntityManagerInterface $entityManager): Response
    {
        if ($this->getUser()->getId() !== $user->getId()) {
            throw new AccessDeniedException('Only admin can access to this page');
        }

        if ($this->isCsrfTokenValid('delete'.$user->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($user);
            $entityManager->flush();
        }

        return $this->redirectToRoute('homepage', [], Response::HTTP_SEE_OTHER);
    }
}
