<?php

declare(strict_types=1);

namespace App\Utils\Helper;

use App\Entity\CspsCoordinator;
use App\Entity\Enterprise;
use App\Entity\Project;
use App\Entity\ProjectBatch;
use App\Entity\ProjectBatchEnterprise;
use App\Entity\ProjectCspsCoordinator;
use App\Entity\ProjectEnterprise;
use App\Entity\ProjectManager;
use App\Entity\ProjectMemberInterface;
use App\Entity\ProjectProjectManager;
use App\Entity\Speciality;
use App\Entity\User;
use App\Entity\UserProfile;
use DateTimeInterface;
use InvalidArgumentException;

/**
 * Class ProjectHelper
 */
class ProjectHelper
{
    const TYPE_NEW = 'NEW';
    const TYPE_OLD_AFTER_1997 = 'OLD_AFTER_1997';
    const TYPE_OLD_BEFORE_1997 = 'OLD_BEFORE_1997';
    const DURATION_TYPE_WEEK = 'WEEK';
    const DURATION_TYPE_MONTH = 'MONTH';
    const DURATION_TYPE_YEAR = 'YEAR';
    const DRAFT_STATUS = 'P_DRAFT';
    const NEW_STATUS = 'P_NEW';

    /**
     * @return string
     */
    public static function generateUid(): string
    {
        return substr(str_shuffle(strtoupper(md5(uuid_create().time()))), 0, 16);
    }

    /**
     * @param Project                $project
     * @param ProjectMemberInterface $projectMember
     *
     * @return Project
     */
    public static function attachRelatedObject(Project $project, ProjectMemberInterface $projectMember): Project
    {
        if ($projectMember instanceof ProjectEnterprise) {
            return $project->addEnterprise($projectMember);
        }

        if ($projectMember instanceof ProjectProjectManager) {
            return $project->addProjectManager($projectMember);
        }

        if ($projectMember instanceof ProjectCspsCoordinator) {
            return $project->addCspsCoordinator($projectMember);
        }

        throw new InvalidArgumentException('Invalid profile given !');
    }

    /**
     * @param Project     $project
     * @param UserProfile $userProfile
     *
     * @return ProjectMemberInterface|null
     */
    public static function getProjectMember(Project $project, UserProfile $userProfile): ?ProjectMemberInterface
    {
        if (empty($userProfile->getCompany())) {
            return null;
        }

        $members = match ($userProfile->getCompany()->getType()) {
            Enterprise::TYPE => $project->getEnterprises(),
            ProjectManager::TYPE => $project->getProjectManagers(),
            CspsCoordinator::TYPE => $project->getCspsCoordinators(),
            default => []
        };

        /** @var ProjectMemberInterface $member */
        foreach ($members as $member) {
            if ($member->getCompany()->getId() === $userProfile->getCompany()->getId()) {
                return $member;
            }
        }

        return null;
    }

    /**
     * @param Project $project
     * @param User    $user
     *
     * @return bool
     */
    public static function isProjectOwner(Project $project, User $user): bool
    {
        $userProfile = $user->getProfile();

        return $userProfile->getId() === $project->getProjectOwner()?->getId()
            || ($userProfile->isAdmin() && $userProfile->getCompany()->getId() === $project->getProjectOwner()?->getCompany()->getId());
    }

    /**
     * @param Project     $project
     * @param User        $user
     * @param string|null $relationType
     *
     * @return bool
     */
    public static function isProjectMember(Project $project, User $user, string $relationType = null): bool
    {
        if (empty($user->getProfile()?->getCompany())) {
            return false;
        }

        $relationType = $relationType ?? $user->getProfile()->getCompany()->getType();
        $profiles = match ($relationType) {
            Enterprise::TYPE => $project->getEnterprises()->map(function (ProjectEnterprise $projectEnterprise) {
                return $projectEnterprise->getEnterprise();
            }),
            ProjectManager::TYPE => $project->getProjectManagers()->map(function (ProjectProjectManager $projectProjectManager) {
                return $projectProjectManager->getProjectManager();
            }),
            CspsCoordinator::TYPE => $project->getCspsCoordinators()->map(function (ProjectCspsCoordinator $projectCspsCoordinator) {
                return $projectCspsCoordinator->getCspsCoordinator();
            }),
            default => []
        };

        $userProfile = $user->getProfile();
        /** @var UserProfile $profile */
        foreach ($profiles as $profile) {
            if ($profile->getId() === $userProfile->getId()
                || ($userProfile->isAdmin() && $userProfile->getCompany()->getId() === $profile->getCompany()->getId())
            ) {
                return true;
            }
        }

        return false;
    }

    /**
     * @param Project         $project
     * @param int|null        $rank
     * @param Enterprise|null $invitedBy
     * @param array           $excludedEnterprisesIdentifiers
     *
     * @return Enterprise[]
     */
    public static function getRelatedEnterprises(Project $project, int $rank = null, Enterprise $invitedBy = null, array $excludedEnterprisesIdentifiers = []): array
    {
        $enterprises = [];
        /** @var ProjectEnterprise $projectEnterprise */
        foreach ($project->getEnterprises() as $projectEnterprise) {
            if (!is_null($rank) && $projectEnterprise->getRank() !== $rank) {
                continue;
            }

            if (!is_null($invitedBy) && $invitedBy->getId() !== $projectEnterprise->getInvitedBy()?->getCompany()?->getId()) {
                continue;
            }

            $company = $projectEnterprise->getEnterprise()->getCompany();
            if (!$company instanceof Enterprise) {
                continue;
            }

            if (in_array($company->getId(), $excludedEnterprisesIdentifiers)) {
                continue;
            }

            $enterprises[] = $company;
        }

        return array_unique($enterprises);
    }

    /**
     * @param Project $project
     *
     * @return Speciality[]
     */
    public static function getAvailableSpecialities(Project $project): array
    {
        $specialities = [];
        foreach (static::getRelatedEnterprises($project) as $enterprise) {
            /** @var Speciality $speciality */
            foreach ($enterprise->getSpecialities() as $speciality) {
                if (!isset($specialities[$speciality->getDomain()->getLabel()])) {
                    $specialities[$speciality->getDomain()->getLabel()] = [];
                }
                if (!in_array($speciality, $specialities[$speciality->getDomain()->getLabel()])) {
                    $specialities[$speciality->getDomain()->getLabel()][] = $speciality;
                }
            }
        }

        return $specialities;
    }

    /**
     * @param Project         $project
     * @param int             $projectBatchId
     * @param Enterprise|null $enterprise
     * @param Enterprise|null $subEnterprise
     *
     * @return array
     */
    public static function getBatchSpecialities(Project $project, int $projectBatchId, Enterprise $enterprise = null, Enterprise $subEnterprise = null): array
    {
        $specialities = [];
        /** @var ProjectBatch $projectBatch */
        foreach ($project->getBatches() as $projectBatch) {
            if ($projectBatch->getId() !== $projectBatchId) {
                continue;
            }

            /** @var ProjectBatchEnterprise $projectBatchEnterprise */
            foreach ($projectBatch->getEnterprises() as $projectBatchEnterprise) {
                if ($enterprise && $enterprise->getId() !== $projectBatchEnterprise->getEnterprise()->getId()) {
                    continue;
                }

                $projectBatchSpecialities = $projectBatchEnterprise->getSpecialities()->toArray();
                if ($subEnterprise) {
                    $projectBatchSpecialities = array_intersect($projectBatchSpecialities, $subEnterprise->getSpecialities()->toArray());
                }

                $specialities = array_merge($specialities, $projectBatchSpecialities);
            }
        }

        return array_unique($specialities);
    }

    /**
     * @param Project $project
     *
     * @return array
     */
    public static function getConfiguredBatchesSpecialities(Project $project): array
    {
        $specialities = [];
        /** @var ProjectBatch $projectBatch */
        foreach ($project->getBatches() as $projectBatch) {
            /** @var ProjectBatchEnterprise $projectBatchEnterprise */
            foreach ($projectBatch->getEnterprises() as $projectBatchEnterprise) {
                foreach ($projectBatchEnterprise->getSpecialities() as $speciality) {
                    $specialities[] = $speciality;
                }
            }
        }

        return array_unique($specialities);
    }

    /**
     * @param Project           $project
     * @param ProjectEnterprise $projectEnterprise
     *
     * @return bool
     */
    public static function isEnterpriseHasAssociatedBatches(Project $project, ProjectEnterprise $projectEnterprise): bool
    {
        if ($project->getBatches()->isEmpty()) {
            return false;
        }

        /** @var ProjectBatch $projectBatch */
        foreach ($project->getBatches() as $projectBatch) {
            /** @var ProjectBatchEnterprise $projectBatchEnterprise */
            foreach ($projectBatch->getEnterprises() as $projectBatchEnterprise) {
                if ($projectEnterprise->getEnterprise()->getCompany()->getId() === $projectBatchEnterprise->getEnterprise()->getId()) {
                    return true;
                }
            }
        }

        return false;
    }

    /**
     * @param Project $project
     *
     * @return DateTimeInterface|null
     */
    public static function calculateEndDate(Project $project): ?DateTimeInterface
    {
        if (empty($project->getStartDate()) || empty($project->getDuration()) || empty($project->getDurationUnity())) {
            return null;
        }

        /** @var \DateTime $startDate */
        $startDate = clone $project->getStartDate();

        return $startDate->modify(sprintf('+ %d %s', $project->getDuration(), $project->getDurationUnity()));
    }

    /**
     * @param Project        $project
     * @param Enterprise|int $enterprise
     *
     * @return bool
     */
    public static function isEnterpriseAssociated(Project $project, Enterprise|int $enterprise): bool
    {
        $enterpriseId = is_int($enterprise) ? $enterprise : $enterprise->getId();
        /** @var ProjectEnterprise $projectEnterprise */
        foreach ($project->getEnterprises() as $projectEnterprise) {
            if ($projectEnterprise->getEnterprise()->getCompany()->getId() === $enterpriseId) {
                return true;
            }
        }

        return false;
    }

    /**
     * @param Project    $project
     * @param Enterprise $enterprise
     *
     * @return array
     */
    public static function getEnterpriseRelatedUsers(Project $project, Enterprise $enterprise): array
    {
        $users = [];
        /** @var ProjectEnterprise $projectEnterprise */
        foreach ($project->getEnterprises() as $projectEnterprise) {
            if ($projectEnterprise->getCompany()->getId() !== $enterprise->getId()) {
                continue;
            }

            $users[] = $projectEnterprise->getEnterprise()->getUser();
        }

        return $users;
    }

    /**
     * @param Project $project
     *
     * @return array
     */
    public static function getRelatedCompanies(Project $project): array
    {
        $companies = [$project->getProjectOwner()->getCompany()];
        /** @var ProjectEnterprise $projectEnterprise */
        foreach ($project->getEnterprises() as $projectEnterprise) {
            $companies[] = $projectEnterprise->getCompany();
        }

        /** @var ProjectProjectManager $projectManager */
        foreach ($project->getProjectManagers() as $projectManager) {
            $companies[] = $projectManager->getCompany();
        }

        /** @var ProjectCspsCoordinator $projectCspsCoordinator */
        foreach ($project->getCspsCoordinators() as $projectCspsCoordinator) {
            $companies[] = $projectCspsCoordinator->getCompany();
        }

        return array_unique($companies);
    }
}
