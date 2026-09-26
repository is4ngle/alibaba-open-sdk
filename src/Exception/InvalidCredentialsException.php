<?php

declare(strict_types=1);

namespace Is4ngle\AlibabaOpen\Exception;

/**
 * 凭证缺失/无效（缺 appKey、appSecret 或 access_token）
 */
final class InvalidCredentialsException extends AlibabaOpenException
{
}
