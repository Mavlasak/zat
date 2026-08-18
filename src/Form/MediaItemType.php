<?php
namespace App\Form;

use App\DTO\MediaItemDTO;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;

class MediaItemType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title', TextType::class, ['label' => 'Title', 'translation_domain' => 'messages'])
            ->add('description', TextType::class, ['label' => 'Description', 'required' => false, 'translation_domain' => 'messages'])
            ->add('acquisitionDate', DateType::class, [
                'widget' => 'single_text',
                'label' => 'Acquisition Date',
                'required' => false,
                'translation_domain' => 'messages',
            ])
            ->add('borrowedTo', TextType::class, ['label' => 'Borrowed To', 'required' => false, 'translation_domain' => 'messages'])
            ->add('type', ChoiceType::class, [
                'choices' => [
                    'Book' => 'book',
                    'CD' => 'cd',
                    'DVD' => 'dvd'
                ],
                'label' => 'Item Type',
                'disabled' => $options['is_edit'],
                'translation_domain' => 'messages',
            ]);

        $dto = $options['data'];
        $type = $dto?->type;

        if (!$options['is_edit'] || $type === 'book') {
            $builder->add('author', TextType::class, ['label' => 'Author', 'required' => false, 'translation_domain' => 'messages']);
        }
        if (!$options['is_edit'] || $type === 'cd') {
            $builder->add('artist', TextType::class, ['label' => 'Artist', 'required' => false, 'translation_domain' => 'messages']);
        }
        if (!$options['is_edit'] || $type === 'dvd') {
            $builder->add('director', TextType::class, ['label' => 'Director', 'required' => false, 'translation_domain' => 'messages']);
        }
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => MediaItemDTO::class,
            'is_edit' => false,
        ]);
    }
}
