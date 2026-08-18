<?php

namespace App\Controller;

use App\DTO\MediaItemDTO;
use App\Entity\MediaItem;
use App\Form\MediaItemType;
use App\Repository\MediaItemRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Factory\MediaItemFactory;
use App\Service\MediaItemService; // Keep this, remove MediaItemManager

#[Route('/mediaitem')]
class MediaItemController extends AbstractController
{

    #[Route('/new', name: 'app_media_item_new', methods: ['GET', 'POST'])]
    public function new(Request $request, MediaItemService $mediaItemService): Response
    {
        $dto = new MediaItemDTO();

        $form = $this->createForm(MediaItemType::class, $dto, [
            'is_edit' => false
        ]);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $mediaItemService->createMediaItemFromDto($dto);

            return $this->redirectToRoute('app_media_item_index');
        }

        return $this->render('media_item/new.html.twig', [
            'form' => $form,
        ]);
    }

    #[Route('/{type?}', name: 'app_media_item_index', requirements: ['type' => 'book|cd|dvd'], methods: ['GET'])]
    public function index(MediaItemRepository $mediaItemRepository, string $type = null): Response
    {
        $mediaItems = $mediaItemRepository->findAllByType($type);

        return $this->render('media_item/index.html.twig', [
            'media_items' => $mediaItems,
            'current_type' => $type,
        ]);
    }

    #[Route('/{id}', name: 'app_media_item_show', methods: ['GET'])]
    public function show(MediaItem $mediaItem): Response
    {
        return $this->render('media_item/show.html.twig', [
            'media_item' => $mediaItem,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_media_item_edit', methods: ['GET', 'POST'])]
    public function edit(
        Request $request,
        MediaItem $mediaItem,
        MediaItemService $mediaItemService
    ): Response {
        $dto = MediaItemDTO::fromEntity($mediaItem);
        $form = $this->createForm(MediaItemType::class, $dto, [
            'is_edit' => true,
        ]);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $mediaItemService->updateMediaItemFromDto($mediaItem, $dto);
            $this->addFlash('success', 'Položka byla úspěšně upravena.');

            return $this->redirectToRoute('app_media_item_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('media_item/edit.html.twig', [
            'media_item' => $mediaItem,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_media_item_delete', methods: ['POST'])]
    public function delete(Request $request, MediaItem $mediaItem, MediaItemService $mediaItemService): Response // Changed dependency
    {
        if ($this->isCsrfTokenValid('delete'.$mediaItem->getId(), $request->getPayload()->getString('_token'))) {
            $mediaItemService->removeMediaItem($mediaItem); // Call the service method
        }

        return $this->redirectToRoute('app_media_item_index', [], Response::HTTP_SEE_OTHER);
    }
}
