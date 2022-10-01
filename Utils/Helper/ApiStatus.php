<?php

declare(strict_types=1);

namespace App\Utils\Helper;

/**
 * Class ApiStatus
 */
class ApiStatus
{
    const API_ERROR = 'Api Error';
    const SEND_MAIL_ERROR = 'Sen Mail Error';
    const VALIDATION_ERROR = 'Validation Error';
    const BAD_REQUEST_ERROR = 'Bad Request';
    const PROFILE_NOT_FOUND = 'Profile Not Found';
    const ACCESS_DENIED = 'Access Denied';
    const AUTHENTICATION_REQUIRED = 'Authentication Required';
    const ACCOUNT_ALREADY_VALIDATED = 'Account Already Validated';
    const INVALID_EMAIL_ACCOUNT = 'Invalid Email Account';
    const INVALID_PASSWORD = 'Invalid password';
}
