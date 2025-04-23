<?php

namespace App\Form;

use App\Document\Category;
use App\Document\Post;
use Doctrine\Bundle\MongoDBBundle\Form\Type\DocumentType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PostType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('category', DocumentType::class, [
                'class' => Category::class,
                'placeholder' => 'Selecciona una...',
                'label' => 'Categoría',
            ])
            ->add('title', TextType::class, [
                'label' => 'Título de la publicación',
                'help' => 'Piensa en el SEO ¿Cómo buscarías eb Google?'
            ])
            ->add('body', TextareaType::class, [
                'label' => 'Contenido',
                'attr' => ['rows' => 10, 'class' => 'bg-light'],
            ])
            ->add('Enviar', SubmitType::class, [
                'attr' => ['class' => 'btn btn-dark'],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Post::class,
        ]);
    }
}
