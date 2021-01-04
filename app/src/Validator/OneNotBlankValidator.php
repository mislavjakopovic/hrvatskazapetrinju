<?php

declare(strict_types=1);

namespace App\Validator;

use App\Validator\Constraint\OneNotBlank;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use Symfony\Component\Validator\Exception\ConstraintDefinitionException;
use Symfony\Component\Validator\Exception\UnexpectedTypeException;
use Symfony\Contracts\Translation\TranslatorInterface;

class OneNotBlankValidator extends ConstraintValidator
{
    /**
     * @var ManagerRegistry
     */
    private $registry;

    /**
     * @var TranslatorInterface
     */
    private $translator;

    /**
     * @param ManagerRegistry $registry
     * @param TranslatorInterface $translator
     */
    public function __construct(ManagerRegistry $registry, TranslatorInterface $translator)
    {
        $this->registry = $registry;
        $this->translator = $translator;
    }

    /**
     * {@inheritdoc}
     */
    public function validate($entity, Constraint $constraint)
    {
        if (!$constraint instanceof OneNotBlank) {
            throw new UnexpectedTypeException($constraint, OneNotBlank::class);
        }
        if (!\is_array($constraint->fields) && !\is_string($constraint->fields)) {
            throw new UnexpectedTypeException($constraint->fields, 'array');
        }

        $fields = (array)$constraint->fields;

        if (\count($fields) === 0) {
            throw new ConstraintDefinitionException('At least one field has to be specified.');
        }
        if ($entity === null) {
            return;
        }

        if ($constraint->entityManager) {
            $entityManager = $this->registry->getManager($constraint->entityManager);
            if (!$entityManager) {
                throw new ConstraintDefinitionException(
                    sprintf('Object manager "%s" does not exist.', $constraint->entityManager)
                );
            }
        } else {
            $entityManager = $this->registry->getManagerForClass(\get_class($entity));
            if (!$entityManager) {
                throw new ConstraintDefinitionException(
                    sprintf(
                        'Unable to find the object manager associated with an entity of class "%s".',
                        get_debug_type($entity)
                    )
                );
            }
        }

        $class = $entityManager->getClassMetadata(\get_class($entity));

        $blank = true;
        $firstBlank = '';

        foreach ($fields as $fieldName) {
            if (!$class->hasField($fieldName) && !$class->hasAssociation($fieldName)) {
                throw new ConstraintDefinitionException(
                    sprintf(
                        'The field "%s" is not mapped by Doctrine, so it cannot be checked.', $fieldName
                    )
                );
            }

            $fieldValue = $class->reflFields[$fieldName]->getValue($entity);

            if (!empty($fieldValue)) {
                $blank = false;
            } elseif (empty($firstBlank)) {
                $firstBlank = $fieldName;
            }
        }

        if ($blank) {
            foreach ($fields as &$field) {
                $translatedField = $this->translator->trans('post.' . $field, [], 'validators');
                if (!empty($translatedField)) {
                    $field = $translatedField;
                }
            }

            $this->context->buildViolation($constraint->message)
                ->setParameter('{{ value }}', implode(', ', $fields))
                ->atPath($firstBlank)
                ->addViolation();
        }
    }
}
