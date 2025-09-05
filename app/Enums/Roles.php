<?php
namespace App\Enums;

enum Roles: string
{
    case SUPER_ADMIN = 'super_admin';
    case ADMIN = 'admin';
    case USER = 'user';

    /**
     * Lable of role
     */
    public function label(): string
    {
        return match ($this) {
            static::SUPER_ADMIN => __('Super Admin'),
            static::ADMIN => __('Admin'),
            static::USER => __('User')
        };
    }

    /**
     * List All Roles
     */
    public static function list(): array
    {
        return array_map(function ($role) {
            return [
                'key' => $role->name,
                'value' => $role->value,
                'label' => $role->label(),
                'guard' => ($role->value == 'user') ? 'web' : 'admin'
            ];
        }, self::cases());
    }

}