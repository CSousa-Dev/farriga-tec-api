<?php 
namespace App\Domain\Devices\Device\UserPermissions;

use App\Domain\Devices\Device\UserPermissions\EnumPermissions;

class UserPermissions
{
    public array $permissions;
    public function __construct(
        public readonly int $userId,
        EnumPermissions ...$permissions
    )
    {
        $this->permissions = $permissions;
    }

    public function hasPermission(EnumPermissions $permission): bool
    {
        return in_array($permission, $this->permissions);
    }

    public function addPermission(EnumPermissions $permission): void
    {
        $this->permissions[] = $permission;
    }

    public function removePermission(EnumPermissions $permission): void
    {
        $this->permissions = array_filter($this->permissions, fn($p) => $p !== $permission);
    }

    public function userId(): int
    {
        return $this->userId;
    }

    public function permissions(): array
    {
        return $this->permissions;
    }
}