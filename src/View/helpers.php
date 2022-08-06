<?php

use Illuminate\Support\HtmlString;
use FlixtechsLabs\TurboLaravelHelpers\View\Providers\ActionProvider;
use FlixtechsLabs\TurboLaravelHelpers\View\Providers\ControllerProvider;
use FlixtechsLabs\TurboLaravelHelpers\View\Providers\TargetProvider;

if (!function_exists('stimulus_controller')) {
    /**
     * Set the stimulus controller on an element
     *
     * @param string $controller
     * @param array $values
     * @return HtmlString
     */
    function stimulus_controller(string $controller, array $values = [])
    {
        $provider = new ControllerProvider();

        $provider->addController($controller, $values);

        return new HtmlString($provider);
    }
}

if (!function_exists('stimulus_controllers')) {
    /**
     * Set multiple stimulus controllers on an element
     *
     * @param mixed ...$controllers
     * @return HtmlString
     */
    function stimulus_controllers(...$controllers)
    {
        if (count($controllers) < 1) {
            throw new InvalidArgumentException("The stimulus_controllers function requires at least one argument");
        }

        $provider = new ControllerProvider();

        collect($controllers)->each(function ($controller) use ($provider) {
            if (is_string($controller)) {
                return $provider->addController($controller, []);
            }

            if (is_array($controller)) {
                list($key, $value) = $controller;

                if (!is_string($key)) {
                    $type = gettype($key);

                    throw new InvalidArgumentException("stimulus_controllers(...) requires the first item in the array to be of type string {$type} given");
                }

                if (!is_array($value)) {
                    $type = gettype($value);

                    throw new InvalidArgumentException("stimulus_controllers(...) requires the second item in the array to be of type array {$type} given");
                }

                return $provider->addController($key, $value);
            }

            $type = gettype($controller);

            throw new InvalidArgumentException("stimulus_controllers(...) requires the argument to be either of type array or string {$type} given");
        });

        return new HtmlString($provider);
    }
}

if (!function_exists('stimulus_action')) {
    /**
     * Set the stimulus action on an element
     *
     * @param string $controller
     * @param string $action
     * @param string|null $event
     * @param array $params
     * @return HtmlString
     */
    function stimulus_action(string $controller, string $action, string $event = null, array $params = [])
    {
        $provder = new ActionProvider();

        $provder->addAction($controller, $action, $event, $params);

        return new HtmlString($provder);
    }
}

if (!function_exists('stimulus_actions')) {
    /**
     * Set multiple stimulus actions on an element
     *
     * @param array $actions
     * @return HtmlString
     */
    function stimulus_actions(array $actions)
    {
        $provder = new ActionProvider();

        collect($actions)->each(function ($params, $controller) use ($provder) {
            $provder->addAction($controller, ...$params);
        });

        return new HtmlString($provder);
    }
}

if (!function_exists('stimulus_target')) {
    /**
     * Set the stimulus target on an element
     *
     * @param string $controller
     * @param string $target
     * @return HtmlString
     */
    function stimulus_target(string $controller, string $target)
    {
        $provider = new TargetProvider();

        $provider->addTarget($controller, $target);

        return new HtmlString($provider);
    }
}

if (!function_exists('stimulus_targets')) {
    /**
     * Set multiple stimulus targets on an element
     *
     * @param array $targets
     * @return HtmlString
     */
    function stimulus_targets(array $targets)
    {
        $provider = new TargetProvider();

        collect($targets)->each(function ($param) use ($provider) {
            list($controller, $target) = $param;

            $provider->addTarget($controller, $target);
        });

        return new HtmlString($provider);
    }
}