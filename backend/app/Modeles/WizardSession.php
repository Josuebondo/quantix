<?php

namespace App\Modeles;

use Core\Modele;

/**
 * WizardSession Model
 * Représente une session de configuration wizard
 */
class WizardSession extends Modele
{
    protected string $table = 'wizard_sessions';

    protected array $fillable = [
        'wizard_session_id',
        'user_id',
        'company_id',
        'status',
        'current_step',
        'state',
        'idempotency_key',
        'deployment_metadata',
        'last_saved_at',
        'deployed_at',
    ];

    protected array $casts = [
        'state' => 'json',
        'deployment_metadata' => 'json',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'last_saved_at' => 'datetime',
        'deployed_at' => 'datetime',
    ];

    /**
     * Relations
     */
    public function user()
    {
        return $this->appartientA('App\Modeles\users', 'user_id');
    }

    public function company()
    {
        return $this->appartientA('App\Modeles\company', 'company_id');
    }

    /**
     * Get session by ID
     */
    public static function findBySessionId(string $sessionId): ?self
    {
        return self::ou('wizard_session_id', '=', $sessionId)->premier();
    }

    /**
     * Mark as saved
     */
    public function markAsSaved(): void
    {
        $this->last_saved_at = now();
        $this->sauvegarder();
    }

    /**
     * Mark as deployed
     */
    public function markAsDeployed(array $metadata = []): void
    {
        $this->status = 'deployed';
        $this->deployed_at = now();
        $this->deployment_metadata = json_encode($metadata, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
        $this->sauvegarder();
    }

    /**
     * Get state or default - Always returns array (never string)
     */
    public function getState()
    {
        $state = $this->state;

        // Decode JSON if string
        if (is_string($state)) {
            $decoded = json_decode($state, true);
            $state = is_array($decoded) ? $decoded : [];
        }

        // Return state or default
        return $state ?? [
            'workspaceName' => '',
            'slug' => '',
            'currency' => 'EUR',
            'country' => 'FR',
            'timezone' => 'UTC+1',
            'unitSystem' => 'metric',
            'siteName' => '',
            'siteType' => 'depot',
            'siteAddress' => '',
            'categories' => [],
            'productName' => '',
            'productSku' => '',
            'productCategory' => '',
            'productPrice' => 0,
            'productStock' => 0,
            'skuPrefix' => 'QTX-',
            'roles' => ['Admin', 'Manager'],
            'selectedRole' => 'Admin',
            'invitations' => [],
            'stockAlertEnabled' => true,
            'negativeStockAllowed' => false,
        ];
    }

    /**
     * Get deployment metadata - Always returns array (never string)
     */
    public function getDeploymentMetadata(): array
    {
        $metadata = $this->deployment_metadata;

        // Decode JSON if string
        if (is_string($metadata)) {
            $decoded = json_decode($metadata, true);
            return is_array($decoded) ? $decoded : [];
        }

        return is_array($metadata) ? $metadata : [];
    }

    /**
     * Update state field
     */
    public function updateState(array $newState, ?array $dirtyFields = null): void
    {
        $currentState = $this->getState();

        // Deep merge
        $mergedState = array_merge($currentState, $newState);
        $this->current_step = $newState['currentStep'] ?? $this->current_step;

        // Always store as JSON string in DB
        $this->state = json_encode($mergedState, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);

        $this->markAsSaved();
    }

    /**
     * Is draft
     */
    public function isDraft(): bool
    {
        return $this->status === 'draft';
    }

    /**
     * Is expired (30 jours inactivité basé sur last_saved_at)
     */
    public function isExpired(): bool
    {
        // Use last_saved_at if available (activity clock), otherwise created_at
        $lastActivity = $this->last_saved_at ?? $this->created_at;

        // Convert to string if DateTime object
        if ($lastActivity instanceof \DateTime) {
            $lastActivity = $lastActivity->format('Y-m-d H:i:s');
        }

        // Return false if no activity recorded (session just created)
        if (!$lastActivity) {
            return false;
        }

        return diffInDays($lastActivity, now()) > 30;
    }

    /**
     * Can be resumed
     */
    public function canBeResumed(): bool
    {
        return !$this->isExpired() && in_array($this->status, ['draft', 'in_progress']);
    }
}
