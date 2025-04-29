<?php

namespace TeaAroma\RouteArchitect\Traits;


use TeaAroma\RouteArchitect\Enums\RouteArchitectRegisterModes;


/**
 * Provides register mode management with forceful control and helper methods.
 */
trait RouteArchitectRegisterMode
{
    /**
     * The register mode.
     *
     * @var RouteArchitectRegisterModes
     */
    protected RouteArchitectRegisterModes $registerMode = RouteArchitectRegisterModes::REGISTER;

    /**
     * Gets the register mode.
     *
     * @return RouteArchitectRegisterModes
     */
    abstract public function getRegisterMode(): RouteArchitectRegisterModes;

    /**
     * Changes the given register mode by the given force.
     *
     * @param RouteArchitectRegisterModes $mode
     * @param bool                        $force
     *
     * @return void
     */
    public function changeMode(RouteArchitectRegisterModes $mode, bool $force = true): void
    {
        if (!$force)
        {
            return;
        }

        $this->registerMode = $mode;
    }

    /**
     * Determines whether the register mode equals with the given register mode.
     *
     * @param RouteArchitectRegisterModes $mode
     *
     * @return bool
     */
    public function isMode(RouteArchitectRegisterModes $mode): bool
    {
        return $this->getRegisterMode() === $mode;
    }

    /**
     * Sets the register mode to 'REGISTER' by the given force.
     *
     * @param bool $force
     *
     * @return void
     */
    public function toRegister(bool $force = true): void
    {
        $this->changeMode(RouteArchitectRegisterModes::REGISTER, $force);
    }

    /**
     * Sets the register mode to 'PASS' by the given force.
     *
     * @param bool $force
     *
     * @return void
     */
    public function toPass(bool $force = true): void
    {
        $this->changeMode(RouteArchitectRegisterModes::PASS, $force);
    }

    /**
     * Determines whether the register mode is 'REGISTER'.
     *
     * @return bool
     */
    public function isRegister(): bool
    {
        return $this->isMode(RouteArchitectRegisterModes::REGISTER);
    }

    /**
     * Determines whether the register mode is 'PASS'.
     *
     * @return bool
     */
    public function isPass(): bool
    {
        return $this->isMode(RouteArchitectRegisterModes::PASS);
    }
}
