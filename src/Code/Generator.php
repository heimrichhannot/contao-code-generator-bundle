<?php

namespace HeimrichHannot\CodeGeneratorBundle\Code;

use Contao\StringUtil;
use Hackzilla\PasswordGenerator\Generator\ComputerPasswordGenerator;
use Hackzilla\PasswordGenerator\Generator\RequirementPasswordGenerator;
use HeimrichHannot\CodeGeneratorBundle\DataContainer\CodeConfigContainer;
use HeimrichHannot\CodeGeneratorBundle\Model\ConfigModel;

class Generator
{
    public function generate(Criteria $criteria): string
    {
        $generator = (new RequirementPasswordGenerator())
            ->setLength($criteria->length)
            ->setUppercase($criteria->allowUppercase)
            ->setLowercase($criteria->allowLowercase)
            ->setNumbers($criteria->allowNumbers)
            ->setAvoidSimilar($criteria->preventAmbiguous)
            ->setSymbols($criteria->allowSymbols)
            ->setParameter(ComputerPasswordGenerator::PARAMETER_SIMILAR, 'iIl1Oo0yYzZL')
        ;

        if ($criteria->allowedSymbols) {
            $generator->setParameter(ComputerPasswordGenerator::PARAMETER_SYMBOLS, $criteria->allowedSymbols);
        }

        if ($criteria->requireUpperCase) $generator->setMinimumCount(RequirementPasswordGenerator::OPTION_UPPER_CASE, 1);
        if ($criteria->requireLowerCase) $generator->setMinimumCount(RequirementPasswordGenerator::OPTION_LOWER_CASE, 1);
        if ($criteria->requireNumbers) $generator->setMinimumCount(RequirementPasswordGenerator::OPTION_NUMBERS, 1);
        if ($criteria->requireSymbols) $generator->setMinimumCount(RequirementPasswordGenerator::OPTION_SYMBOLS, 1);

        return $generator->generatePassword();
    }

    public function generateMultipleFromConfig(ConfigModel $codeConfig, int $count): array
    {
        $criteria = $this->createCriteriaFromModel($codeConfig);

        $codes = [];

        for ($i = 0; $i < $count; ++$i) {
            $code = $this->generate($criteria);

            if ($codeConfig->preventDoubleCodes) {
                $found = false;

                if ($codeConfig->doubleCodeTable && $codeConfig->doubleCodeTableField) {
                    $found = $this->codeExistsInTable($code, $codeConfig->doubleCodeTable, $codeConfig->doubleCodeTableField);
                }

                while (\in_array($code, $codes) || $found) {
                    $code = $this->generate($criteria);

                    $found = false;

                    if ($codeConfig->doubleCodeTable && $codeConfig->doubleCodeTableField) {
                        $found = $this->codeExistsInTable($code, $codeConfig->doubleCodeTable, $codeConfig->doubleCodeTableField);
                    }
                }
            }

            $codes[] = $code;
        }

        return $codes;
    }

    public function createCriteriaFromModel(ConfigModel $codeConfig): Criteria
    {
        $criteria = new Criteria();

        $criteria->length = (int)$codeConfig->length;
        $criteria->preventAmbiguous = (bool)$codeConfig->preventAmbiguous;

        $alphabets = StringUtil::deserialize($codeConfig->alphabets, true);
        $criteria->allowUppercase = in_array(CodeConfigContainer::CAPITAL_LETTERS, $alphabets);
        $criteria->allowLowercase = in_array(CodeConfigContainer::SMALL_LETTERS, $alphabets);
        $criteria->allowNumbers = in_array(CodeConfigContainer::NUMBERS, $alphabets);
        $criteria->allowSymbols = in_array(CodeConfigContainer::SPECIAL_CHARS, $alphabets);

        $rules = StringUtil::deserialize($codeConfig->rules, true);
        $criteria->requireUpperCase = in_array(CodeConfigContainer::CAPITAL_LETTERS, $rules);
        $criteria->requireLowerCase = in_array(CodeConfigContainer::SMALL_LETTERS, $rules);
        $criteria->requireNumbers = in_array(CodeConfigContainer::NUMBERS, $rules);
        $criteria->requireSymbols = in_array(CodeConfigContainer::SPECIAL_CHARS, $rules);

        if (!empty(trim($codeConfig->allowedSpecialChars))) {
            $criteria->allowedSymbols = $codeConfig->allowedSpecialChars;
        }
        return $criteria;
    }

    private function codeExistsInTable(string $code, string $table, string $field)
    {
        return null !== ConfigModel::findBy(["$table.$field=?"], [$code]);
    }
}