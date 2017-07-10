<?php

namespace Emanci\ConsoleColor;

/*
 * @method mixed default()
 * @method mixed black()
 * @method mixed red()
 * @method mixed green()
 * @method mixed yellow()
 * @method mixed blue()
 * @method mixed magenta()
 * @method mixed cyan()
 * @method mixed lightGray()
 * @method mixed darkGray()
 * @method mixed lightRed()
 * @method mixed lightGreen()
 * @method mixed lightYellow()
 * @method mixed lightBlue()
 * @method mixed lightMagenta()
 * @method mixed lightCyan()
 * @method mixed white()
 * @method mixed defaultBackground()
 * @method mixed blackBackground()
 * @method mixed redBackground()
 * @method mixed Background()
 * @method mixed greenBackground()
 * @method mixed yellowBackground()
 * @method mixed blueBackground()
 * @method mixed magentaBackground()
 * @method mixed cyanlightGrayBackground()
 * @method mixed darkGrayBackground()
 * @method mixed lightRedBackground()
 * @method mixed lightGreenBackground()
 * @method mixed lightYellowBackground()
 * @method mixed lightBlueBackground()
 * @method mixed lightMagentaBackground()
 * @method mixed lightCyanBackground()
 * @method mixed whiteBackground()
 * @method mixed bold()
 * @method mixed dim()
 * @method mixed underline()
 * @method mixed blink()
 * @method mixed invert()
 * @method mixed hidden()
 */

define('FOREGROUND', 38);
define('BACKGROUND', 48);

class ConsoleColor
{
    /**
     * The style instance.
     *
     * @var Style
     */
    protected $style;

    /**
     * ConsoleColor construct.
     */
    public function __construct()
    {
        $this->style = new Style();
    }

    /**
     * @param string $method
     * @param array  $args
     *
     * @return $this
     */
    public function __call($method, $args)
    {
        $name = $this->snakeCase($method);
        $str = current($args);

        if ($this->style->styleWasCalled($name) && $str) {
            return $this->render($str);
        }

        return $this;
    }

    /**
     * @param int $code
     * @param int $option
     *
     * @return string
     */
    public function color256($code, $option = null)
    {
        $this->style->color256($code, $option);

        return $this;
    }

    /**
     * Convert a string to snake case.
     *
     * @param string $value
     * @param string $delimiter
     *
     * @return string
     */
    protected function snakeCase($value, $delimiter = '_')
    {
        if (!ctype_lower($value)) {
            $value = preg_replace('/\s+/u', '', $value);
            $value = strtolower(preg_replace('/(.)(?=[A-Z])/u', '$1'.$delimiter, $value));
        }

        return $value;
    }

    /**
     * Add a color to the foreground colors.
     *
     * @param string|array $color
     * @param int|null     $code
     */
    public function addColor($color, $code = null)
    {
        $colors = $this->parseColor($color, $code);
        $this->style->addColor($colors);

        return $this;
    }

    /**
     * Add a color to the background colors.
     *
     * @param string|array $color
     * @param int|null     $code
     */
    public function addBackground($color, $code = null)
    {
        $colors = $this->parseColor($color, $code);
        $this->style->addBackground($colors);

        return $this;
    }

    /**
     * Parse the color.
     *
     * @param string $color
     * @param int    $code
     *
     * @return array
     */
    protected function parseColor($color, $code)
    {
        return is_array($color) ? $color : [$color => $code];
    }

    /**
     * Returns colorized string.
     *
     * @param string $str
     * @param bool   $line
     *
     * @return string
     */
    public function render($str = null, $line = true)
    {
        return $this->style->applyStyle($str, $line);
    }
}
