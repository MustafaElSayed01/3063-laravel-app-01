<?php

namespace App\Helpers;

class AbilityGenerator
{
    /**
     * Generate abilities for a role and token type.
     */
    public static function generate(string $role, string $tokenType = 'web'): array
    {
        $config = config('abilities');

        // Get resources for this role
        $roleResources = $config['roles'][$role] ?? [];

        if (empty($roleResources)) {
            return [];
        }

        $abilities = [];

        // Admin wildcard → all resources
        if (in_array('*', $roleResources, true)) {
            foreach (array_keys($config['resources']) as $resource) {
                $resourceActions = $config['resources'][$resource] ?? [];
                $tokenAllowed = $config['tokens'][$tokenType]['default'] ?? [];
                $finalActions = array_intersect($resourceActions, $tokenAllowed);

                foreach ($finalActions as $action) {
                    $abilities[] = "{$resource}:{$action}";
                }
            }

            return array_values(array_unique($abilities));
        }

        // Manager, User, etc.
        foreach ($roleResources as $resource) {
            $resourceActions = $config['resources'][$resource] ?? [];
            $tokenAllowed = $config['tokens'][$tokenType]['default'] ?? [];
            $finalActions = array_intersect($resourceActions, $tokenAllowed);

            foreach ($finalActions as $action) {
                $abilities[] = "{$resource}:{$action}";
            }
        }

        return array_values(array_unique($abilities));
    }
}
