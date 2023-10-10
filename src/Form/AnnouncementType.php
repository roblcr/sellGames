<?php

namespace App\Form;

use App\Config\Category;
use App\Config\Platform;
use App\Config\State;
use App\Entity\Announcement;
use App\Service\GameApiService;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\CallbackTransformer;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\EnumType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AnnouncementType extends AbstractType
{

    private $gameApiService;

    public function __construct(GameApiService $gameApiService)
    {
        $this->gameApiService = $gameApiService;
    }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {

        $builder
            ->add('title', ChoiceType::class, [
                'label' => 'Titre',
                'attr' => ['class' => 'game-select'],
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
            ->add('images', CollectionType::class, [
                'label' => 'Images',
                'entry_type' => FileType::class,
                'entry_options' => [
                    'label' => false,
                    'required' => true,
                    'multiple' => true,
                    'attr' => [
                        'accept' => 'image/*',
                    ],
                ],
                'allow_add' => true,
                'by_reference' => false,
            ])
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
            ])
            ->addEventListener(FormEvents::PRE_SUBMIT, function (FormEvent $event) {
                $form = $event->getForm();
                $title = $event->getData()['title'];
                if ($title) {
                    $form->add('title', ChoiceType::class, ['choices' => [$title => $title]]);
                }
            });
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Announcement::class,

        ]);
    }
}
