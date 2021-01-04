<?php

declare(strict_types=1);

namespace App\Validator\Constraint;

use App\Validator\OneNotBlankValidator;
use Symfony\Component\Validator\Constraint;

/**
 * @Annotation
 */
class OneNotBlank extends Constraint
{
    public $entityManager = null;

    public $fields = [];

    public $message = 'At least one of fields "{{ value }}" should not be blank';

    public function getRequiredOptions()
    {
        return ['fields'];
    }

    public function validatedBy()
    {
        return OneNotBlankValidator::class;
    }

    public function getTargets()
    {
        return self::CLASS_CONSTRAINT;
    }

    public function getDefaultOption()
    {
        return 'fields';
    }
}
