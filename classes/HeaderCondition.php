<?php

declare(strict_types=1);

namespace Vdlp\RedirectConditionsHeader\Classes;

use Illuminate\Http\Request;
use Psr\Log\LoggerInterface;
use Throwable;
use Vdlp\Redirect\Classes\RedirectRule;
use Vdlp\RedirectConditions\Classes\Condition;

class HeaderCondition extends Condition
{
    public function __construct(
        private Request $request,
        private LoggerInterface $log
    ) {
    }

    public function getCode(): string
    {
        return 'vdlp_header';
    }

    public function getDescription(): string
    {
        return 'Header';
    }

    public function getExplanation(): string
    {
        return 'Match on HTTP header.';
    }

    public function passes(RedirectRule $rule, string $requestUri): bool
    {
        $parameters = $this->getParameters($rule->getId());

        if (empty($parameters)) {
            return true;
        }

        $header = $parameters['header'] ?? '';

        if ($this->request->hasHeader($header)) {
            $headerValue = $this->request->header($header);

            // Header value type is not processable.
            if (!is_string($headerValue)) {
                return false;
            }

            $matchValue = (string) ($parameters['value'] ?? '');

            if ((bool) ($parameters['use_regex'] ?? false)) {
                try {
                    return preg_match($matchValue, $headerValue) === 1;
                } catch (Throwable) {
                    $this->log->warning(sprintf(
                        'Invalid regex %s provided for redirect ID=%d.',
                        $matchValue,
                        $rule->getId()
                    ));
                }
            } else {
                return strtolower($matchValue) === strtolower($headerValue);
            }
        }

        return false;
    }

    public function getFormConfig(): array
    {
        return [
            'header' => [
                'tab' => self::TAB_NAME,
                'label' => 'Header name',
                'type' => 'text',
                'span' => 'left',
            ],
            'value' => [
                'tab' => self::TAB_NAME,
                'label' => 'Header value',
                'type' => 'text',
                'span' => 'left',
            ],
            'use_regex' => [
                'tab' => self::TAB_NAME,
                'label' => 'Use regular expression for header value.',
                'comment' => 'See <a href="http://php.net/manual/en/function.preg-match.php" target="_blank">preg_match</a> documentation.',
                'commentHtml' => true,
                'type' => 'checkbox',
                'span' => 'left',
            ]
        ];
    }
}
