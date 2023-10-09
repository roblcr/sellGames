<?php

namespace App\Form;

use App\Config\Category;
use App\Config\Platform;
use App\Config\State;
use App\Entity\Announcement;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\EnumType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AnnouncementType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title', TextType::class, [
                'label' => 'Titre',
            ])
            ->add('description', TextareaType::class, [
                'label' => 'Description',
            ])
            ->add('price', MoneyType::class, [
                'label' => 'Prix',
            ])
            ->add('state', EnumType::class, [
                'label' => 'État',
                'class' => State::class,
                'multiple' => false,
                'expanded' => false,
                'required' => true,
            ])
            // ->add('images', CollectionType::class, [
            //     'label' => 'Images',
            //     'entry_type' => ImageType::class, // Remplacez par le type de champ approprié
            //     'allow_add' => true,
            // ])
            ->add('platform', EnumType::class, [
                'label' => 'Platform',
                'class' => Platform::class,
                'multiple' => false,
                'expanded' => false,
                'required' => true,
            ])
            ->add('category', EnumType::class, [
                'label' => 'Catégorie',
                'class' => Category::class,
                'multiple' => true,
                'required' => true,
                'attr' => ['class' => 'category-select']
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Announcement::class,
        ]);
    }
}
