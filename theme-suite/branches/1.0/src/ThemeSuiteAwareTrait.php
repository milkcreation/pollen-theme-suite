<?php declare(strict_types=1);

namespace Pollen\ThemeSuite;

use Exception;
use Pollen\ThemeSuite\Contracts\ThemeSuiteContract;

trait ThemeSuiteAwareTrait
{
    /**
     * Instance de l'application.
     * @var ThemeSuite|null
     */
    private $ts;

    /**
     * Récupération de l'instance de l'application.
     *
     * @return ThemeSuite|null
     */
    public function ts(): ?ThemeSuite
    {
        if (is_null($this->ts)) {
            try {
                $this->ts = ThemeSuite::instance();
            } catch (Exception $e) {
                $this->ts;
            }
        }

        return $this->ts;
    }

    /**
     * Définition de l'application.
     *
     * @param ThemeSuiteContract $ts
     *
     * @return static
     */
    public function setThemeSuite(ThemeSuiteContract $ts): self
    {
        $this->ts = $ts;

        return $this;
    }
}
