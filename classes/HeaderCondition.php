<?php

declare(strict_types=1);

namespace Vdlp\RedirectConditionsHeader\Classes;

use Illuminate\Http\Request;
use Psr\Log\LoggerInterface;
use Vdlp\Redirect\Classes\RedirectRule;
use Vdlp\RedirectConditions\Classes\Condition;

/**
 * Class HeaderCondition
 *
 * @package Vdlp\RedirectConditionsHeader\Classes
 */
class HeaderCondition extends Condition
{
    /**
     * @var Request
     */
    private $request;

    /**
     * @var LoggerInterface
     */
    private $log;

    /**
     * @param Request $request
     * @param LoggerInterface $log
     */
    public function __construct(Request $request, LoggerInterface $log)
    {
        $this->request = $request;
        $this->log = $log;
    }

    /**
     * @return string
     */
    public function getCode(): string
    {
        return 'vdlp_header';
    }

    /**
     * {@inheritdoc}
     */
    public function getDescription(): string
    {
        return 'Header';
    }

    /**
     * {@inheritdoc}
     */
    public function getExplanation(): string
    {
        return 'Match on HTTP header.';
    }

    /**
     * {@inheritdoc}
     */
    public function passes(RedirectRule $rule, string $requestUri): bool
    {
        $properties = $this->getParameters($rule->getId());
        $header = $properties['header'] ?? '';

        if ($this->request->hasHeader($header)) {
            $headerValue = $this->request->header($header);

            // Header value type is not processable.
            if (!is_string($headerValue)) {
                return false;
            }

            $matchValue = (string) ($properties['value'] ?? '');

            if ((bool) ($properties['use_regex'] ?? false)) {
                try {
                    return preg_match($matchValue, $headerValue) === 1;
                } catch (\Throwable $e) {
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

    /**
     * {@inheritdoc}
     */
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
