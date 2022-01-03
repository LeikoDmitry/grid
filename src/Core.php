<?php

namespace Dmitry\Grid;

use Exception;

class Core
{
    private ShortCode $shortCode;
    private static array $instances = [];

    private function __construct(ShortCode $shortcode)
    {
        $this->shortCode = $shortcode;
    }

    public static function getInstance(): Core
    {
        $cls = static::class;
        if (!isset(self::$instances[$cls])) {
            self::$instances[$cls] = new static(new ShortCode());
        }

        return self::$instances[$cls];
    }

    public function run(): void
    {
        add_shortcode('dm-grid', [$this->shortCode, 'run']);
    }

    /**
     * @throws Exception
     */
    protected function __clone()
    {
        throw new Exception('Cannot clone a core.');
    }

    /**
     * @throws Exception
     */
    public function __wakeup()
    {
        throw new Exception('Cannot unserialize a core.');
    }
}
