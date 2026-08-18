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
            ->add('title', TextType::class, ['label' => 'Název'])
            ->add('description', TextType::class, ['label' => 'Popis', 'required' => false])
            ->add('acquisitionDate', DateType::class, [
                'widget' => 'single_text',
                'label' => 'Datum pořízení',
                'required' => false,
            ])
            ->add('borrowedTo', TextType::class, ['label' => 'Zapůjčeno komu', 'required' => false])
            ->add('type', ChoiceType::class, [
                'choices' => ['Kniha' => 'book', 'CD' => 'cd', 'DVD' => 'dvd'],
                'label' => 'Typ položky',
                'disabled' => $options['is_edit'],
            ]);

        $dto = $options['data'];
        $type = $dto?->type;

        if (!$options['is_edit'] || $type === 'book') {
            $builder->add('author', TextType::class, ['label' => 'Autor', 'required' => false]);
        }
        if (!$options['is_edit'] || $type === 'cd') {
            $builder->add('artist', TextType::class, ['label' => 'Umělec', 'required' => false]);
        }
        if (!$options['is_edit'] || $type === 'dvd') {
            $builder->add('director', TextType::class, ['label' => 'Režisér', 'required' => false]);
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
