<?php

declare(strict_types=1);

namespace App\Form;

use App\Entity\Post;
use App\Enum\PostCategoryEnum;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Contracts\Translation\TranslatorInterface;

class PostType extends AbstractType
{
    /**
     * @var TranslatorInterface
     */
    protected $translator;

    /**
     * @param TranslatorInterface $translator
     */
    public function __construct(TranslatorInterface $translator)
    {
        $this->translator = $translator;
    }

    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $translator = $this->translator;

        $builder
            ->add('title', TextType::class, [
                'required' => true,
            ])
            ->add('author', TextType::class, [
                'required' => true,
            ])
            ->add('category', ChoiceType::class, [
                'required' => true,
                'choices' => PostCategoryEnum::INTENT_CATEGORIES[$options['intent']],
                'choice_label' => function ($choice) use ($translator) {
                    return $translator->trans($choice);
                },
            ])
            ->add('content', TextareaType::class, [
                'required' => true,
            ])
            ->add('contact', TextType::class, [
                'required' => true,
            ])
            ->add('save', SubmitType::class);
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setRequired('intent');
        $resolver->setDefaults([
            'data_class' => Post::class,
        ]);
    }
}
