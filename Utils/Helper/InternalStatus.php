<?php

declare(strict_types=1);

namespace App\Utils\Helper;

/**
 * Class InternalStatus
 */
class InternalStatus
{
    const UNKNOWN_ERROR = 'An error occurred while processing this request. please try again later.';
    const ACCOUNT_ALREADY_VALIDATED = 'Account already validated.';
    const INVALID_VALIDATION_TOKEN = 'Invalid token.';
    const INVALID_RESET_PASSWORD_TOKEN = 'Invalid token.';
    const NO_ACCOUNT_FOUND = 'No account found.';
    const INVITATION_ALREADY_EXIST = 'An invitation already exist.';
    const INVITE_MEMBER_NOT_ALLOWED = 'Your are not allowed to invite member.';
    const ACCOUNT_ALREADY_EXIST = 'An account with same information already exist.';
}
