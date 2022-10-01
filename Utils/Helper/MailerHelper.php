<?php

declare(strict_types=1);

namespace App\Utils\Helper;

/**
 * Class MailerHelper
 */
class MailerHelper
{
    const ACCOUNT_VALIDATION_TEMPLATE = 'account_validation';
    const ACCOUNT_VALIDATION_SUBJECT = 'Account validation';
    const RESET_PASSWORD_TEMPLATE = 'reset_password';
    const RESET_PASSWORD_SUBJECT = 'Reset password';
    const MEMBER_INVITATION_TEMPLATE = 'member_invitation';
    const MEMBER_INVITATION_SUBJECT = 'Invitation';
    const PROFILE_PROJECT_INVITATION_TEMPLATE = 'profile_project_invitation';
    const GUEST_PROJECT_INVITATION_TEMPLATE = 'guest_project_invitation';
    const ADMIN_PROJECT_INVITATION_TEMPLATE = 'admin_project_invitation';
    const MEMBER_PROJECT_INVITATION_TEMPLATE = 'member_project_invitation';
    const PROJECT_INVITATION_SUBJECT = 'Invitation';
    const ADMIN_PROJECT_INVITATION_VALIDATION_TEMPLATE = 'admin_project_invitation_validation';
}
